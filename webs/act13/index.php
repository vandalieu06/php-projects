<?php
require_once "modelos.php";
require_once "connection.php";

session_start();

if (!isset($_SESSION["vehicles"])) {
  $_SESSION["vehicles"] = [];
}

$tipoVehiculo = $_POST["tipoVehiculo"] ?? "";

$mostrarVehiculos = isset($_POST["veureVehicles"]);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["guardar"])) {
  $marca = $_POST["marca"];
  $model = $_POST["model"];
  $potencia = $_POST["potencia"];
  $cilindrada = $_POST["cilindrada"];
  $consum = $_POST["consum"];

  if ($tipoVehiculo === "cotxe") {
    $vehiculo = new Cotxe(
      $marca,
      $model,
      $potencia,
      $cilindrada,
      $consum,
      $_POST["numPortes"],
      $_POST["numPlaces"],
      $_POST["tipusCarborant"],
    );
  } elseif ($tipoVehiculo === "camio") {
    $vehiculo = new Camio(
      $marca,
      $model,
      $potencia,
      $cilindrada,
      $consum,
      $_POST["pesTara"],
      $_POST["pesCarrega"],
    );
  } elseif ($tipoVehiculo === "moto") {
    $vehiculo = new Moto(
      $marca,
      $model,
      $potencia,
      $cilindrada,
      $consum,
      $_POST["tipusMoto"],
      $_POST["numPlaces"],
    );
  }

  $_SESSION["vehicles"][] = $vehiculo;
  header("Location: index.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pujarVehicles"])) {
  foreach ($_SESSION["vehicles"] as $v) {
    $v->insertVehicle($connection);
  }
  header("Location: index.php");
  exit();
}

$vehiclesFromDB = [];

