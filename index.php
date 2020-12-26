<?php
  include_once './conn.php';

  $rezultatNastavnika = pg_query($dbconn, 'SELECT * FROM "Nastavnik"');
  $rezultatDvorana = pg_query($dbconn, 'SELECT * FROM "Dvorana"');

  $nastavnici =  pg_fetch_all($rezultatNastavnika);
  $dvorane =  pg_fetch_all($rezultatDvorana);
  //print_r($nastavniciArray);

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
    </ul>

    <div class="main-container">
      <form action="#">
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

          <label for="nastavnik">Nastavnik</label>
          <select id="nastavnik" name="nastavnik">
          <?php
              foreach( $nastavnici as $nastavnik) 
                echo "<option value=\"{$nastavnik['prezime']}\">{$nastavnik['prezime']}</option>";
          ?>
          </select>

          <label for="dvorana">Dvorana</label>
          <select id="dvorana" name="dvorana">
          <?php
              foreach( $dvorane as $dvorana) 
                echo "<option value=\"{$dvorana['naziv']}\">{$dvorana['naziv']}</option>";
          ?>
          </select>

          <button class="main-btn">Pretraži</button>
          <button class="main-btn">Pretraži sve</button>
        </div>
      </form>
      <div class="filter-raspored">
        <form action="./new_schedule.php">
          <button class="main-btn">Dodaj predmet</button>
        </form>
      </div>
    </div>

    <div class="shedule-container">
      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.onlinewebfonts.com/svg/img_341860.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title">Teorija baza podataka</h2>
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
            <span class="info-box__subheader-box-text">5</span>
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
            <span class="info-box__subheader-box-text">10</span>
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
            <span class="info-box__subheader-box-text">Schatten</span>
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
            <span class="info-box__subheader-box-text">Utorak</span>
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
            <span class="info-box__subheader-box-text">10 AM</span>
          </div>
        </div>

        <p class="info-box__about">
          <b
            ><span class="info-box__subheader-box-text"
              >Opis predmeta <br /><br />
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo,
              omnis. Culpa a debitis cumque laborum nam enim quos recusandae
              ullam molestiae expedita saepe illum pariatur nihil, vero et
              minima quidem.
            </span></b
          >
        </p>
        <b>
          <div class="info-box__footer">
            <a
              href="https://www.juventus.com/en/"
              target="_blank"
              class="info-box__btn-join"
              >Službena stranica</a
            >
          </div>
        </b>
      </div>

      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.onlinewebfonts.com/svg/img_341860.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title">Teorija baza podataka</h2>
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
            <span class="info-box__subheader-box-text">5</span>
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
            <span class="info-box__subheader-box-text">10</span>
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
            <span class="info-box__subheader-box-text">Schatten</span>
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
            <span class="info-box__subheader-box-text">Utorak</span>
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
            <span class="info-box__subheader-box-text">10 AM</span>
          </div>
        </div>

        <p class="info-box__about">
          <b
            ><span class="info-box__subheader-box-text"
              >Opis predmeta <br /><br />
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo,
              omnis. Culpa a debitis cumque laborum nam enim quos recusandae
              ullam molestiae expedita saepe illum pariatur nihil, vero et
              minima quidem.
            </span></b
          >
        </p>
        <b>
          <div class="info-box__footer">
            <a
              href="https://www.juventus.com/en/"
              target="_blank"
              class="info-box__btn-join"
              >Službena stranica</a
            >
          </div>
        </b>
      </div>

      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.onlinewebfonts.com/svg/img_341860.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title">Teorija baza podataka</h2>
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
            <span class="info-box__subheader-box-text">5</span>
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
            <span class="info-box__subheader-box-text">10</span>
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
            <span class="info-box__subheader-box-text">Schatten</span>
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
            <span class="info-box__subheader-box-text">Utorak</span>
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
            <span class="info-box__subheader-box-text">10 AM</span>
          </div>
        </div>

        <p class="info-box__about">
          <b
            ><span class="info-box__subheader-box-text"
              >Opis predmeta <br /><br />
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo,
              omnis. Culpa a debitis cumque laborum nam enim quos recusandae
              ullam molestiae expedita saepe illum pariatur nihil, vero et
              minima quidem.
            </span></b
          >
        </p>
        <b>
          <div class="info-box__footer">
            <a
              href="https://www.juventus.com/en/"
              target="_blank"
              class="info-box__btn-join"
              >Službena stranica</a
            >
          </div>
        </b>
      </div>

      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.onlinewebfonts.com/svg/img_341860.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title">Teorija baza podataka</h2>
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
            <span class="info-box__subheader-box-text">5</span>
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
            <span class="info-box__subheader-box-text">10</span>
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
            <span class="info-box__subheader-box-text">Schatten</span>
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
            <span class="info-box__subheader-box-text">Utorak</span>
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
            <span class="info-box__subheader-box-text">10 AM</span>
          </div>
        </div>

        <p class="info-box__about">
          <b
            ><span class="info-box__subheader-box-text"
              >Opis predmeta <br /><br />
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo,
              omnis. Culpa a debitis cumque laborum nam enim quos recusandae
              ullam molestiae expedita saepe illum pariatur nihil, vero et
              minima quidem.
            </span></b
          >
        </p>
        <b>
          <div class="info-box__footer">
            <a
              href="https://www.juventus.com/en/"
              target="_blank"
              class="info-box__btn-join"
              >Službena stranica</a
            >
          </div>
        </b>
      </div>
    </div>
    <script src="script.js"></script>
  </body>
</html>