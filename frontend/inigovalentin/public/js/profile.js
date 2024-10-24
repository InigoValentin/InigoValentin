/**
 * Shows the buttons for all language CVs.
 *
 * It also hides the normal CV and the 'Other languages' buttons.
 */
function showAllCvs(){
    document.getElementById('cv_main').style.display = 'none';
    document.getElementById('cv_other_langs').style.display = 'none';
    var btns = document.getElementsByClassName('cv_lang');
    for (var i = 0; i < btns.length; i ++)
        btns.item(i).style.display = 'inline-block';
}
