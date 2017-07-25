<?php
namespace App\Utils;
/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */

/**
 * Purifier
 *
 * @author Diego Castro <ing.diegocastro@gmail.com>
 * @copyright (c) 2016, Diego Castro
 * @version 1.0
 */
class Purifier extends \CApplicationComponent {

    protected $parser = null;
    private static $_instance = null;
    
    /**
     * Purifier instance
     * @return Purifier
     */
    public static function getInstance(){
      if(!self::$_instance) self::$_instance=new Purifier();
      return self::$_instance;
    }

    public function __construct() {
        $this->parser = new \CHtmlPurifier();
    }
    /**
     * Purifica el texto como texto plano
     * @param mixed $data Datos a purificar
     * @return $mixed Datos purificados
     */
    public function purify($data){
      $this->parser->options=array(
        'HTML.Allowed'=>'',
      );
      return $this->_purify($data);
    }
    /**
     * Purifica los datos como html
     * @param mixed $data Datos a purificar
     * @return mixed Datos purificados
     */
    public function purifyHtml($data){
      $this->parser->options=array();
      return $this->_purify($data);
    }
    /**
     * Purifica el texto como html con algunos tags permitidos
     * @param mixed $data Datos a purificar
     * @return $mixed Datos purificados
     */
    public function purifyCustomHtml($data){
      $this->parser->options=array(
        'HTML.Allowed'=>'br,a[href]',
      );
      return $this->_purify($data);
    }
    /**
     * Purifica unos datos
     * @param mixed $data Datos a purificar
     * @return mixed
     */
    private function _purify($data) {
        if (isset($data) and is_array($data)) {
            $data = $this->purifyArray($data);
        } elseif (isset($data) and !is_array($data)) {
            $data = $this->parser->purify(trim($data));
        }
        return $data;
    }
    /**
     * Purifica un array
     * @param array $request_data Datos a purificar
     * @return $array Datos purificados
     */
    private function purifyArray(array $request_data) {
        foreach ($request_data as $key => $value) {
            if (isset($value) and is_array($value)) {
                $request_data[$key] = $this->purifyArray($value);
            } elseif (isset($value)) {
                $request_data[$key] = $this->parser->purify(\CHtml::decode(trim($value)));
            }
        }
        return $request_data;
    }

}