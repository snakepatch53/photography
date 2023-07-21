<footer class="text-center text-white" style="background:#292d3e">
    <div class="container pt-4">
        <section class="mb-4">
            <?php foreach ($DATA['contact'] as $key => $contact) { ?>
                <a class="btn btn-link btn-floating btn-lg text-dark m-1 text-decoration-none" href="<?= $contact['contact_link'] ?>" target="_blank" role="button" data-mdb-ripple-color="dark">
                    <i class="<?= $contact['contact_icon'] ?> fs-3" style="color:<?= $contact['contact_color'] ?>;"></i>
                    <p class="d-block text-light fs-6 fw-normal"><?= $contact['contact_name'] ?></p>
                </a>
            <?php } ?>
            <a class="btn btn-link btn-floating btn-lg text-dark m-1 text-decoration-none" href="mailto:<?= $DATA['info']['info_email'] ?>" target="_blank" role="button" data-mdb-ripple-color="dark">
                <i class="fa-solid fa-envelope fs-3" style="color:red;"></i>
                <p class="d-block text-light fs-6 fw-normal"><?= $DATA['info']['info_email'] ?></p>
            </a>
        </section>
    </div>
    <div class="text-center text-light p-3">
        © <?= date('Y') ?> Copyright:
        <a href="mailto:<?= $DATA['info']['info_email'] ?>"><?= $DATA['info']['info_email'] ?></a>
    </div>
</footer>