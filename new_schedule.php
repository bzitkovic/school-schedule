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
      <h1>Dodaj novi predmet</h1>
      <form action="./room.php">
        <div class="form-control">
          <select id="predmet" name="predmet">
            <option value="Schatten">Teorija baza podataka</option>
            <option value="ca">Deklarativno programiranje</option>
          </select>
        </div>

        <button class="btn">Dodaj predmet</button>

        <p class="text">
          Povratak na raspored? <a href="./index.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>
