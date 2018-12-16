//Load external modules
var Swiper = require('swiper');
var toastr=require('toastr');
var moment=require('moment');

//Toastr to be showed if we have swiped all available donors
function showNoSwipesAvalaibleToast() {
   toastr.warning("Congratulations ! <br/>You already have swiped all the available donors...<br/>But change your criteria or wait a little bit to find new ones !");
}

function loadNextProfil(swiper) {
    //If the current active swiper state is not the profil photo
    if (swiper.activeIndex != 1) {
        //If there are donors left in the queue
        if (donorQueue.size() > 0) {
            let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            //The head of the queue is removed and its donor info is used to put a appropriate entry in the swipeHistory table, the controller returns the info for the next donor to be put in the tail of the queue
            let swipedDonor = donorQueue.remove();

            let like = -1;
            if (swiper.activeIndex == 0) {
                like = 0;
            } else if (swiper.activeIndex == 2) {
                like = 1;
            }

            fetch('/seeker/swipe', {
                    method: 'post',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': _token
                    },
                    body: JSON.stringify({
                        donor_id: swipedDonor.id,
                        like: like
                    })
                }).then(res => {
                    return res.json();
                })
                .catch(err => console.log(err))
                .then(data => {
                    if (data.donorsArray != null) { //if there is a next donor available (if not,)
                        let fetchedDonor = data.donorsArray[0];
                        fetch('/donor/image/' + fetchedDonor.donor.photo_uri, {
                            method: 'get',
                            headers: {
                                'X-CSRF-TOKEN': _token
                            }
                        }).then(photoRes => {
                            let fetchedPhoto = new Image();
                            fetchedPhoto.src = photoRes.url;
                            fetchedPhoto.classList.add("img-fluid");
                            fetchedPhoto.id = "photo";
                            let fetchedBirthdate=moment(new Date(fetchedDonor.donor.birth_date)).format("D MMMM YYYY");
                            let fetchedAge=Math.abs(new Date(Date.now() - new Date(fetchedDonor.donor.birth_date).getTime()).getUTCFullYear() - 1970);
                           

                            donorQueue.add(new Donor(Number(fetchedDonor.donor.id), fetchedDonor.username,
                                fetchedDonor.donor.sex, fetchedDonor.eyecolor, fetchedDonor.haircolor,
                                fetchedDonor.ethnicity, fetchedDonor.donor.family_antecedents, fetchedDonor.donor.medical_antecedents, fetchedPhoto,
                                fetchedBirthdate+" ("+fetchedAge+" years old)"));
                        }).catch(photoErr => console.log(photoErr));
                    }
                }).catch(err => console.log(err));



            if (donorQueue.size() > 0) {
                let nextDisplayedDonor = donorQueue.last();
                document.getElementById('username').innerText = nextDisplayedDonor.username;
                document.getElementById('sex').innerText = nextDisplayedDonor.sex == 0 ? 'Male' : 'Female';
                document.getElementById('photo').replaceWith(nextDisplayedDonor.photo);
                document.getElementById('eyecolor').innerText = nextDisplayedDonor.eyecolor;
                document.getElementById('haircolor').innerText = nextDisplayedDonor.haircolor;
                document.getElementById('ethnicity').innerText = nextDisplayedDonor.ethnicity;
                document.getElementById('family_antecedents').innerText = nextDisplayedDonor.family_antecedents;
                document.getElementById('medical_antecedents').innerText = nextDisplayedDonor.medical_antecedents;
                document.getElementById('age').innerText=nextDisplayedDonor.age;
            } else {
                showNoSwipesAvalaibleToast();
            }
        } else {
            showNoSwipesAvalaibleToast();
        }

    }
    swiper.slideTo(1, 200, false);
}

//https://hackernoon.com/the-little-guide-of-queue-in-javascript-4f67e79260d9

class Queue {

    constructor() {
        this.data = [];
    }

    add(record) {
        this.data.unshift(record);
    }

    remove() {
        return this.data.pop();
    }

    first() {
        return this.data[0];
    }

    last() {
        return this.data[this.data.length - 1];
    }

    size() {
        return this.data.length;
    }
}

class Donor {
    constructor(id, username, sex, eyecolor, haircolor, ethnicity, family_antecedents, medical_antecedents, photo,age) {
        this.id = id;
        this.username = username;
        this.sex = sex;
        this.eyecolor = eyecolor;
        this.haircolor = haircolor;
        this.ethnicity = ethnicity;
        this.family_antecedents = family_antecedents;
        this.medical_antecedents = medical_antecedents;
        this.photo = photo;
        this.age=age;
    }
}

var donorQueue = new Queue();

function initPage() {
    
    toastr.options={
        "positionClass": "toast-top-full-width",
        "preventDuplicates": true
    };

    var swiper = new Swiper.default('.swiper-container', {
        initialSlide: 1,
    });

    swiper.on('transitionEnd', () => loadNextProfil(swiper));

    if (document.getElementById('swipe-no') != null) {
        document.getElementById('swipe-no').onclick = () => swiper.slideTo(0, 200, false);

        document.getElementById('swipe-yes').onclick = () => swiper.slideTo(2, 200, false);
    }

    if (document.getElementById('swipe-profil') != null) {
        let id = Number(document.getElementById('donor_id').innerText);
        let username = document.getElementById('username').innerText;
        let sex = document.getElementById('sex').innerText;
        let eyecolor = document.getElementById('eyecolor').innerText;
        let haircolor = document.getElementById('haircolor').innerText;
        let ethnicity = document.getElementById('ethnicity').innerText;
        let family_antecedents = document.getElementById('family_antecedents').innerText;
        let medical_antecedents = document.getElementById('medical_antecedents').innerText;
        let photo = document.getElementById('photo');
        let age = document.getElementById('age').innerText;
        donorQueue.add(new Donor(id, username, sex, eyecolor, haircolor, ethnicity, family_antecedents, medical_antecedents, photo,age));
    }

    if (document.getElementById('hidden-profils') != null) {
        document.getElementById('hidden-profils').querySelectorAll('div').forEach(child => {
            let id = Number(child.querySelector('.hidden-donor_id').innerText);
            let username = child.querySelector('.hidden-username').innerText;
            let sex = child.querySelector('.hidden-sex').innerText;
            let eyecolor = child.querySelector('.hidden-eyecolor').innerText;
            let haircolor = child.querySelector('.hidden-haircolor').innerText;
            let ethnicity = child.querySelector('.hidden-ethnicity').innerText;
            let family_antecedents = child.querySelector('.hidden-family_antecedents').innerText;
            let medical_antecedents = child.querySelector('.hidden-medical_antecedents').innerText;
            let photo = child.querySelector('.hidden-photo img');
            let age=child.querySelector('.hidden-age').innerText;
            photo.id = "photo";
            donorQueue.add(new Donor(id, username, sex, eyecolor, haircolor, ethnicity, family_antecedents, medical_antecedents, photo,age));
            child.remove();

        });
    }
}


if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPage);
} else {
    initPage();
}
