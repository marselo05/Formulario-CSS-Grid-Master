<?php

echo '<pre>';

function elementos(string $elemento, string $us): array
{
    return [
        'nombre'        => "nombre de $us",
        'ap_paterno'    => "apellido paterno",
        'ap_materno'    => "apellido materno",
        'alias'         => "alias del usuario",
        'email'         => "correo electronico",
        'nivel_acceso'  => "nivel de acceso",
        'sexo'          => "sexo",
        'edad'          => "edad",
    ];
}

// var_dump(elementos("nombre", 'user'));
// Read POST data
// $data = json_decode(file_get_contents("h"));
// exit();
// var_dump($_REQUEST);
// echo '<br>';


$expresiones = [
	'usuario' => '/^[a-zA-Z0-9\_\-]{4,16}$/', // Letras, numeros, guion y guion_bajo
	'nombre' => '/^[a-zA-ZÀ-ÿ\s]{1,40}$/', // Letras y espacios, pueden llevar acentos.
	'password' => '/^.{4,12}$/', // 4 a 12 digitos.
	'correo' => '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
	'telefono' => '/^\d{7,14}$/', // 7 a 14 numeros.
];
// var_dump($expresiones);
// echo '<br>';
$campoEstado = [
	'usuario' 	=> false,
	'nombre' 	=> false,
	'password' 	=> false,
	'password2' => false,
	'correo' 	=> false,
	'telefono' 	=> false,
	'terminos' 	=> false

];
// var_dump($campos);
$valores = [  
  'usuario' 	=> ['text', 'required'],
  'nombre' 		=> ['text', 'required'],
  'password' 	=> ['text-con-numeros', 'required'],
  'password2'   => ['text-con-numeros', 'required'],
  'correo' 		=> ['email', 'required'],
  'telefono' 	=> ['number', 'required'],
  'terminos'    => ['radio', 'required']
];
// 
// $usuario 	= validarCampos($valores["usuario"], $_REQUEST['usuario']);
// $nombre  	= validarCampos($valores["nombre"], $_REQUEST['nombre']);
// $password  	= validarCampos($valores["password"], $_REQUEST['password']);
// $password2 	= validarCampos($valores["password2"], $_REQUEST['password2']);
// $correo  	= validarCampos($valores["correo"], $_REQUEST['correo']);
// $telefono  	= validarCampos($valores["telefono"], $_REQUEST['telefono']);
// $terminos  	= validarCampos($valores["terminos"], $_REQUEST['terminos']);
// 

/**
* 
*/
class Formulario
{
	// 
	private $_request = [];
	private $_reglas  = [];
	private $_estado  = [];
	private $_nombre_campo;
	private $_mensaje = [];
	// 
	public function __construct($_request, $_reglas) {
		$this->_request[] = $_request;
		$this->_reglas[]  = $_reglas;
	}
	// 
	public function campo($_nombre_campo) {
		$this->_nombre_campo = $_nombre_campo;
		$this->validarCampo();
	}

	// 
	public function validarCampo() {
		// var_dump( $this->_nombre_campo );
		
		$nombre_campo = $this->_request[0][$this->_nombre_campo];
		echo $nombre_campo;
		if (isset($nombre_campo)) 
		{	
			// var_dump($this->_reglas[0][$this->_nombre_campo]);
			// exit();
			// $mensaje=[];
			foreach ($this->_reglas[0][$this->_nombre_campo] as $regla) 
			{
				// $mensaje = $valores[$valor];
				switch ($regla) 
				{
			 		case 'text-con-numeros':
		 				$patron = '/^[a-zA-Z0-9\_\-]{4,16}$/';
			 			if (!preg_match($patron, $nombre_campo)) 
			 	    		$this->_mensaje[] = 'El campo requiere solo texto y números  '.$nombre_campo.'';
					break;
					case 'text':
		 				$patron = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
			 			if (!preg_match($patron, $nombre_campo)) 
			 	    		$this->_mensaje[] = 'El campo requiere solo texto '.$nombre_campo.'';
					break;
					case 'required':
						if ($nombre_campo == "") 
			 	    		$this->_mensaje[] = 'es requerido '.$nombre_campo.'';
					break;
					case 'password':
						$this->_mensaje[] = 'es nombre '.$nombre_campo.'';
					break;
					case 'number':
						if ($nombre_campo == "") 
			 	    		$this->_mensaje[] = 'es number '.$nombre_campo.'';
					break;
					case 'radio':
						if ($nombre_campo == "") 
							$this->_mensaje[] = 'El campo requiere solo radio '.$nombre_campo.'';
					break;
					case 'email':
						$patron = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
						if (!preg_match($patron, $nombre_campo)) 
			 	    		$this->_mensaje[] = 'El campo email requiere  '.$nombre_campo.'';
					break;
					default:
						$this->_mensaje[] = 'no se encontro campo para validar';
					break;
				}
			}	
		}
		else
			$this->_mensaje[] = "El registro nombre no existe";
		return  $this->_mensaje;
	}

	public function imprime() {
		var_dump($this->_mensaje);
	}
}

$form = new Formulario($_REQUEST, $valores);
$form->campo('usuario');
// var_dump($form->validarCampo());
$form->campo('nombre');
// $form->validarCampo();
$form->imprime();

exit();
// echo count($usuario);
if (count($usuario) === 0) 
	$campoEstado['usuario'] = true;
else
	var_dump($usuario);

if (count($nombre) === 0) 
	$campoEstado['nombre'] = true;
else
	var_dump($nombre);

if (count($password) === 0) 
	$campoEstado['password'] = true;
else
	var_dump($password);

if (count($password2) === 0) 
	$campoEstado['password2'] = true;
else
	var_dump($password2);

if (count($correo) === 0) 
	$campoEstado['correo'] = true;
else
	var_dump($correo);

if (count($telefono) === 0) 
	$campoEstado['telefono'] = true;
else
	var_dump($telefono);

if (count($terminos) === 0) 
	$campoEstado['terminos'] = true;
else
	var_dump($terminos);

// var_dump($campoEstado);

if (!array_search(false, $campoEstado) ) 
{
	echo 'OK';
}

// Casos
function validarCampos($valores, $campos)
{
	$mensaje = [];
	if (isset($valores)) 
	{	
		foreach ($valores as $valor) 
		{
			// $mensaje = $valores[$valor];
			switch ($valor) 
			{
		 		case 'text-con-numeros':
	 				$patron = '/^[a-zA-Z0-9\_\-]{4,16}$/';
		 			if (!preg_match($patron, $campos)) 
		 	    		$mensaje[] = 'El campo requiere solo texto y números  '.$campos.'';
				break;
				case 'text':
	 				$patron = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
		 			if (!preg_match($patron, $campos)) 
		 	    		$mensaje[] = 'El campo requiere solo texto '.$campos.'';
				break;
				case 'required':
					if ($campos == "") 
		 	    		$mensaje[] = 'es requerido '.$campos.'';
				break;
				case 'password':
					$mensaje[] = 'es nombre '.$campos.'';
				break;
				case 'number':
					if ($campos == "") 
		 	    		$mensaje[] = 'es number '.$campos.'';
				break;
				case 'radio':
					if ($campos == "") 
						$mensaje[] = 'El campo requiere solo radio '.$campos.'';
				break;
				case 'email':
					$patron = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
					if (!preg_match($patron, $campos)) 
		 	    		$mensaje[] = 'El campo email requiere  '.$campos.'';
				break;
				default:
					$mensaje[] = 'no es ninguno '.$campos.'';
				break;
			}
		}	
	}
	else
		$mensaje = "El registro nombre no existe";
	return  $mensaje;
}

