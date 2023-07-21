<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/public.component/head.php') ?>
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.public/photo.css">
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.public/imageviewer.css">
    <title>Fotos</title>
    <script>
        const $album_id = <?= isset($DATA['album_id']) ? $DATA['album_id'] : 0 ?>;
    </script>
</head>

<body>
    <header><?php include('./src/templates/public.component/header.php') ?></header>
    <?php include('./src/templates/public.component/modalcontact.php') ?>
    <?php include('./src/templates/public.component/imageviewer.php') ?>
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
    <footer><?php include('./src/templates/public.component/footer.php') ?></footer>
</body>
<foot>
    <?php include('./src/templates/public.component/foot.php') ?>
    <script src="<?= $DATA['http_domain'] ?>public/js.public/imageviewer.js"></script>
    <script src="<?= $DATA['http_domain'] ?>public/js.public/photo.js"></script>
</foot>

</html>