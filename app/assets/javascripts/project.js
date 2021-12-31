// Populate this array as teh pages are loaded
var images = [];
selectedPhoto = 0;

var galleryOpen = false;
function closeGallery(){
    document.getElementById('gallery_bg').style.opacity = "0.0";
    document.getElementById('gallery_bg').style.display = "none";
    document.getElementById('gallery').style.display = "none";
    galleryOpen = false;
}

function showImage(index){
    if (galleryOpen === false){
        openGallery();
    }
    document.getElementById('gallery_image').src = images[index];
    selectedPhoto = index;
    var previews = document.getElementsByClassName('gallery_preview');
    for (i = 0; i < previews.length; i ++){
        previews[i].classList.remove('gallery_preview_selected');
    }
    document.getElementById('gallery_preview_' + index).classList.add('gallery_preview_selected')
}


function openGallery(){
    document.getElementById('gallery_bg').style.opacity = "0.6";
    document.getElementById('gallery_bg').style.display = "block";
    document.getElementById('gallery').style.display = "block";
    galleryOpen = true;
}

function previousPhoto(){
    newIndex = selectedPhoto - 1;
    if (newIndex < 0){
        newIndex = images.length - 1;
    }
    showImage(newIndex);
}

function nextPhoto(){
    newIndex = selectedPhoto + 1;
    if (newIndex >= images.length){
        newIndex = 0;
    }
    showImage(newIndex);
}
