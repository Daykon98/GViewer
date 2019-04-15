<?php

require_once('DBConnection.php');

class Usuario{

    //!!!!!!!ELIMINAR TODO SOBRE ROL. DE MOMENTO FUNCIONA PERO ESTA FEO

    private $nombreUsuario;
    private $nombre;
    private $password;
    private $rol;
    private $id;

    private function __construct($nombreUsuario, $nombre, $password, $id)
    {
        $this->nombreUsuario= $nombreUsuario;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->id = $id;
    }

    private static function connect()
    {
        $conn = DBConnection::conexionBD();
        if ( $conn->connect_errno ) {
            echo "Error de conexión a la BD: (" . $conn->connect_errno . ") " . utf8_encode( $conn->connect_error);
            $conn = NULL;
        }
        else if ( ! $conn->set_charset("utf8mb4")) {
            echo "Error al configurar la codificación de la BD: (" . $conn->errno . ") " . utf8_encode( $conn->error);
            $conn = NULL;
        }
        return $conn;
    }

    public static function buscaUsuario($nombreUsuario){
        $conn = self::connect();

        $query=sprintf("SELECT * FROM users U WHERE U.username = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        if ($rs) {
            if ( $rs->num_rows > 0 ) {
                $rs->free();
                return TRUE;
            }
            else
            {
                $rs->free();
                return FALSE;
            }
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            exit();
        }
    }
     
    public function compruebaPassword($password){
        if ( ! password_verify($password, $this->password)) {
            return false;
        }
        $_SESSION['login'] = true;
        $_SESSION['nombre'] = $this->nombreUsuario;
        $_SESSION['id'] = $this->id;
        $_SESSION['esAdmin'] = strcmp($this->rol, 'admin') == 0 ? true : false;
        //header('Location: index.php');
        return true;

    }

    public static function login($nombreUsuario, $password){
        $conn = self::connect();

        $query=sprintf("SELECT * FROM users U WHERE U.username = '%s'", $conn->real_escape_string($nombreUsuario));
        $rs = $conn->query($query);
        if ($rs) {
            if ( $rs->num_rows == 0 ) {
                // No se da pistas a un posible atacante
                $rs->free();
                return FALSE;
            } else {
                $fila = $rs->fetch_assoc();
                $rs->free();
                $user = new Usuario($fila['username'], $fila['username'], $fila['password'], $fila['id']);
                return $user;
            }
        } else {
            echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
            return FALSE;
        }
    }
    public static function crea($nombreUsuario,$nombre,$password,$rol){
        $conn = self::connect();

        $query=sprintf("INSERT INTO users(username, name, password) VALUES('%s', '%s', '%s')"
                        , $conn->real_escape_string($nombreUsuario)
                        , $conn->real_escape_string($nombre)
                        , password_hash($password, PASSWORD_DEFAULT));
                if ( $conn->query($query) ) {
                    $_SESSION['login'] = true;
                    $_SESSION['nombre'] = $nombreUsuario;
                    $query2 = $conn->query("SELECT id FROM users WHERE username = '$nombreUsuario'");
                    $_SESSION['id'] = $query2->fetch_assoc()['id'];
                    return TRUE;
                } else {
                    echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                    return FALSE;
                }
    }


}