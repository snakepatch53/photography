<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/public.component/head.php') ?>
    <title>Inicio</title>
</head>

<body>
    <header><?php include('./src/templates/public.component/header.php') ?></header>
    <?php include('./src/templates/public.component/modalcontact.php') ?>
    <main>
        <div class="container">
            <h2 class="h1-responsive font-weight-bold text-center my-5">
                <span class="border-3 border-bottom border-primary">SERVICIOS</span>
            </h2>
            <p class="text-center fs-5 mt-5">Ofrecemos diferentes paquetes a nuestros clientes con precios accesibles a su bolsillo. Contáctanos para que recibas una demostración de nuestro trabajo, nos acomodamos a tu presupuesto de acuerdo a tus necesidades. (Pregunta por nuestro especial de temporada)*</p>
        </div>
    </main>
    <footer><?php include('./src/templates/public.component/footer.php') ?></footer>
</body>
<foot>
    <?php include('./src/templates/public.component/foot.php') ?>
</foot>

</html>