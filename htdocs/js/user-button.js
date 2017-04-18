"use strict";
var list = document.getElementById("user-alternatives");
document.addEventListener("click", function() {
    if (!list.classList.contains("hide")) {
        list.classList.add("hide");
    }
});
document.getElementById("user-button").addEventListener("click", function(event) {
    event.stopPropagation();
    list.classList.toggle("hide");
});
