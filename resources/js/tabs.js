function openTab(event, tabName) {

    var contents = document.getElementsByClassName("tab-content");
    var buttons = document.getElementsByClassName("tab-button");


    // Dölj alla tab-innehåll
    for (var i = 0; i < contents.length; i++) {

        contents[i].classList.remove("active");

    }

    // Ta bort aktiv klass från alla knappar
    for (var i = 0; i < buttons.length; i++) {

        buttons[i].classList.remove("active");

    }

    // Visa vald tab
    document.getElementById(tabName).classList.add("active");

    // Markera vald knapp
    event.currentTarget.classList.add("active");

}

window.onload = function() {

    var contents = document.getElementsByClassName("tab-content");

    for (var i = 0; i < contents.length; i++) {
        contents[i].classList.remove("active");
    }

    document.getElementById("security").classList.add("active");

    var buttons = document.getElementsByClassName("tab-button");

    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("active");
    }

    document.getElementById("security-button").classList.add("active");

};

