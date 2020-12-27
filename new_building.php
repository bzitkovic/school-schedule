<?php

  include_once './conn.php';

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
          <input name="naziv_zgrade" type="text" required />
          <label>Naziv zgrade</label>
        </div>

        <div class="form-control">
          <input name="adresa_zgrade" type="text" required />
          <label>Adresa zgrade</label>
        </div>

        <button name="submit" type="submit" class="btn">Stvori zgradu</button>

        <p class="text">
          Povratak na popis zgrada? <a href="./building.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
