<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/public.component/head.php') ?>
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.public/category.css">
    <title><?= $DATA['title'] ?></title>
</head>

<body>
    <header><?php include('./src/templates/public.component/header.php') ?></header>
    <?php include('./src/templates/public.component/modalcontact.php') ?>
    <main>
        <div class="container">
            <div class="row images-container g-md-4 g-3" id="element-category-container"></div>
        </div>
    </main>
    <footer><?php include('./src/templates/public.component/footer.php') ?></footer>
</body>
<foot>
    <?php include('./src/templates/public.component/foot.php') ?>
    <script src="<?= $DATA['http_domain'] ?>public/js.public/category.js"></script>
</foot>

</html>