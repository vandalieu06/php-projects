<?php

namespace App\Controllers;

use App\Models\EquipModel;
use App\Models\JugadorModel;

class TestDb extends BaseController
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
        $resultats = [];
        $missatge = "";

        if ($this->request->getGet('test') === 'read') {
            $missatge .= "<h3>TEST 1: READ (SELECT)</h3>";
            try {
                $equips = $this->equipModel->obtenirTotsElsEquips();
                $resultats['equips'] = $equips;
                $missatge .= "<p style='color:green'>✓ Equips trobats: " . count($equips) . "</p>";
            } catch (\Exception $e) {
                $missatge .= "<p style='color:red'>✗ Error: " . $e->getMessage() . "</p>";
            }
        }

        if ($this->request->getGet('test') === 'insert') {
            $missatge .= "<h3>TEST 2: INSERT</h3>";
            try {
                $testData = [
                    'nom' => 'Equip Test ' . date('H:i:s'),
                    'poblacio' => 'Barcelona',
                    'numSocis' => 100
                ];
                
                $inserted = $this->equipModel->insert($testData);
                
                if ($inserted) {
                    $resultats['insert_id'] = $this->equipModel->insertID;
                    $missatge .= "<p style='color:green'>✓ Insertat amb ID: " . $this->equipModel->insertID . "</p>";
                    
                    $equip = $this->equipModel->find($this->equipModel->insertID);
                    $resultats['nou_equip'] = $equip;
                } else {
                    $missatge .= "<p style='color:red'>✗ Insert retornà false</p>";
                    $missatge .= "<p>Errors: " . print_r($this->equipModel->errors(), true) . "</p>";
                }
            } catch (\Exception $e) {
                $missatge .= "<p style='color:red'>✗ Exception: " . $e->getMessage() . "</p>";
            }
        }

        if ($this->request->getGet('test') === 'update') {
            $missatge .= "<h3>TEST 3: UPDATE</h3>";
            try {
                $equips = $this->equipModel->findAll();
                if (!empty($equips)) {
                    $codiE = $equips[0]['codiE'];
                    $result = $this->equipModel->update($codiE, ['numSocis' => 999]);
                    $missatge .= "<p style='color:green'>✓ Update result: " . var_export($result, true) . "</p>";
                    
                    $updated = $this->equipModel->find($codiE);
                    $resultats['updated'] = $updated;
                } else {
                    $missatge .= "<p>No hi ha equips per actualitzar</p>";
                }
            } catch (\Exception $e) {
                $missatge .= "<p style='color:red'>✗ Exception: " . $e->getMessage() . "</p>";
            }
        }

        if ($this->request->getGet('test') === 'delete') {
            $missatge .= "<h3>TEST 4: DELETE</h3>";
            try {
                $equips = $this->equipModel->findAll();
                if (!empty($equips)) {
                    $codiE = $equips[0]['codiE'];
                    $result = $this->equipModel->delete($codiE);
                    $missatge .= "<p style='color:green'>✓ Delete result: " . var_export($result, true) . "</p>";
                } else {
                    $missatge .= "<p>No hi ha equips per eliminar</p>";
                }
            } catch (\Exception $e) {
                $missatge .= "<p style='color:red'>✗ Exception: " . $e->getMessage() . "</p>";
            }
        }

        if ($this->request->getGet('test') === 'all') {
            $missatge .= "<h3>TEST COMPLET: READ -> INSERT -> READ -> UPDATE -> READ -> DELETE</h3>";
            
            try {
                $equips = $this->equipModel->findAll();
                $missatge .= "<p>1. READ inicial: " . count($equips) . " equips</p>";
                
                $testData = [
                    'nom' => 'Equip Test',
                    'poblacio' => 'Test',
                    'numSocis' => 50
                ];
                $inserted = $this->equipModel->insert($testData);
                $newId = $this->equipModel->insertID;
                $missatge .= "<p>2. INSERT: " . ($inserted ? "OK (ID: $newId)" : "FAILED") . "</p>";
                
                $equip = $this->equipModel->find($newId);
                $resultats['inserted'] = $equip;
                
                $this->equipModel->update($newId, ['numSocis' => 75]);
                $missatge .= "<p>3. UPDATE: OK</p>";
                
                $updated = $this->equipModel->find($newId);
                $resultats['updated'] = $updated;
                
                $this->equipModel->delete($newId);
                $missatge .= "<p>4. DELETE: OK</p>";
                
                $final = $this->equipModel->find($newId);
                $resultats['final'] = $final;
                
            } catch (\Exception $e) {
                $missatge .= "<p style='color:red'>✗ Error: " . $e->getMessage() . "</p>";
            }
        }

        return view('test_db', [
            'missatge' => $missatge,
            'resultats' => $resultats
        ]);
    }
}