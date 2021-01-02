<?php
  include_once './conn.php';

  if(isset($_POST["update"])){

    $idDvorane = $_POST["update"];

    $query = "SELECT * from dvorana WHERE id_dvorane = '$idDvorane' ";
    $rezultatDvorane = pg_query($dbconn, $query);
    $dvorane = pg_fetch_all($rezultatDvorane);

  }

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
          <input name="naziv_dvorane" type="text" value="<?php 
          if(isset($dvorane))
            {echo $dvorane[0]['naziv'];} 
          ?>"  required />
          <label>Naziv dvorane</label>
        </div>

        <div class="form-control">
          <input name="broj_mjesta" type="number" min="1" max="500" value="<?php 
          if(isset($dvorane))
            {echo $dvorane[0]['broj_mjesta'];} 
          ?>" required />
          <label>Broj mjesta</label>
        </div>

        <label for="dvorana">Zgrada</label>
        <div class="form-control">
          <select id="zgrada" name="zgrada">
              <?php
                  foreach( $zgrade as $zgrada) 
                    echo "<option value=\"{$zgrada['id_zgrade']}\">{$zgrada['naziv']}</option>";
              ?>
            </select>
          </div>

          <?php if(isset($dvorane)){ ?>
          <button value="<?php {echo $dvorane[0]['id_dvorane'];} ?>" name="update" class="btn">Uredi dvoranu</button>
          <?php } else { ?>
            <button name="submit" class="btn">Kreiraj dvoranu</button>
          <?php } ?>

        <p class="text">
          Povratak na popis dvorana? <a href="./room.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
