<script>
    const $category_id = <?= isset($category_id) ? $category_id : 0 ?>;
</script>
<!DOCTYPE html>
<html lang="<?= $proyect['lang'] ?>">

<head>
    <?php include('./view/component.public/head.php') ?>
    <link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.public/album.css">
    <title>Albums</title>
</head>

<body>
    <header><?php include('./view/component.public/header.php') ?></header>
    <?php include('./view/component.public/modalcontact.php') ?>
    <main>
        <div class="container my-4 mb-5">
            <h4 class="text-center text-primary mb-4" id="element-title"></h4>
            <input class="form-control mx-auto" style="max-width:400px" type="search" placeholder="Busca un album.." id="element-input-search">
        </div>
        <div class="container">
            <div class="row images-container g-md-4 g-3" id="element-album-container"></div>
        </div>
    </main>
    <footer><?php include('./view/component.public/footer.php') ?></footer>
</body>
<foot>
    <?php include('./view/component.public/foot.php') ?>
    <script src="<?= $proyect['url'] ?>control/script.public/album.js"></script>
</foot>

</html>