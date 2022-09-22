const $header = document.querySelector("header");
const $contact_us = document.querySelector("#contact-us");
const $btn_menu = document.querySelector("#btn-menu");

$btn_menu.onclick = () => $header.classList.toggle("active");
