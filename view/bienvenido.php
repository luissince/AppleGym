<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
  echo '<script>location.href = "./login.php";</script>';
} else {
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include './layout/head.php'; ?>
  </head>

  <body class="app sidebar-mini">
    <!-- Navbar-->
    <?php include("./layout/header.php"); ?>
    <!-- Sidebar menu-->
    <?php include("./layout/menu.php"); ?>
    <main class="app-content">

      <!-- Sidebar menu-->
      <?php include "./marcarentrada.php"; ?>

      <div class="app-title">
        <div>
          <h1><i class="fa fa-smile-o"></i> Bienvenido a Apple Gym Perú</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        </ul>
      </div>

      <div class="tile mb-4 pt-xl-3 pb-xl-3 pl-xl-5">
        <div class="row">
          <div class="col-lg-12">
            <label for="f-inicio">Bienvenido al Sistema de Gestión del Gimnasio Apple Gym Perú, donde podra agregar planes, cliente, membresias entre otras funcionalidad para tener una mejor administración. </label>
          </div>
        </div>

      </div>

    </main>
    <!-- Essential javascripts for application to work-->
    <?php include "./layout/footer.php"; ?>
    <script>
      let tools = new Tools();
    </script>
  </body>

  </html>

<?php
}
