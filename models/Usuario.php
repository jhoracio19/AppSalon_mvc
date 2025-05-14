<?php 

namespace Model;

class Usuario  extends ActiveRecord{
    // Base de datos
    protected static $tabla = "usuarios";
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre; 
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this -> id = $args['id'] ?? null;
        $this -> nombre = $args['nombre'] ?? '';
        $this -> apellido = $args['apellido'] ?? '';
        $this -> email = $args['email'] ?? '';
        $this -> password = $args['password'] ?? '';
        $this -> telefono = $args['telefono'] ?? '';
        $this -> admin = $args['admin'] ?? '0';
        $this -> confirmado = $args['confirmado'] ?? '0';
        $this -> token = $args['token'] ?? '';
    }

    //Mensajes de Validacion para la creacion de una cuenta
    public function validarNuevaCuenta() {
    if (!$this->nombre) {
        self::$alertas['error'][] = 'El Nombre es Obligatorio';
    }
    if (!$this->apellido) {
        self::$alertas['error'][] = 'El Apellido es Obligatorio';
    }
    if (!$this->telefono) {
        self::$alertas['error'][] = 'El Teléfono es Obligatorio';
    } else if (strlen($this->telefono) !== 10) {
        self::$alertas['error'][] = 'El Teléfono debe tener exactamente 10 dígitos';
    } else if (!ctype_digit($this->telefono)) {
        self::$alertas['error'][] = 'El Teléfono solo debe contener números';
    }
if (!$this->email) {
    self::$alertas['error'][] = 'El Email es Obligatorio';
} else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
    self::$alertas['error'][] = 'El Email no tiene un formato válido';
} else {
    // Obtener el dominio del correo
    $dominioPermitido = ['gmail.com', 'hotmail.com', 'outlook.com'];
    $partesCorreo = explode('@', $this->email);
    
    if (count($partesCorreo) !== 2 || !in_array(strtolower($partesCorreo[1]), $dominioPermitido)) {
        self::$alertas['error'][] = 'Solo se permiten correos de Gmail, Hotmail u Outlook';
    }
}

    if (!$this->password) {
        self::$alertas['error'][] = 'El Password es Obligatorio';
    } else if (strlen($this->password) < 6) {
        self::$alertas['error'][] = 'El Password debe ser de al menos 6 caracteres';
    }

    return self::$alertas;
}


public function validarLogin(){
    if(!$this->email){
        self::$alertas['error'][] = 'El Email es Obligatorio';
    } else {
        // Validar que el correo tenga un formato válido
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El formato del Email no es válido';
        } else {
            // Extraer dominio del correo
            $dominio = substr(strrchr($this->email, "@"), 1);
            
            // Lista de dominios permitidos
            $dominiosPermitidos = ['gmail.com', 'hotmail.com', 'outlook.com', 'live.com', 'hotmail.es', 'outlook.es'];
            
            // Verificar si el dominio está en la lista de permitidos
            if(!in_array($dominio, $dominiosPermitidos)) {
                self::$alertas['error'][] = 'El Email debe ser de tipo Gmail, Hotmail u Outlook';
            }
        }
    }
    
    if(!$this->password){
        self::$alertas['error'][] = 'El Password es Obligatorio';
    }

    return self::$alertas;
}

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El Email es Obligatorio o El Formato es Inválido';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this -> password){
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this -> password) < 6){
            self::$alertas['error'][] = 'El Password debe ser de al menos 6 caracteres';
        }

        return self::$alertas;
    }

    //Verificar si un usuario ya existe
    public function existeUsuario(){
        $querry = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($querry);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;

    }

    public function hashPassword(){
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken(){
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {

        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this -> confirmado){
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }
}