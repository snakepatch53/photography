const $formLogin = document.getElementById("element-loginform");
const $toggleButton = document.getElementById("togglePassword");
const $msgLogin = document.getElementById("element-msg-login");

("use strict");
$formLogin.onsubmit = function (event) {
    if (!$formLogin.checkValidity()) {
        event.stopPropagation();
        event.preventDefault();
    }
    // if ($formLogin.checkValidity()) {
    //     event.preventDefault();
    // }
    handleSubmit(event);
    $formLogin.classList.add("was-validated");
};

$toggleButton.onclick = function () {
    const $input = $toggleButton.parentNode.querySelector("input");
    const type = $input.getAttribute("type") === "password" ? "text" : "password";
    $input.setAttribute("type", type);
    $toggleButton.innerHTML =
        type === "password" ? "<i class='fa fa-eye'></i>" : "<i class='fa fa-eye-slash'></i>";
};

function handleSubmit(event) {
    event.preventDefault();
    const user_user = $formLogin.user_user.value;
    const user_pass = $formLogin.user_pass.value;
    if (!user_user) return showMsg("Ingrese su usuario!");
    if (!user_pass) return showMsg("Ingrese su contraseña!");

    $formLogin.btnSubmit.innerHTML = `
        <span class="me-1">Iniciar sesion</span>
        <i class="fas fa-spinner fa-spin"></i>
    `;
    $formLogin.btnSubmit.classList.add("disabled");

    const formData = new FormData($formLogin);
    fetch_query(formData, "user", "login").then((res) => {
        $formLogin.btnSubmit.innerHTML = `
            <span class="me-1">Iniciar sesion</span>
            <i class="fa-solid fa-right-to-bracket"></i>
        `;
        $formLogin.btnSubmit.classList.remove("disabled");
        if (res?.response) return (location.href = `${http_domain}panel/home`);
        showMsg("Credenciales incorrectos!");
    });
}

function showMsg(text) {
    $msgLogin.innerText = text;
    setTimeout(() => {
        $msgLogin.innerText = "";
    }, 2000);
}
