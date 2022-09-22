const $formPhotos = document.getElementById("element-formPhotos");
const $photos_preview = document.getElementById("element-photos-preview");
const $modalPhotoUpload = document.getElementById("element-modalPhotoUpload");
const bootstrap_modalPhoto = new bootstrap.Modal($modalPhotoUpload, {
    keyboard: false,
});

$modalPhotoUpload.addEventListener("hidden.bs.modal", async function (event) {
    await crudFunction.selectPhotos();
    uiFunction.refreshFrontpage($formPhotos.album_id.value);
    $formPhotos.album_id.value = 0;
});

let files;

$formPhotos.btn_photos.onclick = (event) => $formPhotos.btn_filePhotos.click();

$formPhotos.btn_filePhotos.onchange = function (event) {
    files = this.files;
    $formPhotos.classList.add("active");
    photo_uiFunction.showFiles(files);
    $formPhotos.classList.remove("active");
};

$formPhotos.ondragover = function (event) {
    event.preventDefault();
    $formPhotos.classList.add("active");
};

$formPhotos.ondragleave = function (event) {
    event.preventDefault();
    $formPhotos.classList.remove("active");
};

$formPhotos.ondrop = function (event) {
    event.preventDefault();
    // $photos_preview.innerHTML = "";
    // files = undefined;
    files = event.dataTransfer.files;
    photo_uiFunction.showFiles(files);
    $formPhotos.classList.remove("active");
};

const photo_uiFunction = {
    showModal: function (album_id) {
        bootstrap_modalPhoto.show();
        $formPhotos.album_id.value = album_id;
        $photos_preview.innerHTML = "";
        files = undefined;
    },
    showFiles: async function (files) {
        if (files.length === undefined) {
            await this.processFile(files);
            return;
        }
        for (const file of files) {
            await this.processFile(file);
        }
    },
    processFile: async function (file) {
        const docType = file.type;
        const validExtensions = ["image/jpeg", "image/jpg", "image/png"];
        if (!validExtensions.includes(docType)) return; //archivo no valido
        const fileReader = new FileReader();
        const id = `file-${Math.random().toString(32).substring(7)}`;
        fileReader.onload = (event) => {
            const fileUrl = fileReader.result;
            const image = `
                <div class="preview-item" id="${id}">
                    <img src="${fileUrl}" alt="${file.name}" loading="lazy" />
                    <div class="status">
                        <span>${file.name}</span>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            `;
            $photos_preview.innerHTML += image;
        };
        fileReader.readAsDataURL(file);
        const formData = new FormData($formPhotos);
        formData.append("file", file);

        //timeout load dom
        function timeout(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        }
        let $progressbar = "";
        while (!$progressbar) {
            $progressbar = document.querySelector(`#${id} .progress .progress-bar`);
            await timeout(100);
        }
        await fetch_ajax(formData, "photo", "insert", (event, percent) => {
            $progressbar.style.width = percent + "%";
            $progressbar.classList.remove("bg-danger");
            $progressbar.classList.remove("bg-success");
            $progressbar.classList.add("bg-info");
        })
            .then((res) => {
                if (res) {
                    $progressbar.classList.remove("bg-danger");
                    $progressbar.classList.remove("bg-info");
                    $progressbar.classList.add("bg-success");
                } else {
                    $progressbar.classList.remove("bg-info");
                    $progressbar.classList.remove("bg-success");
                    $progressbar.classList.add("bg-danger");
                }
            })
            .catch((res) => {
                $progressbar.classList.remove("bg-info");
                $progressbar.classList.remove("bg-success");
                $progressbar.classList.add("bg-danger");
            });

        // fetch_query(formData, "photo", "insert")
        //     .then((res) => {
        //         const $status = document.querySelector(`#${id} .status-text`);
        //         if (res) {
        //             $status.innerText = "Subido correctamente..";
        //             $status.classList.add("text-success");
        //             return;
        //         }
        //         $status.innerText = "Error al subir..";
        //         $status.classList.add("text-danger");
        //     })
        //     .catch((res) => {
        //         $status.innerText = "Error al subir..";
        //         $status.classList.add("text-danger");
        //     });
        // Subir imagenes
    },
};

const photo_handleFunction = {};
