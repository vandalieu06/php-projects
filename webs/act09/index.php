<?php
$conn = mysqli_connect("db", "root", "root", "DAW");

if (isset($_POST['add
'])) {
  $id = $_POST['id'];
  $nom = $_POST['nom'];
  $cognoms = $_POST['cognoms'];
  $email = $_POST['email'];
  $tel = $_POST['telefon'];

  $sql = "INSERT INTO Persona VALUES ('$id', '$nom', '$cognoms', '$email', '$tel')";
  mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html>

<body>
  <h2>Afegir Persona</h2>
  <form method="POST">
    ID: <input type="number" name="id" required><br>
    Nom: <input type="text" name="nom"><br>
    Cognoms: <input type="text" name="cognoms"><br>
    Email: <input type="email" name="email"><br>
    Telèfon: <input type="text" name="telefon"><br>
    <input type="submit" name="add" value="Guardar">
  </form>

  <hr>
  <h2>Llistat de Persones</h2>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Nom</th>
      <th>Cognoms</th>
      <th>Email</th>
      <th>Telèfon</th>
    </tr>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM Persona");
    while ($row = mysqli_fetch_assoc($res)) {
      echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nom']}</td>
                <td>{$row['cognoms']}</td>
                <td>{$row['email']}</td>
                <td>{$row['telefon']}</td>
            </tr>";
    }
    ?>
  </table>
</body>

</html>