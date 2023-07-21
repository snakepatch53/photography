<?php


// include('./model/dao/ClientDao.php');
// include('./model/dao/CategoryDao.php');
// include('./model/dao/AlbumDao.php');
// $clientDao = new ClientDao($proyect);
// $categoryDao = new CategoryDao($proyect);
// $albumDao = new AlbumDao($proyect);
// $client_num = mysqli_num_rows($clientDao->select());
// $category_num = mysqli_num_rows($categoryDao->select());
// $album_num = mysqli_num_rows($albumDao->select());
?>

<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/panel.component/head.php') ?>
    <title>Inicio</title>
</head>

<body>
    <?php include('./src/templates/panel.component/header.php') ?>
    <?php include('./src/templates/panel.component/sidebar.php') ?>
    <main>
        <div class="container">
            <div class="row g-4 py-3 p-md-4">
                <a href="<?= $DATA['http_domain'] ?>panel/clients" class="col-md-4 text-decoration-none">
                    <div class="card shadow bg-info p-2">
                        <div class="row g-0">
                            <h5 class="text-light col-10 pt-2"><?= $DATA['client_num'] ?></h5>
                            <span class="text-light fs-3 col-2">
                                <i class="fa-solid fa-mug-hot"></i>
                            </span>
                        </div>
                        <p class="text-light text-center">Total de Clientes</p>
                        <img src="<?= $DATA['http_domain'] ?>public/img/chart.png" alt="Chart Image" style="width:100%;height:50px;object-fit:cover;filter:brightness(3)">
                    </div>
                </a>
                <a href="<?= $DATA['http_domain'] ?>panel/category" class="col-md-4 text-decoration-none">
                    <div class="card shadow bg-success p-2">
                        <div class="row g-0">
                            <h5 class="text-light col-10 pt-2"><?= $DATA['category_num'] ?></h5>
                            <span class="text-light fs-3 col-2">
                                <i class="fa-solid fa-puzzle-piece"></i>
                            </span>
                        </div>
                        <p class="text-light text-center">Total de Categorias</p>
                        <img src="<?= $DATA['http_domain'] ?>public/img/chart.png" alt="Chart Image" style="width:100%;height:50px;object-fit:cover;filter:brightness(3)">
                    </div>
                </a>
                <a href="<?= $DATA['http_domain'] ?>panel/albums" class="col-md-4 text-decoration-none">
                    <div class="card shadow bg-primary p-2">
                        <div class="row g-0">
                            <h5 class="text-light col-10 pt-2"><?= $DATA['album_num'] ?></h5>
                            <span class="text-light fs-3 col-2">
                                <i class="fa-sharp fa-solid fa-images"></i>
                            </span>
                        </div>
                        <p class="text-light text-center">Total de Albums</p>
                        <img src="<?= $DATA['http_domain'] ?>public/img/chart.png" alt="Chart Image" style="width:100%;height:50px;object-fit:cover;filter:brightness(3)">
                    </div>
                </a>

            </div>

            <!-- form | ini -->
            <h3 class="text-center mt-4">Información</h3>
            <form class="needs-validation p-md-4" id="element-infoForm" onsubmit="return false" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="validationServer01" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="validationServer01" placeholder="InfoName" name="info_name" required>
                        <div class="invalid-feedback">
                            Escribe un nombre!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer02" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="validationServer02" placeholder="info@email.com" name="info_email" required>
                        <div class="invalid-feedback">
                            Escribe un email!
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="validationServer03" class="form-label">Logo</label>
                        <input type="file" class="form-control" id="validationServer03" name="info_logo">
                    </div>
                    <div class="col-12">
                        <label for="validationServer04" class="form-label">Servicios <span class="text-danger">*</span></label>
                        <textarea name="info_services" id="validationServer04" class="form-control" placeholder="lorem ipsum" rows="5" required></textarea>
                        <div class="invalid-feedback">
                            Escribe una descripcion de tus servicios!
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="text-info msg-feetback"></p>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary px-5 py-2" name="btnSubmit">
                            <span>Guardar</span>
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                    </div>
                </div>
            </form>
            <!-- form | end -->
            <!-- contact | ini -->
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <b class="fs-5">Contactos</b>
                        <button class="btn btn-outline-success" onclick="handleFunction.new()">
                            <i class="fa-solid fa-plus"></i>
                            <span>Crear nuevo</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover border">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th class="d-none d-md-table-cell" scope="col">#</th>
                                <th class="text-center text-md-left" scope="col">Nombre</th>
                                <th class="text-center text-md-left" scope="col">Icono</th>
                                <th class="text-center" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="element-table-contact"></tbody>
                    </table>
                </div>
            </div>
            <!-- contact | end -->

            <!-- MODAL | INI -->
            <!-- form | ini -->
            <div class="modal fade" id="element-modalform" tabindex="-1" aria-labelledby="element-modalformLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content needs-validation" id="element-contactform" onsubmit="return false" novalidate>
                        <input type="hidden" name="contact_id" value="0">
                        <div class="modal-header">
                            <h5 class="modal-title" id="element-modalformLabel">Formulario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- form | ini -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="validationServer01" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="validationServer01" placeholder="Facebook.." name="contact_name" required>
                                    <div class="invalid-feedback">
                                        Escribe el nombre del contacto!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationServer02" class="form-label">Link</label>
                                    <input type="text" class="form-control" id="validationServer02" placeholder="https://facebook.com/enterprisename" name="contact_link" required>
                                    <div class="invalid-feedback">
                                        Inserta el link para direccionar!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationServer03" class="form-label"><a href="https://fontawesome.com/icons" target="_blank">Icono de Fontawesome</a></label>
                                    <input type="text" class="form-control" id="validationServer03" placeholder="fa-duotone fa-house" name="contact_icon" required>
                                    <div class="invalid-feedback">
                                        Escribe el nombre de un icono de fontawesome!
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="validationServer04" class="form-label">Color</label>
                                    <input type="color" class="form-control" id="validationServer04" placeholder="Url" name="contact_color" require>
                                    <div class="invalid-feedback">
                                        Elije un color!
                                    </div>
                                </div>
                            </div>
                            <!-- form | end -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- form | end -->
            <!-- confirm | ini -->
            <div class="modal fade" id="element-modalconfirm" tabindex="-1" aria-labelledby="element-modalconfirmLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="element-modalconfirmLabel">Eliminar registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estas seguro de eliminar este registro?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="crudFunction.delete()">Eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- confirm | end -->
            <!-- MODAL | END -->

        </div>
    </main>
</body>
<foot>
    <?php include('./src/templates/panel.component/foot.php') ?>
    <script src="<?= $DATA['http_domain'] ?>public/js.panel/home.js"></script>
</foot>

</html>