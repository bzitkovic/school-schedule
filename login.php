<?php
  include_once './conn.php';
  $pogreska = "";

  if(isset($_POST["submit"])){
    
    $korisnickoIme = pg_escape_string( $_POST['kor_ime']);
    $lozinka = pg_escape_string( $_POST['lozinka']);
    
    $query = "SELECT * FROM korisnik WHERE korisnicko_ime = '$korisnickoIme' AND lozinka = '$lozinka' AND CAST(vrijedece_vrijeme AS text) LIKE '%infinity%'";
    $rezultat = pg_query($dbconn, $query);
    
    if(pg_num_rows($rezultat) == 1) {
      header('Location: ./index.php');
    } else {
     $pogreska = "Krivi korisnički podaci!";
    }

    $_SESSION['kor_ime'] = $korisnickoIme;
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
      <h1>Prijavi se</h1>
      <form method="POST" action="./login.php">
        <div class="form-control">
          <input name="kor_ime" type="text" required />
          <label>Korisničko ime</label>
        </div>

        <div class="form-control">
          <input name="lozinka" type="password" required />
          <label>Lozinka</label>
        </div>

        <button name="submit" class="btn">Prijava</button>

        <p class="error-text" class="text">
          <?php {echo $pogreska;} ?>
        </p>

        <p class="text">
          Nemate račun? <a href="./register.php">Registracija</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
