<?php

function createSale($connection, $userId, $cartItems)
{
  mysqli_begin_transaction($connection);
  
  try {
    $sql = "INSERT INTO compra (codiUsuari) VALUES (?)";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $purchaseId = mysqli_insert_id($connection);
    mysqli_stmt_close($stmt);
    
    $counts = array_count_values($cartItems);
    
    foreach ($counts as $productId => $quantity) {
      $sql = "INSERT INTO comanda (codiCompra, codiProducte, quantitat) VALUES (?, ?, ?)";
      $stmt = mysqli_prepare($connection, $sql);
      mysqli_stmt_bind_param($stmt, "iii", $purchaseId, $productId, $quantity);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      
      $sql = "UPDATE producte SET stock = stock - ? WHERE codiProducte = ? AND stock >= ?";
      $stmt = mysqli_prepare($connection, $sql);
      mysqli_stmt_bind_param($stmt, "iii", $quantity, $productId, $quantity);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    
    mysqli_commit($connection);
    return [true, $purchaseId];
    
  } catch (Exception $e) {
    mysqli_rollback($connection);
    return [false, $e->getMessage()];
  }
}

function getAllSales($connection)
{
  $sql = "SELECT c.codiCompra, c.data, c.codiUsuari, u.email, u.nom, u.cognoms,
          SUM(p.preu * com.quantitat) as total
          FROM compra c
          JOIN usuari u ON c.codiUsuari = u.codiUsuari
          JOIN comanda com ON c.codiCompra = com.codiCompra
          JOIN producte p ON com.codiProducte = p.codiProducte
          GROUP BY c.codiCompra
          ORDER BY c.data DESC";
  
  $result = mysqli_query($connection, $sql);
  $sales = [];
  
  if (!$result) {
    return [];
  }
  
  while ($row = mysqli_fetch_assoc($result)) {
    $sales[] = $row;
  }
  
  return $sales;
}

function getSaleDetails($connection, $saleId)
{
  $sql = "SELECT c.codiCompra, c.data, c.codiUsuari, u.email, u.nom, u.cognoms
          FROM compra c
          JOIN usuari u ON c.codiUsuari = u.codiUsuari
          WHERE c.codiCompra = ?";
  
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, "i", $saleId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $sale = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);
  
  if (!$sale) {
    return null;
  }
  
  $sql = "SELECT p.codiProducte, p.nom, p.preu, com.quantitat
          FROM comanda com
          JOIN producte p ON com.codiProducte = p.codiProducte
          WHERE com.codiCompra = ?";
  
  $stmt = mysqli_prepare($connection, $sql);
  mysqli_stmt_bind_param($stmt, "i", $saleId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  
  $items = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $items[] = $row;
  }
  mysqli_stmt_close($stmt);
  
  $sale['items'] = $items;
  $sale['total'] = array_sum(array_map(fn($i) => $i['preu'] * $i['quantitat'], $items));
  
  return $sale;
}

function getTotalSales($connection)
{
  $sql = "SELECT COUNT(*) as total, SUM(p.preu * com.quantitat) as amount
          FROM compra c
          JOIN comanda com ON c.codiCompra = com.codiCompra
          JOIN producte p ON com.codiProducte = p.codiProducte";
  
  $result = mysqli_query($connection, $sql);
  return mysqli_fetch_assoc($result);
}

?>
