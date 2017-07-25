<?php
session_start();

$bdd = new PDO('mysql:host=localhost:3307;dbname=marchica', 'root', 'root');

if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM membres WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE membres SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: ../appel_offre/appel_offre.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE membres SET mail = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: ../appel_offre/appel_offre.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE membres SET motdepasse = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: ../appel_offre/appel_offre.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }

   if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
      $tailleMax = 2097152;
      $extensionsValides = array('jpg', 'jpeg', 'gif', 'png');
      if($_FILES['avatar']['size'] <= $tailleMax) {
         $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
         if(in_array($extensionUpload, $extensionsValides)) {
            $chemin = "membres/avatars/".$_SESSION['id'].".".$extensionUpload;
            $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
            if($resultat) {
               $updateavatar = $bdd->prepare('UPDATE membres SET avatar = :avatar WHERE id = :id');
               $updateavatar->execute(array(
                  'avatar' => $_SESSION['id'].".".$extensionUpload,
                  'id' => $_SESSION['id']
                  ));
               header('Location: ../appel_offre/appel_offre.php?id='.$_SESSION['id']);
            } else {
               $msg = "Erreur durant l'importation de votre photo de profil";
            }
         } else {
            $msg = "Votre photo de profil doit être au format jpg, jpeg, gif ou png";
         }
      } else {
         $msg = "Votre photo de profil ne doit pas dépasser 2Mo";
      }
   }



?>
<html>
   <head>
      <title>Editer votre profil</title>
      <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="editionprofil.css"/>
   </head>
   <body>
      <div class="container">
        <br/><br/>
         <h1>Edition de mon profil</h1>
         <form method="POST" id="contact" action="" enctype="multipart/form-data">

                  <fieldset>
                  <input type="text" name="newpseudo" placeholder="Pseudo" value="<?php echo $user['pseudo']; ?>" /><br /><br />
                  </fieldset>

                 <fieldset>
                  <input type="text" name="newmail" placeholder="Mail" value="<?php echo $user['mail']; ?>" /><br /><br />
                </fieldset>

                 <fieldset>
                  <input type="password" name="newmdp1" placeholder="Mot de passe"/><br /><br/>
                </fieldset>

                 <fieldset>
                  <input type="password" name="newmdp2" placeholder="Confirmation mdp" /><br/><br/>
                </fieldset>

                 <fieldset>
                 <input type="file" name="avatar" value="" id="avatar"><br /><br />
                  </fieldset>

                <input type="submit" value="Mettre à jour mon profil" id="contact-submit"/>
                <a href="../appel_offre/appel_offre.php?id=<?php echo $user['id']; ?>"><input type="button" value="Annuler" id="contact-annuler"/></a>

        </form>
        <?php if(isset($msg)) { echo $msg; } ?>
        </div>
   </body>
</html>
<?php
}
else {
   header("Location: connexion.php");
}
?>
