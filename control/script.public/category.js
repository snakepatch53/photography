//declarations
const $category_container = document.getElementById("element-category-container");

//other declarations
let albumDatabase = [];
let categoryDatabase = [];
let photoDatabase = [];

async function InicioMain() {
    await selectAlbum();
    await selectCategory();
    await selectPhoto();
    refreshCategory();
}

//handle functions
//ui functions
function getHtmlItemCategory({ category_id, category_name, category_descr }) {
    let photo_array = albumDatabase
        .filter((el) => el.category_id == category_id)
        .map((album) => photoDatabase.find((el) => el.album_id == album.album_id))
        .filter((el) => el);
    return `
        <a 
            href="${$proyect.url}category/${category_id}" 
            class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item check"
        >
            <div class="card p-0 shadow">
                <div class="frontpage">${getFrontpage(photo_array)}</div>
                <div class="card-body px-4 py-2">
                    <h5 class="card-title text-primary text-center">${category_name}</h5>
                </div>
            </div>
        </a>
    `;
}
function refreshCategory() {
    let html = "";
    categoryDatabase.forEach((category, index) => (html += getHtmlItemCategory(category)));
    $category_container.innerHTML = html;
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
            let imgSrc = `${$proyect.url}model/script/photo/getphoto.php?photo_name=${photo.photo_name}&photo_quality=20&photo_size=500`;
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
async function selectAlbum() {
    await fetch_query(null, "album", "select").then((res) => (albumDatabase = res));
}
async function selectPhoto() {
    await fetch_query(null, "photo", "select").then((res) => (photoDatabase = res));
}

async function selectCategory() {
    await fetch_query(null, "category", "select").then((res) => {
        categoryDatabase = res;
    });
}

InicioMain();
