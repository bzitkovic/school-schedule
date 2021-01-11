<?php
  include_once './conn.php';
  $korisnik = $_SESSION['kor_ime'];

  if(isset($_POST["submit"])){
    
    $nazivZgrade = pg_escape_string( $_POST['naziv_zgrade']);
    $adresaZgrade = pg_escape_string( $_POST['adresa_zgrade']);
    
    $query = "INSERT INTO zgrada (naziv, adresa) VALUES ('$nazivZgrade', '$adresaZgrade')";
    $rezultat = pg_query($dbconn, $query);
  }

  if(isset($_POST["delete"])){
    $idZgrade = $_POST["delete"];
    $query = "DELETE FROM zgrada WHERE id_zgrade = '$idZgrade' ";
    $rezultat = pg_query($dbconn, $query);
  }

  if(isset($_POST["update"])){

    $idZgrade = $_POST["update"];
    $nazivZgrade = pg_escape_string( $_POST['naziv_zgrade']);
    $adresaZgrade = pg_escape_string( $_POST['adresa_zgrade']);
    
    $query = "UPDATE zgrada SET naziv = '$nazivZgrade', adresa = '$adresaZgrade' WHERE id_zgrade = '$idZgrade'";
    $rezultat = pg_query($dbconn, $query);
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
    <ul>
      <li><a href="./index.php">Raspored</a></li>
      <li><a href="./subject.php">Predmeti</a></li>
      <li><a href="./professor.php">Profesori</a></li>
      <li><a href="./room.php">Dvorane</a></li>
      <li><a class="active" href="./building.php">Zgrade</a></li>
      <li><a name="logout" href="./login.php">Odjava</a></li>
      <div class="active-user">
        <p>Prijavljeni ste kao: <?php {echo $korisnik;} ?></p>
      </div>
    </ul>

    <div class="main-container">
      <div class="filter-raspored">
        <form action="./new_building.php">
          <button class="main-btn">Nova zgrada</button>
        </form>
      </div>
    </div>
    <div class="subject-cards">
      <?php
          foreach( $zgrade as $zgrada) {                     
      ?>
      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.iconscout.com/icon/free/png-256/building-1741335-1484597.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title"><?php {echo $zgrada['naziv'];} ?></h2>
        </div>

        <div class="info-box__subheader">
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                class="info-box__subheader-img"
                src="https://cdn.onlinewebfonts.com/svg/img_372594.png"
                alt="country-image"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Adresa</span></b>
            <span class="info-box__subheader-box-text">
            <?php {echo $zgrada['adresa'];} ?>
            </span>
          </div>
        </div>
          <form method="POST" action="./new_building.php">
            <button value="<?php {echo $zgrada['id_zgrade'];} ?>" class="btn-crud" type="submit" name="update">Uredi</button>
          </form>
        
          <form  method="POST" action="./building.php">
            <button value="<?php {echo $zgrada['id_zgrade'];} ?>" class="btn-crud" type="submit" name="delete">Izbriši</button>
          </form>
      </div>
      <?php 
        }; 
      ?>
    </div>
    <script src="script.js"></script>
  </body>
</html>
