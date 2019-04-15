<?php
    require_once(dirname(__FILE__) . '/config.php');   
    require_once(dirname(__FILE__) . '/DBConnection.php');

	$db = DBConnection::conexionBD();

    $user_view_id = isset($_POST['view_id']) ? $_POST['view_id'] : null;

    if (isset($_SESSION['login']) && $_SESSION['login'] == true && !empty($user_view_id))
    {
        $users = $db->query("SELECT user_id FROM user_views WHERE id = $user_view_id");
        if (!$users) { echo "Erro en consulta"; exit; }

        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        if ($db && $user_id != null && $users->num_rows > 0 && $users->fetch_assoc()['user_id'] == $user_id)
        {
            if (!$db->query("DELETE FROM user_views WHERE id = $user_view_id;"))
                echo $db->error;//"Error borrando la vista";
            else
                echo "ok";
        }
        else
            echo "Error de base de datos o usuario no dado";
    }
    else echo "No hay sesión iniciada.";


    


    