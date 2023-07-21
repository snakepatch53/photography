//variables
let AlbumSelected_id = 0;

// elements
const $uploadarea = document.getElementById("uploadarea");
const $uploadinput = document.getElementById("uploadinput");
const $uploadbutton = document.getElementById("uploadbutton");
const $preview = document.getElementById("preview");
const $modalPhotoUpload = document.getElementById("element-modalPhotoUpload");

// modal
const bootstrap_modalPhoto = new bootstrap.Modal($modalPhotoUpload, {
    keyboard: false,
});

// modal event
$modalPhotoUpload.addEventListener("hidden.bs.modal", async function (event) {
    await crudFunction.selectPhotos();
    uiFunction.refreshFrontpage(AlbumSelected_id);
    AlbumSelected_id = 0;
    $preview.innerHTML = "";
});

// upload events
$uploadbutton.onclick = () => $uploadinput.click();
$uploadinput.onchange = (event) => handleChange(event);
$uploadarea.ondragover = (event) => handleOver(event);
$uploadarea.ondragleave = (event) => handleLeave(event);
$uploadarea.ondrop = (event) => handleDrop(event);

// upload functioncs
function handleOver(event) {
    event.preventDefault();
    $uploadarea.classList.add("bg-dark");
}
function handleLeave(event) {
    event.preventDefault();
    $uploadarea.classList.remove("bg-dark");
}
function handleDrop(event) {
    event.preventDefault();
    $uploadarea.classList.remove("bg-dark");
    const files = event.dataTransfer.files;
    hanldeFiles(files);
}
function handleChange(event) {
    const files = uploadinput.files;
    hanldeFiles(files);
}
async function hanldeFiles(files) {
    const upload_id = `upload-${Math.random().toString(32).substring(7)}`;
    for (const file of files) {
        const file_id = `file-${Math.random().toString(32).substring(7)}`;
        file.id = file_id;
        const foto = await compressImg(file, 5);
        $preview.innerHTML += getHtmlItem(foto.src, file_id, upload_id);
    }
    await waitLoadHTML(".miniPreviewImgItem." + upload_id, files.length);
    let cont = 0;
    for (const file of files) {
        const item_img_id = "item-img-id-" + file.id;
        const formData = new FormData();
        formData.append("file", file);
        formData.append("album_id", AlbumSelected_id);
        await fetch_ajax(formData, "photo", "insert", (event, percent) => handlePercent(item_img_id, percent, 0))
            .then((res) => {
                if (res) {
                    cont++;
                    handlePercent(item_img_id, 100, 1);
                    return;
                }
                handlePercent(item_img_id, 100, 2);
            })
            .catch((err) => handlePercent(item_img_id, 100, 2));
    }
    $preview.innerHTML += `
        <p class="col col-12 text-center">${cont} fotos subidas, ${files.length - cont} fallidas</p>
    `;
}

// other functions
function showUploadModal(album_id) {
    bootstrap_modalPhoto.show();
    AlbumSelected_id = album_id;
}

function getHtmlItem(src, file_id, upload_id) {
    return `
        <div class="col col-4 col-md-2 miniPreviewImgItem ${upload_id}" id="item-img-id-${file_id}">
            <div class="card border border-info rounded-3">
                <img class="m-0 p-0 rounded-top rounded-3" src="${src}" style="width:100%;height:50px;object-fit:cover;" />
                <div class="progress m-2" style="height:8px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
            </div>
        </div>
    `;
}

async function waitLoadHTML(selector, numItems) {
    let isLoad = false;
    while (!isLoad) {
        const loadHtml = $preview.querySelectorAll(selector);
        if (loadHtml.length == numItems) isLoad = true;
        await timeout(100);
    }
}

function handlePercent(id, percent, state) {
    const stateClassList = ["bg-info", "bg-success", "bg-danger"];
    const stateClass = stateClassList[state];
    const $itemImg = document.getElementById(id);
    const $progressbar = $itemImg.querySelector(".progress-bar");
    $progressbar.style.width = percent + "%";
    stateClassList.map((el) => (stateClass != el ? $progressbar.classList.remove(el) : $progressbar.classList.add(stateClass)));
}
