<nav class="header navbar navbar-expand navbar-dark p-0 bg-primary">
    <div class="container-fluid">
        <!-- Options | ini -->
        <ul class="navbar-nav mb-0 mb-lg-0 ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="header-user-photo rounded-circle" src="https://i.imgur.com/JFHjdNr.jpg" alt="User photo">
                    <span><?= $_SESSION['user_name'] ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end p-2 user-menu" aria-labelledby="navbarDropdown">
                    <li class="text-center">
                        <img class="dropdown-user-photo rounded-circle" src="https://i.imgur.com/JFHjdNr.jpg" alt="User photo">
                        <br>
                        <span class="text-primary"><?= $_SESSION['user_name'] ?></span>
                    </li>
                    <li>
                        <hr>
                    </li>
                    <li><a class="btn btn-outline-primary p-1 mb-1" style="width:100%" href="#">Perfil</a></li>
                    <li><button class="btn btn-outline-primary p-1 mb-1" style="width:100%" onclick="logout()">Cerrar sesion</button></li>
                </ul>
            </li>
        </ul>
        <!-- Options | end -->
    </div>
</nav>