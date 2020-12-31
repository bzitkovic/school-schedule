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
      <h1>Stvori novi raspored</h1>
      <form method="POST" action="./index.php">
        <div class="form-control">
          <input name="naziv_rasporeda" type="text" required />
          <label>Naziv rasporeda</label>
        </div>
      
          <button name="submit_schedule" class="btn">Stvori raspored</button>
              
        <p class="text">
          Povratak na raspored? <a href="./index.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
