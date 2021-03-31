<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
        <div class="app-sidebar__user">
                <div class="m-2">
                        <img class="img-fluid" src="./images/logo.jpeg" alt="User Image">
                </div>

                <div class="m-1">
                        <p class="app-sidebar__user-name"><?= $_SESSION["Nombres"] . ' ' . $_SESSION["Apellidos"] ?></p>
                </div>
        </div>
        <ul class="app-menu">
                <?php

                if ($_SESSION["Roles"][0]["ver"] == 1) {
                        print '<li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>';
                }

                if ($_SESSION["Roles"][1]["ver"] == 1) {
                        $ventamenu = '<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Ventas</span><i class="treeview-indicator fa fa-angle-right"></i></a><ul class="treeview-menu">';
                        if ($_SESSION["Roles"][2]["ver"] == 1) {
                                $ventamenu .= '<li><a class="app-menu__item" href="ventas.php"><i class="app-menu__icon fa fa-folder"></i><span class="app-menu__label">Lista</span></a></li>';
                        }
                        if ($_SESSION["Roles"][3]["ver"] == 1) {
                                $ventamenu .= ' <li><a class="app-menu__item" href="ingresos.php"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Ingresos</span></a></li>';
                        }
                        $ventamenu .= '</ul></li>';
                        print $ventamenu;
                }

                if ($_SESSION["Roles"][4]["ver"] == 1) {
                        $cliente = '<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Clientes</span><i class="treeview-indicator fa fa-angle-right"></i></a> <ul class="treeview-menu">';
                        if ($_SESSION["Roles"][5]["ver"] == 1) {
                                $cliente .=  '<li><a class="app-menu__item" href="clientes.php"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Lista</span></a></li>';
                        }
                        if ($_SESSION["Roles"][6]["ver"] == 1) {
                                $cliente .=  '<li><a class="app-menu__item" href="membresias.php"><i class="app-menu__icon fa fa-wpforms"></i><span class="app-menu__label">Membresias</span></a></li>';
                        }
                        $cliente .= '</ul></li>';
                        print $cliente;
                }

                if ($_SESSION["Roles"][7]["ver"] == 1) {
                        $personaclientemenu = '<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-address-book-o"></i><span class="app-menu__label">Personal/Roles</span><i class="treeview-indicator fa fa-angle-right"></i></a><ul class="treeview-menu">';
                        if ($_SESSION["Roles"][8]["ver"] == 1) {
                                $personaclientemenu .= '<li><a class="app-menu__item" href="empleados.php"><i class="app-menu__icon fa fa-address-book-o"></i><span class="app-menu__label">Personal</span></a></li>';
                        }
                        if ($_SESSION["Roles"][9]["ver"] == 1) {
                                $personaclientemenu .= ' <li><a class="app-menu__item" href="roles.php"><i class="app-menu__icon fa fa-check-square "></i><span class="app-menu__label">Roles</span></a></li>';
                        }
                        $personaclientemenu .= '</ul></li>';
                        print $personaclientemenu;
                }



                if ($_SESSION["Roles"][10]["ver"] == 1) {
                        $inventariomenu = '<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Inventario</span><i class="treeview-indicator fa fa-angle-right"></i></a><ul class="treeview-menu">';
                        if ($_SESSION["Roles"][11]["ver"] == 1) {
                                $inventariomenu .= ' <li><a class="app-menu__item" href="productos.php"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Productos/Servicios</span></a></li>';
                        }
                        if ($_SESSION["Roles"][12]["ver"] == 1) {
                                $inventariomenu .= '<li><a class="app-menu__item" href="membresias.php"><i class="app-menu__icon fa fa-book "></i><span class="app-menu__label">Recepción de Mercadería</span></a></li>';
                        }
                        $inventariomenu .= '</ul></li>';
                        print  $inventariomenu;
                }

                if ($_SESSION["Roles"][13]["ver"] == 1) {
                        print '<li><a class="app-menu__item" href="reportes.php"><i class="app-menu__icon fa fa-bar-chart"></i><span class="app-menu__label">Reportes</span></a></li>';
                }

                if ($_SESSION["Roles"][14]["ver"] == 1) {
                        $configuracionmenu = '<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Configuración</span><i class="treeview-indicator fa fa-angle-right"></i></a><ul class="treeview-menu">';
                        if ($_SESSION["Roles"][15]["ver"] == 1) {
                                $configuracionmenu .= '<li><a class="app-menu__item" href="planes.php"><i class="app-menu__icon fa fa-align-left"></i><span class="app-menu__label">Planes</span></a></li>';
                        }

                        if ($_SESSION["Roles"][16]["ver"] == 1) {
                                $configuracionmenu .= '<li><a class="app-menu__item" href="disciplinas.php"><i class="app-menu__icon fa fa-indent"></i><span class="app-menu__label">Disciplinas</span></a></li>';
                        }

                        if ($_SESSION["Roles"][17]["ver"] == 1) {
                                $configuracionmenu .= '<li><a class="app-menu__item" href="categoria.php"><i class="app-menu__icon fa fa-sitemap"></i><span class="app-menu__label">Categoría</span></a></li>';
                        }

                        if ($_SESSION["Roles"][18]["ver"] == 1) {
                                $configuracionmenu .= '<li><a class="app-menu__item" href="impuesto.php"><i class="app-menu__icon fa fa-percent"></i><span class="app-menu__label">Impuestos</span></a></li>';
                        }

                        if ($_SESSION["Roles"][19]["ver"] == 1) {
                                $configuracionmenu .= '<li><a class="app-menu__item" href="empresa.php"><i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">Empresa</span></a></li>';
                        }
                        $configuracionmenu .= '</ul></li>';
                        print $configuracionmenu;
                }
                ?>
        </ul>
</aside>