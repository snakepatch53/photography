const forms = document.querySelectorAll(".needs-validation");
const $form = document.getElementById("element-userform");
// const $element_user_pass = document.querySelector("form input[name=usuario_pass]");
const $element_table_user = document.getElementById("element-table-user");
const bootstrap_modalform = new bootstrap.Modal(document.getElementById("element-modalform"), {
    keyboard: false,
});
const bootstrap_modalconfirm = new bootstrap.Modal(document.getElementById("element-modalconfirm"), {
    keyboard: false,
});

async function main() {
    crudFunction.select();
    formInit();
}

//functions
function formInit() {
    "use strict";

    // Loop over them and prevent submission
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
                    crudFunction.insertUpdate($form);
                }

                form.classList.add("was-validated");
            },
            false
        );
    });
}

const handleFunction = {
    new: function () {
        uiFunction.modalForm_clear();
        $form.user_id.value = 0;
        bootstrap_modalform.show();
    },
    edit: function (user_id) {
        const user = uiFunction.userDatabase.find((el) => el.user_id == user_id);
        setValuesForm(user, $form);
        bootstrap_modalform.show();
    },
    delete: function (user_id) {
        $form.user_id.value = user_id;
        bootstrap_modalconfirm.show();
    },
    togglePassword: function ($toggleButton) {
        const $input = $toggleButton.parentNode.querySelector("input");
        const type = $input.getAttribute("type") === "password" ? "text" : "password";
        $input.setAttribute("type", type);
        $toggleButton.innerHTML = type === "password" ? "<i class='fa fa-eye'></i>" : "<i class='fa fa-eye-slash'></i>";
    },
};

const crudFunction = {
    select: async function () {
        await fetch_query(null, "user", "select").then((res) => {
            uiFunction.userDatabase = res;
            uiFunction.refreshTable();
        });
    },
    insertUpdate: function (form) {
        const formData = new FormData(form);
        const action = $form.user_id.value == 0 ? "insert" : "update";
        fetch_query(formData, "user", action).then((res) => {
            uiFunction.modalForm_hide();
            this.select();
        });
    },
    delete: function () {
        const formData = new FormData($form);
        fetch_query(formData, "user", "delete").then((res) => {
            uiFunction.modalForm_hide();
            this.select();
            uiFunction.modalConfirm_hide();
        });
    },
};

const uiFunction = {
    userDatabase: [],
    getTrUser: function ({ user_id, user_name, user_user, user_type }) {
        return `
            <tr>
                <td class="d-none d-md-table-cell fw-bold">${user_id}</td>
                <td class="text-center text-md-left">${user_name}</td>
                <td class="d-none d-md-table-cell">${user_user}</td>
                <td class="d-none d-md-table-cell">${$user_type[user_type]}</td>
                <td class="text-center">
                    <button class="btn btn-outline-primary" onclick="handleFunction.edit(${user_id})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-outline-danger" onclick="handleFunction.delete(${user_id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    },
    refreshTable: function () {
        let html = "";
        for (let user of this.userDatabase) {
            html += this.getTrUser(user);
        }
        $element_table_user.innerHTML = html;
    },
    modalForm_hide: function () {
        bootstrap_modalform.hide();
        $form.reset();
        this.modalForm_clear();
    },
    modalForm_clear: function () {
        $form.reset();
        $form.classList.remove("was-validated");
    },
    modalConfirm_hide: function () {
        bootstrap_modalconfirm.hide();
    },
};

main();
