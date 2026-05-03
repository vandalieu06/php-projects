<?php

abstract class Vehicle
{
  private $marca;
  private $model;
  private $potencia;
  private $cilindrada;
  private $consum;

  public function __construct($marca, $model, $potencia, $cilindrada, $consum)
  {
    $this->marca = $marca;
    $this->model = $model;
    $this->potencia = $potencia;
    $this->cilindrada = $cilindrada;
    $this->consum = $consum;
  }

  abstract public function calculaImpostCirculacio(): float;

  abstract public function mostraDades(): string;

  abstract public function insertVehicle($connection): void;

  public static function selectVehicles($connection, string $tipus): array
  {
    $format_tipus = strtolower($tipus);

    $sql = "SELECT * FROM vehicles WHERE LOWER(tipus) = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $format_tipus);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $vehicles = [];
    if (!$result) {
      return [];
    }

    while ($row = mysqli_fetch_assoc($result)) {
      $vehicles[] = $row;
    }

    return $vehicles;
  }

  public static function deleteVehicles($connection, string $tipus): bool
  {
    $format_tipus = strtolower($tipus);

    $sql = "DELETE FROM vehicles WHERE LOWER(tipus) = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "s", $format_tipus);
    $result = mysqli_stmt_execute($stmt);

    return $result;
  }

  public function getMarca()
  {
    return $this->marca;
  }
  public function setMarca($marca)
  {
    $this->marca = $marca;
  }

  public function getModel()
  {
    return $this->model;
  }
  public function setModel($model)
  {
    $this->model = $model;
  }

  public function getPotencia()
  {
    return $this->potencia;
  }
  public function setPotencia($potencia)
  {
    $this->potencia = $potencia;
  }

  public function getCilindrada()
  {
    return $this->cilindrada;
  }
  public function setCilindrada($cilindrada)
  {
    $this->cilindrada = $cilindrada;
  }

  public function getConsum()
  {
    return $this->consum;
  }
  public function setConsum($consum)
  {
    $this->consum = $consum;
  }
}

interface Quatrexquatre
{
  public function activa4x4(): float;
}

class Cotxe extends Vehicle implements Quatrexquatre
{
  private $numPortes;
  private $numPlaces;
  private $tipusCarborant;

  public function __construct(
    $marca,
    $model,
    $potencia,
    $cilindrada,
    $consum,
    $numPortes,
    $numPlaces,
    $tipusCarborant,
  ) {
    parent::__construct($marca, $model, $potencia, $cilindrada, $consum);
    $this->numPortes = $numPortes;
    $this->numPlaces = $numPlaces;
    $this->tipusCarborant = $tipusCarborant;
  }

  public function calculaImpostCirculacio(): float
  {
    return parent::getCilindrada() * 0.04;
  }

  public function activa4x4(): float
  {
    return parent::getConsum() * 1.8;
  }

  public function mostraDades(): string
  {
    return "Puertas: $this->numPortes, Plazas: $this->numPlaces, Carburante: $this->tipusCarborant.";
  }

  public function insertVehicle($connection): void
  {
    $sql =
      "INSERT INTO vehicles (tipus, marca, model, potencia, cilindrada, consum, numPortes, numPlaces, tipusCarborant) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    $tipus = "cotxe";
    $marca = $this->getMarca();
    $model = $this->getModel();
    $potencia = $this->getPotencia();
    $cilindrada = $this->getCilindrada();
    $consum = $this->getConsum();
    $numPortes = $this->numPortes;
    $numPlaces = $this->numPlaces;
    $tipusCarborant = $this->tipusCarborant;

    mysqli_stmt_bind_param(
      $stmt,
      "sssiiiiis",
      $tipus,
      $marca,
      $model,
      $potencia,
      $cilindrada,
      $consum,
      $numPortes,
      $numPlaces,
      $tipusCarborant,
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }

  public function getNumPortes()
  {
    return $this->numPortes;
  }
  public function getNumPlaces()
  {
    return $this->numPlaces;
  }
  public function getTipusCarborant()
  {
    return $this->tipusCarborant;
  }
}

class Camio extends Vehicle implements Quatrexquatre
{
  private $pesTara;
  private $pesCarrega;

  public function __construct(
    $marca,
    $model,
    $potencia,
    $cilindrada,
    $consum,
    $pesTara,
    $pesCarrega,
  ) {
    parent::__construct($marca, $model, $potencia, $cilindrada, $consum);
    $this->pesTara = $pesTara;
    $this->pesCarrega = $pesCarrega;
  }

  public function calculaImpostCirculacio(): float
  {
    return parent::getCilindrada() * 0.08;
  }

  public function activa4x4(): float
  {
    return parent::getConsum() * 2.0;
  }

  public function mostraDades(): string
  {
    return "Peso tara: $this->pesTara kg, Peso carga: $this->pesCarrega kg.";
  }

  public function insertVehicle($connection): void
  {
    $sql =
      "INSERT INTO vehicles (tipus, marca, model, potencia, cilindrada, consum, pesTara, pesCarga) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    $tipus = "camio";
    $marca = $this->getMarca();
    $model = $this->getModel();
    $potencia = $this->getPotencia();
    $cilindrada = $this->getCilindrada();
    $consum = $this->getConsum();
    $pesTara = $this->pesTara;
    $pesCarrega = $this->pesCarrega;

    mysqli_stmt_bind_param(
      $stmt,
      "sssiiiii",
      $tipus,
      $marca,
      $model,
      $potencia,
      $cilindrada,
      $consum,
      $pesTara,
      $pesCarrega,
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }

  public function getPesTara()
  {
    return $this->pesTara;
  }
  public function getPesCarrega()
  {
    return $this->pesCarrega;
  }
}

class Moto extends Vehicle
{
  private $tipusMoto;
  private $numPlaces;

  public function __construct(
    $marca,
    $model,
    $potencia,
    $cilindrada,
    $consum,
    $tipusMoto,
    $numPlaces,
  ) {
    parent::__construct($marca, $model, $potencia, $cilindrada, $consum);
    $this->tipusMoto = $tipusMoto;
    $this->numPlaces = $numPlaces;
  }

  public function calculaImpostCirculacio(): float
  {
    return parent::getCilindrada() * 0.03;
  }

  public function mostraDades(): string
  {
    return "Tipo: $this->tipusMoto, Plazas: $this->numPlaces.";
  }

  public function insertVehicle($connection): void
  {
    $sql =
      "INSERT INTO vehicles (tipus, marca, model, potencia, cilindrada, consum, tipusMoto, numPlaces) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($connection, $sql);

    $tipus = "moto";
    $marca = $this->getMarca();
    $model = $this->getModel();
    $potencia = $this->getPotencia();
    $cilindrada = $this->getCilindrada();
    $consum = $this->getConsum();
    $tipusMoto = $this->tipusMoto;
    $numPlaces = $this->numPlaces;

    mysqli_stmt_bind_param(
      $stmt,
      "sssiiisi",
      $tipus,
      $marca,
      $model,
      $potencia,
      $cilindrada,
      $consum,
      $tipusMoto,
      $numPlaces,
    );

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }

  public function getTipusMoto()
  {
    return $this->tipusMoto;
  }
  public function getNumPlaces()
  {
    return $this->numPlaces;
  }
}

?>
