//declarations
const $category_container = document.getElementById("element-category-container");

//other declarations
let albumDatabase = [];
let categoryDatabase = [];
let photoDatabase = [];

async function InicioMain() {
    await selectAlbum();
    await selectCategory();
    // await selectPhoto();
    refreshCategory();
}

//handle functions
//ui functions
function getHtmlItemCategory({ category_id, category_name, category_descr, category_photo_url }) {
    return `
        <a 
            href="${http_domain}category/${category_id}" 
            class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item check"
        >
            <div class="card p-0 shadow">
                <div class="frontpage">
                    <div class="row g-0 frontpage-el">
                        <img src="${category_photo_url}" class="card-img-top" alt="${category_name}" />
                    </div>
                </div>
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

//crud functions
async function selectAlbum() {
    await fetch_query(null, "album", "select").then((res) => {
        albumDatabase = res.data;
    });
}

async function selectCategory() {
    await fetch_query(null, "category", "select").then((res) => {
        categoryDatabase = res.data;
    });
}

InicioMain();
