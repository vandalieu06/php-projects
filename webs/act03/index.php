<!DOCTYPE html>
<html lang="en" data-theme="lightj">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVIDAD 2 FUNCIONES EN PHP - by JHONNY CLAURE</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css">
  <style>
    h3 {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <header>

  </header>

  <main class="container">
    <h2>Arrays en PHP</h2>
    <?php

    function numerosPrimers($num1, $num2)
    {
      $primers = [];
      for ($i = $num1; $i <= $num2; $i++) {
        if ($i < 2) continue;
        $esPrimer = true;
        for ($j = 2; $j <= sqrt($i); $j++) {
          if ($i % $j == 0) {
            $esPrimer = false;
            break;
          }
        }
        if ($esPrimer) $primers[] = $i;
      }
      return $primers;
    }

    echo "<h3>Exercici 1</h3>";
    $resultat = numerosPrimers(1, 50);
    echo "<span>";
    for ($i = 0; $i < count($resultat); $i++) {
      if ($i == count($resultat) - 1) {
        echo $resultat[$i];
        echo "</span>";
        break;
      }
      echo $resultat[$i] . " - ";
    }

    echo "<h3>Exercici 2</h3>";
    $frase = "Aquesta és una frase qualsevol per a l'exemple.";
    $paraules = explode(" ", $frase);
    echo "<span>";
    foreach ($paraules as $key => $paraula) {
      if ($key == count($paraules) - 1) {
        echo $paraula;
        echo "</span>";
        echo "<p><b>Total de palabras: </b>" . count($paraules) . "</p>";
        break;
      }
      echo $paraula . " - ";
    }

    function operacions($a, $b)
    {
      return [
        "suma" => $a + $b,
        "resta" => $a - $b,
        "multiplicacio" => $a * $b,
        "divisio" => $b != 0 ? $a / $b : "Error: No es pot dividir per 0"
      ];
    }

    echo "<h3>Exercici 3</h3>";
    $resultats = operacions(10, 2);
    echo "<pre>";
    print_r($resultats);
    echo "</pre>";

    $colors = [
      "Vermell" => "RGB(255, 0, 0)",
      "Verd" => "RGB(0, 255, 0)",
      "Blau" => "RGB(0, 0, 255)",
      "Groc" => "RGB(255, 255, 0)",
      "Rosa" => "RGB(255, 192, 203)"
    ];

    function recorre_arrayA($arr)
    {
      foreach ($arr as $nom => $valor) {
        echo "<li>$nom => $valor</li>";
      }
    }

    function recorre_arrayB($arr)
    {
      reset($arr);
      do {
        echo "<li>" . key($arr) . " => " . current($arr) . "</li>";
      } while (next($arr));
    }

    echo "<h3>Exercici 4</h3>";
    echo "<b>Recorregut amb foreach:</b><br>";
    recorre_arrayA($colors);

    echo "<br><b>Recorregut amb do-while:</b><br>";
    recorre_arrayB($colors);

    function recorrer_invers($arr)
    {
      end($arr);
      do {
        echo "<li>" . key($arr) . " => " . current($arr) . "</li>";
      } while (prev($arr));
    }

    echo "<h3>Exercici 5</h3>";
    recorrer_invers($colors);

    echo "<h3>Exercici 6</h3>";
    foreach ($_SERVER as $key => $value) {
      if (gettype($value) == "array") continue;
      echo "<b>$key</b> => $value<br>";
    }

    $notes = [
      "Anna" => 9,
      "Pau" => 5,
      "Marta" => 7,
      "Jordi" => 8,
      "Clara" => 6
    ];

    echo "<h3>Exercici 7</h3>";

    $proves = [
      "asort" => $notes,
      "arsort" => $notes,
      "ksort" => $notes,
      "krsort" => $notes,
      "shuffle" => $notes
    ];

    echo "<pre>";
    asort($proves["asort"]);
    echo "asort:\n";
    print_r($proves["asort"]);

    arsort($proves["arsort"]);
    echo "\narsort:\n";
    print_r($proves["arsort"]);

    ksort($proves["ksort"]);
    echo "\nksort:\n";
    print_r($proves["ksort"]);

    krsort($proves["krsort"]);
    echo "\nkrsort:\n";
    print_r($proves["krsort"]);

    shuffle($proves["shuffle"]);
    echo "\nshuffle:\n";
    print_r($proves["shuffle"]);
    echo "</pre>";

    function buscaElementArray($arr, $element)
    {
      $posicio = array_search($element, $arr);
      return $posicio !== false ? $posicio : -1;
    }

    echo "<h3>Exercici 8</h3>";
    $animals = ["gos", "gat", "ocell", "peix", "ratolí"];
    $busca = "ocell";
    $resultat = buscaElementArray($animals, $busca);
    echo $resultat !== -1
      ? "L’element '$busca' es troba a la posició $resultat."
      : "L’element '$busca' no s’ha trobat.";

    function sumaArray($arr)
    {
      return array_sum($arr);
    }

    function getMajor($arr)
    {
      return max($arr);
    }

    function getPosMajor($arr)
    {
      return array_search(max($arr), $arr);
    }

    echo "<h3>Exercici 9</h3>";
    $nums = [5, 12, 8, 23, 9];
    echo "Suma: " . sumaArray($nums) . "<br>";
    echo "Major: " . getMajor($nums) . "<br>";
    echo "Posició major: " . getPosMajor($nums) . "<br>";

    ?>
    <div style="padding-block: 60px 40px; text-align: center;">
      <b>
        By Jhonny Claure
      </b>
    </div>


  </main>
</body>

</html>