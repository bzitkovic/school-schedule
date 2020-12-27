<?php
  include_once './conn.php';

  if(isset($_POST["submit"])){
    
    $imeNastavnika = pg_escape_string( $_POST['ime_nastavnika']);
    $prezimeNastavnika = pg_escape_string( $_POST['prezime_nastavnika']);
    $emailNastavnika = pg_escape_string( $_POST['email_nastavnika']);
    
    $query = "INSERT INTO nastavnik (ime, prezime, email) VALUES ('$imeNastavnika', '$prezimeNastavnika', '$emailNastavnika')";
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
          <div class="info-box__footer">
            <a
              href="mailto:<?php {echo $nastavnik['email'];} ?>"
              target="_blank"
              class="info-box__btn-join"
              >Pošalji email</a
            >
          </div>
        </b>
      </div>
      <?php 
        }; 
      ?>
    </div>
    <script src="script.js"></script>
  </body>
</html>
