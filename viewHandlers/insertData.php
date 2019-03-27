<?php
    require('../includes/DBConnection.php');

    function insert_suicides(){
        $db = DBConnection::conexionBD();
        
		if ($db)
		{
			$db->autocommit(FALSE);
			$row = 0;
			if ($handler = fopen("../suicidesPrepro.csv", "r"))
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
						if (!$db->query($sql))
							echo $db->error . '<br>';
					}
					$row++;
					
				}
			}
			
			$db->query("COMMIT");

			DBConnection::shutdown();

		}
	}
    
    function insert_countries(){
        $db = DBConnection::conexionBD();
        
		if ($db)
		{
			$db->autocommit(FALSE);
			$row = 0;
			if ($handler = fopen("../countries of the world Prepro.csv", "r"))
			{
				while ($data = fgetcsv($handler,','))
				{ 
					$country = $data[0];
                    $region = $data[1];
                    $population = $data[2] != '' ? $data[2] : 'NULL';
                    $area = $data[3] != '' ? $data[3] : 'NULL';
                    $pop_density = $data[4] != '' ? $data[4] : 'NULL';
                    $coastline = $data[5] != '' ? $data[5] : 'NULL';
                    $net_migration = $data[6] != '' ? $data[6] : 'NULL';
                    $infant_mortality = $data[7] != '' ? $data[7] : 'NULL';
                    $GDP = $data[8] != '' ? $data[8] : 'NULL';
                    $literacy = $data[9] != '' ? $data[9] : 'NULL';
                    $phones = $data[10] != '' ? $data[10] : 'NULL';
                    $arable = $data[11] != '' ? $data[11] : 'NULL';
                    $crops = $data[12] != '' ? $data[12] : 'NULL';
                    $other = $data[13] != '' ? $data[13] : 'NULL';
                    $climate = $data[14] != '' ? $data[14] : 'NULL';
                    $birthrate = $data[15] != '' ? $data[15] : 'NULL';
                    $deathrate = $data[16] != '' ? $data[16] : 'NULL';
                    $agriculture = $data[17] != '' ? $data[17] : 'NULL';
                    $industry = $data[18] != '' ? $data[18] : 'NULL';
                    $service = $data[19] != '' ? $data[19] : 'NULL';

						
					$sql = "INSERT INTO countries_table(country, region, population, area, pop_density, coastline, net_migration, 
                                infant_mortality, GDP, literacy, phones, arable, crops, other, climate, birthrate, deathrate, agriculture, industry, service) 
                                VALUES ('$country', '$region', $population, $area, $pop_density, $coastline, $net_migration, 
                                $infant_mortality, $GDP, $literacy, $phones, $arable, $crops, $other, $climate, $birthrate, $deathrate, $agriculture, $industry, $service);";
					if (!$db->query($sql))
						echo $db->error . '<br>' . $row . '<br>';
					
					$row++;
                }
				
			}
			
			$db->query("COMMIT");

			DBConnection::shutdown();

		}
    }
    
    //insert_suicides();
    //insert_countries();