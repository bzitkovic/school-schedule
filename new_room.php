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
      <h1>Stvori novi dvoranu</h1>
      <form action="./room.php">
        <div class="form-control">
          <input name="naziv_dvorane" type="text" required />
          <label>Naziv dvorane</label>
        </div>

        <div class="form-control">
          <input name="broj_mjesta" type="number" min="1" max="500" required />
          <label>Broj mjesta</label>
        </div>

        <button class="btn">Stvori dvoranu</button>

        <p class="text">
          Povratak na popis dvorana? <a href="./room.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>