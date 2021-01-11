<?php

  include_once './conn.php';
  error_reporting(E_ERROR | E_PARSE);
  $pogreska = "";

  if(isset($_POST["submit_register"])) {

    $korisnickoIme = pg_escape_string( $_POST['kor_ime']);
    $email = pg_escape_string( $_POST['email']);
    $lozinka = pg_escape_string( $_POST['lozinka']);

    $query = "INSERT INTO korisnik (korisnicko_ime, lozinka, email) VALUES ('$korisnickoIme', '$lozinka', '$email')";
    $rezultat = pg_query($dbconn, $query);
    
    if($rezultat){
      header('Location: ./login.php');
    } else  {
      $error = pg_last_error($dbconn);
      $error = explode('!', $error);
      $error = explode(':', $error[0]);
      
      $pogreska = $error[1]."!";
    }
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
      <h1>Registrirajte se</h1>
      <form method="POST" action="./register.php">
        <div class="form-control">
          <input name="kor_ime" type="text" required />
          <label>Korisničko ime</label>
        </div>

        <div class="form-control">
          <input name="email" type="text" required />
          <label>Email</label>
        </div>

        <div class="form-control">
          <input name="lozinka" type="password" required />
          <label>Lozinka</label>
        </div>

        <div class="form-control">
          <input type="password" required />
          <label>Ponovljena lozinka</label>
        </div>

        <p class="error-text" class="text">
          <?php {echo $pogreska;} ?>
        </p>

        <button name="submit_register" class="btn">Registracija</button>

        <p class="text">
          Natrag na prijavu?<a href="./login.php"> Prijava</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
