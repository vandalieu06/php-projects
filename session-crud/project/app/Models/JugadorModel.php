<?php

namespace App\Models;

use CodeIgniter\Model;

class JugadorModel extends Model
{
  protected $table = "Jugador";
  protected $primaryKey = "codiJ";
  protected $useAutoIncrement = true;
  protected $returnType = "array";
  protected $allowedFields = ["nom", "cognoms", "demarcacio", "codiE", "foto"];

  public function obtenirTotsElsJugadors()
  {
    return $this->findAll();
  }

  public function obtenirJugadorPerCodi($codiJ)
  {
    return $this->find($codiJ);
  }

  public function inserirJugador($dades)
  {
    try {
      $result = $this->insert($dades);
      if (!$result) {
        log_message(
          "error",
          "Insert Jugador failed: " . print_r($this->errors(), true),
        );
        throw new \RuntimeException(
          "Error al inserir jugador: " . print_r($this->errors(), true),
        );
      }
      return $result;
    } catch (\Exception $e) {
      log_message(
        "error",
        "JugadorModel inserirJugador error: " . $e->getMessage(),
      );
      throw $e;
    }
  }

  public function eliminarJugador($codiJ)
  {
    return $this->delete($codiJ);
  }

  public function obtenirJugadorsPerEquip($codiE)
  {
    return $this->where("codiE", $codiE)->findAll();
  }
}
