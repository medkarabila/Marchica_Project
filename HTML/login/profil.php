<?php
session_start();

$bdd = new PDO('mysql:host=localhost:3307;dbname=marchica', 'root', 'root');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
<html>
   <head>
      <title>Profil</title>
      <meta charset="utf-8">
   </head>
   <body>
      <div align="center">


         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>
         <br /><br />
         <?php
         if(!empty($userinfo['avatar']))
         {
           ?>
           <img src="membres/avatars/<?php echo $userinfo['avatar']; ?>" width="150"/>
           <?php
         }
         ?>
         <br />
         Pseudo = <?php echo $userinfo['pseudo']; ?>
         <br />
         Mail = <?php echo $userinfo['mail']; ?>
         <br />
         <br />
         <a href="editionprofil.php"><input type="button" name="" value="Editer mon profil"></a>
         <a href="deconnexion.php"><input type="button" name="" value="Se déconnecter"></a>
         <?php
         }
         ?>
      </div>
   </body>
</html>
<?php
}
?>
