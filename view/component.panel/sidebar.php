<link rel="stylesheet" href="<?= $proyect['url'] ?>view/css.panel/sidebar.css">
<div class="sidebar">
    <button class="burguer-button" onclick="handleBurgerSidebar()">
        <i class="fa-solid fa-bars text-light"></i>
    </button>
    <div class="sidebar-header">
        <h4 class="text-truncate p-2 text-light"><?= $info_r['info_name'] ?></h4>
    </div>
    <img class="logo" src="<?= $proyect['url'] ?>view/img/logo.png" alt="Logo">
    <!-- List | ini -->
    <ul class="list-group rounded-0 p-2 border-0">
        <a href="<?= $proyect['url'] ?>panel/home" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($currentPage == "panel/home") ? "shadow  active" : "" ?>">
            <i class="fa-solid fa-house"></i>
            <span class="ms-2">Inicio</span>
        </a>
        <?php if ($_SESSION['user_type'] == 1) { ?>
            <a href="<?= $proyect['url'] ?>panel/users" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($currentPage == "panel/users") ? "shadow active" : "" ?>">
                <i class="fa-solid fa-user"></i>
                <span class="ms-2">Usuarios</span>
            </a>
        <?php } ?>
        <a href="<?= $proyect['url'] ?>panel/clients" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($currentPage == "panel/clients") ? "shadow active" : "" ?>">
            <i class="fa-solid fa-mug-hot"></i>
            <span class="ms-2">Clientes</span>
        </a>
        <a href="<?= $proyect['url'] ?>panel/category" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($currentPage == "panel/category") ? "shadow active" : "" ?>">
            <i class="fa-solid fa-puzzle-piece"></i>
            <span class="ms-2">Categorias</span>
        </a>
        <a href="<?= $proyect['url'] ?>panel/albums" class="nav-option btn btn-outline-primary border-0 text-start p-3 mb-2 <?= ($currentPage == "panel/albums") ? "shadow active" : "" ?>">
            <i class="fa-sharp fa-solid fa-images"></i>
            <span class="ms-2">Albums</span>
        </a>
    </ul>
    <!-- List | end -->
</div>