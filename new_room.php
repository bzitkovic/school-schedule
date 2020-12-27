<?php
  include_once './conn.php';

  $rezultatZgrada = pg_query('SELECT * FROM zgrada');

  $zgrade =  pg_fetch_all($rezultatZgrada);
  

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
      <h1>Stvori novi dvoranu</h1>
      <form  method="POST" action="./room.php">
        <div class="form-control">
          <input name="naziv_dvorane" type="text" required />
          <label>Naziv dvorane</label>
        </div>

        <div class="form-control">
          <input name="broj_mjesta" type="number" min="1" max="500" required />
          <label>Broj mjesta</label>
        </div>

        <label for="dvorana">Zgrada</label>
        <div class="form-control">
          <select id="zgrada" name="zgrada">
              <?php
                  foreach( $zgrade as $zgrada) 
                    echo "<option value=\"{$zgrada['ID_zgrade']}\">{$zgrada['naziv']}</option>";
              ?>
            </select>
          </div>

        <button name="submit" type="submit" class="btn">Stvori dvoranu</button>

        <p class="text">
          Povratak na popis dvorana? <a href="./room.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
