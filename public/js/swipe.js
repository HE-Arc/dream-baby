function loadNextProfilProperty(property) {
    document.getElementById(property).innerHTML = document.getElementById('hidden-' + property).innerHTML;
}
var lastDonorId = -1;

function loadNextProfil(swiper) {
    if (swiper.activeIndex != 1) {
        //TO-DO: put in swap_history if yes/no + load with ajax next profil that will remplace the 'hidden' profil
        let _token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let donor_id = document.getElementById('donor_id').innerHTML;
        if (lastDonorId == donor_id) {
            Toastify({
                text: "You have already swiped this donor, maybe it means that you have already swiped all the available donors on this website ! Congratulations !",
                duration: 10000,
                close: true,
                gravity: "top", // `top` or `bottom`
                positionLeft: true, // `true` or `false`
                backgroundColor: "linear-gradient(to right, red, orange)",
              }).showToast();
        } else {
            lastDonorId = donor_id;
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
                        _token: _token,
                        donor_id: donor_id,
                        like: like
                    })
                }).then(res => console.log(res.json()))
                .catch(err => console.log(err));
        }
        if (document.getElementById('hidden-profil') != null) {
            loadNextProfilProperty('username');
            loadNextProfilProperty('sex');
            loadNextProfilProperty('eyecolor');
            loadNextProfilProperty('haircolor');
            loadNextProfilProperty('ethnicity');
            loadNextProfilProperty('family_antecedents');
            loadNextProfilProperty('medical_antecedents');
            loadNextProfilProperty('donor_id');
            document.getElementById('photo').src = document.getElementById('hidden-photo_uri').innerHTML;
        }

        //load with ajax next hidden profil


    }
    swiper.slideTo(1, 200, false);
}

window.onload = () => {
    var swiper = new Swiper('.swiper-container', {
        initialSlide: 1,
    });

    swiper.on('transitionEnd', () => loadNextProfil(swiper));

    document.getElementById('swipe-no').onclick = () => swiper.slideTo(0, 200, false);

    document.getElementById('swipe-yes').onclick = () => swiper.slideTo(2, 200, false);
}
