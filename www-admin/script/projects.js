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

function deleteVersion(id, title){
    dialog("confirm", "Delete version", "Do you really want to delete the version '" + title + "'?<br/><br/>There is no way to undo this action. You can also unpublish the version instead of deleting it.", function (confirmed) {
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
                        dialog("alert", "ERROR", "Error deleting the version '" + title + "'.", null);
                    }
                }
            }
            xmlhttp.open("GET","/projects/deleteversion.php?v=" + id, true);
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
            xmlhttp.open("GET","/projects/deletecomment.php?i=" + id, true);
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

function selectIcon(){
    document.getElementById("icon_file").click();
}

function changeIcon(event, title){
    console.log("changeIcon 1");
    var frame = document.getElementById("icon");
    var file = event.target.files[0];
    var reader = new FileReader();
    var httpPost = new XMLHttpRequest();
    console.log("changeIcon 2");
    reader.onloadend = function() {
        console.log("changeIcon LOADEND 1");
        console.log('RESULT', reader.result);
        var data = "image=IVV" + reader.result;
        var path = "/projects/uploadimage.php?name=" + title + "-icon.png";
        console.log("changeIcon LOADEND 2");
        httpPost.open("POST", path, true);
        console.log("changeIcon LOADEND 3");
        httpPost.setRequestHeader('Content-Type', 'x-www-form-urlencoded');
        httpPost.setRequestHeader("Content-length", data.length);
        console.log("changeIcon LOADEND 4");
        httpPost.send(data);
        console.log("changeIcon LOADEND 5 - END");
    }
    console.log("changeIcon 3");
    var b64 = reader.readAsDataURL(file);
    //var b64 = reader.result;
    console.log("changeIcon 4");
    httpPost.onreadystatechange = function(err) {
        console.log("changeIcon REQCHANGE");
        if (httpPost.readyState == 4 && httpPost.status == 200){
            console.log("changeIcon REQOK");
            frame.src = window.URL.createObjectURL(event.target.files[0]);
            console.log(httpPost.responseText);
        }
        else {
            console.log("changeIcon REQ-ERROR");
            console.log(err);
        }
    };
    console.log("changeIcon 5 - END");
    
}
