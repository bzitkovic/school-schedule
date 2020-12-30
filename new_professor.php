<?php
  include_once './conn.php';

  if(isset($_POST["update"])){

    $idNastavnika = $_POST["update"];

    $query = "SELECT * from nastavnik WHERE id_nastavnika = '$idNastavnika' ";
    $rezultatNastavnika = pg_query($dbconn, $query);
    $nastavnici = pg_fetch_all($rezultatNastavnika);

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
      <h1>Stvori novog nastavnika</h1>
      <form method="POST" action="./professor.php">
        <div class="form-control">
          <input name="ime_nastavnika" type="text" value="<?php 
          if(isset($nastavnici))
            {echo $nastavnici[0]['ime'];} 
          ?>"  required />
          <label>Ime profesora</label>
        </div>

        <div class="form-control">
          <input name="prezime_nastavnika" type="text" value="<?php 
          if(isset($nastavnici))
            {echo $nastavnici[0]['prezime'];} 
          ?>"  required />
          <label>Prezime profesora</label>
        </div>

        <div class="form-control">
          <input name="email_nastavnika" type="text" value="<?php 
          if(isset($nastavnici))
            {echo $nastavnici[0]['email'];} 
          ?>"  required />
          <label>Email profesora</label>
        </div>

        <?php if(isset($nastavnici)){ ?>
          <button value="<?php {echo $nastavnici[0]['id_nastavnika'];} ?>" name="update" class="btn">Uredi nastavnika</button>
        <?php } else { ?>
          <button name="submit" class="btn">Kreiraj nastavnika</button>
        <?php } ?>

        <p class="text">
          Povratak na popis profesora? <a href="./professor.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
