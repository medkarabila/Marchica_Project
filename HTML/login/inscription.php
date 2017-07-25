<?php
$bdd = new PDO('mysql:host=localhost:3307;dbname=marchica', 'root', 'root');

if(isset($_POST['forminscription'])) {
   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);
   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {

            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {
                  if($mdp == $mdp2) {
                     $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse, avatar) VALUES(?, ?, ?, ?)");
                     $insertmbr->execute(array($pseudo, $mail, $mdp, "default.png"));
                     $erreur = "* Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
                  } else {
                     $erreur = "* Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "* Adresse mail déjà utilisée !";
               }

         }
      } else {
         $erreur = "* Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      $erreur = "* Tous les champs doivent être complétés !";
   }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="inscription.css"/>
  </head>
  <body>
    <div class="container">
      <form id="contact" action="" method="POST">
        <h1>S'inscrire</h1>
        <fieldset>
          <input type="text" placeholder="Utilisateur" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />
        </fieldset>
        <fieldset>
          <input type="email" placeholder="Mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
        </fieldset>
        <fieldset>
          <input type="password" placeholder="Mot de passe" id="mdp" name="mdp" />
        </fieldset>
        <fieldset>
          <input type="password" placeholder="Confirmez le mot de passe" id="mdp2" name="mdp2" />
        </fieldset>
        <fieldset>
          <input type="submit" name="forminscription" id="contact-submit" value="Je m'inscris"/>
        </fieldset>
        <fieldset>
          <a href="../index.html"><input type="button" value="Annuler" id="contact-annuler"/></a>
        </fieldset>
      </form>
      <?php
      if(isset($erreur)) {
         echo '<font color="red";>'.$erreur."</font>";
      }
      ?>
    </div>
  </body>
</html>
