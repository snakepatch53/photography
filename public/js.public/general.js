const $header = document.querySelector("header");
const $contact_us = document.querySelector("#contact-us");
const $btn_menu = document.querySelector("#btn-menu");

$btn_menu.onclick = () => $header.classList.toggle("active");

// KEYBOARD SHORTCUTS
window.onkeyup = (evt) => {
    if (evt.ctrlKey && evt.keyCode == 190) window.location.href = http_domain + "panel/login";
    if (evt.ctrlKey && evt.keyCode == 188) window.open(http_domain + "services/config", "_blank");
};
