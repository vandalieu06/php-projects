<!DOCTYPE html>
<html lang="en" data-theme="lightj" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ACTIVIDAD 2 FUNCIONES EN PHP - by JHONNY CLAURE</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.fuchsia.min.css"
  >
</head>
<body>
  <header>

  </header>

  <main class="container" >
    <h2>Funciones en PHP</h2>
    <div class="act01">
      <h3>Excerici 1</h3>
      <?php
        function createTable($rows, $columns){
          $table = "<table cellpadding='5' cellspacing='0'>";
          $theader = "<thead><tr>";
          for ($i = 1; $i <= $columns; $i++) {
            $theader .= "<th style='text-align: center;'>$i</th>";
            if ($i == $columns){
              $theader .= "</tr></thead>";
            }
          }
          $table .= $theader;
          $tbody = "<tbody>";
          for ($i = 0; $i < $rows; $i++){
            $tbody .=  "<tr>";
            for ($j = 1; $j <= $columns; $j++){
              $tbody .= "<th style='text-align: center;'>$j</th>";
            }
            $tbody .= "</tr>";
          }
          $tbody .= "</tbody>";
          $table .= $tbody;
          
          $table .= "</table>";
          return $table;
        }

        $result = createTable(2, 10); 
        echo "$result";
      ?>
    </div>
    <div class="act02" style="margin-top: 40px;">
      <h3>Excerici 2</h3>
      <div class="grid">
        <div class="questions">
          <h5>Preguntas</h3>
          <p>Cuantas palabras compone "Hello World!"?</p>
          <p>Cuantas palabras compone "Hello_World!"?</p>
          <p>Cuantas palabras compone "Hello_World!"?</p>
        </div>
        <div class="answers">
          <h5>Respuestas</h3>
          <?php 
            $count = str_word_count("Hello world!");
            $count2 = str_word_count("Hello_world!");
            $count3 = str_word_count("Hello_world!", 0, "_");
            echo "<p>El numero de palabras es de <b>{$count}</b></p>";
            echo "<p>El numero de palabras es de <b>{$count2}</b></p>";
            echo "<p>El numero de palabras es de <b>{$count3}</b></p>";
          ?>
        </div>
        <div class="method">
          <h5>Metodo</h5>
          <p>str_word_count("Hello world!");</p>
          <p>str_word_count("Hello_world!");</p>
          <p>str_word_count("Hello_world!", 0, "_");</p>
          
        </div>
      </div>
      
    </div>
    <div class="act03" style="margin-top: 40px;">
      <h3>Excercici 3</h3> 
      <div class="grid">
        <div>
          <h5>Pregunta</h5>
          <p>El numero total de cambios a hacer es de: </p>
          <p>El numero total de cambios a hacer es de: </p>
        </div>
        <div>
          <h5>Resultado</h5>
          <?php
            echo "<p>".levenshtein("Hello World","ello Wor  ld")."</p>";
            echo "<p>".levenshtein("Hello World","ello Wor  ld", 10, 20, 30)."</p>";
          ?> 
        </div>
        <div>
          <h5>Metodo</h5>
          <p>levenshtein("Hello World","ello Wor  ld")</p>
          <p>levenshtein("Hello World","ello Wor  ld", 10, 20, 30)</p>
        </div>
      </div>
    </div>
    <div class="act04" style="margin-top: 40px;">
      <h3>Excercici 4</h3> 
      <?php
        for($i = 0; $i <=10; $i++){
          $color = $i % 2 == 0 && $i != 0? 'green' : 'red';
          echo "<span style='color: $color; margin-inline: 20px;'>{$i}</span>";
        }
      ?>
    </div>
    <div class="act05" style="margin-top: 40px;">
      <h3>Excercici 5</h3>
      <div class="grid">
        <div>
          <h5>Preguntas</h5>
          <p>"Hello world!" == "Hello world!"</p>
          <p>"Hello world!" == "Hello_world!"</p>
          <p>"Hello_world!" == "Hello world!"</p>
        </div> 
        <div>
          <h5>Resultado</h5>
          <?php
            $text1 = strcmp("Hello world!","Hello world!");
            $text2 = strcmp("Hello world!","Hello_world!");
            $text3 = strcmp("Hello_world!","Hello world!");
            echo "<p>$text1</p>";
            echo "<p>$text2</p>";
            echo "<p>$text3</p>";
          ?> 
        </div>
      </div>
    </div>
    <div class="act06">
      <h3>Exercici 6</h3>
      <div>
        <?php
          function mayusculas(&$valor){
            $valor = strtoupper($valor);
          }
          $nombre = 'Gorka';
          echo "<p>$nombre</p>";
          mayusculas($nombre);
          echo "<p>$nombre</p>";
        ?>
      </div>
      </div>
    </div>
    <div class="act07">
      <h3>Exercici 7</h3>
      <!--https://www.geeksforgeeks.org/php/php-highlight_string-function/-->
      <?php 
        $codigo_a_resaltar = <<<CODE
          function funcioMultiplesReturns(\$v1,\$v2,\$v3){
              \$v1="variable1";
              \$v2="variable2";
              \$v3="variable3";
              return array(\$v1,\$v2,\$v3);
          }
          CODE;
        $codigo_html_resaltado = highlight_string($codigo_a_resaltar, true);
        echo $codigo_html_resaltado;
      ?>
      <p>Es una funcion que tiene tres parametros, que luego dentro de la función se asigna los valores tipo string a cada uno. Por ultimo retorna un metodo llamado array() al cual se le asigna los parametro para que los retorne como un Array</p>
      <div></div>
    </div>
    <div class="act08">
      <h3>Exercici 8</h3>
      <div>
        <?php
          function comprova_email(string $email): bool {
            $email_corregido = strtolower($email);
            //\s+ escoge todos los espacio en blanco
            $email_corregido = preg_replace('/\s+/', '', $email_corregido);
            $tiene_arroba = str_contains($email_corregido, '@');
            $mida = strlen($email_corregido); 
            return $mida < 75 && $tiene_arroba ? TRUE : FALSE; 
          }

          $email1 = "CORREU.de.Prova@exemple.cat "; 
          $email2 = "sajdkajsdpohduchdnlksdsdsdsdsdsssssssssssjasjsjsjsjsjkljakljdcnaklsnk@test.com"; 
          $email3 = "sensearrobaexemple.com";

          $correcto = "<span style='color: green;'>VALIDO</span>";
          $invalido = "<span style='color: red;'>INVALIDO</span>";

          echo "<p>Email 1 ('$email1'): ".(comprova_email($email1) ? $correcto : $invalido)."</p>";
          echo "<p>Email 2 ('$email2'): " . (comprova_email($email2) ? $correcto : $invalido)."</p>";
          echo "<p>Email 3 ('$email3'): " . (comprova_email($email3) ? $correcto : $invalido)."</p>";
        ?>
      </div>
    </div>
    <div class="act09">
      <h3>Exercici 9</h3>
      <div>
        <?php
          function comprova_email2(string $email): bool {
            $email_corregido = strtolower($email);
            //\s+ escoge todos los espacio en blanco
            $email_corregido = preg_replace('/\s+/', '', $email_corregido);
            $tiene_arroba = str_contains($email_corregido, '@');
            $mida = strlen($email_corregido); 
            // Obtenemos el dominio, example@exemple.com. Cogemos la posicion despues del 
            $dominio = substr($email_corregido, strpos($email_corregido, '@') + 1);
        
            return $mida < 75 && $tiene_arroba && checkdnsrr($dominio,"A") ? TRUE : FALSE; 
          }

          $email1 = "CORREU.de.Prova@exeasple.cat "; 
          $email2 = "claurejhonny188@gmail.com";

          $correcto = "<span style='color: green;'>VALIDO</span>";
          $invalido = "<span style='color: red;'>INVALIDO</span>";

          echo "<p>Email 1 ('$email1'): ".(comprova_email2($email1) ? $correcto : $invalido)."</p>";
          echo "<p>Email 2 ('$email2'): " . (comprova_email2($email2) ? $correcto : $invalido)."</p>";
        ?>
      </div>
    </div>
    <div class="act10">
      <h3>Exercici 10</h3>
      <div>
        <?php
          include 'sample.php'
        ?>
      </div>
    </div>
    <div class="act11">
      <h3>Exercici 11</h3>
      <div>
        <?php
          $timestamp_actual = time();
          echo "<p>Timestamp Actual: <strong>{$timestamp_actual}</strong></p>";
          $format_final = date("l, d F Y G:i", $timestamp_actual); 
          echo "<p >Format utilitzat: <b>{$format_final}</b></p>";
        ?>
      </div>
    </div>
  </main>

</body>
</html>
