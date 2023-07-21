//declarations
const $photo_container = document.getElementById("element-photo-container");
const $title = document.getElementById("element-title");

//other declarations
let photoDatabase = [];

async function InicioMain() {
    const data = await selectAlbumById();
    photoDatabase = data.album_photos;
    refreshphoto(photoDatabase);
}

//handle functions
function handleView(button, view) {
    const condition = ({ photo_like }) => {
        if (view == 0) return true;
        if (view == 1) return photo_like == true;
        if (view == 2) return photo_like != true;
    };
    const photo_array = photoDatabase.filter((el) => condition(el));
    document.querySelectorAll(".visibility-items").forEach((el) => el.classList.remove("disabled"));
    button.classList.add("disabled");
    refreshphoto(photo_array);
}

//ui functions
function getHtmlItemphoto({ id, url, name, folder, picked }, index) {
    const date = moment(new Date()).format("LLL");
    return `
        <div 
            class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item check" 
            id="element-photo-id-${id}"
        >
            <div class="card p-0">
                <img src="${url}" class="card-img-top" alt="Foto del album" onclick="showPhotoInImageviewer(${index})" loading="lazy">
                <div class="card-body px-4 py-2">
                    <div class="row">
                        <div class="col-10">
                            <span class="text-info datetime">${date}</span>
                            <span class="text-primary">#${index + 1}</span>
                        </div>
                        <button 
                            class="border-0 bg-transparent text-primary col-2 p-2 fs-4 select ${
                                picked == true ? "like" : ""
                            }" 
                            onclick="likePhoto('${id}')"
                        >
                            <span class="check"><i class="fa-regular fa-star"></i></span>
                            <span class="uncheck"><i class="fa-solid fa-star"></i></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function refreshphoto(photoDatabase) {
    let html = "";
    photoDatabase.forEach(
        (photo, index) => (html += getHtmlItemphoto(photo, index, photoDatabase))
    );
    $photo_container.innerHTML = html;
}

//crud functions
async function selectAlbumById() {
    const formData = new FormData();
    formData.append("album_id", $album_id);
    return await fetch_query(formData, "album", "select_by_id").then((res) => {
        $title.innerText = res.data.album_name;
        return res.data;
    });
}

function likePhoto(id) {
    const { folder, name, picked } = photoDatabase.find((el) => el.id == id);
    const photo = name;
    const pick = !picked;
    const formData = new FormData();
    formData.append("folder", folder);
    formData.append("photo", photo);
    formData.append("pick", pick);
    fetch_query(formData, "album", "pick_photo").then((res) => {
        const new_name = res.data;
        const btn_like = document.querySelector(`#element-photo-id-${id} button.select`);
        if (pick) {
            console.log("like");
            btn_like.classList.add("like");
        } else {
            console.log("unlike");
            btn_like.classList.remove("like");
        }
        photoDatabase.map((el) => {
            if (el.id == id) {
                el.picked = pick;
                el.name = new_name;
            }
        });
    });
}

// main call
InicioMain();
