<?php
	// include Database connection file
	include("db_connection.php");

	// Design initial table header
	$data = '<table class="table table-bordered table-striped">
						<tr>
							<th>No.</th>
							<th>Titre</th>
							<th>Description</th>
							<th>Type</th>
							<th>Chef de Projet</th>
							<th>Date</th>
							<th>DateJ</th>
							<th>Montant estimé</th>
							<th>CPS</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>';

	$query = "SELECT * FROM appel_offre";

	if (!$result = mysql_query($query)) {
        exit(mysql_error());
    }

    // if query results contains rows then featch those rows
    if(mysql_num_rows($result) > 0)
    {
    	$number = 1;
    	while($row = mysql_fetch_assoc($result))
    	{
    		$data .= '<tr>
				<td>'.$number.'</td>
				<td>'.$row['titre'].'</td>
				<td>'.$row['description'].'</td>
				<td>'.$row['type'].'</td>
				<td>'.$row['chef'].'</td>
				<td>'.$row['datec'].'</td>
				<td>'.$row['datej'].'</td>
				<td>'.$row['montant'].' MAD</td>
				<td><a href="ajax/uploads/'.$row['cps'].'">Visualiser le document</a></td>


				<td>
					<button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning">Update</button>
				</td>
				<td>
					<button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button>
				</td>
    		</tr>';
    		$number++;
    	}
    }
    else
    {
    	// records now found
    	$data .= '<tr><td colspan="6">Records not found!</td></tr>';
    }

    $data .= '</table>';

    echo $data;
?>
