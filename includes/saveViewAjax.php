<?php
    require_once(dirname(__FILE__) . './config.php');   
    require_once(dirname(__FILE__) . './DBConnection.php');

	$db = DBConnection::conexionBD();

    $json = file_get_contents('php://input');
    $jsonDecoded = json_decode($json,TRUE);
    $view =  $jsonDecoded['view'];
    $dataset_id = $jsonDecoded['dataset'];
    $data = $jsonDecoded['data'];
    if (isset($_SESSION['login']) && $_SESSION['login'] == true)
    {
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        if ($db && $user_id != null)
        {
            if (!$db->query("INSERT INTO user_views (view_id, dataset_id, user_id, data) VALUES ($view, $dataset_id, $user_id, '$data');"))
                echo "Error insertando en BD";
            echo "ok";
        }
        else
            echo "Error de base de datos o usuario no dado";
    }
    else echo "No hay sesión iniciada.";

    



    