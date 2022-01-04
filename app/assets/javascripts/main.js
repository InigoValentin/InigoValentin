function showContactForm(){
    clearContactErrors();
    document.getElementById('contact_menu').style.display = "block";
    document.getElementById('contact_progress').style.display = "none";
    document.getElementById('contact_confirmation').style.display = "none";
    document.getElementById('contact_bg').style.opacity = "0.6";
    document.getElementById('contact_bg').style.display = "block";
    document.getElementById('contact').style.display = "block";
}
function closeContactForm(){
    document.getElementById('contact_bg').style.opacity = "0.0";
    document.getElementById('contact_bg').style.display = "none";
    document.getElementById('contact').style.display = "none";
}
function clearContactErrors(){
    document.getElementById('sender_name_error').style.opacity = "0";
    document.getElementById('sender_email_error').style.opacity = "0";
    document.getElementById('text_error').style.opacity = "0";
}
function contactSuccess(){
    clearContactErrors();
    document.getElementById('contact_sender_name').value = "";
    document.getElementById('contact_sender_email').value = "";
    document.getElementById('contact_text').value = "";
    document.getElementById('contact_menu').style.display = "none";
    document.getElementById('contact_progress').style.display = "none";
    document.getElementById('contact_confirmation').style.display = "block";
}
function contactError(response){
    document.getElementById('contact_menu').style.display = "block";
    document.getElementById('contact_progress').style.display = "none";
    document.getElementById('contact_confirmation').style.display = "none";
    var errors = JSON.parse(response.replace(/\s/g, '')).response.errors
    for (let i = 0; i < errors.length; i++) {
        if (errors[i] === "INVALID_EMAIL"){
            document.getElementById('sender_email_error').style.display = "inline";
        }
        if (errors[i] === "INVALID_TEXT"){
            document.getElementById('text_error').style.display = "inline";
        }
    }
    
}
function sendMessage(e) {
    // Prevent form submit
    if (e.preventDefault) e.preventDefault();

    // Hide previously shown errors
    clearContactErrors();

    // Validate fields
    var success = true;
    var sender_name = document.getElementById('contact_sender_name').value;
    var sender_email = document.getElementById('contact_sender_email').value;
    var text = document.getElementById('contact_text').value;
    
    // Sender name is always OK
    // Sender email has to look like an email
    const res = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (res.test(String(sender_email).toLowerCase()) === false){
        success = false;
        document.getElementById('sender_email_error').style.opacity = "1";
    }
    // Text needs to have something
    if (text.length < 1){
        success = false;
        document.getElementById('text_error').style.opacity = "1";
    }
    if (success === false){
        return false;
    }
    
    // Send request
    var url = "/contact/";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    //xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200){
                contactSuccess();
            }
            else{
                contactError(xhr.responseText)
            }
        }};
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    datastring =
      'authenticity_token=' + encodeURI(document.getElementById('authenticity_token').value) +
      '&sender_name=' + encodeURI(sender_name) +
      '&sender_email=' + encodeURI(sender_email) +
      '&text=' + encodeURI(text)
    document.getElementById('contact_menu').style.display = "none";
    document.getElementById('contact_progress').style.display = "block";
    document.getElementById('contact_confirmation').style.display = "none";
    xhr.send(datastring);


    // You must return false to prevent the default form behavior
    return false;
}

