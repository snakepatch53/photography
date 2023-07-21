<!DOCTYPE html>
<html lang="<?= $proyect['lang'] ?>">

<head>
    <?php include('./view/component.public/head.php') ?>
    <title>Inicio</title>
</head>

<body>
    <header><?php include('./view/component.public/header.php') ?></header>
    <?php include('./view/component.public/modalcontact.php') ?>
    <main>
        <?= $currentPage ?>
    </main>
    <footer><?php include('./view/component.public/footer.php') ?></footer>
</body>
<foot>
    <?php include('./view/component.public/foot.php') ?>
</foot>

</html>