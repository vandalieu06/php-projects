<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipModel extends Model
{
  protected $table = "Equip";
  protected $primaryKey = "codiE";
  protected $useAutoIncrement = true;
  protected $returnType = "array";
  protected $allowedFields = ["nom", "poblacio", "numSocis"];

  public function obtenirTotsElsEquips()
  {
    return $this->findAll();
  }

  public function obtenirEquipPerCodi($codiE)
  {
    return $this->find($codiE);
  }

  public function inserirEquip($dades)
  {
    try {
      $inserted = $this->insert($dades);
      log_message("info", "Insert returned: " . var_export($inserted, true));
      log_message("info", "Insert ID: " . $this->insertID);
      log_message("info", "Errors: " . print_r($this->errors(), true));

      if (!$inserted && empty($this->insertID)) {
        log_message(
          "error",
          "Insert Equip failed: " . print_r($this->errors(), true),
        );
        throw new \RuntimeException(
          "Error al inserir equip: " . print_r($this->errors(), true),
        );
      }
      return $inserted;
    } catch (\Exception $e) {
      log_message(
        "error",
        "EquipModel inserirEquip error: " . $e->getMessage(),
      );
      throw $e;
    }
  }

  public function eliminarEquip($codiE)
  {
    return $this->delete($codiE);
  }
}
