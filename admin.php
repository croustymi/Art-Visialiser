<?php
  require './assets/includes/core.php';
  if(!isset($_SESSION["id"])){header("Location: ./login");};

  $error_T = "Créer un Thème";
  $error_D = "Ajouter un Dessin";

  if(isset($_POST["addtheme"])){
    $tm_id = htmlspecialchars($_POST['id']);
    $tm_name = htmlspecialchars($_POST['name']);

    if(empty($_POST['id']) AND empty($_POST['name'])){
      $error_T = "Merci d'entrer les identifiants";
    }elseif(empty($_POST['id'])){
      $error_T = "ID manquant";
    }elseif(empty($_POST['name'])){
      $error_T = "Nom manquant";
    }elseif(!empty($_POST['id']) AND !empty($_POST['name'])) {

      $testTHid = $db__conn->prepare("SELECT * FROM themes WHERE theme_id = ?");
      $testTHid->execute(array($tm_id));
      $THIDexist = $testTHid->rowCount();

      if($THIDexist == 0){
        $db_insert = $db__conn->prepare("INSERT INTO themes(theme_id, theme_name) VALUES(?,?)");
        $db_insert->execute(array($tm_id, $tm_name));

        $error_T = "Thème ajouté";
      }else{
        $error_T = "Cet ID existe déjà";
      };
    };
  };

  if(isset($_POST["adddraw"])){
    $dw_author = htmlspecialchars($_POST['author']);
    $dw_discord = htmlspecialchars($_POST['discord']);
    $dw_theme = htmlspecialchars($_POST['theme']);
    $dw_url = htmlspecialchars($_POST['url']);

    if(empty($_POST['author']) AND empty($_POST['discord']) AND empty($_POST['theme'])AND empty($_POST['url'])){
      $error_D = "Merci d'entrer <b>TOUTES</b> les informations";
    }elseif(empty($_POST['author'])){
      $error_D = "Auteur manquant";
    }elseif(empty($_POST['discord'])){
      $error_D = "Discord ID manquant";
    }elseif(empty($_POST['theme'])){
      $error_D = "Thème ID manquant";
    }elseif(empty($_POST['url'])){
      $error_D = "Lien manquant";
    }elseif(!empty($_POST['author']) AND !empty($_POST['discord']) AND !empty($_POST['theme'])AND !empty($_POST['url'])) {

      $db_insert = $db__conn->prepare("INSERT INTO draws(author, discord_id, theme, img_url) VALUES(?,?,?,?)");
      $db_insert->execute(array($dw_author, $dw_discord, $dw_theme, $dw_url));

      $error_D = "Dessin ajouté";
    };
  };
?>
<html lang=<?= '"'.$site_lang.'"'; ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= 'Admin • '.$site_name; ?></title>

  <link rel="shortcut icon" href="./assets/img/favicon.png">
  <link rel="icon" href="./assets/img/favicon.png">
  <link rel="apple-touch-icon" href="./assets/img/favicon.png">

  <!-- CSS FILES -->
  <link rel="stylesheet" type="text/css" href="./assets/css/admin.css">

  <!-- EXTERNALS CSS FILES -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
</head>
<body>
  <section>
    <div class="header">
      <span>Administration</span>
      <div class="nav">
        <a href="./admin">Accueil</a>
        <a href="./admin?theme">Créer un Thème</a>
        <a href="./admin?draws">Ajouter des Dessins</a>
        <a href="./">Retourner sur le Site</a>
        <a href="./logout">Déconnexion</a>
      </div>
    </div>
    <?php if(isset($_GET["theme"])){ ?>
    <div class="main">
      <div class="container">
        <div class="box top">
          <?php
            $theme = $db__conn->query("SELECT * FROM themes ORDER BY id DESC LIMIT 1");
            while($GetLT = $theme->fetch()) {
          ?>
          <span>Thème actuel: <?= $GetLT["theme_name"]; ?></span>
          <?php }; ?>
        </div>
        <div class="box info">
          <span><?= $error_T; ?></span>
          <form method="POST" action="">
            <table>
              <thead>
                <tr>
                  <th>ID du Thème</th>
                  <th>Nom du Thème</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" id="textentry" name="id" placeholder="ID du Thème"></span></td>
                  <td><input type="text" id="textentry" name="name" placeholder="Nom du Thème"></span></td>
                </tr>
              </tbody>
            </table>
            <input type="submit" name="addtheme" value="Ajouter le thème">
          </form>
        </div>
        <div class="box">
          <span>Liste des thèmes</span>
          <table>
            <thead>
              <tr>
                <th>ID du Thème</th>
                <th>Nom du Thème</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $theme = $db__conn->query("SELECT * FROM themes ORDER BY id DESC LIMIT 9");
                while($GetT = $theme->fetch()) {
              ?>
              <tr>
                <td><?= $GetT["theme_id"]; ?></td>
                <td><?= $GetT["theme_name"]; ?></td>
              </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php }elseif(isset($_GET["draws"])){ ?>
    <div class="main">
      <div class="container">
        <div class="box top">
          <?php
            $theme = $db__conn->query("SELECT * FROM themes ORDER BY id DESC LIMIT 1");
            while($GetLT = $theme->fetch()) {
          ?>
          <span>ID du Thème actuel: <?= $GetLT["theme_id"]; ?></span>
          <?php }; ?>
        </div>
        <div class="box info">
          <span><?= $error_D; ?></span>
          <form method="POST" action="">
            <table>
              <thead>
                <tr>
                  <th>Auteur</th>
                  <th>ID Discord</th>
                  <th>ID Thème</th>
                  <th>Lien du Dessin</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="text" id="textentry" name="author" placeholder="Nom de l'Auteur"></span></td>
                  <td><input type="text" id="textentry" name="discord" placeholder="ID Discord de l'Auteur"></span></td>
                  <td><input type="text" id="textentry" name="theme" placeholder="ID du Thème"></span></td>
                  <td><input type="text" id="textentry" name="url" placeholder="Lien du Dessin"></span></td>
                </tr>
              </tbody>
            </table>
            <input type="submit" name="adddraw" value="Ajouter le Dessin">
          </form>
        </div>
        <div class="box">
          <span>Liste des dessins</span>
          <table>
            <thead>
              <tr>
                <th>Auteur</th>
                <th>ID Discord</th>
                <th>ID Thème</th>
                <th>Lien</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $theme = $db__conn->query("SELECT * FROM draws ORDER BY id DESC LIMIT 9");
                while($GetD = $theme->fetch()) {
              ?>
              <tr>
                <td><?= $GetD["author"]; ?></td>
                <td><?= $GetD["discord_id"]; ?></td>
                <td><?= $GetD["theme"]; ?></td>
                <td><a href=<?= '"'.$GetD["img_url"].'"'; ?> target="_blank">Voir l'image</a></td>
              </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php }else{ ?>
    <div class="main">
      <div class="container">
        <div class="box top">
          <span>Bienvenue <?= $_SESSION["user"]; ?></span>
        </div>
      </div>
    </div>
    <?php }; ?>
  </section>

  <script type="text/javascript" src="./assets/js/admin.js"></script>
</body>
</html>
