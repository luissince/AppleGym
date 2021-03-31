<header class="app-header">

    <a class="app-header__logo" href="index.php">Apple Gym</a>
    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <?php
        if ($_SESSION["Roles"][20]["ver"] == 1) {
            print '<li class="dropdown">
             <a class="app-nav__item" href="puntoDeVenta.php">
                 <i class="fa fa fa-shopping-cart fa-lg"></i> <span class="app-nav_text">Punto de Venta<span>
             </a>
         </li>';
        }
        if ($_SESSION["Roles"][21]["ver"] == 1) {
            print ' <li class="dropdown">
             <a class="app-nav__item" href="javascript:void(0)" onclick="openMarcarEntrada()">
                 <i class="fa fa-hand-pointer-o fa-lg"></i> <span class="app-nav_text">Marcar Entreda<span>
             </a>
         </li>';
        }
        ?>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="perfil.php"><i class="fa fa-user fa-lg"></i> <span class="app-nav_text">Perfil<span> </a></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Cerrar Sessión</a>
                </li>
            </ul>
        </li>
    </ul>
</header>