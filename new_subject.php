<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <title>Raspored</title>
  </head>
  <body>
    <div class="login-container-subject">
      <h1>Stvori novi predmet</h1>
      <form action="./subject.php">
        <div class="form-control">
          <input name="naziv_predmeta" type="text" required />
          <label>Naziv predmeta</label>
        </div>

        <div class="form-control">
          <input name="broj_ectsa" type="number" min="1" max="10" required />
          <label>Broj ECTS-a</label>
        </div>

        <label>Nastavnik</label>
        <div class="form-control">
          <select id="nastavnik" name="nastavnik">
            <option value="Schatten">Schatten</option>
            <option value="ca">Okreša Đurić</option>
          </select>
        </div>

        <label>Dvorana</label>
        <div class="form-control">
          <select id="dvorana" name="dvorana">
            <option value="10">10</option>
            <option value="9">9</option>
            <option value="1">1</option>
          </select>
        </div>

        <label>Dan</label>
        <div class="form-control">
          <select id="dan" name="dan">
            <option value="Ponedjeljak">Ponedjeljak</option>
            <option value="Utorak">Utorak</option>
            <option value="Srijeda">Srijeda</option>
            <option value="Četvrtak">Četvrtak</option>
            <option value="Petak">Petak</option>
            <option value="Subota">Subota</option>
            <option value="Nedjelja">Nedjelja</option>
          </select>
        </div>

        <label>Vrijeme od</label>
        <div class="form-control">
          <input name="vrijeme_od" type="time" required />
        </div>

        <label>Vrijeme do</label>
        <div class="form-control">
          <input name="vrijeme_do" type="time" required />
        </div>

        <label for="opis_predmeta">Opis predmeta</label>
        <div class="form-control">
          <textarea
            name="opis_predmeta"
            type="textarea"
            cols="40"
            rows="10"
            required
          ></textarea>
        </div>

        <button class="btn">Stvori predmet</button>

        <p class="text">
          Povratak na popis predmeta? <a href="./subject.php">Vrati se</a>
        </p>
      </form>
    </div>
    <script src="script.js"></script>
  </body>
</html>