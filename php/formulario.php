<?php
echo '<pre>';
/**
* Clase Formulario
* (donde nace hace la magia).
*/
class Formulario
{
	// 
	private $_request = [];
	private $_reglas  = [];
	private $_estado  = [];
	private $_nombre_campo;
	private $_mensaje = [];
	private $_campo_estado = [];
	
	public function __construct($_request, $_reglas, $_campo_estado) {
		$this->_request[] 		= $_request;
		$this->_reglas[]  		= $_reglas;
		$this->_campo_estado[] 	= $_campo_estado; 
	}
	// 
	public function campo($_nombre_campo) {
		$this->_nombre_campo 	= $_nombre_campo;
		$this->validarCampo();
	}

	// 
	public function validarCampo() {
		$nombre_campo = $this->_request[0][$this->_nombre_campo];
		if (isset($nombre_campo)) 
		{	
			foreach ($this->_reglas[0][$this->_nombre_campo] as $regla) 
			{
				switch ($regla) 
				{
			 		case 'text-con-numeros':
		 				$patron = '/^[a-zA-Z0-9\_\-]{4,16}$/';
			 			if (!preg_match($patron, $nombre_campo)) 
			 	    		$this->_mensaje[] = 'El campo requiere solo texto y números  '.$nombre_campo.'';
			 	    	else{
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
			 	    	}
					break;
					case 'text':
		 				$patron = '/^[a-zA-ZÀ-ÿ\s]{1,40}$/';
			 			if (!preg_match($patron, $nombre_campo)) 
			 	    		$this->_mensaje[] = 'El campo requiere solo texto '.$nombre_campo.'';
			 	    	else
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
					break;
					case 'required':
						if ($nombre_campo == "") 
			 	    		$this->_mensaje[] = 'es requerido '.$nombre_campo.'';
			 	    	else
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
					break;
					case 'password':
						if ($nombre_campo == "") 
							$this->_mensaje[] = 'es nombre '.$nombre_campo.'';
						else
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
					break;
					case 'number':
						if ($nombre_campo == "") 
			 	    		$this->_mensaje[] = 'es number '.$nombre_campo.'';
			 	    	else
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
					break;
					case 'radio':
						if ($nombre_campo == "") 
							$this->_mensaje[] = 'El campo requiere solo radio '.$nombre_campo.'';
						else
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
					break;
					case 'email':
						$patron = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
						if (!preg_match($patron, $nombre_campo)) 
			 	    		$this->_mensaje[] = 'El campo email requiere  '.$nombre_campo.'';
			 	    	else
			 	    		$this->_campo_estado[0][$this->_nombre_campo] = true;
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
		// verifico que todos los request sean true
		if (!array_search(false, $this->_campo_estado[0]) ) 
		{
			echo 'OK';
			// query
		}
		else
		{
			echo 'NO';
			// mnsj error
			var_dump($this->_campo_estado);	
			var_dump($this->_mensaje);
		}
	}
}

// 
$campoEstado = [
	'usuario' 	=> false,
	'nombre' 	=> false,
	'password' 	=> false,
	'password2' => false,
	'correo' 	=> false,
	'telefono' 	=> false,
	'terminos' 	=> false

];
// 
$valores = [  
  'usuario' 	=> ['text-con-numeros', 'required'],
  'nombre' 		=> ['text', 'required'],
  'password' 	=> ['text-con-numeros', 'required'],
  'password2'   => ['text-con-numeros', 'required'],
  'correo' 		=> ['email', 'required'],
  'telefono' 	=> ['number', 'required'],
  'terminos'    => ['radio', 'required']
];
// 
$form = new Formulario($_REQUEST, $valores, $campoEstado);
	$form->campo('usuario');
	$form->campo('nombre');
	$form->campo('password');
	$form->campo('password2');
	$form->campo('correo');
	$form->campo('telefono');
	$form->campo('terminos');
$form->imprime();

