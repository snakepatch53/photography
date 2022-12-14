const $photo_view_container = document.getElementById("element-photo-view-container");
const $bootstrap_modalViewPhoto = document.getElementById("element-modalViewPhoto");
const bootstrap_modalViewPhoto = new bootstrap.Modal($bootstrap_modalViewPhoto, {
    keyboard: false,
});

$bootstrap_modalViewPhoto.addEventListener("hidden.bs.modal", async function (event) {
    await crudFunction.selectPhotos();
    uiFunction.refreshFrontpage(viewPhoto_uiFunction.album_id);
    viewPhoto_uiFunction.album_id = 0;
});

const viewPhoto_uiFunction = {
    album_id: 0,
    showModal: function (album_id) {
        this.printHtml(album_id);
        this.album_id = album_id;
        bootstrap_modalViewPhoto.show();
    },
    printHtml: function (album_id) {
        const photos = uiFunction.photoDatabase.filter((el) => el.album_id == album_id);
        let html = "";
        for (const photo of photos) {
            let imgSrc = `${$proyect.url}model/script/photo/getphoto.php?photo_name=${photo.photo_name}&photo_quality=20&photo_size=500`;
            if (photo.photo_name == null || photo.photo_name == "") imgSrc = `${$proyect.url + "view/img/"}notfound.gif`;
            html += `
                <div class="col-12 col-md-6 col-lg-3" id="item-view-${photo.photo_id}">
                    <div class="card shadow shadow-sm">
                        <img class="card-img" src="${imgSrc}" alt="${photo.photo_name}" loading="lazy">
                        <div class="card-body text-center">
                            <button 
                                class="btn btn-outline-info p-2 mx-1 shadow-none select ${
                                    photo.photo_like == true ? "like" : ""
                                }" 
                                onclick="viewPhoto_uiFunction.likePhoto(${photo.photo_id})"
                            >
                                <span class="check"><i class="fa-regular fa-star"></i></span>
                                <span class="uncheck"><i class="fa-solid fa-star"></i></span>
                            </button>
                            <button 
                                class="btn btn-outline-danger p-2 mx-1" 
                                onclick="viewPhoto_uiFunction.deletePhoto(${photo.photo_id}, ${album_id})"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }
        if (html == "") {
            html = `<span class="text-center text-info">Aun no agregas fotos en este album..</span>`;
        }
        $photo_view_container.innerHTML = html;
    },
    download: function (like) {
        const url = `${$proyect.url}model/script/photo/download.php?album_id=${this.album_id}&photo_like=${like}`;
        const link = document.createElement("a");
        document.body.appendChild(link);
        link.href = url;
        link.click();
        link.remove();
    },
    likePhoto: function (photo_id) {
        const photo = uiFunction.photoDatabase.find((el) => el.photo_id == photo_id);
        let isLike = photo.photo_like == false || photo.photo_like == null ? true : false;
        photo.photo_like = isLike;
        const formData = new FormData();
        formData.append("photo_id", photo_id);
        formData.append("photo_like", isLike);
        fetch_query(formData, "photo", "updateLike").then((res) => {
            const btn_like = document.querySelector(`#item-view-${photo.photo_id} button.select`);
            if (isLike) {
                btn_like.classList.add("like");
            } else {
                btn_like.classList.remove("like");
            }
            $photo_view_container.focus();
        });
    },
    deletePhoto: function (photo_id, album_id) {
        const formData = new FormData();
        formData.append("photo_id", photo_id);
        fetch_query(formData, "photo", "delete").then((res) => {
            if (res) {
                uiFunction.photoDatabase = uiFunction.photoDatabase.filter((el) => el.photo_id != photo_id);
                this.printHtml(album_id);
            }
        });
    },
};
