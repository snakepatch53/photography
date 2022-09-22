<menu class="container">
    <ul>
        <li>
            <a href="<?= $proyect['url'] ?>category">Eventos</a>
        </li>
        <li>
            <a href="<?= $proyect['url'] ?>album">Clientes</a>
        </li>
        <li class="logo">
            <a href="<?= $proyect['url'] ?>">
                <img src="<?= $proyect['url'] ?>view/img/logo.png" alt="Logo">
            </a>
        </li>
        <li>
            <a href="<?= $proyect['url'] ?>contact">Contactanos</a>
        </li>
        <li>
            <a href="<?= $proyect['url'] ?>service">Servicios</a>
        </li>
    </ul>
    <button id="contact-us" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="fa-sharp fa-solid fa-envelope"></i>
    </button>
    <div id="sm-logo">
        <img src="<?= $proyect['url'] ?>view/img/logo.png" alt="Logo">
    </div>
    <button id="btn-menu">
        <i class="fa-solid fa-bars"></i>
    </button>
</menu>