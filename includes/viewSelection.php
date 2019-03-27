
	<?php
            
    require_once('DBConnection.php');
    
    function printDatasets($id)
    {
echo '<ul class="nav nav-pills nav-fill">';

        $db = DBConnection::conexionBD();

        if($db)
        {
			$isValidId = $db->query("SELECT * FROM datasets WHERE id=$id");
			//La validación se puede hacer en otro lado seguramente, y asegurarse de siempre haber dado aquí un id válido
            if ($isValidId->num_rows == 0)
                $id = 1;

            $datasets = $db->query("SELECT * FROM datasets");
            if (!$datasets)
                echo "Error obteniendo bases de datos";
            
            while ($database = $datasets->fetch_assoc())
            {
                echo '<li class="nav-item">';
                echo '<a class="nav-link' . ($id == $database['id'] ? ' active' : '') . '" href="../index.php?id=' . $database['id'] .
                '&view=1">' . $database["name"] . '</a></li>';
            }
            echo "</ul>";
        }
    }
        

		function printViews($id, $view)
		{
			echo '<ul class="nav nav-tabs">';

			$db = DBConnection::conexionBD();
			
			if($db)
			{
				$views = $db->query("SELECT * FROM views WHERE dataset_id=$id");
				if (!$views)
					echo "Error obteniendo vistas.";
				
				while ($vista = $views->fetch_assoc())
				{
					echo '<li class="nav-item">';
					echo '<a class="nav-link' . ($view == $vista['id'] ? ' active' : '') . '" href="../index.php?id=' . $id .
					'&view=' . $vista["id"] . '">' . $vista["view_name"] . '</a></li>';
				}
				echo "</ul>";
			}
		}

		function validateView($inputId, $inputView)
		{
			$db = DBConnection::conexionBD();
				
			if (!isset($inputId))
				return array("id" => 1, "view" => 1); //$inputId = 1;
			if (!isset($inputView))
				$inputView = 1;

			$isValidId = $db->query("SELECT * FROM datasets WHERE id=$inputId");
			if (!$isValidId || $isValidId->num_rows == 0)
				$inputId = 1;

			$isValidView = $db->query("SELECT * FROM views WHERE dataset_id=$inputId AND id=$inputView");
			if (!$isValidView || $isValidView->num_rows == 0)
				$inputView = 1;


			return array("id" => $inputId, "view" => $inputView);
		}

		//$ID es un array con "id y view" ya validado por validateView
		function getHandlerRoute($ID)
		{
			$dataset = $ID["id"];
			$view = $ID["view"];

			$db = DBConnection::conexionBD();

			$query = $db->query("SELECT * FROM views WHERE dataset_id=$dataset AND id=$view");
			$row = $query->fetch_assoc();
			return $row['view_handler_name'];
		}