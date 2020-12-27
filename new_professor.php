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
      <h1>Stvori novog nastavnika</h1>
      <form method="POST" action="./professor.php">
        <div class="form-control">
          <input name="ime_nastavnika" type="text" required />
          <label>Ime profesora</label>
        </div>

        <div class="form-control">
          <input name="prezime_nastavnika" type="text" required />
          <label>Prezime profesora</label>
        </div>

        <div class="form-control">
          <input name="email_nastavnika" type="text" required />
          <label>Email profesora</label>
        </div>

        <button name="submit" class="btn">Stvori nastavnika</button>

        <p class="text">
          Povratak na popis profesora? <a href="./professor.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
