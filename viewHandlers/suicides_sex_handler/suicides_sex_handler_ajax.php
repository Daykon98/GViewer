<?php
	require_once(dirname(__FILE__) . './../../includes/DBConnection.php');
	require_once(dirname(__FILE__) . '/suicides_sex_handler_prepared.php');

	const DB = array('host' => 'localhost', 'bd' => 'graph', 'user' => 'root', 'pass' => '');

	$id = $_POST['id'];
	$country = $_POST['country'];
	$age = $_POST['age'];
	$year = $_POST['year'];

	//Parametrizar esto

	SuicidesSexPrepared::prepareQueries();
	if ($id === 'country')
	{
		if ($country === "Any")
			echo "<option selected>Any</option>";
		else
			echo "<option>Any</option>";
		
		$query = SuicidesSexPrepared::fetchCountry($country, $age, $year);
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
		$query = SuicidesSexPrepared::fetchAge($country, $age, $year);
			
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

	elseif ($id === 'year')
	{
		$query = SuicidesSexPrepared::fetchYear($country, $age, $year);
		
		if ($year === "Any")
			echo "<option selected>Any</option>"; 
		else
			echo "<option>Any</option>";
		while ($row = $query->fetch_assoc())
		{
			$year_opt = $row["year"];
			if ($year_opt == $year)
				echo "<option value='$year_opt' selected>$year_opt</option>";
			else
				echo "<option value='$year_opt'>$year_opt</option>";
		}
	}

	elseif ($id === 'data')
	{
		$query = SuicidesSexPrepared::fetchData($country, $age, $year);
		$dataArray = array();

		while ($row = $query->fetch_assoc())
		{
			$data = array('y' => $row['suicides'],
						 'name' => ucfirst($row['sex']),
						 'label' => ucfirst($row['sex']),
						  'color' => $row['sex'] === 'male' ? '#4eb3ff' : '#dc59ff');
			array_push($dataArray, $data);
		}
		echo json_encode($dataArray, JSON_NUMERIC_CHECK);
	}
	