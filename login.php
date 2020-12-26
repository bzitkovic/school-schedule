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
      <h1>Prijavi se</h1>
      <form action="./index.php">
        <div class="form-control">
          <input type="text" required />
          <label>Korisničko ime</label>
        </div>

        <div class="form-control">
          <input type="password" required />
          <label>Lozinka</label>
        </div>

        <button class="btn">Prijava</button>

        <p class="text">
          Nemate račun? <a href="./register.php">Registracija</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
