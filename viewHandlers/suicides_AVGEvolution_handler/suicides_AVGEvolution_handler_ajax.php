<?php
	require_once(dirname(__FILE__) . './../../includes/DBConnection.php');
	require_once(dirname(__FILE__) . '/suicides_AVGEvolution_handler_prepared.php');

	$id = $_POST['id'];
	$country = $_POST['country'];
	$age = $_POST['age'];

	$db = DBConnection::conexionBD();

	//Parametrizar esto
	if ($db)
	{
		SuicidesAVGEvolutionPrepared::prepareQueries();

		if ($id === 'country')
		{

			if ($country === "Any")
				echo "<option selected>Any</option>";
			else
				echo "<option>Any</option>";
			
			$query = SuicidesAVGEvolutionPrepared::fetchCountry($country, $age);
			while ($row = $query->fetch_assoc())
			{
				$country_opt = $row["country"];
				if ($country === $country_opt)
					echo "<option value='$country_opt' selected>$country_opt</option>";
				else
					echo "<option value='$country_opt'>$country_opt</option>";
			}
		}

		elseif ($id === 'age')
		{
			$query = SuicidesAVGEvolutionPrepared::fetchAge($country, $age);
			
			if ($age === "Any")
				echo "<option selected>Any</option>";
			else
				echo "<option>Any</option>";
			while ($row = $query->fetch_assoc())
			{
				$age_opt = $row["age"];
				if ($age_opt === $age)
					echo "<option value='$age_opt' selected>$age_opt</option>";
				else
					echo "<option value='$age_opt'>$age_opt</option>";
			}
		}

		elseif ($id === 'data')
		{
			$query = SuicidesAVGEvolutionPrepared::fetchData($country, $age);
			$dataArray = array();

			while ($row = $query->fetch_assoc())
			{
				$data = array('y' => $row['suicides'],
							 'x' => $row['year']);
				array_push($dataArray, $data);
			}
			echo json_encode($dataArray, JSON_NUMERIC_CHECK);
		}
	}
	