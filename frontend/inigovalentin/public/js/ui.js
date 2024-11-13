function openMessage(){
  var cover = document.getElementById('message_cover');
  var message = document.getElementById('message');
  cover.style.display = 'block';
  cover.style.opacity = 1;
  message.style.display = 'block';
}

function closeMessage(){
  var cover = document.getElementById('message_cover');
  var message = document.getElementById('message');
  cover.style.display = 'none';
  cover.style.opacity = 0;
  message.style.display = 'none';
}
