function showCover(visible){
    var cover = document.getElementById('cover');
    if (visible){
        cover.style.display = 'block';
        cover.style.opacity = 1;
    }
    else{
        cover.style.display = 'none';
        cover.style.opacity = 0;
    }
}
