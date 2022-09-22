<!DOCTYPE html>
<html lang="<?= $proyect['lang'] ?>">

<head>
    <?php include('./view/component.panel/head.php') ?>
    <title>Clientes</title>
</head>

<body>
    <?php include('./view/component.panel/header.php') ?>
    <?php include('./view/component.panel/sidebar.php') ?>
    <!-- CONTENT PAGE | INI -->
    <main class="pt-4 px-md-5 px-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $proyect['url'] ?>panel/home">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </nav>
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <b>Clientes</b>
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
                            <th class="d-none d-md-table-cell" scope="col">Celular</th>
                            <th class="d-none d-md-table-cell" scope="col">Email</th>
                            <th class="text-center" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="element-table-client"></tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- CONTENT PAGE | END -->

    <!-- MODAL | INI -->
    <!-- form | ini -->
    <div class="modal fade" id="element-modalform" tabindex="-1" aria-labelledby="element-modalformLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content needs-validation" id="element-clientform" onsubmit="return false" novalidate>
                <input type="hidden" name="client_id" value="0">
                <div class="modal-header">
                    <h5 class="modal-title" id="element-modalformLabel">Formulario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- form | ini -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="validationServer01" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="validationServer01" placeholder="Mark" name="client_name" required>
                            <div class="invalid-feedback">
                                Escribe tu nombre!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer02" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="validationServer02" placeholder="Celular" name="client_phone" required>
                            <div class="invalid-feedback">
                                Escribe tu numero de celular!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer04" class="form-label">Correo Electronico</label>
                            <input type="text" class="form-control" id="validationServer04" placeholder="Email" name="client_mail" required>
                            <div class="invalid-feedback">
                                Escribe tu email!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationServer03" class="form-label">Facebook</label>
                            <input type="text" class="form-control" id="validationServer03" placeholder="Url" name="client_fb">
                        </div>
                        <div class="col-md-12">
                            <label for="validationServer05" class="form-label">Descripcion</label>
                            <textarea name="client_descr" class="form-control" id="validationServer05" rows="1"></textarea>
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
</body>
<foot>
    <?php include('./view/component.panel/foot.php') ?>
    <script src="<?= $proyect['url'] ?>control/script.panel/clients.js"></script>
</foot>

</html>