<?php
  include_once './conn.php';
  $korisnik = $_SESSION['kor_ime'];

  if(isset($_POST["submit"])){
    
    $imeNastavnika = pg_escape_string( $_POST['ime_nastavnika']);
    $prezimeNastavnika = pg_escape_string( $_POST['prezime_nastavnika']);
    $emailNastavnika = pg_escape_string( $_POST['email_nastavnika']);
    
    $query = "INSERT INTO nastavnik (ime, prezime, email) VALUES ('$imeNastavnika', '$prezimeNastavnika', '$emailNastavnika')";
    $rezultat = pg_query($dbconn, $query);
  }

  if(isset($_POST["delete"])){
    $idNastavnika = $_POST["delete"];
    $query = "DELETE FROM nastavnik WHERE id_nastavnika = '$idNastavnika' ";
    $rezultat = pg_query($dbconn, $query);
  }

  if(isset($_POST["update"])){

    $idNastavnika = $_POST["update"];
    $imeNastavnika = pg_escape_string( $_POST['ime_nastavnika']);
    $prezimeNastavnika = pg_escape_string( $_POST['prezime_nastavnika']);
    $emailNastavnika = pg_escape_string( $_POST['email_nastavnika']);

    $query = "UPDATE nastavnik SET ime = '$imeNastavnika', prezime = '$prezimeNastavnika', email = '$emailNastavnika' WHERE id_nastavnika = '$idNastavnika'";
    $rezultat = pg_query($dbconn, $query);


  }


  $rezultatNastavnika = pg_query('SELECT * FROM nastavnik');

  $nastavnici = pg_fetch_all($rezultatNastavnika);
 
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
    <ul>
      <li><a href="./index.php">Raspored</a></li>
      <li><a href="./subject.php">Predmeti</a></li>
      <li><a class="active"  href="./professor.php">Profesori</a></li>
      <li><a href="./room.php">Dvorane</a></li>
      <li><a href="./building.php">Zgrade</a></li>
      <li><a name="logout" href="./login.php">Odjava</a></li>
      <div class="active-user">
        <p>Prijavljeni ste kao: <?php {echo $korisnik;} ?></p>
      </div>
    </ul>

    <div class="main-container">
      <div class="filter-raspored">
        <form action="./new_professor.php">
          <button class="main-btn">Novi profesor</button>
        </form>
      </div>
    </div>
    <div class="subject-cards">
      <?php
            foreach( $nastavnici as $nastavnik) {                     
      ?>
      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn2.iconfinder.com/data/icons/education-people/512/22-512.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title"><?php {echo $nastavnik['ime']." ".$nastavnik['prezime'];} ?></h2>
        </div>

        <div class="info-box__subheader">
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                class="info-box__subheader-img"
                src="https://cdn.iconscout.com/icon/free/png-256/email-1818372-1541480.png"
                alt="country-image"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">EMAIL</span></b>
            <span class="info-box__subheader-box-text">
            <?php {echo $nastavnik['email'];} ?>
            </span>
          </div>
        </div>
        <b>
          <form method="POST" action="./new_professor.php">
            <button value="<?php {echo $nastavnik['id_nastavnika'];} ?>" class="btn-crud" type="submit" name="update">Uredi</button>
          </form>
        
          <form  method="POST" action="./professor.php">
            <button value="<?php {echo $nastavnik['id_nastavnika'];} ?>" class="btn-crud" type="submit" name="delete">Izbriši</button>
          </form>
        </b>
      </div>
      <?php 
        }; 
      ?>
    </div>
    <script src="script.js"></script>
  </body>
</html>
