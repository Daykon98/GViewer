<?php
	require_once(dirname(__FILE__) . './../../includes/DBConnection.php');
	require_once(dirname(__FILE__) . '/countries_birthdeath_handler_prepared.php');

	$country = $_POST['country'];

	$db = DBConnection::conexionBD();

	if ($db)
	{
		CountriesBirthdeathPrepared::prepareQueries();
		
		$query = CountriesBirthdeathPrepared::fetchData($country);
		$dataArray = array();

		while ($row = $query->fetch_assoc())
		{
			$data = array('y' => $row['birthrate'],
						  'x' => '1',
						  'label' => 'Birthrate',
						  'color' => '#91E59C'
						);
			array_push($dataArray, $data);
			$data = array('y' => $row['deathrate'],
						  'x' => '2',
						  'label' => 'Deathrate',
						  'color' => '#Da4F4f'
						);
			array_push($dataArray, $data);
		}
		echo json_encode($dataArray, JSON_NUMERIC_CHECK);
		
	}
	