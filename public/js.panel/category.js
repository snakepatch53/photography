const forms = document.querySelectorAll(".needs-validation");
const $form = document.getElementById("element-categoryform");
const $element_table_category = document.getElementById("element-table-category");
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
        $form.category_id.value = 0;
        bootstrap_modalform.show();
    },
    edit: function (category_id) {
        const category = uiFunction.categoryDatabase.find((el) => el.category_id == category_id);
        setValuesForm(category, $form);
        bootstrap_modalform.show();
    },
    delete: function (category_id) {
        $form.category_id.value = category_id;
        bootstrap_modalconfirm.show();
    },
};

const crudFunction = {
    select: async function () {
        await fetch_query(null, "category", "select").then((res) => {
            uiFunction.categoryDatabase = res.data;
            uiFunction.refreshTable();
        });
    },
    insertUpdate: function (form) {
        const formData = new FormData(form);
        const action = $form.category_id.value == 0 ? "insert" : "update";
        fetch_query(formData, "category", action).then((res) => {
            uiFunction.modalForm_hide();
            this.select();
        });
    },
    delete: function () {
        const formData = new FormData($form);
        fetch_query(formData, "category", "delete").then((res) => {
            uiFunction.modalForm_hide();
            this.select();
            uiFunction.modalConfirm_hide();
        });
    },
};

const uiFunction = {
    categoryDatabase: [],
    getTrcategory: function ({ category_id, category_name, category_descr }) {
        return `
            <tr>
                <td class="d-none d-md-table-cell fw-bold">${category_id}</td>
                <td class="text-center text-md-left">${category_name}</td>
                <td class="text-center">
                    <button class="btn btn-outline-primary" onclick="handleFunction.edit(${category_id})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="btn btn-outline-danger" onclick="handleFunction.delete(${category_id})">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </td>
            </tr>
        `;
    },
    refreshTable: function () {
        let html = "";
        for (let category of this.categoryDatabase) {
            html += this.getTrcategory(category);
        }
        $element_table_category.innerHTML = html;
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
