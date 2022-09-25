//declarations
const $album_container = document.getElementById("element-album-container");
const $input_search = document.getElementById("element-input-search");
const $title = document.getElementById("element-title");

//events
$input_search.onkeyup = (event) => handleSearch(event);

//other declarations
let albumDatabase = [];
let photoDatabase = [];

async function InicioMain() {
    await selectAlbum();
    await selectPhoto();
    await selectCategoryById();
    refreshAlbum(albumDatabase);
}

//handle functions
function handleSearch(event) {
    const value = event.srcElement.value;
    const album_array = albumDatabase.filter((el) => el.album_name.toLowerCase().includes(value.toLowerCase()));
    if (value === "") {
        refreshAlbum(albumDatabase);
        return;
    }
    refreshAlbum(album_array);
}

//ui functions
function getHtmlItemalbum({ album_id, album_name, album_descr }) {
    let photo_array = photoDatabase.filter((el) => el.album_id == album_id).filter((el) => el);
    return `
        <a 
            href="${$proyect.url}album/${album_id}" 
            class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item check"
        >
            <div class="card p-0 shadow">
                <div class="frontpage">${getFrontpage(photo_array)}</div>
                <div class="card-body px-4 py-2">
                    <h5 class="card-title text-primary text-center">${album_name}</h5>
                </div>
            </div>
        </a>
    `;
}
function refreshAlbum(albumDatabase) {
    let html = "";
    albumDatabase.forEach((album, index) => (html += getHtmlItemalbum(album)));
    $album_container.innerHTML = html;
}
function getFrontpage(photos) {
    let html = "";
    let max_photo = 0;
    if (photos.length >= 1) max_photo = 1;
    if (photos.length >= 2) max_photo = 2;
    if (photos.length >= 4) max_photo = 4;
    if (photos.length >= 9) max_photo = 9;
    const col = max_photo == 9 ? 4 : max_photo == 1 ? 12 : 6;
    if (max_photo == 0) {
        html = `<img src="${$proyect.url}view/img/notfound.gif" class="card-img-top" alt="Album not found" loading="lazy">`;
    } else {
        html = `<div class="row g-0 frontpage-el">`;
        for (let i = 0; i < max_photo; i++) {
            const photo = photos[i];
            let imgSrc = `${$proyect.url}model/script/photo/getphoto.php?photo_name=${photo.photo_name}&photo_quality=10&photo_size=300`;
            if (photo.photo_name == null || photo.photo_name == "") imgSrc = `${$proyect.url}view/img/notfound.gif`;
            html += `
                <img class="col-${col}" src="${imgSrc}" alt="${photo.photo_name}" loading="lazy" />
            `;
        }
        html += `</div>`;
    }
    return html;
}

//crud functions
async function selectCategoryById() {
    const formData = new FormData();
    formData.append("category_id", $category_id);
    if ($category_id != 0) {
        await fetch_query(formData, "category", "selectById").then((res) => {
            $title.innerText = res.category_name;
        });
        return;
    }
    $title.innerText = "Lista de Albums";
}
async function selectAlbum() {
    await fetch_query(null, "album", "select").then((res) => {
        if ($category_id == 0) {
            albumDatabase = res;
            return;
        }
        albumDatabase = res.filter((el) => el.category_id == $category_id);
    });
}
async function selectPhoto() {
    await fetch_query(null, "photo", "select").then((res) => (photoDatabase = res));
}

InicioMain();
