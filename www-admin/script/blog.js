function managePost(id){
    window.location.href = "/blog/edit.php?p=" + id;
}

function deletePost(id, title){
    dialog("confirm", "Delete post", "Do you really want to delete the post '" + title + "'?<br/><br/>There is no way to undo this action. You can also unpublish the post instead of deleting it.", function (confirmed) {
        if (confirmed) {
            var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp = new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState == 4){
                    if (xmlhttp.status == 200){
                        location.reload();
                    }
                    else{
                        dialog("alert", "ERROR", "Error deleting the post '" + title + "'.", null);
                    }
                }
            }
            xmlhttp.open("GET","/blog/delete.php?p=" + id, true);
            xmlhttp.send();
        }
    });
}


function deleteComment(id){
    dialog("confirm", "Delete version", "Do you really want to delete this comment?<br/><br/>There is no way to undo this action. You can also disapprove the comment instead of deleting it.", function (confirmed) {
        if (confirmed) {
            var xmlhttp;
            if (window.XMLHttpRequest){
                xmlhttp = new XMLHttpRequest();
            }
            xmlhttp.onreadystatechange=function(){
                if (xmlhttp.readyState == 4){
                    if (xmlhttp.status == 200){
                        location.reload();
                    }
                    else{
                        dialog("alert", "ERROR", "Error deleting the comment.", null);
                    }
                }
            }
            xmlhttp.open("GET","/blog/deletecomment.php?i=" + id, true);
            xmlhttp.send();
        }
    });
}

function visiblePost(id, title, visible){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState == 4){
            if (xmlhttp.status == 200){
                location.reload();
            }
            else{
                dialog("alert", "ERROR", "Error changing visibility of the post '" + title + "'.", null);
            }
        }
    }
    xmlhttp.open("GET","/post/visible.php?p=" + id + "&v=" + visible, true);
    xmlhttp.send();
}
