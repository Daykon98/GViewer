<?php

/*
	//Se usa este código para eliminar las comillas del csv y quitar las comas del gdp_per_year
	if (($handler = fopen('suicides.csv', 'r')) && ($outputHandler = fopen('suicidesPrepro.csv', 'w')))
	{
		while (!feof($handler))
		{
			$line = str_split(fgets($handler));
			$newline = '';
			$quotes = 0;
			foreach ($line as $char)
			{
				if ($char === '"')
					$quotes += 1;
				elseif ($quotes !== 3 || $char != ',')
					$newline .= $char;
				
			}
			fwrite($outputHandler, $newline);
		}
	}
*/
	if (($handler = fopen('countries of the world.csv', 'r')) && ($outputHandler = fopen('countries of the world Prepro.csv', 'w')))
	{
		while (!feof($handler))
		{
			$line = fgets($handler);
			//echo preg_replace('/\s+/', '', $line);
			$newLine = preg_replace('/\s+/', '', $line) . "\n";
			$newLine = str_split($newLine);
			$newLine2 = '';

			$quotes = 0;
			foreach ($newLine as $char)
			{
				if ($char === '"')
					$quotes += 1;
				elseif ($quotes % 2 == 1 && $char == ',')
					$newLine2 .= '.';
				else
					$newLine2 .= $char;
					
				
			}
			fwrite($outputHandler, $newLine2);
		}
	}
