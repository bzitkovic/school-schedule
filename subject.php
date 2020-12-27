<?php
  include_once './conn.php';

  if(isset($_POST["submit"])){
    
    $nazivPredmeta = pg_escape_string( $_POST['naziv_predmeta']);
    $brojEctsa = pg_escape_string( $_POST['broj_ectsa']);
    $idNastavnika = pg_escape_string( $_POST['nastavnik']);
    $idDvorane = pg_escape_string( $_POST['dvorana']);
    $dan = pg_escape_string( $_POST['dan']);
    $vrijemeOd = pg_escape_string( $_POST['vrijeme_od']);
    $vrijemeDo = pg_escape_string( $_POST['vrijeme_do']);
    $opisPredmeta = pg_escape_string( $_POST['opis_predmeta']);
    
    $query = "INSERT INTO predmet (naziv, ects, opis) VALUES ('$nazivPredmeta', '$brojEctsa', '$opisPredmeta') RETURNING id_predmeta AS id";
    $rezultat = pg_query($dbconn, $query);
    $idPredmeta = pg_fetch_row($rezultat);

    $query2 = "INSERT INTO vrijeme (dan, vrijeme_od, vrijeme_do) VALUES ('$dan', '$vrijemeOd', '$vrijemeDo') RETURNING id_vremena AS id";
    $rezultat = pg_query($dbconn, $query2);
    $idVremena = pg_fetch_row($rezultat);

   
    $idVremena = intval($idVremena[0]);
    $idPredmeta = intval($idPredmeta[0]);

    $query3 = "INSERT INTO traje (id_vremena, id_predmeta) VALUES ('$idVremena', '$idPredmeta')";
    $rezultat = pg_query($dbconn, $query3);

    $query4 = "INSERT INTO predaje (id_predmeta, id_nastavnika) VALUES ('$idPredmeta', '$idNastavnika')";
    $rezultat = pg_query($dbconn, $query4);

    $query5 = "INSERT INTO se_izvodi (id_predmeta, id_dvorane) VALUES ('$idPredmeta', '$idDvorane')";
    $rezultat = pg_query($dbconn, $query5);
   
  }

  $rezultatPredmeta = pg_query('SELECT * FROM predmet');

  $predmeti =  pg_fetch_all($rezultatPredmeta);
 

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
      <li><a class="active" href="./subject.php">Predmeti</a></li>
      <li><a href="./professor.php">Profesori</a></li>
      <li><a href="./room.php">Dvorane</a></li>
      <li><a href="./building.php">Zgrade</a></li>
    </ul>

    <div class="main-container">
      <div class="filter-raspored">
        <form action="./new_subject.php">
          <button class="main-btn">Novi predmet</button>
        </form>
      </div>
    </div>
    <div class="subject-cards">
      <?php
          foreach( $predmeti as $predmet) {                     
      ?>
      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.onlinewebfonts.com/svg/img_341860.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title"><?php {echo $predmet['naziv'];} ?></h2>
        </div>

        <div class="info-box__subheader">
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                class="info-box__subheader-img"
                src="https://static.thenounproject.com/png/2479138-200.png"
                alt="country-image"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">ECTS</span></b>
            <span class="info-box__subheader-box-text"><?php {echo $predmet['ects'];} ?></span>
          </div>
        </div>
        <p class="info-box__about">
          <b
            ><span class="info-box__subheader-box-text"
              >Opis predmeta <br /><br />
              <?php {echo $predmet['opis'];} ?>
            </span></b
          >
        </p>
        <b>
          <div class="info-box__footer">
            <a
              href="#"
              class="info-box__btn-join"
              >Službena stranica</a
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
