<script>
    const $album_id = <?= isset($album_id) ? $album_id : 0 ?>;
</script>
<!DOCTYPE html>
<html lang="<?= $proyect['lang'] ?>">

<head>
    <?php include('./view/component.public/head.php') ?>
    <link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.public/photo.css">
    <link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.public/imageviewer.css">
    <title>Fotos</title>
</head>

<body>
    <header><?php include('./view/component.public/header.php') ?></header>
    <?php include('./view/component.public/modalcontact.php') ?>
    <?php include('./view/component.public/imageviewer.php') ?>
    <main>
        <div class="container text-center">
            <h4 class="my-4 text-center text-primary" id="element-title"></h4>
            <div class="btn-group mb-3" role="group" aria-label="Basic outlined example">
                <button type="button" class="btn btn-outline-info visibility-items disabled" onclick="handleView(this, 0)">
                    <span>All</span>
                    <i class="fa-solid fa-image"></i>
                </button>
                <button type="button" class="btn btn-outline-info visibility-items" onclick="handleView(this, 1)">
                    <span>Like</span>
                    <i class="fa-solid fa-star"></i>
                </button>
                <button type="button" class="btn btn-outline-info visibility-items" onclick="handleView(this, 2)">
                    <span>Unlike</span>
                    <i class="fa-regular fa-star"></i>
                </button>
            </div>
            <div class="row images-container g-md-4 g-3" id="element-photo-container"></div>
        </div>
    </main>
    <footer><?php include('./view/component.public/footer.php') ?></footer>
</body>
<foot>
    <?php include('./view/component.public/foot.php') ?>
    <script src="<?= $proyect['url'] ?>control/script.public/imageviewer.js"></script>
    <script src="<?= $proyect['url'] ?>control/script.public/photo.js"></script>
</foot>

</html>