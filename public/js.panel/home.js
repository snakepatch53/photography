//#region info
const $formInfo = document.getElementById("element-infoForm");

let INFO_DATABASE = [];

function mainInfo() {
    formInfoInit();
    infoFormSelect();
}

// functions
function formInfoInit() {
    $formInfo.onsubmit = function (event) {
        if (!$formInfo.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        if ($formInfo.checkValidity()) {
            event.preventDefault();
            infoFormInsert($formInfo);
        }
        $formInfo.classList.add("was-validated");
    };
}

// crud functions
function infoFormSelect() {
    fetch_query(null, "info", "select").then((res) => {
        INFO_DATABASE = res.data;
        setValuesForm(INFO_DATABASE, $formInfo);
    });
}

function infoFormInsert($formInfo) {
    const formData = new FormData($formInfo);
    $formInfo.btnSubmit.innerHTML = `
        <span>Guardar</span>
        <i class="fas fa-spinner fa-spin"></i>
    `;
    $formInfo.btnSubmit.classList.add("disabled");
    fetch_query(formData, "info", "update").then((res) => {
        $formInfo.btnSubmit.innerHTML = `
            <span>Enviar</span>
            <i class="fa-solid fa-floppy-disk"></i>
        `;
        $formInfo.btnSubmit.classList.remove("disabled");
        $formInfo.reset();
        $formInfo.classList.remove("was-validated");
        $formInfo.querySelector(".msg-feetback").innerText = "Listo";
        infoFormSelect();
        setTimeout(() => ($formInfo.querySelector(".msg-feetback").innerText = ""), 1000);
    });
}

mainInfo();
//#endregion

// CONTACT CRUD
const $formContact = document.getElementById("element-contactform");
const $element_table_contact = document.getElementById("element-table-contact");
const bootstrap_modalform = new bootstrap.Modal(document.getElementById("element-modalform"), {
    keyboard: false,
});
const bootstrap_modalconfirm = new bootstrap.Modal(
    document.getElementById("element-modalconfirm"),
    {
        keyboard: false,
    }
);

async function mainContact() {
    crudFunction.select();
    formContactInit();
}

//functions
function formContactInit() {
    // Loop over them and prevent submission
    $formContact.onsubmit = function (event) {
        if (!$formContact.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        if ($formContact.checkValidity()) {
            event.preventDefault();
            crudFunction.insertUpdate($formContact);
        }
        $formContact.classList.add("was-validated");
    };
}

const handleFunction = {
    new: function () {
        uiFunction.modalForm_clear();
        $formContact.contact_id.value = 0;
        bootstrap_modalform.show();
    },
    edit: function (contact_id) {
        const contact = uiFunction.contactDatabase.find((el) => el.contact_id == contact_id);
        setValuesForm(contact, $formContact);
        bootstrap_modalform.show();
    },
    delete: function (contact_id) {
        $formContact.contact_id.value = contact_id;
        bootstrap_modalconfirm.show();
    },
};

const crudFunction = {
    select: async function () {
        await fetch_query(null, "contact", "select").then((res) => {
            uiFunction.contactDatabase = res.data;
            uiFunction.refreshTable();
        });
    },
    insertUpdate: function (form) {
        const formData = new FormData(form);
        const action = $formContact.contact_id.value == 0 ? "insert" : "update";
        fetch_query(formData, "contact", action).then((res) => {
            uiFunction.modalForm_hide();
            this.select();
        });
    },
    delete: function () {
        const formData = new FormData($formContact);
        fetch_query(formData, "contact", "delete").then((res) => {
            uiFunction.modalForm_hide();
            this.select();
            uiFunction.modalConfirm_hide();
        });
    },
};

const uiFunction = {
    contactDatabase: [],
    getTrcontact: function ({
        contact_id,
        contact_name,
        contact_link,
        contact_icon,
        contact_color,
    }) {
        return `
            <tr>
                <td class="d-none d-md-table-cell fw-bold">${contact_id}</td>
                <td class="text-center text-md-left"><a href="${contact_link}" target="_blank">${contact_name}</a></td>
                <td class="text-center text-md-left"><i class="${contact_icon} fs-4" style="color:${contact_color}" />></td>
                <td class="text-center">
                    <button class="btn btn-outline-primary" onclick="handleFunction.edit(${contact_id})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-outline-danger" onclick="handleFunction.delete(${contact_id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    },
    refreshTable: function () {
        let html = "";
        for (let contact of this.contactDatabase) {
            html += this.getTrcontact(contact);
        }
        $element_table_contact.innerHTML = html;
    },
    modalForm_hide: function () {
        bootstrap_modalform.hide();
        $formContact.reset();
        this.modalForm_clear();
    },
    modalForm_clear: function () {
        $formContact.reset();
        $formContact.classList.remove("was-validated");
    },
    modalConfirm_hide: function () {
        bootstrap_modalconfirm.hide();
    },
};

mainContact();
