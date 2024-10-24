/**
 * Current image ID for the image viewer.
 */
let curImage = 0;

/**
 * Total number of images.
 */
let totalImages = -1;

/**
 * Shows an image in the image viewer.
 *
 * Loads the image and text from the image preview.
 *
 * @param element The clicked img element.
 */
function showImage(element){
  curImage = Number(element.id.substring(4));
  document.getElementById('image_viewer_cover').style.display = 'block';
  document.getElementById('image_viewer_cover').style.opacity = '1';
  loadImage(element);
  document.getElementById('image_viewer').style.display = 'block';
  if (totalImages == -1){
    console.log("RECALC TOTAL");
    totalImages = document.getElementById("image_reel").children.length;
    console.log("RECALC TOTAL: " + totalImages);
  }
}

/**
 * Closes the image viewew.
 */
function closeImage(){
    document.getElementById('image_viewer_cover').style.display = 'none';
    document.getElementById('image_viewer_cover').style.opacity = '0';
    document.getElementById('image_viewer').style.display = 'none';
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
    console.log("LOADED: " + curImage + "/" + totalImages);
}
