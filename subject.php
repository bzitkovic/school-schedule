<?php
  include_once './conn.php';
  $korisnik = $_SESSION['kor_ime'];

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

  if(isset($_POST["delete"])){
    $idPredmeta = $_POST["delete"];
    $query = "DELETE FROM predmet WHERE id_predmeta = '$idPredmeta' ";
    $rezultat = pg_query($dbconn, $query);
  }

  if(isset($_POST["update"])){

    $idPredmeta = $_POST["update"];
    $nazivPredmeta = pg_escape_string( $_POST['naziv_predmeta']);
    $brojEctsa = pg_escape_string( $_POST['broj_ectsa']);
    $idNastavnika = pg_escape_string( $_POST['nastavnik']);
    $idDvorane = pg_escape_string( $_POST['dvorana']);
    $dan = pg_escape_string( $_POST['dan']);
    $idVremena = $_SESSION['vrijeme'];
    $vrijemeOd = pg_escape_string( $_POST['vrijeme_od']);
    $vrijemeDo = pg_escape_string( $_POST['vrijeme_do']);
    $opisPredmeta = pg_escape_string( $_POST['opis_predmeta']);

    $query = "UPDATE predmet SET naziv = '$nazivPredmeta', ects = '$brojEctsa', opis = '$opisPredmeta' WHERE id_predmeta = '$idPredmeta' ";
    $rezultat = pg_query($dbconn, $query);
    

    $query2 = "UPDATE vrijeme v SET dan = '$dan', vrijeme_od = '$vrijemeOd', vrijeme_do = '$vrijemeDo' FROM traje t WHERE t.id_predmeta = '$idPredmeta' 
               AND t.id_vremena = '$idVremena' AND v.id_vremena = '$idVremena' ";
    $rezultat = pg_query($dbconn, $query2);

    $query3 = "UPDATE predaje p SET id_predmeta = '$idPredmeta', id_nastavnika = '$idNastavnika' WHERE p.id_predmeta = '$idPredmeta'";
    $rezultat = pg_query($dbconn, $query3);

    $query4 = "UPDATE se_izvodi si SET id_predmeta = '$idPredmeta', id_dvorane = '$idDvorane' WHERE si.id_predmeta = '$idPredmeta' ";
    $rezultat = pg_query($dbconn, $query4);


  }

  $rezultatPredmeta = pg_query(
    "SELECT
      p.id_predmeta,
      p.naziv,
      p.ects,
      p.opis
    FROM
      predmet p
      JOIN se_nalazi sn ON sn.id_predmeta = p.id_predmeta
      JOIN raspored r ON r.id_rasporeda = sn.id_rasporeda
      JOIN korisnik k ON k.id_korisnika = r.id_korisnika
      WHERE k.korisnicko_ime = '$korisnik' ");

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
      <li><a name="logout" href="./login.php">Odjava</a></li>
      <div class="active-user">
        <p>Prijavljeni ste kao: <?php {echo $korisnik;} ?></p>
      </div>
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
         
          <form method="POST" action="./new_subject.php">
            <button value="<?php {echo $predmet['id_predmeta'];} ?>" class="btn-crud" type="submit" name="update">Uredi</button>
          </form>
        
          <form  method="POST" action="./subject.php">
            <button value="<?php {echo $predmet['id_predmeta'];} ?>" class="btn-crud" type="submit" name="delete">Izbriši</button>
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
