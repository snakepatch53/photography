<!DOCTYPE html>
<html lang="<?= $_ENV['HTML_LANG'] ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.panel/login.css">
    <link rel="shortcut icon" href="<?= $DATA['http_domain'] ?>public/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="<?= $DATA['http_domain'] ?>public/css.general/bootstrap2.min.css">

    <title>Login</title>

    <script>
        const http_domain = '<?= $DATA['http_domain'] ?>';
    </script>
</head>

<body>
    <main class='container-fluid'>
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height:100vh">
                <div class="col-md-7 col-lg-5">
                    <div class="card">
                        <div class="card-body p-5">
                            <form class="needs-validation" id="element-loginform" onsubmit="return false" novalidate>
                                <!-- form | ini -->
                                <div class="row g-3">
                                    <div class="col-md-12 text-center">
                                        <img class="logo" src="<?= $DATA['http_domain'] ?>public/img/logo.png" alt="Logo">
                                        <h3 class="mt-2">Login</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="validationCustom01" class="form-label">Usuario</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                                            <input class="form-control" id="validationCustom01" name="user_user" placeholder="Usuario" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="validationCustom02" class="form-label">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                            <input class="form-control" id="validationCustom02" name="user_pass" placeholder="Contraseña" type="password" required>
                                            <span class="input-group-text" style="cursor: pointer" id="togglePassword">
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-danger fs-6 text-center my-0 py-0" id="element-msg-login"></div>
                                    <div class="col-md-12 m-0">
                                        <button type="submit" class="btn btn-primary" style="width:100%" name="btnSubmit">
                                            <span class="me-1">Iniciar sesion</span>
                                            <i class="fa-solid fa-right-to-bracket"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- form | end -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<foot>
    <!-- <?php include('./src/templates/public.component/foot.php') ?> -->
    <script src="<?= $DATA['http_domain'] ?>public/js.general/fetch.js"></script>
    <script src="<?= $DATA['http_domain'] ?>public/js.panel/login.js"></script>
</foot>

</html>