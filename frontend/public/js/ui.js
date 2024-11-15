function openMessage(){
  const cover = document.getElementById('message_cover');
  const message = document.getElementById('message');
  const form = document.getElementById('message_form');
  const confirmation = document.getElementById('message_confirmation');
  cover.style.display = 'block';
  cover.style.opacity = 1;
  message.style.display = 'block';
  form.style.display = 'block';
  confirmation.style.display = 'none';
}

function closeMessage(){
  var cover = document.getElementById('message_cover');
  var message = document.getElementById('message');
  cover.style.display = 'none';
  cover.style.opacity = 0;
  message.style.display = 'none';
}
