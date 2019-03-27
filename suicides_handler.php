<?php
	require_once("include/DBConnection.php")

	const DB = array('host' => 'localhost', 'bd' => 'graph', 'user' => 'root', 'pass' => '')
	//const SERVER = 'localhost';
	//const USER = 'root';
	//const PASS = '';
	//const DB = 'graph';

	function insert(){
		$db = mysqli_connect(SERVER, USER, PASS, DB);

		if ($db)
		{
			mysqli_autocommit($db, FALSE);
			$row = 0;
			if ($handler = fopen("suicidesPrepro.csv", "r"))
			{
				while ($data = fgetcsv($handler,','))
				{
					if ($row != 0)
					{
						
						$country = $data[0];
						$year = $data[1];
						$sex = $data[2];
						$age = $data[3];
						$suicides_no = $data[4];
						$population = $data[5];
						$suicidesPer100kpop = $data[6];
						$country_year = $data[7];
						$HDIforYear = $data[8] == '' ? 'NULL' : $data[8];
						$gdp_for_year = $data[9];
						$gdp_per_capita = $data[10];
						$generation = $data[11];
						$sql = "INSERT INTO suicides_table (id, country, year, sex, age, suicides_no, population, suicidesPer100kpop, country_year, HDIforYear, gdp_for_year, gdp_per_capita, generation)
						VALUES ($row, '$country', $year, '$sex', '$age', $suicides_no, $population, $suicidesPer100kpop, '$country_year', $HDIforYear, '$gdp_for_year', $gdp_per_capita, '$generation');";
						if (!mysqli_query($db, $sql))
							echo mysqli_error($db) . '<br>';
					}
					$row++;
					
				}
			}

			
			mysqli_query($db, "COMMIT");

			mysqli_close($db);

		}
	}
	
	function getSelections($selected){
		DBConnection::init(DB);
		$db = DBConnection::conexionBD();
		if ($db)
		{
			echo "<div class='row'>";
				echo "<div class='col-4'>";
					echo "Country: ";
					echo "<select class='form-control' id='country'>";
					
					$query = mysqli_query($db, "SELECT DISTINCT country FROM suicides_table ORDER BY country ASC;");
					echo "<option>Any</option>";
					while ($row = mysqli_fetch_assoc($query))
					{
						$country = $row["country"];
						echo "<option value='$country'>$country</option>";
					}
					echo "</select>";
				echo "</div>";

				echo "<div class='col-4'>";
					echo "Age: ";
					echo "<select class='form-control' id='age'>";
	
					$query = mysqli_query($db, "SELECT DISTINCT age FROM suicides_table ORDER BY age ASC;");
					echo "<option>Any</option>";
					while ($row = mysqli_fetch_assoc($query))
					{
						$country = $row["age"];
						echo "<option value='$country'>$country</option>";
					}
					echo "</select>";
				echo "</div>";

				echo "<div class='col-4'>";
					echo "Year: ";
					echo "<select class='form-control' id='year'>";
	
					$query = mysqli_query($db, "SELECT DISTINCT year FROM suicides_table ORDER BY year ASC;");
					echo "<option>Any</option>";
					while ($row = mysqli_fetch_assoc($query))
					{
						$country = $row["year"];
						echo "<option value='$country'>$country</option>";
					}
					echo "</select>";
				echo "</div>";
			echo "</div>";
		}
		mysqli_close($db);
	}

	


