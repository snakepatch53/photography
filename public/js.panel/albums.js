const forms = document.querySelectorAll(".needs-validation");
const $form = document.getElementById("element-albumform");
const $search = document.getElementById("element-search");
// const $element_album_pass = document.querySelector("form input[name=usuario_pass]");
const $element_table_album = document.getElementById("element-table-album");
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
    // await crudFunction.selectPhotos();
    await crudFunction.select();
    await crudFunction.selectclients();
    await crudFunction.selectCategory();
    await crudFunction.selectFolders();
    formInit();

    $search.onkeyup = (event) => uiFunction.search(event);
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
        $form.album_id.value = 0;
        bootstrap_modalform.show();
    },
    edit: function (album_id) {
        const album = uiFunction.albumDatabase.find((el) => el.album_id == album_id);
        setValuesForm(album, $form);
        bootstrap_modalform.show();
    },
    delete: function (album_id) {
        $form.album_id.value = album_id;
        bootstrap_modalconfirm.show();
    },
    togglePassword: function ($toggleButton) {
        const $input = $toggleButton.parentNode.querySelector("input");
        const type = $input.getAttribute("type") === "password" ? "text" : "password";
        $input.setAttribute("type", type);
        $toggleButton.innerHTML =
            type === "password" ? "<i class='fa fa-eye'></i>" : "<i class='fa fa-eye-slash'></i>";
    },
};

const crudFunction = {
    select: async function () {
        await fetch_query(null, "album", "select").then((res) => {
            if (!res?.data) return;
            uiFunction.albumDatabase = res.data;
            uiFunction.refreshTable();
        });
    },
    selectclients: async function () {
        await fetch_query(null, "client", "select").then((res) => {
            if (!res?.data) return;
            uiFunction.clientDatabase = res.data;
            uiFunction.refresSelectclient();
        });
    },
    selectCategory: async function () {
        await fetch_query(null, "category", "select").then((res) => {
            if (!res?.data) return;
            uiFunction.categoryDatabase = res.data;
            uiFunction.refresSelectCategory();
        });
    },
    selectFolders: async function () {
        await fetch_query(null, "album", "get_folders").then((res) => {
            if (!res?.data) return;
            uiFunction.folderDatabase = res.data;
            uiFunction.refresSelectFolder();
        });
    },
    // selectPhotos: async function () {
    //     await fetch_query(null, "photo", "select").then((res) => {
    //         uiFunction.photoDatabase = res.data;
    //     });
    // },
    insertUpdate: function (form) {
        const formData = new FormData(form);
        const action = $form.album_id.value == 0 ? "insert" : "update";
        fetch_query(formData, "album", action).then((res) => {
            uiFunction.modalForm_hide();
            this.select();
        });
    },
    delete: function () {
        const formData = new FormData($form);
        fetch_query(formData, "album", "delete").then((res) => {
            uiFunction.modalForm_hide();
            this.select();
            uiFunction.modalConfirm_hide();
        });
    },
};

const uiFunction = {
    albumDatabase: [],
    clientDatabase: [],
    folderDatabase: [],
    photoDatabase: [],
    categoryDatabase: [],
    getTralbum: function ({ album_id, album_name, client_name, album_photo_url }) {
        const photos = this.photoDatabase.filter((el) => el.album_id == album_id);
        return `
            <div class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item" id="album-item-${album_id}">
                <div class="card p-0">
                    <div class="frontpage">
                        <div class="row g-0 frontpage-el">
                            ${"" /*this.getFrontpage(photos)*/}
                            <img src='${album_photo_url}' alt='${album_name}'/>
                        </div>
                    </div>
                    <div class="card-body px-4 py-2">
                        <h6 class="text-primary text-center">${album_name}</h6>
                        <h6 class="d-flex mb-3">
                            <b>Cliente: </b>
                            <span class="ms-1 fw-normal">${client_name}</span>
                        </h6>
                        <div class="container">
                            <div class="row gx-3">
                                <div class="col-3">
                                    <button class="btn btn-outline-success p-2" onclick="showUploadModal(${album_id})">
                                        <i class="fa-solid fa-upload"></i>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-outline-dark p-2" onclick="viewPhoto_uiFunction.showModal(${album_id})">
                                        <i class="fa-solid fa-folder-open"></i>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-outline-info p-2" onclick="handleFunction.edit(${album_id})">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-outline-danger p-2" onclick="handleFunction.delete(${album_id})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    },
    refreshTable: function () {
        let html = `<h6 class='text-center fw-normal'>No hay registros..</h6>`;
        if (this.albumDatabase.length > 0) html = "";
        for (let album of this.albumDatabase) {
            html += this.getTralbum(album);
        }
        $element_table_album.innerHTML = html;
    },
    refresSelectclient: function () {
        let html = "<option value=''>Selecciona un usuario..</option>";
        for (let client of this.clientDatabase) {
            html += `<option value="${client.client_id}">${client.client_name}</option>`;
        }
        $form.client_id.innerHTML = html;
    },
    refresSelectCategory: function () {
        let html = "<option value=''>Selecciona una categoria..</option>";
        for (let category of this.categoryDatabase) {
            html += `<option value="${category.category_id}">${category.category_name}</option>`;
        }
        $form.category_id.innerHTML = html;
    },
    refresSelectFolder: function () {
        let html = "<option value=''>Selecciona una carpeta..</option>";
        for (let _folder of this.folderDatabase) {
            const { folder } = _folder;
            html += `<option value="${folder}">${folder}</option>`;
        }
        $form.album_path.innerHTML = html;
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
    refreshFrontpage: function (album_id) {
        const photos = this.photoDatabase.filter((el) => el.album_id == album_id);
        document.querySelector(`#album-item-${album_id} .frontpage`).innerHTML =
            this.getFrontpage(photos);
    },
    getFrontpage: function (photos) {
        let html = "";
        let max_photo = 0;
        if (photos.length >= 1) max_photo = 1;
        if (photos.length >= 2) max_photo = 2;
        if (photos.length >= 4) max_photo = 4;
        if (photos.length >= 9) max_photo = 9;
        const col = max_photo == 9 ? 4 : max_photo == 1 ? 12 : 6;
        if (max_photo == 0) {
            html = `<img src="${http_domain}public/img/photo/notfound.gif" class="card-img-top" alt="Album not found" loading="lazy">`;
        } else {
            html = `<div class="row g-0 frontpage-el">`;
            for (let i = 0; i < max_photo; i++) {
                const photo = photos[i];
                const url = http_domain + "public/img/photo/";
                let imgSrc = `${http_domain}services/photo/get_photo?photo_name=${photo.photo_name}&photo_quality=10&photo_size=200`;
                html += `<img class="col-${col}" src="${imgSrc}" alt="${photo.photo_name}" loading="lazy" />`;
            }
            html += `</div>`;
        }
        return html;
    },
    search: function (event) {
        const value = event.target.value;
        if (value !== "") {
            let html = `<h6 class='text-center fw-normal'>No hay registros..</h6>`;
            if (this.albumDatabase.length > 0) html = "";
            for (let album of this.albumDatabase) {
                if (
                    album.album_name.toLowerCase().includes(value.toLowerCase()) ||
                    album.client_name.toLowerCase().includes(value.toLowerCase())
                ) {
                    html += this.getTralbum(album);
                }
            }
            $element_table_album.innerHTML = html;
        } else {
            this.refreshTable();
        }
    },
};

main();
