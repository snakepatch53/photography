<menu class="container">
    <ul>
        <li class="<?= $DATA['name'] == 'home' ? 'active' : '' ?>">
            <a href="<?= $DATA['http_domain'] ?>category">Categorias</a>
        </li>
        <li class="<?= $DATA['name'] == 'album' ? 'active' : '' ?>">
            <a href="<?= $DATA['http_domain'] ?>album">Albums</a>
        </li>
        <li class="logo">
            <a href="<?= $DATA['http_domain'] ?>">
                <img src="<?= $DATA['http_domain'] ?>public/img/logo.png" alt="Logo">
            </a>
        </li>
        <li class="<?= $DATA['name'] == 'contact' ? 'active' : '' ?>">
            <a href="<?= $DATA['http_domain'] ?>contact">Contactanos</a>
        </li>
        <li class="<?= $DATA['name'] == 'service' ? 'active' : '' ?>">
            <a href="<?= $DATA['http_domain'] ?>service">Servicios</a>
        </li>
    </ul>
    <button id="contact-us" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa-sharp fa-solid fa-envelope"></i>
    </button>
    <div id="sm-logo">
        <img src="<?= $DATA['http_domain'] ?>public/img/logo.png" alt="Logo">
    </div>
    <button id="btn-menu">
        <i class="fa-solid fa-bars"></i>
    </button>
</menu>