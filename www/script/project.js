/**
 * Used to resize the iframe for embebbed projects.
 *
 * @param obj The iframe.
 */
function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight + 100) + 'px';
    obj.style.width = (obj.contentWindow.document.body.scrollWidth + 100) + 'px';
}


function showAdvancedSearch() {
    indicator = document.getElementById('advanced_search_indicator');
    slid = document.getElementById('advanced_search_slider');
    cont = document.getElementById('advanced_search');

    if (indicator.value == 1){
        // Advanced search show. Hide it.
        indicator.value = 0;
        slid.src = '/img/misc/slid-right.png';
        cont.style.height = '0px';
    }
    else if (indicator.value ==0){
        // Advanced search hidden. Show it.
        indicator.value = 1;
        slid.src = '/img/misc/slid-down.png';
        cont.style.height = 'auto';
    }
}

function showLicense(visible){
    showCover(visible);
    var license = document.getElementById('license');
    if (visible){
        license.style.display = 'block';
        license.style.opacity = 1;
    }
    else{
        license.style.display = 'none';
        license.style.opacity = 0;
    }
    
}
