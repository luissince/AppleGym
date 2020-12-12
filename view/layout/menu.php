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
                <li><a class="app-menu__item" href="index.php"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
                <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Ingresos</span></a></li>
                <li><a class="app-menu__item" href="clientes.php"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Clientes</span></a></li>
                <li><a class="app-menu__item" href="#"><i class="app-menu__icon fa fa-calendar"></i><span class="app-menu__label">Citas</span></a></li>
                <li><a class="app-menu__item" href="planes.php"><i class="app-menu__icon fa fa-align-left"></i><span class="app-menu__label">Planes</span></a></li>
                <li><a class="app-menu__item" href="disciplinas.php"><i class="app-menu__icon fa fa-indent"></i><span class="app-menu__label">Disciplinas</span></a></li>
                <li><a class="app-menu__item" href="empresa.php"><i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">Empresa</span></a></li>

                <!-- <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">UI Elements</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                                <li><a class="treeview-item" href="bootstrap-components.html"><i class="icon fa fa-circle-o"></i>
                                                Bootstrap Elements</a></li>
                                <li><a class="treeview-item" href="https://fontawesome.com/v4.7.0/icons/" target="_blank" rel="noopener"><i class="icon fa fa-circle-o"></i> Font Icons</a></li>
                                <li><a class="treeview-item" href="ui-cards.html"><i class="icon fa fa-circle-o"></i> Cards</a></li>
                                <li><a class="treeview-item" href="widgets.html"><i class="icon fa fa-circle-o"></i> Widgets</a></li>
                        </ul>
                </li>
                <li><a class="app-menu__item" href="charts.html"><i class="app-menu__icon fa fa-pie-chart"></i><span class="app-menu__label">Charts</span></a></li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-edit"></i><span class="app-menu__label">Forms</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                                <li><a class="treeview-item" href="form-components.html"><i class="icon fa fa-circle-o"></i> Form
                                                Components</a></li>
                                <li><a class="treeview-item" href="form-custom.html"><i class="icon fa fa-circle-o"></i> Custom
                                                Components</a></li>
                                <li><a class="treeview-item" href="form-samples.html"><i class="icon fa fa-circle-o"></i> Form
                                                Samples</a></li>
                                <li><a class="treeview-item" href="form-notifications.html"><i class="icon fa fa-circle-o"></i> Form
                                                Notifications</a></li>
                        </ul>
                </li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Tables</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                                <li><a class="treeview-item" href="table-basic.html"><i class="icon fa fa-circle-o"></i> Basic
                                                Tables</a></li>
                                <li><a class="treeview-item" href="table-data-table.html"><i class="icon fa fa-circle-o"></i> Data
                                                Tables</a></li>
                        </ul>
                </li>
                <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text"></i><span class="app-menu__label">Pages</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                        <ul class="treeview-menu">
                                <li><a class="treeview-item" href="blank-page.html"><i class="icon fa fa-circle-o"></i> Blank Page</a>
                                </li>
                                <li><a class="treeview-item" href="page-login.html"><i class="icon fa fa-circle-o"></i> Login Page</a>
                                </li>
                                <li><a class="treeview-item" href="page-lockscreen.html"><i class="icon fa fa-circle-o"></i> Lockscreen
                                                Page</a></li>
                                <li><a class="treeview-item" href="page-user.html"><i class="icon fa fa-circle-o"></i> User Page</a>
                                </li>
                                <li><a class="treeview-item" href="page-invoice.html"><i class="icon fa fa-circle-o"></i> Invoice
                                                Page</a></li>
                                <li><a class="treeview-item" href="page-calendar.html"><i class="icon fa fa-circle-o"></i> Calendar
                                                Page</a></li>
                                <li><a class="treeview-item" href="page-mailbox.html"><i class="icon fa fa-circle-o"></i> Mailbox</a>
                                </li>
                                <li><a class="treeview-item" href="page-error.html"><i class="icon fa fa-circle-o"></i> Error Page</a>
                                </li>
                        </ul>
                </li> -->
                <!-- <li><a class="app-menu__item" href="docs.html"><i class="app-menu__icon fa fa-file-code-o"></i><span class="app-menu__label">Docs</span></a></li> -->
        </ul>
</aside>