
function toggleElement(name){
    if (document.getElementById("list_" + name).clientHeight > 0){
        document.getElementById("list_" + name).style.maxHeight = '0em';
        setTimeout(function(){document.getElementById('slid_' + name).src = '/img/misc/slid-right.png';}, 500);
    }
    else{
        document.getElementById("list_" + name).style.maxHeight = '90em';
        setTimeout(function(){document.getElementById('slid_' + name).src = '/img/misc/slid-down.png';}, 500);
    }
    document.getElementById('slid_' + name).style.opacity = '0';
    setTimeout(function(){document.getElementById('slid_' + name).style.opacity = '1';}, 500);
}

