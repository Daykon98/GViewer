<?php
	require_once(dirname(__FILE__) . './../../includes/DBConnection.php');
	require_once(dirname(__FILE__) . '/countries_sectors_handler_prepared.php');

	$country = $_POST['country'];

	$db = DBConnection::conexionBD();

	//Parametrizar esto
	if ($db)
	{
		CountriesSectorsPrepared::prepareQueries();
		
		$query = CountriesSectorsPrepared::fetchData($country);
		$dataArray = array();

		while ($row = $query->fetch_assoc())
		{
			$data = array('y' => $row['agriculture'],
						  'name' => 'Agriculture',
						  'label' => 'Agriculture',
						  'color' => '#B2E792'
						);
			array_push($dataArray, $data);
			$data = array('y' => $row['industry'],
						  'name' => 'Industry',
						  'label' => 'Industry',
						  'color' => '#FFAE5D'
						);
			array_push($dataArray, $data);
			$data = array('y' => $row['service'],
						  'name' => 'Service',
						  'label' => 'Service',
						  'color' => '#92B2E7'
						);
			array_push($dataArray, $data);
		}
		echo json_encode($dataArray, JSON_NUMERIC_CHECK);
		
	}
	