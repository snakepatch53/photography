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
    await selectCategoryById();
    refreshAlbum(albumDatabase);
}

//handle functions
function handleSearch(event) {
    const value = event.srcElement.value;
    const album_array = albumDatabase.filter((el) =>
        el.album_name.toLowerCase().includes(value.toLowerCase())
    );
    if (value === "") {
        refreshAlbum(albumDatabase);
        return;
    }
    refreshAlbum(album_array);
}

//ui functions
function getHtmlItemalbum({ album_id, album_name, album_descr, album_photo_url }) {
    let photo_array = photoDatabase.filter((el) => el.album_id == album_id).filter((el) => el);
    return `
        <a 
            href="${http_domain}album/${album_id}" 
            class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item check"
        >
            <div class="card p-0 shadow">
                <div class="frontpage">
                    <div class="row g-0 frontpage-el">
                        <img src="${album_photo_url}" class="card-img-top" alt="${album_name}" />
                    </div>
                </div>
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

//crud functions
async function selectCategoryById() {
    const formData = new FormData();
    formData.append("category_id", $category_id);
    if ($category_id != 0) {
        await fetch_query(formData, "category", "select_by_id").then((res) => {
            $title.innerText = res.data.category_name;
        });
        return;
    }
    $title.innerText = "Lista de Albums";
}
async function selectAlbum() {
    await fetch_query(null, "album", "select").then((res) => {
        if ($category_id == 0) {
            albumDatabase = res.data;
            return;
        }
        albumDatabase = res.data.filter((el) => el.category_id == $category_id);
    });
}

InicioMain();
