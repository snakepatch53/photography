const $imageviewermodal = document.getElementById("imageviewermodal");
const $buttonBeff = $imageviewermodal.querySelector(".button-beff");
const $buttonNext = $imageviewermodal.querySelector(".button-next");
const bootstrap_modalViewPhoto = new bootstrap.Modal($imageviewermodal, {});

function showPhotoInImageviewer(index) {
    index = parseInt(index);
    const database = photoDatabase;
    const photo_name = database[index].photo_name;
    const photo_beff = index - 1 <= 0 ? database.length - 1 : index - 1;
    const photo_next = index + 1 >= database.length ? 0 : index + 1;
    // $imageviewermodal.querySelector("img").src = `${$proyect.url}view/img/photo/${photo_name}`;
    $imageviewermodal.querySelector(
        "img"
    ).src = `${$proyect.url}model/script/photo/getphoto.php?photo_name=${photo_name}&photo_quality=30&photo_width=800`;
    $buttonBeff.setAttribute("image-index", photo_beff);
    $buttonNext.setAttribute("image-index", photo_next);
    bootstrap_modalViewPhoto.show();
}

$buttonBeff.onclick = function () {
    showPhotoInImageviewer(this.getAttribute("image-index"));
};
$buttonNext.onclick = function () {
    showPhotoInImageviewer(this.getAttribute("image-index"));
};
