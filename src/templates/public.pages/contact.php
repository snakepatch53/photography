<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/public.component/head.php') ?>
    <title>Contactos</title>
</head>

<body>
    <header><?php include('./src/templates/public.component/header.php') ?></header>
    <?php include('./src/templates/public.component/modalcontact.php') ?>
    <main>
        <div class="container">
            <section class="mb-4">
                <div class="row text-center">
                    <h2 class="h1-responsive font-weight-bold text-center my-4">
                        <span class="border-3 border-bottom border-primary">CONTACTANOS</span>
                    </h2>
                    <p class="text-center w-responsive mx-auto mb-5 mt-3">Escribanos dejanos un mensaje o contactanos directamente con Nosotros</p>
                    <br><br>
                    <div class="col-lg-9 mb-md-0 mb-5">
                        <?php include('./src/templates/public.component/contactform.php') ?>
                    </div>
                    <div class="col-lg-3 text-center">
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($DATA['contact'] as $key => $contact) { ?>
                                <li>
                                    <a href="<?= $contact['contact_link'] ?>" class="text-dark text-decoration-none" target="_blank">
                                        <i class="<?= $contact['contact_icon'] ?> mt-4 fa-2x" style="color:<?= $contact['contact_color'] ?>;"></i>
                                        <p><?= $contact['contact_name'] ?></p>
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="mailto:<?= $DATA['info']['info_email'] ?>" class="text-dark text-decoration-none" target="_blank">
                                    <i class="fa-solid fa-envelope  mt-4 fa-2x" style="color:red;"></i>
                                    <p><?= $DATA['info']['info_email'] ?></p>
                                </a>
                            </li>
                            <!-- <li>
                                <i class="fa-solid fa-clock mt-4 fa-2x text-primary"></i>
                                <p class="m-0"><b>Weekdays: </b>9am – 8pm</p>
                                <p class="m-0"><b>Saturday: </b>9am – 7pm</p>
                                <p class="m-0"><b>Sunday: </b>Close</p>
                            </li> -->
                        </ul>
                    </div>
                </div>

            </section>
        </div>
    </main>
    <footer><?php include('./src/templates/public.component/footer.php') ?></footer>
</body>
<foot>
    <?php include('./src/templates/public.component/foot.php') ?>
</foot>

</html>