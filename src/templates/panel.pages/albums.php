<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <?php include('./src/templates/panel.component/head.php') ?>
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.panel/albums.css">
    <title>Albums</title>
</head>

<body>
    <?php include('./src/templates/panel.component/header.php') ?>
    <?php include('./src/templates/panel.component/sidebar.php') ?>
    <main class="pt-4 px-md-5 px-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $DATA['http_domain'] ?>panel/home">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Albums</li>
            </ol>
        </nav>
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <b>Albums</b>
                    <input class="form-control mx-3" type="search" placeholder="Buscar un album.." id="element-search" />
                    <button class="btn btn-outline-success text-nowrap" onclick="handleFunction.new()">
                        <i class="fa-solid fa-plus"></i>
                        <span>Crear nuevo</span>
                    </button>
                </div>
            </div>
            <div class="card-body row images-container g-md-4 g-3" id="element-table-album"></div>
        </div>
    </main>

    <!-- MODAL | INI -->
    <!-- form | ini -->
    <div class="modal fade" id="element-modalform" tabindex="-1" aria-labelledby="element-modalformLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content needs-validation" id="element-albumform" onsubmit="return false" novalidate>
                <input type="hidden" name="album_id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="element-modalformLabel">Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form | ini -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="validationServer01" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="validationServer01" placeholder="Boda 20 de julio.." name="album_name" required>
                            <div class="invalid-feedback">
                                Escribe el nombre!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Cliente</label>
                            <select class="form-select" id="validationCustom02" name="client_id" required></select>
                            <div class="invalid-feedback">
                                Selecciona una opcion!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom03" class="form-label">Categoria</label>
                            <select class="form-select" id="validationCustom03" name="category_id" required></select>
                            <div class="invalid-feedback">
                                Selecciona una opcion!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom05" class="form-label">Carpeta</label>
                            <select class="form-select" id="validationCustom05" name="album_path" required></select>
                            <div class="invalid-feedback">
                                Selecciona una opcion!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom06" class="form-label">Portada</label>
                            <input class="form-control" id="validationCustom06" name="album_photo" type="file" accept="image/*" required />
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom04" class="form-label">Descripcion</label>
                            <textarea class="form-control" id="validationCustom04" name="album_descr" placeholder="Escribe una descripcion.." cols="1"></textarea>
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
    <!-- progress optimize | ini -->
    <div class="modal fade" id="element-modalprogressoptimize" tabindex="-1" data-bs-backdrop="static" aria-labelledby="element-modalprogressoptimizeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="element-modalprogressoptimizeLabel">Optimizando fotos del album</h5>
                </div>
                <div class="modal-body">
                    <p class="text-center">Espere un momento por favor, estamos optimizando las fotos para mejorar el rendimiento de la pagina para comodidad del cliente..</p>
                    <div class="progress m-2" style="height:20px;width:95%;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">0%</div>
                    </div>
                    <p class="text-center"><i class="message"></i></p>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- progress optimize | end -->
    <!-- MODAL | END -->
    <?php include('./src/templates/panel.component/album_photoUpload.php') ?>
</body>
<foot>
    <?php include('./src/templates/panel.component/foot.php') ?>
    <script src="<?= $DATA['http_domain'] ?>public/js.panel/albums.js"></script>
    <script src="<?= $DATA['http_domain'] ?>public/js.general/images.js"></script>
    <script src="<?= $DATA['http_domain'] ?>public/js.panel/album.view.js"></script>
</foot>

</html>