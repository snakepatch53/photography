const $photo_view_container = document.getElementById("element-photo-view-container");
const $bootstrap_modalViewPhoto = document.getElementById("element-modalViewPhoto");
const bootstrap_modalViewPhoto = new bootstrap.Modal($bootstrap_modalViewPhoto, {
    keyboard: false,
});

$bootstrap_modalViewPhoto.addEventListener("hidden.bs.modal", async function (event) {
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
        const photos = uiFunction.albumDatabase.find((el) => el.album_id == album_id).album_photos;
        let html = "";
        for (const photo of photos) {
            const { url } = photo;
            html += `
                <div class="col-12 col-md-6 col-lg-3" id="item-view-${photo.id}">
                    <div class="card shadow shadow-sm">
                        <img class="card-img" src="${url}" alt="${photo.name}" loading="lazy">
                        <div class="card-body text-center">
                            <button 
                                class="btn btn-outline-info p-2 mx-1 shadow-none select ${
                                    photo.picked == true ? "like" : ""
                                }" 
                                onclick="viewPhoto_uiFunction.likePhoto(${album_id}, '${
                photo.id
            }')">
                                <span class="check"><i class="fa-regular fa-star"></i></span>
                                <span class="uncheck"><i class="fa-solid fa-star"></i></span>
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
    likePhoto: function (album_id, photo_id) {
        const { name, picked } = uiFunction.albumDatabase
            .find((el) => el.album_id == album_id)
            .album_photos.find((el) => el.id == photo_id);
        const pick = !picked;
        const formData = new FormData();
        formData.append("album_id", album_id);
        formData.append("album_photo_name", name);
        formData.append("pick", pick);
        fetch_query(formData, "album", "pick_photo").then((res) => {
            const btn_like = document.querySelector(`#item-view-${photo_id} button.select`);
            if (pick) {
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
                uiFunction.photoDatabase = uiFunction.photoDatabase.filter(
                    (el) => el.photo_id != photo_id
                );
                this.printHtml(album_id);
            }
        });
    },
};
