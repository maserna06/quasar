<?php

namespace App\Utils;

/**
 * Guarda valores globales en un objeto estatico
 * Administra los retornos de las clases
 *
 * @author Diego Castro <ing.diegocastro@gmail.com>
 * @package cgr.components.helpers
 * @version 1.0
 */
class JsonResponse{

  /**
   * Objeto donde se guardarán los valores
   * @var \stdClass
   */
  protected $_response;

  /**
   * Nombre de la clave de error
   * @var string
   */
  protected $_errorKey='error';

  /**
   * Instancia de la clase
   * @var DResponse
   */
  private static $_instance=null;

  /**
   * Headers
   * @var Array
   */
  protected $_headers=[];

  /**
   * Constructor de la clase
   * @param string $errorKey Nombre de la clave de error, por defecto es error 
   */
  public function __construct($errorKey='error'){
    $this->_response=new \stdClass();
    if(!empty($errorKey)) $this->_errorKey=$errorKey;
    $this->addHeader('Content-type','application/json; charset=UTF-8');
  }

  /**
   * Retorna una instancia de la clase
   * @return JsonResponse
   */
  public static function getInstance(){
    if(self::$_instance === null) self::$_instance=new JsonResponse();
    return self::$_instance;
  }

  /**
   * Establece un valor para la clave Error
   * @param mixed $value Valor del error
   */
  public function error($value=true){
    if($value === false || $value === null) $this->removeError();
    else $this->set($this->_errorKey,$value);
    return $this;
  }

  /**
   * Elimina la clave Error
   */
  public function removeError(){
    unset($this->_response->{$this->_errorKey});
    return $this;
  }

  /**
   * Retorna el error
   * @return mixed
   */
  public function getError(){
    return $this->get($this->_errorKey);
  }

  /**
   * Remove all items
   * @return JsonResponse
   */
  public function clear(){
    $this->_response=new \stdClass();
    return $this;
  }

  /**
   * Establece un valor para una clave
   * @param string $key Nombre de la clave
   * @param mixed $value Valor de la clave
   * @param string $error Guarda una clave de error también
   * @return boolean si no se envia la clave retorna false, en caso contrario true
   */
  public function set($key='',$value='',$error=false){
    if(empty($key)) return false;
    $this->_response->$key=$value;
    if($error) $this->error($error);
    return $this;
  }

  /**
   * Guarda un valor en la clase
   * <pre>
   * $this->propertyName=$value;
   * $this->eventName=$callback;
   * </pre>
   * @param string $name Nombre de la propiedad
   * @param mixed $value Valor de la propiedad
   * @return Bool
   */
  public function __set($name,$value){
    return $this->set($name,$value);
  }

  /**
   * Retorna el valor de una propiedad
   * @param mixed $key Clave a devolver
   * @return mixed Valor a devolver
   */
  public function __get($key){
    return $this->get($key);
  }

  /**
   * @see DRespose::set
   */
  public function _($key='',$value='',$error=false){
    return $this->set($key,$value,$error);
  }

  /**
   * Guarda toda la información de un objeto
   * @param mixed $object Objeto que se va a guardar
   * @return boolean Si todo sale bien true, en caso contrario false
   */
  public function setObject($object=null){
    if($object === null) return false;
    $object=(object)$object;
    foreach($object as $key=> $value){
      $this->set($key,$value);
    }
    return true;
  }

  /**
   * Retorna una clave o todas las claves
   * @param string $key Clave que desea retornar, si la clave no existe retorna false. Si la clave es vacia o null retorna todas las claves
   * @return boolean
   */
  public function get($key=null){
    if($key === null || empty($key)) return $this->_response;
    else if(isset($this->_response->$key)) return $this->_response->$key;
    return false;
  }

  /**
   * Agrega un encabezado
   * @param type $header
   * @param type $value
   * @return JsonResponse
   */
  public function addHeader($header,$value){
    $this->_headers[$header]=$value;
    return $this;
  }

  private function putsHeaders(){
    $stringHeaders='';
    if(count($this->_headers)){
      foreach($this->_headers as $header=> $value){
        $stringHeaders.=$header.': '.$value.' ';
      }
    }
    header($stringHeaders);
  }

  /**
   * Send a http status in headers
   * @param integer $statusCode Http Code. 200 is default
   * @return JsonResponse
   */
  public function code($statusCode=200){
    if($statusCode && is_int($statusCode)){
      HttpHelper::sendResponse($statusCode);
    }
    return $this;
  }

  /**
   * Devuelve las claves como una cadena json
   * @param boolean $end Indica si termina la ejecución del script actual
   * @param integer $statusCode Código http para la salida, por defecto es 200
   * @return mixed Claves y valores
   */
  public function output($end=true,$statusCode=null){
    if($end){
      if($statusCode && is_int($statusCode)){
        HttpHelper::sendResponse($statusCode);
      }
      $this->putsHeaders();
      echo json_encode($this->_response);
      exit(0);
    }else{
      return json_encode($this->_response);
    }
  }

}
