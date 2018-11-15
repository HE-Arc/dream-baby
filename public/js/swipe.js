function loadNextProfilProperty(property)
{
    document.getElementById(property).innerHTML=document.getElementById('hidden-'+property).innerHTML;
}

function loadNextProfil(swiper)
{
    //TO-DO: put in swap_history if yes/no + load with ajax next profil that will remplace the 'hidden' profil
    loadNextProfilProperty('username');
    loadNextProfilProperty('sex');
    loadNextProfilProperty('eyecolor');
    loadNextProfilProperty('haircolor');
    loadNextProfilProperty('ethnicity');
    loadNextProfilProperty('family_antecedents');
    loadNextProfilProperty('medical_antecedents');
    document.getElementById('photo').src=document.getElementById('hidden-photo_uri').innerHTML;
    swiper.slideTo(1,200 , false);
     
}

window.onload = () => {
    var swiper = new Swiper ('.swiper-container', {
        initialSlide:1,
      });
    
      swiper.on('transitionEnd',()=>loadNextProfil(swiper));

    document.getElementById('swipe-no').onclick=()=>loadNextProfil(swiper);

    document.getElementById('swipe-yes').onclick=()=>loadNextProfil(swiper);
}
