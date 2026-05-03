<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVITAT 01 - JHONNY CLAURE</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css"
  >
</head>
<body>
  <main class="container">
    <h1>PHP - TUTORIAL 01</h1>
    <?php 
      # Ex 1
      echo "<h2>Lista de Hello Worlds</h2>";

      echo '<p>Hello "World"</p>';
      echo "<p>Hello 'World'</p>";
      echo '<p>Hello World \\</p>';

      $age = 19;
      $tipo_variable = gettype($age);
      echo "La variable \$age es de tipo: $tipo_variable";

      $numeroFalso = 0;
      if ($numeroFalso == FALSE){
        echo "<p>El numero 0 es FALSE</p>";
      }

      $numeroTrue = 100;
      if ($numeroTrue == TRUE){
        echo "<p>El numero 100 es TRUE</p>";
      }

      # Ex 2
      echo "<h2>Concatenación de textos</h2>";

      $texto1 = "Hola";
      $texto2 = "Mundo";
      $texto_concat = $texto1." ".$texto2;
      echo "<p>$texto_concat</p>";

      # Ex 3
      echo "<h2>Diferencia entre ISSET y EMPTY</h2>";

      $numero_destruido = 100;

      if (isset($numero_destruido)) {
          echo "<p>isset: La variable \$numero_destruido existe</p>";
      } else {
          echo "<p>isset: La variable \$numero_destruido no existe</p>";
      }

      if (empty($numero_destruido)) {
          echo "<p>empty: La variable \$numero_destruido está vacía</p>";
      } else {
          echo "<p>empty: La variable \$numero_destruido NO está vacía</p>";
      }

      unset($numero_destruido);

      if (isset($numero_destruido)) {
          echo "<p>isset: La variable \$numero_destruido existe</p>";
      } else {
          echo "<p>isset: La variable \$numero_destruido no existe</p>";
      }

      if (empty($numero_destruido)) {
          echo "<p>empty: La variable \$numero_destruido está vacía o no existe</p>";
      } else {
          echo "<p>empty: La variable \$numero_destruido NO está vacía</p>";
      }

      # Ex 4
      $a = 1;
      $b = -3;
      $c = 2;
    
      echo "<h2>Resolviendo la ecuación: {$a}x² + {$b}x + {$c} = 0</h2>";
      $discriminate = $b**2 - 4*$a*$c; 

      if ($discriminate > 0) {
          $x1 = (-$b + sqrt($discriminate)) / (2*$a);
          $x2 = (-$b - sqrt($discriminate)) / (2*$a);
          echo "<p>Dos soluciones reales: x1 = $x1, x2 = $x2</p>";
      } else if ($discriminate == 0) {
          $x = -$b / (2*$a);
          echo "<p>Una única solución real: x = $x</p>";
      } else {
          echo "<p>No hay soluciones reales</p>";
      }

      # Ex 5
      echo "<h2>Numeros Pares</h2>";
      for ($i = 1; $i <= 1000; $i++){
        if ($i % 2 == 0){ 
          echo "$i ";
        }
      }
      
      # Ex 6
      echo "<h2>Numeros Primos</h2>";
      for ($i = 2; $i <= 1000; $i++) {
        $esPrimo = true;
        
        for ($j = 2; $j <= sqrt($i); $j++) {
          if ($i % $j == 0) {
            $esPrimo = false;
            break;
          }
        }
  
        if ($esPrimo) {
          echo "$i ";
        }
      }

      # Ex 7
      echo "<h2>Mulpiplicacion Sucesivas</h2>";
      $num1 = 4;
      $num2 = 3;
      $result = 0;

      for ($i = 1; $i <= $num2; $i++) {
          $result += $num1;
      }

      echo "<p>$num1 x $num2 = $result</p>";
      
      # Ex 8
      echo "<h2>Tablas de multiplicar del 1 al 10</h2>";
      echo "<table border='1' cellpadding='5' cellspacing='0'>";
      echo "<thead data-theme='light'><tr><th></th>";
      for ($i = 1; $i <= 10; $i++) {
          echo "<th>$i</th>";
      }
      echo "</tr></thead>";
      echo "<tbody>";
      for ($i = 1; $i <= 10; $i++) {
          echo "<tr>";
          echo "<th data-theme=\"light\">$i</th>";

          for ($j = 1; $j <= 10; $j++) {
              $resultat = $i * $j;
              echo "<td>$resultat</td>";
          }
          echo "</tr>";
      }
      echo "</tbody>";
      echo "</table>"; 
      
    ?>
  </main>
</body>
</html>