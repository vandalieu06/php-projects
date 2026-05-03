<?php
$conn = mysqli_connect("db", "root", "root", "DAW");

if (isset($_POST['update'])) {
  $id = $_POST['id_persona'];
  $email = $_POST['email'];
  $tel = $_POST['telefon'];

  mysqli_query($conn, "UPDATE Persona SET email='$email', telefon='$tel' WHERE id='$id'");
  echo "<p>Dades actualitzades!</p>";
}
?>

<!DOCTYPE html>
<html>

<body>
  <h2>Modificar Persona</h2>

  <form method="POST">
    Selecciona Persona:
    <select name="id_persona">
      <?php
      $res = mysqli_query($conn, "SELECT id, nom, cognoms FROM Persona");
      while ($row = mysqli_fetch_assoc($res)) {
        echo "<option value='{$row['id']}'>{$row['nom']} {$row['cognoms']}</option>";
      }
      ?>
    </select>
    <input type="submit" name="select" value="Enviar">
  </form>

  <?php
  if (isset($_POST['select'])):
    $id_sel = $_POST['id_persona'];
  ?>
    <hr>
    <form method="POST">
      <input type="hidden" name="id_persona" value="<?php echo $id_sel; ?>">
      Nou Email: <input type="email" name="email" required><br>
      Nou Telèfon: <input type="text" name="telefon" required><br>
      <input type="submit" name="update" value="Actualitzar">
    </form>
  <?php endif; ?>

  <br><a href="index.php">Tornar al llistat</a>
</body>

</html>