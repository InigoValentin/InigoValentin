function manageProject(id){
    window.location.href = "/projects/edit.php?p=" + id;
}

function deleteProject(id, title){
    dialog("confirm", "Delete project", "Do you really want to delete the project '" + title + "'?<br/><br/>There is no way to undo this action. You can also unpublish the project instead of deleting it.", function (confirmed) {
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
                        dialog("alert", "ERROR", "Error deleting the project '" + title + "'.", null);
                    }
                }
            }
            xmlhttp.open("GET","/projects/delete.php?p=" + id, true);
            xmlhttp.send();
        }
    });
}

function visibleProject(id, title, visible){
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
                dialog("alert", "ERROR", "Error changing visibility of the project '" + title + "'.", null);
            }
        }
    }
    xmlhttp.open("GET","/projects/visible.php?p=" + id + "&v=" + visible, true);
    xmlhttp.send();
}
