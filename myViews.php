<?php

require("includes/config.php");
require("includes/DBConnection.php");


?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>My views</title>
    <script src="js/myViews.js"></script>
    <?php require_once('includes/comun/bootstrap.php'); ?>
</head>

<body>

<div id="content">

<?php

	require_once('includes/comun/cabecera.php');
    echo "<div class='container'>";
	echo "<div class='row'>";
	echo "<div class='col-12 '>";
    if (isset($_SESSION['login']) && $_SESSION['login'] = true)
    {
        $user_id = $_SESSION['id'];
        $db = DBConnection::conexionBD();
        if ($db)
        {
            $savedDatasets = $db->query("SELECT DISTINCT V.dataset_id AS 'id', D.name AS 'name', D.description AS 'description'
                                        FROM user_views U JOIN views V ON (U.view_id = V.id AND U.dataset_id = V.dataset_id) JOIN
                                        datasets D ON V.dataset_id = D.id
                                        WHERE U.user_id=$user_id
                                        ORDER BY V.dataset_id;");
            if(!$savedDatasets || $savedDatasets->num_rows == 0)
            {
                echo $db->error;
                echo "<h1 class='d-flex justify-content-center error'>No hay vistas guardadas.</h2>";
            }
            else 
            {
                echo '<div class="list-group list-group-custom">';
                while ($dataset = $savedDatasets->fetch_assoc())
                {
                    $dataset_id = $dataset['id'];
                    $dataset_name = $dataset['name'];
                    echo "<button type='button' class='list-group-item list-group-item-action' 
                        data-toggle='collapse' data-target='#dset$dataset_id' aria-expanded='false' aria-controls='dset$dataset_id'>$dataset_name</button>";
                    echo "<div class='collapse' id='dset$dataset_id'>";
                    $savedViews = $db->query("SELECT U.id AS 'id', V.id AS 'vid', V.dataset_id AS 'did', V.view_name AS 'name', U.data AS 'data'
                                              FROM user_views U JOIN views V ON (U.view_id = V.id AND U.dataset_id = V.dataset_id) WHERE U.user_id=$user_id
                                              AND V.dataset_id=$dataset_id
                                              ORDER BY V.id ASC, U.id DESC;");
                    if (!$savedViews)
                    {
                        echo $db->error;
                    }
                    else 
                    {
                        //Estas dos variables se utilizan para cambiar los colores por cada tipo de vista distinto
                        $last_view_name = "";
                        $markup = true;
                        while($view = $savedViews->fetch_assoc())
                        {
                            $user_view_id = $view['id'];
                            $view_id = $view['vid'];
                            $view_dataset_id = $view['did'];
                            $view_name = $view['name'];
                            $view_data = $view['data'];
                            //Para embellecer
                            $markup = $last_view_name == $view_name ? $markup : !$markup;
                            $last_view_name = $view_name;
                            $decodedData = json_decode($view_data);
                            $values = "";
                            $first = true;
                            foreach ($decodedData as $key => $value)
                            {
                                $key = ucfirst($key);
                                if (!$first)
                                {
                                    $values .= ", ";
                                }
                                $values .= "<strong>$key</strong>: $value";
                                $first = false;
                            }
                            $view_data = str_replace('"', "&quot;", $view_data);
                            //tratar view data
                            //mandar por post, como si fuera un form. Puede que sea un form
                            echo "<div id='$user_view_id'>";

                            echo "<div class='row'>";
                            
                            echo "<div class='col-xl-11 col-lg-11 col-md-10 col-sm-9 col-xs-8 noPaddingRight' style='padding-right: 0px;'>";
                            echo "<form method='POST' action='index.php?id=$view_dataset_id&view=$view_id'>";                            
                            echo "<input type='hidden' name='data' value='" . $view_data. "'></input>";
                            echo "<button type='submit' class='list-group-item list-group-item-action list-bg" . ($markup ? "-alt" : "") . "' 
                            id='usrv$user_view_id'><h4>$view_name:</h4> $values
                            </button>";
                            echo "</div>";
                            echo "</form>";

                            echo "<div class='col-xl-1 col-lg-1 col-md-2 col-sm-3 col-xs-4 noPaddingLeft'>";
                            echo "<button class='list-group-item list-bg". ($markup ? "-alt" : "") . 
                            " deleteButton' onclick='deleteView($user_view_id)'>Borrar</button>"; 
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            
                        }
                    }
                    echo "</div>";


                }
                echo "</div>";
            }
                                        
            
        }

    }
    else
    {
        echo "<h1 class='d-flex justify-content-center error'>Debes estar logueado para ver en esta página</h1>";
    }
    echo "</div></div></div>";
    
	require_once('includes/comun/footer.php');
?>


</div>

</body>
</html>