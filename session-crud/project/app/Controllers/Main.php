<?php

namespace App\Controllers;

use App\Models\EquipModel;
use App\Models\JugadorModel;

class Main extends BaseController
{
  protected $equipModel;
  protected $jugadorModel;

  public function __construct()
  {
    $this->equipModel = new EquipModel();
    $this->jugadorModel = new JugadorModel();
  }

  public function index()
  {
    return view("index");
  }

  public function insertarEquip()
  {
    if ($this->request->is("post")) {
      $rules = [
        "nom" => "required|min_length[1]|max_length[50]",
        "poblacio" => "required|min_length[1]|max_length[25]",
        "numSocis" => "required|integer|greater_than[0]",
      ];
      if (!$this->validate($rules)) {
        return view("llistat_equips", ["validation" => $this->validator]);
      }
      $dades = [
        "nom" => $this->request->getPost("nom"),
        "poblacio" => $this->request->getPost("poblacio"),
        "numSocis" => $this->request->getPost("numSocis"),
      ];

      try {
        $result = $this->equipModel->inserirEquip($dades);
        return view("llistat_equips");
      } catch (\Exception $e) {
        return view("form_equip", [
          "error" => $e->getMessage(),
        ]);
      }
    }

    return view("form_equip");
  }

  public function mostrarEquips()
  {
    $equips = $this->equipModel->obtenirTotsElsEquips();
    return view("llistat_equips", ["equips" => $equips]);
  }

  public function eliminarEquip()
  {
    if ($this->request->is("post")) {
      $codiE = $this->request->getPost("codiE");

      if ($codiE) {
        try {
          $this->jugadorModel->where("codiE", $codiE)->delete();
          $this->equipModel->eliminarEquip($codiE);
          return redirect()
            ->to("/eliminarEquip")
            ->with("missatge", "Equip i jugadors eliminats correctament");
        } catch (\Exception $e) {
          return redirect()
            ->to("/eliminarEquip")
            ->with("missatge", "Error en eliminar: " . $e->getMessage());
        }
      }
    }

    $equips = $this->equipModel->obtenirTotsElsEquips();
    return view("eliminar_equip", ["equips" => $equips]);
  }

  public function insertarJugador()
  {
    if ($this->request->is("post")) {
      $rules = [
        "nom" => "required|min_length[1]|max_length[20]",
        "cognoms" => "required|min_length[1]|max_length[30]",
        "demarcacio" => "required|min_length[1]|max_length[20]",
        "codiE" => "required|integer",
        "foto" => "uploaded[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]|max_size[foto,2048]"
      ];

      if (!$this->validate($rules)) {
        $equips = $this->equipModel->obtenirTotsElsEquips();
        return view("form_jugador", [
          "validation" => $this->validator,
          "equips" => $equips,
        ]);
      }

      $dades = [
        "nom" => $this->request->getPost("nom"),
        "cognoms" => $this->request->getPost("cognoms"),
        "demarcacio" => $this->request->getPost("demarcacio"),
        "codiE" => $this->request->getPost("codiE"),
      ];

      // Handle photo upload
      $foto = $this->request->getFile('foto');
      if ($foto->isValid() && !$foto->hasMoved()) {
        $nomFoto = uniqid() . '.' . $foto->getExtension();
        $foto->move(WRITEPATH . 'uploads', $nomFoto);
        $dades['foto'] = $nomFoto;
      }

      try {
        $this->jugadorModel->inserirJugador($dades);
        return redirect()
          ->to("/mostrarJugadors")
          ->with("missatge", "Jugador inserit correctament");
      } catch (\Exception $e) {
        $equips = $this->equipModel->obtenirTotsElsEquips();
        return view("form_jugador", [
          "error" => $e->getMessage(),
          "equips" => $equips,
        ]);
      }
    }

    $equips = $this->equipModel->obtenirTotsElsEquips();
    return view("form_jugador", ["equips" => $equips]);
  }

  public function mostrarJugadors()
  {
    $jugadors = $this->jugadorModel->obtenirTotsElsJugadors();

    foreach ($jugadors as &$jugador) {
      $equip = $this->equipModel->obtenirEquipPerCodi($jugador["codiE"]);
      $jugador["nom_equip"] = $equip ? $equip["nom"] : "Sense equip";
    }

    return view("llistat_jugadors", ["jugadors" => $jugadors]);
  }

  public function eliminarJugador()
  {
    if ($this->request->is("post")) {
      $codiJ = $this->request->getPost("codiJ");

      if ($codiJ) {
        try {
          $this->jugadorModel->eliminarJugador($codiJ);
          return redirect()
            ->to("/eliminarJugador")
            ->with("missatge", "Jugador eliminat correctament");
        } catch (\Exception $e) {
          log_message("error", "Eliminar jugador error: " . $e->getMessage());
          return redirect()
            ->to("/eliminarJugador")
            ->with("missatge", "Error en eliminar: " . $e->getMessage());
        }
      }
    }

    $jugadors = $this->jugadorModel->obtenirTotsElsJugadors();

    foreach ($jugadors as &$jugador) {
      $equip = $this->equipModel->obtenirEquipPerCodi($jugador["codiE"]);
      $jugador["nom_equip"] = $equip ? $equip["nom"] : "Sense equip";
    }

    return view("eliminar_jugador", ["jugadors" => $jugadors]);
  }

  public function senseModel()
  {
    $db = \Config\Database::connect();

    $query = $db->query("
            SELECT J.nom, J.cognoms, J.demarcacio, E.nom as nom_equip, E.poblacio
            FROM Jugador J
            INNER JOIN Equip E ON J.codiE = E.codiE
            ORDER BY E.nom, J.cognoms
        ");

    $result = $query->getResultArray();

    return view("sense_model", ["resultats" => $result]);
  }
}
