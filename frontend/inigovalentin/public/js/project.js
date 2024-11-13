/**
 * Current image ID for the image viewer.
 */
let curImage = 0;

/**
 * Total number of images.
 */
let totalImages = -1;

/**
 * Indicates if the image viewer is open.
 */
let viewer_open = false;

/**
 * Shows an image in the image viewer.
 *
 * Loads the image and text from the image preview.
 *
 * @param element The clicked img element.
 */
function showImage(element){
  curImage = Number(element.id.substring(4));
  document.getElementById('cover').style.display = 'block';
  document.getElementById('cover').style.opacity = '1';
  loadImage(element);
  document.getElementById('image_viewer').style.display = 'block';
  if (totalImages == -1) totalImages = document.getElementById("image_reel").children.length;
  viewer_open = true;
}

/**
 * Closes the image viewew.
 */
function closeImage(){
    document.getElementById('cover').style.display = 'none';
    document.getElementById('cover').style.opacity = '0';
    document.getElementById('image_viewer').style.display = 'none';
    viewer_open = false;
}

/**
 * Shows the next image in the image viewer.
 */
function nextImage(){
    curImage = curImage + 1;
    if (curImage > totalImages) curImage = 0;
    loadImage(document.getElementById('img_' + curImage));
}

/**
 * Shows the previous image in the image viewer.
 */
function prevImage(){
    curImage = curImage - 1;
    if (curImage < 0) curImage = totalImages;
    loadImage(document.getElementById('img_' + curImage));
}

/**
 * Shows an image in the image viewer.
 *
 * Dont call manually, use {@see showImage} instead.
 *
 * @param element The clicked img element.
 */
function loadImage(element){
    document.getElementById('image_viewer_title').innerHTML = element.title;
    document.getElementById('image_viewer_image').src = element.src;
    document.getElementById('image_viewer_image').srcset = element.srcset;
    document.getElementById('image_viewer_image').alt = element.alt;
    document.getElementById('image_viewer_image').title = element.title;
}

/**
 * Handles keys for the image viewer.
 *
 * Left, Right and ESC keys are handled, and only when the viewer is opened.
 *
 * @param e Key event.
 */
function keyCapt(e){
  if(typeof window.event!="undefined") e = window.event; //IE stuff
  if(e.type == "keydown"){
    switch(e.keyCode){
      case 37: if (viewer_open === true) prevImage(); break; // Left
      case 39: if (viewer_open === true) nextImage(); break; // Right
      case 27: if (viewer_open === true) closeImage(); break; // ESC
    }
  }
}

if (document.addEventListener){ // Listen to keypresses, standart
  document.addEventListener("keydown",keyCapt,false);
  document.addEventListener("keyup",keyCapt,false);
  document.addEventListener("keypress",keyCapt,false);
}
else{ // Listen to keypresses, IE
  document.attachEvent("onkeydown",keyCapt);
  document.attachEvent("onkeyup",keyCapt);
  document.attachEvent("onkeypress",keyCapt);
}
