<?php
session_start();
if (!isset($_SESSION["IdEmpleado"])) {
  echo '<script>location.href = "./login.php";</script>';
} else {
  if ($_SESSION["Roles"][0]["ver"] == 1) {
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
            <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            <p>Panel de general de la información del progreso de la empresa</p>
          </div>
          <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          </ul>
        </div>

        <div class="row">

          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
              <div class="info">
                <h4>Clientes</h4>
                <p><b id="lblCliente">0</b></p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-files-o fa-3x"></i>
              <div class="info">
                <h4>Empleados</h4>
                <p><b id="lblEmpleados">0</b></p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="widget-small info coloured-icon"><i class="icon fa fa-money fa-3x"></i>
              <div class="info">
                <h4>Ingresos del Día</h4>
                <p><b id="lblIngresos">0</b></p>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-star fa-3x"></i>
              <div class="info">
                <h4>Cuentas por Cobrar</h4>
                <p><b id="lblCuentas">0</b></p>
              </div>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="tile">
              <h5 class="tile-title" id="lblProximasRenovaciones">Próximas Renovaciones(0)</h5>
              <span>Membresías que vencerán en los próximos 10 días</span>
              <div class="tile-body">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Nombres</th>
                              <th>Fecha Fin</th>
                              <th>N° Celular</th>
                            </tr>
                          </thead>
                          <tbody id="tbProximasRenovaciones">

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="form-group d-flex justify-content-end">
                      <button class="btn btn-primary" id="btnAnteriorProximasRonovaciones">
                        <i class="fa fa-arrow-circle-left"></i>
                      </button>
                      <span class="m-2" id="lblPaginaActualProximasRenovaciones">0</span>
                      <span class="m-2">
                        de
                      </span>
                      <span class="m-2" id="lblPaginaSiguienteProximasRenovaciones">0</span>
                      <button class="btn btn-primary" id="btnSiguienteProximaRenovaciones">
                        <i class="fa fa-arrow-circle-right"></i>
                      </button>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="tile">
              <h5 class="tile-title" id="lblClientePorRecuperar">Clientes por Recuperar(0)</h5>
              <span>Membresías vencidas en los ultimos 30 días</span>
              <div class="tile-body">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Nombres</th>
                              <th>Fecha Fin</th>
                              <th>N° Celular</th>
                            </tr>
                          </thead>
                          <tbody id="tbClientesPorRecurar">

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 col-md-12">
                    <div class="form-group d-flex justify-content-end">
                      <button class="btn btn-primary" id="btnAnteriorPorRecuperar">
                        <i class="fa fa-arrow-circle-left"></i>
                      </button>
                      <span class="m-2" id="lblPaginaActualPorRecuperar">0</span>
                      <span class="m-2">
                        de
                      </span>
                      <span class="m-2" id="lblPaginaSiguientePorRecuperar">0</span>
                      <button class="btn btn-primary" id="btnSiguientePorRecuperar">
                        <i class="fa fa-arrow-circle-right"></i>
                      </button>
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>
        </div>

      </main>
      <!-- Essential javascripts for application to work-->
      <?php include "./layout/footer.php"; ?>

      <script type="text/javascript">
        let tools = new Tools();

        let totalPaginacionPorVencer = 0;
        let statePorVencer = false;
        let paginacionPorVencer = 0;
        let opcionPorVencer = 0;

        let totalPaginacionVencidas = 0;
        let stateVencidas = false;
        let paginacionVencidas = 0;
        let opcionVencidas = 0;

        $(document).ready(function() {

          initComponentsProximasRenovaciones();
          initComponentsPorRecuperar();

          loadDasboard();
          loadInitPorVencer();
          loadInitVencidas();
        });

        function initComponentsProximasRenovaciones() {
          $("#btnAnteriorProximasRonovaciones").click(function() {
            if (!statePorVencer) {
              if (paginacionPorVencer > 1) {
                paginacionPorVencer--;
                onEventPaginacionPorVencer();
              }
            }
          });

          $("#btnAnteriorProximasRonovaciones").keydown(function(event) {
            if (event.keyCode == 13) {
              if (!statePorVencer) {
                if (paginacionPorVencer > 1) {
                  paginacionPorVencer--;
                  onEventPaginacionPorVencer();
                }
              }
              event.preventDefault();
            }
          });

          $("#btnSiguienteProximaRenovaciones").click(function() {
            if (!statePorVencer) {
              if (paginacionPorVencer < totalPaginacionPorVencer) {
                paginacionPorVencer++;
                onEventPaginacionPorVencer();
              }
            }
          });

          $("#btnSiguienteProximaRenovaciones").keydown(function(event) {
            if (event.keyCode == 13) {
              if (!statePorVencer) {
                if (paginacionPorVencer < totalPaginacionPorVencer) {
                  paginacionPorVencer++;
                  onEventPaginacionPorVencer();
                }
              }
              event.preventDefault();
            }
          });
        }

        function initComponentsPorRecuperar() {
          $("#btnAnteriorPorRecuperar").click(function() {
            if (!stateVencidas) {
              if (paginacionVencidas > 1) {
                paginacionVencidas--;
                onEventPaginacionVencidas();
              }
            }
          });
          $("#btnAnteriorPorRecuperar").keydown(function(event) {
            if (event.keyCode == 13) {
              if (!stateVencidas) {
                if (paginacionVencidas > 1) {
                  paginacionVencidas--;
                  onEventPaginacionVencidas();
                }
              }
              event.preventDefault();
            }
          });

          $("#btnSiguientePorRecuperar").click(function() {
            if (!stateVencidas) {
              if (paginacionVencidas < totalPaginacionVencidas) {
                paginacionVencidas++;
                onEventPaginacionVencidas();
              }
            }
          });
          $("#btnSiguientePorRecuperar").keydown(function(event) {
            if (event.keyCode == 13) {
              if (!stateVencidas) {
                if (paginacionVencidas < totalPaginacionVencidas) {
                  paginacionVencidas++;
                  onEventPaginacionVencidas();
                }
              }
              event.preventDefault();
            }
          });
        }

        function loadDasboard() {
          $.ajax({
            url: "../app/miempresa/LoadDashboard.php",
            method: "GET",
            data: {
              "type": "informacion"
            },
            beforeSend: function() {
              $("#lblCliente").html(0);
              $("#lblIngresos").html(0);
              $("#lblEmpleados").html(0);
              $("#lblCuentas").html(0);
            },
            success: function(result) {
              if (result.estado == 1) {
                $("#lblCliente").html(result.clientes);
                $("#lblIngresos").html("S/ " + tools.formatMoney(result.ingresos));
                $("#lblEmpleados").html(result.empleados);
                $("#lblCuentas").html(result.cuentas);
              } else {}
            },
            error: function(error) {

            }
          });
        }

        function onEventPaginacionPorVencer() {
          switch (opcionPorVencer) {
            case 0:
              loadTablePorVencer();
              break;
          }
        }

        function loadInitPorVencer() {
          if (!statePorVencer) {
            paginacionPorVencer = 1;
            loadTablePorVencer();
            opcionPorVencer = 0;
          }
        }

        function loadTablePorVencer() {
          $.ajax({
            url: "../app/miempresa/LoadDashboard.php",
            method: "GET",
            data: {
              "type": "porvencer",
              "page": paginacionPorVencer
            },
            beforeSend: function() {
              $("#tbProximasRenovaciones").empty();
              $("#lblProximasRenovaciones").html("Próximas Renovaciones(0)");
              totalPaginacionPorVencer = 0;
              statePorVencer = true;
            },
            success: function(result) {
              if (result.estado == 1) {
                for (let value of result.memPorVencer) {
                  $("#tbProximasRenovaciones").append('<tr>' +
                    '<td>' + value.apellidos + "<br>" + value.nombres + '</td>' +
                    '<td>' + tools.getDateForma(value.fechaFin) + '</td>' +
                    '<td>' + value.celular + '</td>' +
                    '</tr>');
                }

                totalPaginacionPorVencer = parseInt(Math.ceil((parseFloat(result.memPorVencerTotal) / parseInt(10))));
                $("#lblPaginaActualProximasRenovaciones").html(paginacionPorVencer);
                $("#lblPaginaSiguienteProximasRenovaciones").html(totalPaginacionPorVencer);

                $("#lblProximasRenovaciones").html("Próximas Renovaciones(" + result.memPorVencerTotal + ")");

                statePorVencer = false;
              } else {
                statePorVencer = false;
              }
            },
            error: function(error) {
              statePorVencer = false;
            }
          });
        }

        function onEventPaginacionVencidas() {
          switch (opcionVencidas) {
            case 0:
              loadTableVencidas();
              break;
          }
        }

        function loadInitVencidas() {
          if (!stateVencidas) {
            paginacionVencidas = 1;
            loadTableVencidas();
            opcionVencidas = 0;
          }
        }

        function loadTableVencidas() {
          $.ajax({
            url: "../app/miempresa/LoadDashboard.php",
            method: "GET",
            data: {
              "type": "vencido",
              "page": paginacionVencidas
            },
            beforeSend: function() {
              $("#tbClientesPorRecurar").empty();
              $("#lblClientePorRecuperar").html("Próximas Renovaciones(0)");
              totalPaginacionVencidas = 0;
              stateVencidas = true;
            },
            success: function(result) {
              if (result.estado == 1) {
                for (let value of result.memFinazalidas) {
                  $("#tbClientesPorRecurar").append('<tr>' +
                    '<td>' + value.apellidos + "<br>" + value.nombres + '</td>' +
                    '<td>' + tools.getDateForma(value.fechaFin) + '</td>' +
                    '<td>' + value.celular + '</td>' +
                    '</tr>');
                }

                totalPaginacionVencidas = parseInt(Math.ceil((parseFloat(result.memFinazalidasTotal) / parseInt(10))));
                $("#lblPaginaActualPorRecuperar").html(paginacionVencidas);
                $("#lblPaginaSiguientePorRecuperar").html(totalPaginacionVencidas);

                $("#lblClientePorRecuperar").html("Clientes por Recuperar(" + result.memFinazalidasTotal + ")");
                stateVencidas = false;
              } else {
                stateVencidas = false;
              }
            },
            error: function(error) {
              stateVencidas = false;
            }
          });
        }

        // var data = {
        //   labels: ["January", "February", "March", "April", "May"],
        //   datasets: [{
        //       label: "My First dataset",
        //       fillColor: "rgba(220,220,220,0.2)",
        //       strokeColor: "rgba(220,220,220,1)",
        //       pointColor: "rgba(220,220,220,1)",
        //       pointStrokeColor: "#fff",
        //       pointHighlightFill: "#fff",
        //       pointHighlightStroke: "rgba(220,220,220,1)",
        //       data: [65, 59, 80, 81, 56]
        //     },
        //     {
        //       label: "My Second dataset",
        //       fillColor: "rgba(151,187,205,0.2)",
        //       strokeColor: "rgba(151,187,205,1)",
        //       pointColor: "rgba(151,187,205,1)",
        //       pointStrokeColor: "#fff",
        //       pointHighlightFill: "#fff",
        //       pointHighlightStroke: "rgba(151,187,205,1)",
        //       data: [28, 48, 40, 19, 86]
        //     }
        //   ]
        // };
        // var pdata = [{
        //     value: 300,
        //     color: "#46BFBD",
        //     highlight: "#5AD3D1",
        //     label: "Complete"
        //   },
        //   {
        //     value: 50,
        //     color: "#F7464A",
        //     highlight: "#FF5A5E",
        //     label: "In-Progress"
        //   }
        // ]

        // var ctxl = $("#lineChartDemo").get(0).getContext("2d");
        // var lineChart = new Chart(ctxl).Line(data);

        // var ctxp = $("#pieChartDemo").get(0).getContext("2d");
        // var pieChart = new Chart(ctxp).Pie(pdata);
      </script>
    </body>

    </html>

<?php
  } else {
    echo '<script>location.href = "./bienvenido.php";</script>';
  }
}
