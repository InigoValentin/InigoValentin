/**
 * Shows one of the headers.
 * 
 * @param header Header ID.
 * @param from Element clicked to open the header. It will be highlighted.
 */
function showHeader(header, from){
    if(document.getElementById('header_' + header).style.display == 'block'){
        document.getElementById('header_' + header).style.display = 'none';
        from.style.backgroundColor = '#000000';
    }
    else{
        var headers = document.getElementsByClassName('secondary_header');
        for (var i = 0; i < headers.length; i ++)
                headers.item(i).style.display = 'none';
        var sections = document.getElementsByClassName('header_section');
        for (var j = 0; j < sections.length; j ++)
                sections.item(j).style.backgroundColor = '#000000';
        
        document.getElementById('header_' + header).style.display = 'block';
        from.style.backgroundColor = '#333333';
    }
}


/**
 * Shows a language tab.
 * 
 * @param lang Two letter language code. 'es', 'en' or 'eu'.
 */
function showLanguage(lang){
    switch (lang){
        case 'es':
            document.getElementById('content_lang_es').style.display = 'block';
            document.getElementById('content_lang_eu').style.display = 'none';
            document.getElementById('content_lang_en').style.display = 'none';
            document.getElementById('lang_tab_es').classList.add("lang_tabs_active");
            document.getElementById('lang_tab_eu').classList.remove("lang_tabs_active");
            document.getElementById('lang_tab_en').classList.remove("lang_tabs_active");
            break;
        case 'eu':
            document.getElementById('content_lang_es').style.display = 'none';
            document.getElementById('content_lang_eu').style.display = 'block';
            document.getElementById('content_lang_en').style.display = 'none';
            document.getElementById('lang_tab_es').classList.remove("lang_tabs_active");
            document.getElementById('lang_tab_eu').classList.add("lang_tabs_active");
            document.getElementById('lang_tab_en').classList.remove("lang_tabs_active");
            break;
        case 'en':
            document.getElementById('content_lang_es').style.display = 'none';
            document.getElementById('content_lang_eu').style.display = 'none';
            document.getElementById('content_lang_en').style.display = 'block';
            document.getElementById('lang_tab_es').classList.remove("lang_tabs_active");
            document.getElementById('lang_tab_eu').classList.remove("lang_tabs_active");
            document.getElementById('lang_tab_en').classList.add("lang_tabs_active");
    }
}

function dialog(type, title, message, callback) {
    var dialogWindow = document.getElementById('dialog');
    var dialogText = document.getElementById('dialog_text');
    var dialogTitle = document.getElementById('dialog_title');
    var background = document.getElementById('dialog_background');
    var ynContainer = document.getElementById('dialog_button_yn_container');
    var aContainer = document.getElementById('dialog_button_a_container');
    var yButton = document.getElementById('dialog_yes');
    var nButton = document.getElementById('dialog_no');
    var aButton = document.getElementById('dialog_accept');

    function show(){
        dialogTitle.innerText = title;
        dialogText.innerHTML = message;
        dialogWindow.style.display = 'block';
        dialogWindow.style.opacity = '1';
    };
    function hide(){
        dialogWindow.style.display = 'none';
        dialogWindow.style.opacity = '0';
    };

    // Set up the dialog type
    if (type == "confirm"){
        ynContainer.style.display = "block";
        aContainer.style.display = "none";
        yButton.onclick = function() {
            hide();
            callback(true);
        }
        nButton.onclick = function() { 
            hide();
            callback(false);
        }
    }
    else if (type == "alert"){
        ynContainer.style.display = "none";
        aContainer.style.display = "block";
        aButton.onclick = function() {
            hide();
            callback(true);
        };
    }
    show();
}


function enableEdit(button){
    var container = button.parentElement;
    var fieldResult = container.getElementsByClassName('field_result')[0];
    var fieldEditable = container.getElementsByClassName('field_editable')[0];
    var cke = container.getElementsByClassName('cke')[0];
    var buttonEdit = container.getElementsByClassName('button_edit')[0];
    var buttonSave = container.getElementsByClassName('button_save')[0];
    var buttonCancel = container.getElementsByClassName('button_cancel')[0];
    fieldEditable.value = fieldResult.innerHTML;
    fieldResult.style.display = 'none';
    if (typeof(cke) != 'undefined' && cke != null){
        cke.style.display = 'block';
    }
    else{
        fieldEditable.style.display = 'initial';
    }
    buttonEdit.style.display = 'none';
    buttonSave.style.display = 'initial';
    buttonCancel.style.display = 'initial';
}

function saveEdit(button, table, column, id){
    var container = button.parentElement;
    var fieldResult = container.getElementsByClassName('field_result')[0];
    var fieldEditable = container.getElementsByClassName('field_editable')[0];
    var cke = container.getElementsByClassName('cke')[0];
    var buttonEdit = container.getElementsByClassName('button_edit')[0];
    var buttonSave = container.getElementsByClassName('button_save')[0];
    var buttonCancel = container.getElementsByClassName('button_cancel')[0];
    var value;
    if (typeof(cke) != 'undefined' && cke != null){
        fieldEditable.innerHTML = CKEDITOR.instances['text_en'].getData()
        fieldResult.innerHTML = fieldEditable.innerHTML;
        value = escape(fieldEditable.innerHTML);
    }
    else{
        value = escape(fieldEditable.value);
    }
    // TODO: Do some validation.
    
    var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp = new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState == 4){
                    if (xmlhttp.status == 200){
                        if (typeof(cke) != 'undefined' && cke != null){
                            cke.style.display = 'none';
                            fieldEditable.innerHTML = CKEDITOR.instances['text_en'].getData()
                            fieldResult.innerHTML = fieldEditable.innerHTML;
                        }
                        else{
                            fieldEditable.style.display = 'none';
                            fieldResult.innerHTML = fieldEditable.value;
                        }
                        fieldResult.style.display = 'initial';
                        buttonEdit.style.display = 'initial';
                        buttonSave.style.display = 'none';
                        buttonCancel.style.display = 'none';
                    }
                    else{
                        dialog("alert", "ERROR", "Error saving changes.", null);
                    }
                }
            }
            xmlhttp.open("GET","/functions/save.php?t=" + table + "&c=" + column + "&v=" + value + "&i=" + id, true);
            xmlhttp.send();
}

function cancelEdit(button){
    var container = button.parentElement;
    var fieldResult = container.getElementsByClassName('field_result')[0];
    var fieldEditable = container.getElementsByClassName('field_editable')[0];
    var cke = container.getElementsByClassName('cke')[0];
    var buttonEdit = container.getElementsByClassName('button_edit')[0];
    var buttonSave = container.getElementsByClassName('button_save')[0];
    var buttonCancel = container.getElementsByClassName('button_cancel')[0];
    fieldEditable.value = fieldResult.innerHTML;
    fieldResult.style.display = 'initial';
        if (typeof(cke) != 'undefined' && cke != null){
        cke.style.display = 'none';
    }
    else{
        fieldEditable.style.display = 'none';
    }
    buttonEdit.style.display = 'initial';
    buttonSave.style.display = 'none';
    buttonCancel.style.display = 'none';
}
