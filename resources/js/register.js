//This function is used to update the form fields: hide/show the donor part and remove/add required attributes to all the donor inputs
function applyDisplayStyleAndSetRequiredToChildren(parentDiv, displayStyle, requiredBool) {
    let donorInfoDiv = document.getElementById(parentDiv);
    donorInfoDiv.style.display = displayStyle;

    donorInfoDiv.querySelectorAll('select,textarea,input').forEach(child => {
        child.required = requiredBool;
    });
}

function setShowHideButtonListeners() {
    //Shows donor form and apply required to all inputs
    document.getElementById('user_type_donor').addEventListener('click', () => {
        applyDisplayStyleAndSetRequiredToChildren('donorInfo', 'block', true);
    });
    //Hides donor form and remove required for all inputs
    document.getElementById('user_type_seeker').addEventListener('click', () => {
        applyDisplayStyleAndSetRequiredToChildren('donorInfo', 'none', false);
    });
}

//Adds event listeners when the page is loaded
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", setShowHideButtonListeners);
} else {
    setShowHideButtonListeners();
}
