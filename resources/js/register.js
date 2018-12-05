function applyDisplayStyleAndSetRequiredToChildren(parentDiv, displayStyle, requiredBool) {
    let donorInfoDiv = document.getElementById(parentDiv);
    donorInfoDiv.style.display = displayStyle;

    donorInfoDiv.querySelectorAll('select,textarea,input').forEach(child => {
        child.required = requiredBool;
    });
}

function setShowHideButtonListeners() {
    document.getElementById('user_type_donor').addEventListener('click', () => {
        applyDisplayStyleAndSetRequiredToChildren('donorInfo', 'block', true);
    });
    document.getElementById('user_type_seeker').addEventListener('click', () => {
        applyDisplayStyleAndSetRequiredToChildren('donorInfo', 'none', false);
    });
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", setShowHideButtonListeners);
} else {
    setShowHideButtonListeners();
}
