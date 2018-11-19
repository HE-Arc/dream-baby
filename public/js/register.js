function showDonorForm()
{
    document.getElementById('donorInfo').style.display = 'block';
    document.getElementById('femaleSex').required=true;
    document.getElementById('maleSex').required=true;
    document.getElementById('eye_color').required=true;
    document.getElementById('ethnicity').required=true;
    document.getElementById('hair_color').required=true;
    document.getElementById('medical_antecedents').required=true;
    document.getElementById('family_antecedents').required=true;
}

function hideDonorForm()
{
    document.getElementById('donorInfo').style.display = 'none';
    document.getElementById('femaleSex').required=false;
    document.getElementById('maleSex').required=false;
    document.getElementById('eye_color').required=false;
    document.getElementById('ethnicity').required=false;
    document.getElementById('hair_color').required=false;
    document.getElementById('medical_antecedents').required=false;
    document.getElementById('family_antecedents').required=false;
}
