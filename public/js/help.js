/**
 * Opens or closes a section in the help page.
 *
 * If the currently openend section is toggled, it will just close. If another onw is toggled, it
 * will open, and any other currently open sections will be closed.
 *
 * @param id Id of the section to toggle.
 */
function toggleHelp(id){
    var helps = document.getElementsByClassName("help");
    for (var i = 0; i < helps.length; i++) {
        if (helps[i].id == id){
            if (helps[i].classList.contains("selected")) helps[i].classList.remove("selected");
            else helps[i].classList.add("selected");
        }
        else helps[i].classList.remove("selected");
    }
}

/**
 * Hiddes the privacy policy.
 */
function closePolicy(){
    document.getElementById('policy_cover').style.display = 'none';
    document.getElementById('policy').style.display = 'none';
}

/**
 * Shows the privacy policy.
 */
function openPolicy(){
    document.getElementById('policy_cover').style.display = 'block';
    document.getElementById('policy').style.display = 'block';
}
