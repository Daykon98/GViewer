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
                <div class="grupo-control">
                    <label>Nombre de usuario:</label> <input class="control" type="text" name="nombreUsuario" />
                </div>
                <div class="grupo-control">
                    <label>Nombre completo:</label> <input class="control" type="text" name="nombre" />
                </div>
                <div class="grupo-control">
                    <label>Password:</label> <input class="control" type="password" name="password" />
                </div>
                <div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>
                <div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
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