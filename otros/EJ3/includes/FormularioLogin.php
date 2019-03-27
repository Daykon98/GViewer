<?php
require_once('Form.php');
require_once('usuario.php');

class FormLogin extends Form{
    public function __construct()
    {
        parent::__construct('login', array('action' => 'login.php'));
    }

    protected function generaCamposFormulario($datosIniciales)
    {
        $html = '<fieldset>
                    <legend>Usuario y contraseña</legend>
                        <div class="grupo-control">
                            <label>Nombre de usuario:</label> <input type="text" name="nombreUsuario" />
                        </div>
                        <div class="grupo-control">
                            <label>Password:</label> <input type="password" name="password" />
                        </div>
                    <div class="grupo-control"><button type="submit" name="login">Entrar</button></div>
                </fieldset>';
        return $html;
    }

    protected function procesaFormulario($datos)
    {   
        //Procesa los datos
        $erroresFormulario = array();

        $nombreUsuario = isset($datos['nombreUsuario']) ? $datos['nombreUsuario'] : null;

        if ( empty($nombreUsuario) ) {
            $erroresFormulario[] = "El nombre de usuario no puede estar vacío";
        }

        $password = isset($datos['password']) ? $datos['password'] : null;
        if ( empty($password) ) {
            $erroresFormulario[] = "El password no puede estar vacío.";
        }

        if (count($erroresFormulario) === 0) {
            if ($usuario = Usuario::login($nombreUsuario, $password))
            {
                if ($usuario->compruebaPassword($password))
                    return "index.php";
                else
                    $erroresFormulario[] = "El usuario o el password no coinciden";
            }
            else
                $erroresFormulario[] = "El usuario o el password no coinciden";
            
        
        }

        return $erroresFormulario;
    }
}   