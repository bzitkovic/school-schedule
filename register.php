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
      <h1>Registrirajte se</h1>
      <form action="./login.php">
        <div class="form-control">
          <input type="text" required />
          <label>Korisničko ime</label>
        </div>

        <div class="form-control">
          <input type="text" required />
          <label>Email</label>
        </div>

        <div class="form-control">
          <input type="password" required />
          <label>Lozinka</label>
        </div>

        <div class="form-control">
          <input type="password" required />
          <label>Ponovljena lozinka</label>
        </div>

        <button class="btn">Registracija</button>

        <p class="text">
          Natrag na prijavu?<a href="./login.php"> Prijava</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>