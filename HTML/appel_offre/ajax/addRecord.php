<?php
	if(isset($_POST['titre']) && isset($_POST['description']) && isset($_POST['chef']) && isset($_POST['datec']) && isset($_POST['datej']) && isset($_POST['montant']) && isset($_POST['cps'])  && isset($_POST['type']))
	{
		// include Database connection file
		include("db_connection.php");




		// get values
		$titre = $_POST['titre'];
		$description = $_POST['description'];
		$type = $_POST['type'];
		$chef = $_POST['chef'];
		$datec = $_POST['datec'];
		$datej = $_POST['datej'];
		$montant = $_POST['montant'];
		$cps = $_POST['cps'];
?>

<?php
		$query = "INSERT INTO appel_offre(titre, description, chef, datec, datej, montant, cps, type) VALUES('$titre', '$description', '$chef', '$datec', '$datej', '$montant', '$cps','$type')";
		if (!$result = mysql_query($query)) {
	        exit(mysql_error());
	    }
	    echo "1 Record Added!";
	}


?>

<?php

$target_dir = "uploads/";
$target_file = $target_dir ."C:fakepath". basename($_FILES["cps"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

// Check if file already exists
if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
}
// Check file size
if ($_FILES["cps"]["size"] > 500000000) {
		echo "Sorry, your file is too large.";
		$uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "txt" && $imageFileType != "docx"  ) {
		echo "Sorry, only JPG, JPEG, PNG ,PDF , TXT , DOC & GIF files are allowed.";
		$uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
		if (move_uploaded_file($_FILES["cps"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["cps"]["name"]). " has been uploaded.";
		} else {
				echo "Sorry, there was an error uploading your file.";
		}
}
?>
