<?php
require_once('Form.php');
require_once('usuario.php');

class FormRegistro extends Form{
    public function __construct()
    {
        parent::__construct('registro', array('action' => 'registro.php'));
    }

    protected function generaCamposFormulario($datosIniciales)
    {
        $html = '<fieldset>
                <legend>Sign In</legend>
                <div class="form-group">
                    <label>Username:</label> <input type="text" class="form-control" name="nombreUsuario" placeholder="Username" />
                </div>
                <div class="form-group">
                    <label>Full name:</label> <input type="text" class="form-control" name="nombre" placeholder="Full Name" />
                </div>
                <div class="form-group">
                    <label>Password:</label> <input  type="password" class="form-control" name="password" placeholder="Password" />
                </div>
                <div class="form-group"><label>Input your password again:</label> <input class="form-control" type="password" name="password2" placeholder="Password" /><br /></div>
                <div class="form-group"><button type="submit" class="btn btn-outline-success" name="registro">Sign In</button></div>
                </fieldset>';
        return $html;
    }

    protected function procesaFormulario($datos)
    {   
        $erroresFormulario = array();
        
        $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null;
        
        if ( empty($nombreUsuario) || mb_strlen($nombreUsuario) < 5 ) {
            $erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $nombre = isset($datos['nombre']) ? $datos['nombre'] : null;
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $erroresFormulario[] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) || mb_strlen($password) < 5 ) {
            $erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
        }
        $password2 = isset($datos['password2']) ? $datos['password2'] : null;
        if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
            $erroresFormulario[] = "Los passwords deben coincidir";
        }
        
        if (count($erroresFormulario) === 0) {
        
            if (Usuario::buscaUsuario($nombreUsuario))
                $erroresFormulario[] = "El usuario ya existe";
            else
            {
                if (Usuario::crea($nombreUsuario,$nombre,$password,'user'))
                    return 'index.php';
            }
        }
        return $erroresFormulario;
    }
}   