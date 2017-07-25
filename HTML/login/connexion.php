<?php
session_start();

$bdd = new PDO('mysql:host=localhost:3307;dbname=marchica', 'root', 'root');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: ../appel_offre/appel_offre.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<html>
   <head>
      <title>Authentification</title>
      <meta charset="utf-8">
      <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
      <link href='login.css' rel='stylesheet' type='text/css'>
   </head>
   <body>

     <div class="login-block">
         <h1>S'identifier</h1>
         <form method="POST" action="">
            <input type="email" name="mailconnect" placeholder="Mail" id="username"/>
            <input type="password" name="mdpconnect" placeholder="Mot de passe" id="password"/>
            <br /><br />
            <input type="submit" name="formconnexion" value="Se connecter" id="submit" />
            <a href="inscription.php"><input type="text" value="S'inscrire" id="inscrire"/></a>
         </form>
         <?php
         if(isset($erreur)) {
            echo '<font color="red">'.$erreur."</font>";
         }
         ?>
      </div>
   </body>
</html>
