<!DOCTYPE html>
<html lang="<?= $proyect['lang'] ?>">

<head>
    <?php include('./view/component.public/head.php') ?>
    <link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.public/category.css">
    <title>Categorias</title>
</head>

<body>
    <header><?php include('./view/component.public/header.php') ?></header>
    <?php include('./view/component.public/modalcontact.php') ?>
    <main>
        <div class="container">
            <div class="row images-container g-md-4 g-3" id="element-category-container"></div>
        </div>
    </main>
    <footer><?php include('./view/component.public/footer.php') ?></footer>
</body>
<foot>
    <?php include('./view/component.public/foot.php') ?>
    <script src="<?= $proyect['url'] ?>control/script.public/category.js"></script>
</foot>

</html>