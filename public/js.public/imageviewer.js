const $imageviewermodal = document.getElementById("imageviewermodal");
const $buttonBeff = $imageviewermodal.querySelector(".button-beff");
const $buttonNext = $imageviewermodal.querySelector(".button-next");
const bootstrap_modalViewPhoto = new bootstrap.Modal($imageviewermodal, {});

function showPhotoInImageviewer(index) {
    index = parseInt(index);
    const database = photoDatabase[index];
    const { folder, name } = database;
    const photo_beff = index - 1 <= 0 ? photoDatabase.length - 1 : index - 1;
    const photo_next = index + 1 >= photoDatabase.length ? 0 : index + 1;
    // $imageviewermodal.querySelector("img").src = `${$proyect.url}view/img/photo/${photo_name}`;
    $imageviewermodal.querySelector(
        "img"
    ).src = `${http_domain}services/album/get_photo/${folder}/${name}?photo_quality=25&photo_size=900`;
    // $imageviewermodal.querySelector("img").src = database.url;
    $buttonBeff.setAttribute("image-index", photo_beff);
    $buttonNext.setAttribute("image-index", photo_next);
    bootstrap_modalViewPhoto.show();
}

$buttonBeff.onclick = function () {
    console.log("left");
    showPhotoInImageviewer(this.getAttribute("image-index"));
};
$buttonNext.onclick = function () {
    console.log("right");
    showPhotoInImageviewer(this.getAttribute("image-index"));
};
