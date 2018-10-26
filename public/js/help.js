function toggleHelp(id){
    var helps = document.getElementsByClassName("help");
    for (var i = 0; i < helps.length; i++) {
        if (helps[i].id == id){
            if (helps[i].classList.contains("selected")){
                helps[i].classList.remove("selected");
            }
            else{
                helps[i].classList.add("selected");
            }
        }
        else{
            helps[i].classList.remove("selected");
        }
    }
}
