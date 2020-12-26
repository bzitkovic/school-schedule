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
    </ul>

    <div class="main-container">
      <div class="filter-raspored">
        <form action="./new_building.html">
          <button class="main-btn">Nova zgrada</button>
        </form>
      </div>
    </div>
    <div class="subject-cards">
      <div class="info-box">
        <div class="info-box__header">
          <figure class="info-box__subheader-figure">
            <img
              class="info-box__subheader-img"
              src="https://cdn.iconscout.com/icon/free/png-256/building-1741335-1484597.png"
              alt="club-image"
            />
          </figure>
          <h2 class="info-box__title">FOI 1</h2>
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
              Pavlinska ul. 2, 42000, Varaždin
            </span>
          </div>
        </div>
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