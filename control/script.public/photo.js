//declarations
const $photo_container = document.getElementById("element-photo-container");
const $title = document.getElementById("element-title");

//other declarations
let photoDatabase = [];

async function InicioMain() {
    await selectAlbumById();
    await selectphoto();
    refreshphoto(photoDatabase);
}

//handle functions
function handleView(button, view) {
    const condition = ({ photo_like }) => {
        if (view == 0) return true;
        if (view == 1) return photo_like;
        if (view == 2) return !photo_like;
    };
    const photo_array = photoDatabase.filter((el) => condition(el));
    document.querySelectorAll(".visibility-items").forEach((el) => el.classList.remove("disabled"));
    button.classList.add("disabled");
    refreshphoto(photo_array);
}

//ui functions
function getHtmlItemphoto({ photo_id, photo_name, photo_like, photo_create }, index) {
    let srcImg = $proyect.url + "view/img/notfound.gif";
    if (photo_name !== "" && photo_name !== null) srcImg = $proyect.url + "view/img/photo/" + photo_name;
    const date = moment(new Date(photo_create)).format("LLL");
    return `
        <div 
            class="col-xl-3 col-lg-4 col-md-6 col-12 text-dark text-decoration-none image-item check" 
            id="element-photo-id-${photo_id}"
        >
            <div class="card p-0">
                <img src="${srcImg}" class="card-img-top" alt="Foto del album" onclick="alert('jijiss')" loading="lazy">
                <div class="card-body px-4 py-2">
                    <div class="row">
                        <div class="col-10">
                            <span class="text-info datetime">${date}</span>
                            <span class="text-primary">#${index + 1}</span>
                        </div>
                        <button 
                            class="border-0 bg-transparent text-primary col-2 p-2 fs-4 select ${photo_like ? "like" : ""}" 
                            onclick="likePhoto(${photo_id})"
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
    photoDatabase.forEach((photo, index) => (html += getHtmlItemphoto(photo, index)));
    $photo_container.innerHTML = html;
}

//crud functions
async function selectAlbumById() {
    const formData = new FormData();
    formData.append("album_id", $album_id);
    await fetch_query(formData, "album", "selectById").then((res) => ($title.innerText = res.album_name));
}
async function selectphoto() {
    await fetch_query(null, "photo", "select").then((res) => (photoDatabase = res.filter((el) => el.album_id == $album_id)));
}
function likePhoto(photo_id) {
    const photo = photoDatabase.find((el) => el.photo_id == photo_id);
    let isLike = photo.photo_like == false || photo.photo_like == null ? true : false;
    photo.photo_like = isLike;
    const formData = new FormData();
    formData.append("photo_id", photo_id);
    formData.append("photo_like", isLike);
    fetch_query(formData, "photo", "updateLike").then((res) => {
        const btn_like = document.querySelector(`#element-photo-id-${photo.photo_id} button.select`);
        if (isLike) {
            btn_like.classList.add("like");
        } else {
            btn_like.classList.remove("like");
        }
        // $photo_view_container.focus();
    });
}

// main call
InicioMain();
