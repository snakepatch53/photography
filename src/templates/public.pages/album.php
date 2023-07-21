<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/public.component/head.php') ?>
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.public/album.css">
    <title>Category</title>
    <script>
        const $category_id = <?= isset($DATA['category_id']) ? $DATA['category_id'] : 0 ?>;
    </script>
</head>

<body>
    <header><?php include('./src/templates/public.component/header.php') ?></header>
    <?php include('./src/templates/public.component/modalcontact.php') ?>
    <main>
        <div class="container my-4 mb-5">
            <h4 class="text-center text-primary mb-4" id="element-title"></h4>
            <input class="form-control mx-auto" style="max-width:400px" type="search" placeholder="Busca un album.." id="element-input-search">
        </div>
        <div class="container">
            <div class="row images-container g-md-4 g-3" id="element-album-container"></div>
        </div>
    </main>
    <footer><?php include('./src/templates/public.component/footer.php') ?></footer>
</body>
<foot>
    <?php include('./src/templates/public.component/foot.php') ?>
    <script src="<?= $DATA['http_domain'] ?>public/js.public/album.js"></script>
</foot>

</html>