if (
  $_SERVER["REQUEST_METHOD"] === "POST" &&
  isset($_POST["seleccionarTipus"])
) {
  $tipusSeleccionat = $_POST["tipusSeleccionar"];
  $vehiclesFromDB = Vehicle::selectVehicles($connection, $tipusSeleccionat);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminarTipus"])) {
  $tipusEliminar = $_POST["tipusEliminar"];
  Vehicle::deleteVehicles($connection, $tipusEliminar);
  header("Location: index.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>

    <!-- SELECCIONADOR DE BASE VEHICULO Y EXTRAS -->
    <div>
        <h2>Selecciona el tipo de vehiculo a añadir</h2>
        <form action="" method="POST">
            <select name="tipoVehiculo" id="tipoVehiculo" onchange="this.form.submit()">
                <option value=""> -- Seleccionar -- </option>
                <option value="cotxe" <?= $tipoVehiculo === "cotxe"
                  ? "selected"
                  : "" ?>>
                    Cotxe
                </option>
                <option value="camio" <?= $tipoVehiculo === "camio"
                  ? "selected"
                  : "" ?>>
                      Camio
                  </option>
                <option value="moto" <?= $tipoVehiculo === "moto"
                  ? "selected"
                  : "" ?>>
                      Moto
                  </option>
            </select>
        </form>
        <br>
        <form action="" method="POST">
            <button type="submit" name="veureVehicles">Veure Vehicles</button>
        </form>
        <br>
        <form action="" method="POST">
            <button type="submit" name="pujarVehicles">Pujar Vehicles a BD</button>
        </form>
        <br>
        <form action="" method="POST">
            <select name="tipusSeleccionar">
                <option value=""> -- Seleccionar tipus -- </option>
                <option value="cotxe">Cotxe</option>
                <option value="camio">Camio</option>
                <option value="moto">Moto</option>
            </select>
            <button type="submit" name="seleccionarTipus">Seleccionar de BD</button>
        </form>
        <br>
        <form action="" method="POST">
            <select name="tipusEliminar">
                <option value=""> -- Seleccionar tipus -- </option>
                <option value="cotxe">Cotxe</option>
                <option value="camio">Camio</option>
                <option value="moto">Moto</option>
            </select>
            <button type="submit" name="eliminarTipus">Eliminar de BD</button>
        </form>
    </div>

    <!-- FORMULARIO DE CREACION DE VEHICULO-->
    <?php if ($tipoVehiculo): ?>
    <div>
        <h3>Datos del vehículo</h3>
        <form action="" method="POST">
            <input type="hidden" name="tipoVehiculo" value="<?= $tipoVehiculo ?>">

            <label>Marca: <input type="text" name="marca" required></label><br><br>
            <label>Model: <input type="text" name="model" required></label><br><br>
            <label>Potencia: <input type="number" name="potencia" required></label><br><br>
            <label>Cilindrada: <input type="number" name="cilindrada" required></label><br><br>
            <label>Consum: <input type="number" step="0.1" name="consum" required></label><br><br>

            <?php if ($tipoVehiculo === "cotxe"): ?>
                <label>Num. Puertas: <input type="number" name="numPortes" required></label><br><br>
                <label>Num. Plazas: <input type="number" name="numPlaces" required></label><br><br>
                <label>Tipo Carburante:
                    <select name="tipusCarborant">
                        <option value="gasolina">Gasolina</option>
                        <option value="diesel">Dièsel</option>
                        <option value="electric">Elèctric</option>
                    </select>
                </label><br><br>
            <?php elseif ($tipoVehiculo === "camio"): ?>
                <label>Peso Tara: <input type="number" name="pesTara" required></label><br><br>
                <label>Peso Carga: <input type="number" name="pesCarrega" required></label><br><br>
            <?php elseif ($tipoVehiculo === "moto"): ?>
                <label>Tipo Moto: <input type="text" name="tipusMoto" required></label><br><br>
                <label>Num. Plazas: <input type="number" name="numPlaces" required></label><br><br>
            <?php endif; ?>

            <button type="submit" name="guardar">Guardar Vehículo</button>
        </form>
    </div>
    <?php endif; ?>


    <!-- LISTA DE PRODUCTOS LOCALES (SESSION) -->
    <?php if ($mostrarVehiculos && !empty($_SESSION["vehicles"])): ?>
    <div>
        <h3>Llista de Vehicles:</h3>
        <table border="0" cellpadding="5">
            <tr>
                <th>Tipus</th>
                <th>Marca</th>
                <th>Model</th>
                <th>Potencia</th>
                <th>Cilindrada</th>
                <th>Dades Específiques</th>
                <th>Impost Circulació</th>
                <th>Consumo normal</th>
                <th>Consumo 4x4</th>
            </tr>
            <?php foreach ($_SESSION["vehicles"] as $v): ?>
            <tr>
                <td>
                    <?php if ($v instanceof Cotxe) {
                      echo "Cotxe";
                    } elseif ($v instanceof Camio) {
                      echo "Camió";
                    } elseif ($v instanceof Moto) {
                      echo "Moto";
                    } ?>
                </td>
                <td><?= $v->getMarca() ?></td>
                <td><?= $v->getModel() ?></td>
                <td><?= $v->getPotencia() ?> CV</td>
                <td><?= $v->getCilindrada() ?> cc</td>
                <td><?= $v->mostraDades() ?></td>
                <td><?= number_format(
                  $v->calculaImpostCirculacio(),
                  2,
                ) ?> €</td>
                <td><?= number_format($v->getConsum(), 2) ?> l</td>
                <td>
                    <?php if ($v instanceof Moto) {
                      echo "";
                    } else {
                      $num = number_format($v->activa4x4(), 2);
                      echo "$num l";
                    } ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php elseif ($mostrarVehiculos): ?>
    <p>No hi ha vehicles guardats.</p>
    <?php endif; ?>

    <!-- LISTA DE VECHICULOS DE LA BASE DE DATOS -->
    <?php if (!empty($vehiclesFromDB)): ?>
    <div>
        <h3>Vehicles de la Base de Dades:</h3>
        <table border="0" cellpadding="5">
            <tr>
                <th>Tipus</th>
                <th>Marca</th>
                <th>Model</th>
                <th>Potencia</th>
                <th>Cilindrada</th>
                <th>Dades Específiques</th>
                <th>Impost Circulació</th>
                <th>Consumo normal</th>
                <?php if ($_POST["tipusSeleccionar"] != "moto"): ?>
                <th>Consumo 4x4</th>
                <?php endif; ?>
            </tr>
            <?php foreach ($vehiclesFromDB as $row): ?>
            <?php if ($row["tipus"] === "cotxe") {
              $v = new Cotxe(
                $row["marca"],
                $row["model"],
                $row["potencia"],
                $row["cilindrada"],
                $row["consum"],
                $row["numPortes"],
                $row["numPlaces"],
                $row["tipusCarborant"],
              );
            } elseif ($row["tipus"] === "camio") {
              $v = new Camio(
                $row["marca"],
                $row["model"],
                $row["potencia"],
                $row["cilindrada"],
                $row["consum"],
                $row["pesTara"],
                $row["pesCarga"],
              );
            } else {
              $v = new Moto(
                $row["marca"],
                $row["model"],
                $row["potencia"],
                $row["cilindrada"],
                $row["consum"],
                $row["tipusMoto"],
                $row["numPlaces"],
              );
            } ?>
            <tr>
                <td>
                    <?php if ($v instanceof Cotxe) {
                      echo "Cotxe";
                    } elseif ($v instanceof Camio) {
                      echo "Camió";
                    } elseif ($v instanceof Moto) {
                      echo "Moto";
                    } ?>
                </td>
                <td><?= $v->getMarca() ?></td>
                <td><?= $v->getModel() ?></td>
                <td><?= $v->getPotencia() ?> CV</td>
                <td><?= $v->getCilindrada() ?> cc</td>
                <td><?= $v->mostraDades() ?></td>
                <td><?= number_format(
                  $v->calculaImpostCirculacio(),
                  2,
                ) ?> €</td>
                <td><?= number_format($v->getConsum(), 2) ?> l</td>
                <td>
                    <?php if ($v instanceof Moto) {
                      echo "";
                    } else {
                      echo number_format($v->activa4x4(), 2) . " l";
                    } ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php elseif (isset($_POST["seleccionarTipus"])): ?>
    <h3>No hay vehiculos del tipo selecciondo en la base de datos</h3>
    <?php endif; ?>
</body>
</html>
