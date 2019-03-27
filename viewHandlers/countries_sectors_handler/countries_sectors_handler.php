<?php
	require_once("includes/DBConnection.php");
	
	function getSelections($selected){
		$db = DBConnection::conexionBD();
		if ($db)
		{
				echo "<div class='col-6 offset-3'>";
					echo "Country: ";
					echo "<select class='form-control' onchange='updateOptions(this.id)' id='country'>";
					
					$query = $db->query("SELECT DISTINCT country FROM countries_table 
										 WHERE industry IS NOT NULL ORDER BY country ASC;");
					while ($row = $query->fetch_assoc())
					{
						$country = $row["country"];
						echo "<option value='$country'>$country</option>";
					}
					echo "</select>";
				echo "</div>";
		
		}
		mysqli_close($db);
	}

	


