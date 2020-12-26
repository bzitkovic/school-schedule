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
      <h1>Stvori novu zgradu</h1>
      <form action="./building.php">
        <div class="form-control">
          <input name="ime_profesora" type="text" required />
          <label>Naziv zgrade</label>
        </div>

        <div class="form-control">
          <input name="prezime_profesora" type="text" required />
          <label>Adresa zgrade</label>
        </div>

        <button class="btn">Stvori zgradu</button>

        <p class="text">
          Povratak na popis zgrada? <a href="./building.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>