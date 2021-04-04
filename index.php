<?php
  require './assets/includes/core.php';
?>
<html lang=<?= '"'.$site_lang.'"'; ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $site_name; ?></title>

  <link rel="shortcut icon" href="./assets/img/favicon.png">
  <link rel="icon" href="./assets/img/favicon.png">
  <link rel="apple-touch-icon" href="./assets/img/favicon.png">

  <!-- CSS FILES -->
  <link rel="stylesheet" type="text/css" href="./assets/css/art.css">
  <link rel="stylesheet" type="text/css" href="./assets/css/responsive.css">

  <!-- EXTERNALS CSS FILES -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
</head>
<body>
  <?php if(isset($_SESSION["id"])){ ?>
    <a class="admin" href="./admin">Administration</a>
  <?php }; ?>
  <?php
    $theme = $db__conn->query("SELECT * FROM themes ORDER BY id DESC LIMIT 1");
    while($GetLT = $theme->fetch()) {
  ?>
  <span class="theme">Thème Actuel: <?= $GetLT["theme_name"]; ?></span>
  <?php }; ?>
  <section>
    <ul>
      <li class="list active" data-filter="all">Tous les dessins</li>
      <?php
        $themes = $db__conn->query("SELECT * FROM themes ORDER BY id DESC");
        while($GetT = $themes->fetch()) {
      ?>
      <li class="list" data-filter=<?= '"'.$GetT["theme_id"].'"'; ?>><?= $GetT["theme_name"]; ?></li>
      <?php }; ?>
    </ul>
    <div class="products">
      <?php
        $draws = $db__conn->query("SELECT * FROM draws ORDER BY id DESC");
        while($GetD = $draws->fetch()) {
      ?>
      <div class=<?= '"itemBox '.$GetD["theme"].'"' ?>><img src=<?= '"'.$GetD["img_url"].'"'; ?> />
        <div class="caption">
          <span class="author"><?= $GetD["author"]; ?></span>
          <a href=<?= '"'.$GetD["img_url"].'"'; ?> target="_blank" class="view">Voir <i class="fas fa-caret-right"></i></a>
        </div>
      </div>
      <?php }; ?>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="./assets/js/main.js"></script>
</body>
</html>
