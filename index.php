<?php session_start(); ?>
<!doctype html>
<html lang="pl">
  <head>
    <title>PS8 - Zadanie 1</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="zad1.css">
    <script src="zad1.js"></script>
  </head>
  <body>

    <div id="content">
      <form action="/index.php" method="POST">
        <label for="url">URL: </label><br>
        <input type="text" id="url" name="url"><br>
        <label for="podpis">Podpis: </label><br>
        <input type="text" id="podpis" name="podpis"><br>
        <input type="submit" value="Wyślij" name='send'><br>
      </form>
      <form action="/index.php" method="POST">
        <input type='submit' value='Usuń wszystko' name='deleteAll'><br>
      </form>
      <?php
        function pushImg() {
          $image = $_POST;
          $image['date'] = date("d.m.y h:i:s");
          $_SESSION['sesja'][] = $image;
        }

        function renderImgs() {
          if(!empty($_SESSION['sesja'])) {
            foreach ($_SESSION['sesja'] as $elem) {
              echo "<img width='50%' src='".$elem["url"]."'>";
              echo "<div>".$elem["podpis"]."</div>";
              echo "<div>Dodane: ".$elem["date"]."</div>";
              echo "<form action='/index.php' method='POST'>";
              echo "<input type='submit' value='Usuń' name='delImg'>";
              echo '<input type="hidden" name="id" value="'.$elem['date'].'"/>';
              echo "</form>";
            }
          }
        }

        if(isset($_POST['delImg'])) {
          foreach ($_SESSION['sesja'] as $elem => $tag) {
            if($tag['date'] == $_POST['id']) {
              unset($_SESSION['sesja'][$elem]);
            }
          }
          renderImgs();
        } else {       
          if(isset($_POST['deleteAll'])) {
            unset($_SESSION['sesja']);
          } else {
            if(isset($_POST['send'])) {
              $to_check = $_POST["url"];
              if (empty($to_check)) {
                echo "URL wymagany!";
              } elseif (!filter_var($to_check, FILTER_VALIDATE_URL)) {
                echo "'".$to_check."' nie jest poprawnym URL!";
              } else {
                if (empty($_POST["podpis"])) {
                  echo "Podpis wymagany!";
                } else {
                  pushImg();
                  renderImgs();
                }
              }
            } else {
              renderImgs();
            }
          }
        }
      ?>
    </div>

  </body>
</html>