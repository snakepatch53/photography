const forms = document.querySelectorAll(".needs-validation");
const $form = document.getElementById("element-clientform");
const $element_table_client = document.getElementById("element-table-client");
const bootstrap_modalform = new bootstrap.Modal(document.getElementById("element-modalform"), {
    keyboard: false,
});
const bootstrap_modalconfirm = new bootstrap.Modal(
    document.getElementById("element-modalconfirm"),
    {
        keyboard: false,
    }
);

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
        $form.client_id.value = 0;
        bootstrap_modalform.show();
    },
    edit: function (client_id) {
        const client = uiFunction.clientDatabase.find((el) => el.client_id == client_id);
        setValuesForm(client, $form);
        bootstrap_modalform.show();
    },
    delete: function (client_id) {
        $form.client_id.value = client_id;
        bootstrap_modalconfirm.show();
    },
};

const crudFunction = {
    select: async function () {
        await fetch_query(null, "client", "select").then((res) => {
            uiFunction.clientDatabase = res.data;
            uiFunction.refreshTable();
        });
    },
    insertUpdate: function (form) {
        const formData = new FormData(form);
        const action = $form.client_id.value == 0 ? "insert" : "update";
        fetch_query(formData, "client", action).then((res) => {
            uiFunction.modalForm_hide();
            this.select();
        });
    },
    delete: function () {
        const formData = new FormData($form);
        fetch_query(formData, "client", "delete").then((res) => {
            uiFunction.modalForm_hide();
            this.select();
            uiFunction.modalConfirm_hide();
        });
    },
};

const uiFunction = {
    clientDatabase: [],
    getTrclient: function ({ client_id, client_name, client_phone, client_mail }) {
        return `
            <tr>
                <td class="d-none d-md-table-cell fw-bold">${client_id}</td>
                <td class="text-center text-md-left">${client_name}</td>
                <td class="d-none d-md-table-cell">${client_phone}</td>
                <td class="d-none d-md-table-cell">${client_mail}</td>
                <td class="text-center">
                    <button class="btn btn-outline-primary" onclick="handleFunction.edit(${client_id})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-outline-danger" onclick="handleFunction.delete(${client_id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    },
    refreshTable: function () {
        let html = "";
        for (let client of this.clientDatabase) {
            html += this.getTrclient(client);
        }
        $element_table_client.innerHTML = html;
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
