<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./src/templates/public.component/head.php') ?>
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.public/404.css">
</head>

<body>

    <header>
        <?php include('./src/templates/public.component/header.php') ?>
    </header>

    <main class="animate__animated animate__fadeIn">
        <div class="container">
            <img src="<?= $DATA['http_domain'] ?>public/img/personaje2.png?last=<?= $DATA['info']['info_last'] ?>" alt="Imagen 2 del personaje">
            <h2>404</h2>
            <p>Estas orbitando por página desconocidas.</p>
            <br><br>
            <a href="<?= $DATA['http_domain'] ?>">
                <i class="fas fa-globe-americas"></i>
                <span>Regresame a la tierra</span>
            </a>
        </div>


        <div class="stars">
            <div class="star star-1"></div>
            <div class="star star-2"></div>
            <div class="star star-3"></div>
            <div class="star star-4"></div>
            <div class="star star-5"></div>
            <div class="star star-6"></div>
            <div class="star star-7"></div>
            <div class="star star-8"></div>
            <div class="star star-9"></div>
            <div class="star star-10"></div>
            <div class="star star-11"></div>
            <div class="star star-12"></div>
            <div class="star star-13"></div>
            <div class="star star-14"></div>
            <div class="star star-15"></div>
            <div class="star star-16"></div>
            <div class="star star-17"></div>
            <div class="star star-18"></div>
            <div class="star star-19"></div>
            <div class="star star-20"></div>
            <div class="star star-21"></div>
            <div class="star star-22"></div>
            <div class="star star-23"></div>
            <div class="star star-24"></div>
            <div class="star star-25"></div>
            <div class="star star-26"></div>
            <div class="star star-27"></div>
            <div class="star star-28"></div>
            <div class="star star-29"></div>
            <div class="star star-30"></div>
        </div>

    </main>

    <!-- <footer id="section-footer">
        <?php include('./src/templates/public.component/footer.php') ?>
    </footer> -->
</body>

<foot>
    <?php include('./src/templates/public.component/foot.php') ?>
</foot>

</html>