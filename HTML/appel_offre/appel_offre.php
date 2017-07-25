<?php
session_start();

$bdd = new PDO('mysql:host=localhost:3307;dbname=marchica', 'root', 'root');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Demo Ajout/Modification/Suppression</title>

    <!-- Bootstrap CSS File  -->
    <link rel="stylesheet" type="text/css" href="bootstrap-3.3.5-dist/css/bootstrap.css"/>
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
       <img src="../login/membres/avatars/<?php echo $userinfo['avatar']; ?>" width="150"/>
       <?php
     }
     ?>
     <br />
     Pseudo = <?php echo $userinfo['pseudo']; ?>
     <br />
     Mail = <?php echo $userinfo['mail']; ?>
     <br />
     <br />
     <a href="../login/editionprofil.php"><input type="button" name="" value="Editer mon profil"></a>
     <a href="../login/deconnexion.php"><input type="button" name="" value="Se déconnecter"></a>
     <?php
     }
     ?>
  </div>
  <?php
  }
  ?>
<!-- Content Section -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Demo : Ajout - Modification - Suppression d'un appel d'offre</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <button class="btn btn-success" data-toggle="modal" data-target="#add_new_record_modal">Add New Record</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h3>Records:</h3>

            <div class="records_content"></div>
        </div>
    </div>
</div>
<!-- /Content Section -->


<!-- Bootstrap Modals -->
<!-- Modal - Add New Record/User -->


<form action="ajax/addRecord.php" method="post" enctype="multipart/form-data">
<div class="modal fade" id="add_new_record_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add New Record</h4>
            </div>
            <div class="modal-body">

              <div class="form-group">
                  <label for="titre">Titre</label>
                  <input type="text" id="titre" placeholder="Titre" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="description">Description</label>
                  <textarea id="description" placeholder="Description" class="form-control"></textarea>
              </div>
              <div class="form-group">
                  <label for="type">Type</label>
                  <input type="text" id="type" placeholder="Type" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="chef">Chef de Projet</label>
                  <input type="text" id="chef" placeholder="Chef de Projet" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="datec">Date</label>
                  <input type="text" id="datec" placeholder="AAAA-MM-JJ" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="datej">DateJ</label>
                  <input type="text" id="datej" placeholder="AAAA-MM-JJ" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="montant">Montant estimé</label>
                  <input type="text" id="montant" placeholder="Montant estimé en Dirham" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="cps">CPS</label>
                  <input type="file" name ="cps" id="cps" placeholder="CPS" class="form-control"/>
              </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" onclick="addRecord()" value="Add Record">
            </div>
        </div>
    </div>
</div>
</form>
<!-- // Modal -->

<!-- Modal - Update User details -->
<form action="ajax/updateUserDetails.php" method="post" enctype="multipart/form-data">
<div class="modal fade" id="update_user_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body">

              <div class="form-group">
                  <label for="update_titre">Titre</label>
                  <input type="text" id="update_titre" placeholder="Titre" class="form-control"/>
              </div>

              <div class="form-group">
                  <label for="update_description">Description</label>
                  <textarea id="update_description" placeholder="Description" class="form-control"></textarea>
              </div>
              <div class="form-group">
                  <label for="update_cps">Type</label>
                  <input type="text" id="update_type" placeholder="Type" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="update_chef">Chef de projet</label>
                  <input type="text" id="update_chef" placeholder="Chef de projet" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="update_datec">Date</label>
                  <input type="date" id="update_datec" placeholder="Date" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="update_datej">DateJ</label>
                  <input type="date" id="update_datej" placeholder="datej" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="update_montant">Montant estimé</label>
                  <input type="text" id="update_montant" placeholder="Montant estimé" class="form-control"/>
              </div>
              <div class="form-group">
                  <label for="update_cps">CPS</label>
                  <input type="file" name="update_cps" id="update_cps" placeholder="CPS" class="form-control"/>
              </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="submit" class="btn btn-primary" onclick="UpdateUserDetails()" value="Save Changes">
                <input type="hidden" id="hidden_user_id">
            </div>
        </div>
    </div>
</div>
</form>
<!-- // Modal -->

<!-- Jquery JS file -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>

<!-- Bootstrap JS file -->
<script type="text/javascript" src="bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>

<!-- Custom JS file -->
<script type="text/javascript" src="js/script.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-75591362-1', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
