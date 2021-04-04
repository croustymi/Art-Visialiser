<?php
  //header("Location: ./");

  require './assets/includes/core.php';
  if(isset($_SESSION["id"])){header("Location: ./admin");};

  if(isset($_POST["registing"])){
    $reg_id = htmlspecialchars($_POST['id']);
    $reg_pw = sha1($_POST['pw']);

    if(empty($_POST['id']) AND empty($_POST['pw'])){
      $error = "Merci d'entrer des identifiants";
    }elseif(empty($_POST['id'])){
      $error = "Identifiant manquant";
    }elseif(empty($_POST['pw'])){
      $error = "Mot de passe manquant";
    }elseif(!empty($_POST['id']) AND !empty($_POST['pw'])) {

      $testusername = $db__conn->prepare("SELECT * FROM users WHERE username = ?");
      $testusername->execute(array($reg_id));
      $usernameexist = $testusername->rowCount();

      if($usernameexist == 1){
        $error = "Cet utilisateur existe déjà";
      }else{
        $db_insert = $db__conn->prepare("INSERT INTO users(username, password) VALUES(?,?)");
        $db_insert->execute(array($reg_id, $reg_pw));
        $error = "Compte créé";
      };
    };
  };
?>
<html lang=<?= '"'.$site_lang.'"'; ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= 'Inscription • '.$site_name; ?></title>

  <link rel="shortcut icon" href="./assets/img/favicon.png">
  <link rel="icon" href="./assets/img/favicon.png">
  <link rel="apple-touch-icon" href="./assets/img/favicon.png">

  <!-- CSS FILES -->
  <link rel="stylesheet" type="text/css" href="./assets/css/login.css">

  <!-- EXTERNALS CSS FILES -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.14.0/css/all.css" integrity="sha384-HzLeBuhoNPvSl5KYnjx0BT+WB0QEEqLprO+NBkkk5gbc67FTaL7XIGa2w1L0Xbgc" crossorigin="anonymous">
</head>
<body>
  <section id="login">
    <div id="login-panel">
      <p class="login-title">
        Administration
        <?php
        if(isset($error)) { ?>
          <br/><span class="error"><?= $error; ?></span>
        <?php }; ?>
      </p>

      <form method="POST" action="" id="logbox">
        <span class="login-uptext">Identifiant:<br/>
        <input type="text" id="textentry" name="id" placeholder="Identifiant"></span>

        <span class="login-uptext">Mot de Passe:<br/>
        <input type="password" id="textentry" name="pw" placeholder="Mot de Passe"></span>

        <input type="submit" name="registing" value="Créer le compte">
      </form>
    </div>
  </section>
</body>
</html>
