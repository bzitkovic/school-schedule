<?php
  include_once './conn.php';
  $korisnik = $_SESSION['kor_ime'];
  $pogreska = "";
  error_reporting(E_ERROR | E_PARSE);

  if(isset($_POST["submit"])){
    
    $idPredmeta = pg_escape_string( $_POST['predmet']);
    $idRasporeda = pg_escape_string( $_POST['raspored']);
    
    $query = "INSERT INTO se_nalazi (id_predmeta, id_rasporeda) VALUES ('$idPredmeta', '$idRasporeda')";
    $rezultat = pg_query($dbconn, $query);
    
    if(!$rezultat){
     
      $pogreska = "Predmet već postoji na rasporedu!";
    }
  }

  if(isset($_POST["submit_schedule"])){
    
    $nazivRasporeda = pg_escape_string( $_POST['naziv_rasporeda']);
    $query = "SELECT * FROM korisnik k WHERE k.korisnicko_ime = '$korisnik'";
    $rezultatKorisnika = pg_query($dbconn, $query);
    $korisnikId =  pg_fetch_all($rezultatKorisnika)[0]['id_korisnika'];
    
    $query2 = "INSERT INTO raspored (naziv, id_korisnika) VALUES ('$nazivRasporeda', '$korisnikId')";
    $rezultat = pg_query($dbconn, $query2);
    
  }

  if(isset($_POST["delete"])){
    $idPredmeta = $_POST["delete"];
    $query = "DELETE FROM se_nalazi WHERE id_predmeta = '$idPredmeta' ";
    $rezultat = pg_query($dbconn, $query);
  }

  if(isset($_POST["delete_acc"])){
    $query = "SELECT * FROM korisnik k WHERE k.korisnicko_ime = '$korisnik'";
    $rezultatKorisnika = pg_query($dbconn, $query);
    $korisnikId =  pg_fetch_all($rezultatKorisnika)[0]['id_korisnika'];
    $rezultat = pg_query_params($dbconn, 'call izbrisi_kor_racun($1)',array($korisnikId));
    header('Location: ./login.php');
  }

  if(isset($_POST["delete_schedule"])){
    $nazivRasporeda = pg_escape_string( $_POST['raspored']);
    $query = "SELECT * FROM raspored r WHERE r.naziv = '$nazivRasporeda'";
    $rezultatRasporeda = pg_query($dbconn, $query);
    $rasporedId =  pg_fetch_all($rezultatRasporeda)[0]['id_rasporeda'];
    echo $rasporedId;
    $rezultat = pg_query_params($dbconn, 'call izbrisi_raspored($1)',array($rasporedId));
    header('Location: ./index.php');
  }

  if(isset($_POST["search"])) {
    $dan = pg_escape_string( $_POST['dan']);
    $nazivRaspreda = pg_escape_string( $_POST['raspored']);

    $rezultatRasporeda = pg_query(
      "SELECT
        r.naziv AS naziv_rasporeda,
        p.naziv AS naziv_predmeta,
        z.naziv AS naziv_zgrade,
        p.id_predmeta,
        p.ects,
        p.opis,
        v.dan,
        n.ime,
        n.prezime,
        n.email,
        v.vrijeme_od,
        v.vrijeme_do,
        d.naziv AS naziv_dvorane
      FROM
        raspored r
        JOIN se_nalazi sn ON sn.id_rasporeda = r.id_rasporeda
        JOIN predmet p on p.id_predmeta = sn.id_predmeta
        JOIN traje t ON t.id_predmeta = p.id_predmeta
        JOIN vrijeme v ON v.id_vremena = t.id_vremena
        JOIN predaje pr ON pr.id_predmeta = p.id_predmeta
        JOIN nastavnik n ON n.id_nastavnika = pr.id_nastavnika
        JOIN se_izvodi si ON si.id_predmeta = p.id_predmeta
        JOIN dvorana d ON d.id_dvorane = si.id_dvorane
        JOIN zgrada z ON z.id_zgrade = d.id_zgrade
        JOIN korisnik k ON k.id_korisnika = r.id_korisnika
        WHERE v.dan = '$dan' AND r.naziv = '$nazivRaspreda' AND  k.korisnicko_ime = '$korisnik' AND CAST(sn.vrijedece_vrijeme AS text) LIKE '%infinity%'
    ");  
  } elseif(isset($_POST["search_all"])) {
    $rezultatRasporeda = pg_query(
    "SELECT
      r.naziv AS naziv_rasporeda,
      p.naziv AS naziv_predmeta,
      z.naziv AS naziv_zgrade,
      p.id_predmeta,
      p.ects,
      p.opis,
      v.dan,
      n.ime,
      n.prezime,
      n.email,
      v.vrijeme_od,
      v.vrijeme_do,
      d.naziv AS naziv_dvorane
    FROM
      raspored r
      JOIN se_nalazi sn ON sn.id_rasporeda = r.id_rasporeda
      JOIN predmet p on p.id_predmeta = sn.id_predmeta
      JOIN traje t ON t.id_predmeta = p.id_predmeta
      JOIN vrijeme v ON v.id_vremena = t.id_vremena
      JOIN predaje pr ON pr.id_predmeta = p.id_predmeta
      JOIN nastavnik n ON n.id_nastavnika = pr.id_nastavnika
      JOIN se_izvodi si ON si.id_predmeta = p.id_predmeta
      JOIN dvorana d ON d.id_dvorane = si.id_dvorane
      JOIN zgrada z ON z.id_zgrade = d.id_zgrade
      JOIN korisnik k ON k.id_korisnika = r.id_korisnika
      WHERE k.korisnicko_ime = '$korisnik' AND CAST(sn.vrijedece_vrijeme AS text) LIKE '%infinity%'
    ");  
  } else {
    $rezultatRasporeda = pg_query(
      "SELECT
        r.naziv AS naziv_rasporeda,
        p.naziv AS naziv_predmeta,
        z.naziv AS naziv_zgrade,
        sn.vrijedece_vrijeme,
        p.id_predmeta,
        p.ects,
        p.opis,
        v.dan,
        n.ime,
        n.prezime,
        n.email,
        v.vrijeme_od,
        v.vrijeme_do,
        d.naziv AS naziv_dvorane
      FROM
        raspored r
        JOIN se_nalazi sn ON sn.id_rasporeda = r.id_rasporeda
        JOIN predmet p on p.id_predmeta = sn.id_predmeta
        JOIN traje t ON t.id_predmeta = p.id_predmeta
        JOIN vrijeme v ON v.id_vremena = t.id_vremena
        JOIN predaje pr ON pr.id_predmeta = p.id_predmeta
        JOIN nastavnik n ON n.id_nastavnika = pr.id_nastavnika
        JOIN se_izvodi si ON si.id_predmeta = p.id_predmeta
        JOIN dvorana d ON d.id_dvorane = si.id_dvorane
        JOIN zgrada z ON z.id_zgrade = d.id_zgrade
        JOIN korisnik k ON k.id_korisnika = r.id_korisnika
        WHERE k.korisnicko_ime = '$korisnik' AND CAST(sn.vrijedece_vrijeme AS text) LIKE '%infinity%';
    ");  
  }

  $rezultatKorisnikovihrasporeda = pg_query(
    "SELECT
      *
    FROM
      korisnik k
    JOIN raspored r ON r.id_korisnika = k.id_korisnika
    WHERE k.korisnicko_ime = '$korisnik';
  ");

  $rezultatNastavnika = pg_query('SELECT * FROM nastavnik');
  $rezultatDvorana = pg_query('SELECT * FROM dvorana');
  
  $korisnikoviRasporedi = pg_fetch_all($rezultatKorisnikovihrasporeda);
  $nastavnici =  pg_fetch_all($rezultatNastavnika);
  $dvorane =  pg_fetch_all($rezultatDvorana);
  $rasporedi = pg_fetch_all($rezultatRasporeda);
 
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
      <li><a class="active" href="./index.php">Raspored</a></li>
      <li><a href="./subject.php">Predmeti</a></li>
      <li><a href="./professor.php">Profesori</a></li>
      <li><a href="./room.php">Dvorane</a></li>
      <li><a href="./building.php">Zgrade</a></li>
      <li><a name="logout" href="./login.php">Odjava</a></li>    
      <div class="active-user">
        <form method="POST" action="./index.php">
          <p>Prijavljeni ste kao: <?php {echo $korisnik;} ?>  <button class="btn_delete_acc" name="delete_acc"> Izbriši acc</button> </p>               
        </form>
      </div>
    </ul>
    <div class="main-container">
      <form method="POST" action="./index.php">
        <div class="filter-raspored">
          <h2>Pretraži raspored</h2>
          <label for="dan">Dan</label>
          <select id="dan" name="dan">
            <option value="Ponedjeljak">Ponedjeljak</option>
            <option value="Utorak">Utorak</option>
            <option value="Srijeda">Srijeda</option>
            <option value="Četvrtak">Četvrtak</option>
            <option value="Petak">Petak</option>
            <option value="Subota">Subota</option>
            <option value="Nedjelja">Nedjelja</option>
          </select>

          <label for="raspored">Raspored</label>
          <select id="raspored" name="raspored">
          <?php
              foreach( $korisnikoviRasporedi as $korisnikovRaspored) 
                echo "<option value=\"{$korisnikovRaspored['naziv']}\">{$korisnikovRaspored['naziv']}</option>";
          ?>
          </select>

          <button class="main-btn" name="search">Pretraži</button>
          <button class="main-btn" name="search_all">Pretraži sve</button>
          <button class="main-btn" name="delete_schedule" >Obriši raspored</button>
        </div>
      </form>
      <div class="filter-raspored">
        <form action="./new_schedule.php">
          <button class="main-btn">Dodaj predmet</button>
        </form>

        <form action="./new_user_schedule.php">
          <button class="main-btn">Novi raspored</button>
        </form>
      </div>
    </div>

    <p class="error"><?php {echo $pogreska;} ?></p>

    <div class="shedule-container">
    <?php
          foreach( $rasporedi as $raspored) {                     
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
          <h2 class="info-box__title"><?php {echo $raspored['naziv_predmeta'];} ?></h2>
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
            <span class="info-box__subheader-box-text"><?php {echo $raspored['ects'];} ?></span>
          </div>

          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                src="https://images.vexels.com/media/users/3/157343/isolated/preview/fa058a304813b6d204d29253f5cb90d4-flat-home-house-icon-by-vexels.png"
                alt="city-image"
                class="info-box__subheader-img"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Dvorana</span></b>
            <span class="info-box__subheader-box-text">  <?php {echo $raspored['naziv_dvorane'];} ?></span>
          </div>

          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                src="https://cdn.iconscout.com/icon/free/png-256/building-1741335-1484597.png"
                alt="city-image"
                class="info-box__subheader-img"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Zgrada</span></b>
            <span class="info-box__subheader-box-text">  <?php {echo $raspored['naziv_zgrade'];} ?></span>
          </div>
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                src="https://cdn2.iconfinder.com/data/icons/education-people/512/22-512.png"
                alt="city-image"
                class="info-box__subheader-img"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Nastavnik</span></b>
            <span class="info-box__subheader-box-text"><?php {echo $raspored['prezime'];} ?></span>
          </div>
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                src="https://www.flaticon.com/svg/static/icons/svg/1374/1374122.svg"
                alt="city-image"
                class="info-box__subheader-img"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Dan</span></b>
            <span class="info-box__subheader-box-text"><?php {echo $raspored['dan'];} ?></span>
          </div>
          <div class="info-box__subheader-box">
            <figure class="info-box__subheader-figure">
              <img
                src="https://cdn3.iconfinder.com/data/icons/shipping-and-delivery-28/64/Delivery_and_Logistic-17-512.png"
                alt="city-image"
                class="info-box__subheader-img"
              />
            </figure>
            <b><span class="info-box__subheader-box-text">Vrijeme</span></b>
            <span class="info-box__subheader-box-text"><?php {echo $raspored['vrijeme_od']." - ".$raspored['vrijeme_do'];} ?></span>
          </div>
        </div>

        <p class="info-box__about">
          <b
            ><span class="info-box__subheader-box-text"
              >Opis predmeta <br /><br />
              <?php {echo $raspored['opis'];} ?>
            </span></b
          >
        </p>
        <b>
         
          <form  method="POST" action="./index.php">
            <button value="<?php {echo $raspored['id_predmeta'];} ?>" class="btn-crud" type="submit" name="delete">Ukloni s rasporeda</button>
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
