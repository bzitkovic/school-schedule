<?php

  include_once './conn.php';

  if(isset($_POST["update"])){

    $idZgrade = $_POST["update"];

    $query = "SELECT * from zgrada WHERE id_zgrade = '$idZgrade' ";
    $rezultatZgrade = pg_query($dbconn, $query);
    $zgrade = pg_fetch_all($rezultatZgrade);

  }


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
      <h1>Stvori novu zgradu</h1>
      <form  method="POST" action="./building.php">
        <div class="form-control">
          <input name="naziv_zgrade" type="text" value="<?php 
          if(isset($zgrade))
            {echo $zgrade[0]['naziv'];} 
          ?>" required />
          <label>Naziv zgrade</label>
        </div>

        <div class="form-control">
          <input name="adresa_zgrade" type="text" value="<?php 
          if(isset($zgrade))
            {echo $zgrade[0]['adresa'];} 
          ?>" required />
          <label>Adresa zgrade</label>
        </div>

          <?php if(isset($zgrade)){ ?>
            <button value="<?php {echo $zgrade[0]['id_zgrade'];} ?>" name="update" class="btn">Uredi zgradu</button>
          <?php } else { ?>
            <button name="submit" class="btn">Kreiraj zgradu</button>
          <?php } ?>

        <p class="text">
          Povratak na popis zgrada? <a href="./building.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
