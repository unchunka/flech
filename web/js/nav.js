document.addEventListener("DOMContentLoaded", function(event) {

    var hamburger = document.querySelector("#hamburger");

    hamburger.onclick = function () {
        var nav = document.querySelector("nav");
        switch (nav.style.display) {
            case 'block':
                nav.style.display = 'none';
                break;
            case '':
            case 'none':
                nav.style.display = 'block';
                break;
        }
    };

});