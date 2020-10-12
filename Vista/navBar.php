<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php'; ?>
<style>
    .navbar-brand.navbar-image {
        padding: 0 20px 0 0;
        display: flex;
    }

    .navbar-brand.navbar-image>img {
        margin: auto 0;
        z-index: 1;
        height: 50px;
    }

    @media (min-width: 768px) {
        .navbar.taller .navbar-nav>li>a {
            padding-top: 25px;
            padding-bottom: 25px;
        }
    }
</style>
<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand navbar-image" href="../index.html"><img src="../Controlador/assets/img/logo.png" alt=""></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="./home.php">Inicio</a></li>

                <?php echo isUser() ? '<li><a href="./users.php">Usuarios</a></li>' : "" ?>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo getEmail() ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="./logout.php">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div>
</nav>