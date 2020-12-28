<?php
  include_once './conn.php';

  $rezultatPredmeta = pg_query('SELECT * FROM predmet');
  $rezultatRasporeda = pg_query('SELECT * FROM raspored');

  $predmeti =  pg_fetch_all($rezultatPredmeta);
  $rasporedi =  pg_fetch_all($rezultatRasporeda);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Raspored</title>
  </head>
  <body>
    <div class="login-container">
      <h1>Dodaj novi predmet</h1>
      <form method="POST" action="./index.php">
        <div class="form-control">
          <select id="predmet" name="predmet">
          <?php
              foreach( $predmeti as $predmet) 
                echo "<option value=\"{$predmet['id_predmeta']}\">{$predmet['naziv']}</option>";
          ?>
          </select>
        </div>

        <div class="form-control">
          <select id="raspored" name="raspored">
          <?php
              foreach( $rasporedi as $raspored) 
                echo "<option value=\"{$raspored['id_rasporeda']}\">{$raspored['naziv']}</option>";
          ?>
          </select>
        </div>

        <button name="submit" class="btn">Dodaj predmet</button>

        <p class="text">
          Povratak na raspored? <a href="./index.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
