<?php
// include Database connection file
include("db_connection.php");

// check request
if(isset($_POST))
{
    // get values
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $chef = $_POST['chef'];
    $datec = $_POST['datec'];
    $datej = $_POST['datej'];
    $montant = $_POST['montant'];
    $cps = $_POST['cps'];

    // Updaste User details
    $query = "UPDATE appel_offre SET titre = '$titre', description = '$description', chef = '$chef', datec = '$datec', datej = '$datej', montant = '$montant', cps = '$cps', type = '$type' WHERE id = '$id'";
    if (!$result = mysql_query($query)) {
        exit(mysql_error());
    }
}

?>


<?php

$target_dir = "uploads/";
$target_file = $target_dir ."C:fakepath". basename($_FILES["update_cps"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

// Check if file already exists
if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
}
// Check file size
if ($_FILES["cps"]["size"] > 500000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" ) {
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
		if (move_uploaded_file($_FILES["update_cps"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["update_cps"]["name"]). " has been uploaded.";
		} else {
				echo "Sorry, there was an error uploading your file.";
		}
}
?>
