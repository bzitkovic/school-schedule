<?php
  include_once './conn.php';

  if(isset($_POST["submit"])){
    
    $nazivDvorane = pg_escape_string( $_POST['naziv_dvorane']);
    $brojMjesta = pg_escape_string( $_POST['broj_mjesta']);
    $idZgrade = pg_escape_string( $_POST['zgrada']);
    
    $query = "INSERT INTO dvorana (naziv, broj_mjesta, id_zgrade) VALUES ('$nazivDvorane', '$brojMjesta', '$idZgrade') RETURNING id_dvorane AS id";
    $rezultat = pg_query($dbconn, $query);
    //print_r(pg_fetch_row($rezultat));
  }

  $rezultatDvorana = pg_query('SELECT * FROM dvorana');

  $dvorane =  pg_fetch_all($rezultatDvorana);
 
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
      <li><a class="active" href="./room.php">Dvorane</a></li>
      <li><a href="./building.php">Zgrade</a></li>
    </ul>

    <div class="main-container">
      <div class="filter-raspored">
        <form action="./new_room.php">
          <button class="main-btn">Nova dvorana</button>
        </form>
      </div>
    </div>
    <div class="subject-cards">
      <?php
          foreach( $dvorane as $dvorana) {                     
      ?>
      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://images.vexels.com/media/users/3/157343/isolated/preview/fa058a304813b6d204d29253f5cb90d4-flat-home-house-icon-by-vexels.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title"><?php {echo $dvorana['naziv'];} ?></h2>
        </div>

        <div class="info-box__subheader">
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                class="info-box__subheader-img"
                src="https://image.flaticon.com/icons/png/512/83/83510.png"
                alt="country-image"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Broj mjesta</span></b>
            <span class="info-box__subheader-box-text"> <?php {echo $dvorana['broj_mjesta'];} ?> </span>
          </div>
        </div>
      </div>
      <?php 
        }; 
      ?>
    </div>
    <script src="script.js"></script>
  </body>
</html>
