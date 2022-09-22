const forms = document.querySelectorAll(".needs-validation");
function mainContactForm() {
    formInit();
}

// functions
function formInit() {
    "use strict";
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener(
            "submit",
            function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                if (form.checkValidity()) {
                    event.preventDefault();
                    contactFormInsert(form);
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
}

// crud functions
function contactFormInsert($form) {
    const formData = new FormData($form);
    $form.btnSubmit.innerHTML = `
        <span>Enviar</span>
        <i class="fas fa-spinner fa-spin"></i>
    `;
    $form.btnSubmit.classList.add("disabled");
    fetch_query(formData, "client", "insert").then((res) => {
        $form.btnSubmit.innerHTML = `
            <span>Enviar</span>
            <i class="fa-sharp fa-solid fa-paper-plane"></i>
        `;
        $form.btnSubmit.classList.remove("disabled");
        $form.reset();
        $form.classList.remove("was-validated");
        $form.querySelector(".msg-feetback").innerText = "Listo";
        setTimeout(
            () => ($form.querySelector(".msg-feetback").innerText = ""),
            1000
        );
    });
}

mainContactForm();
