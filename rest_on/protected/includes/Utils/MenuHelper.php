<?php

namespace App\Utils;

/*
 *  Created by Diego Castro <diego.castro@knowbi.com>
 */

/**
 * Descripción de la clase MenuHelper
 *
 * @author Diego Castro <diego.castro@knowbi.com>
 * @copyright (c) 2016, Diego Castro
 * @version 1.0
 */
class MenuHelper{

  /**
   * Current Controller Id
   * @var string
   */
  private static $_controllerId = null;

  /**
   * Current Action id
   * @var string
   */
  private static $_actionId = null;

  /**
   * Active css class
   * @var string
   */
  private static $_activeClass = 'active';

  /**
   * Menu open class
   * @var string
   */
  private static $_openClass = 'menu-open';

  /**
   * return active class if the condition is true
   * @param string $url
   */
  public static function isActive($url){
//    if(is_string($url)){
    if($url == '/' && self::$_controllerId == 'site' && self::$_actionId == 'index')
        return self::$_activeClass;
    $parts = explode('/',$url);
    if(count($parts) == 2)
        return $url == '/'.self::$_controllerId?self::$_activeClass:'';
    else
        return $url == '/'.self::$_controllerId.'/'.self::$_actionId?self::$_activeClass:'';
//    }else if(is_array($url)){
//      return in_array(self::$_controllerId,$url)?self::$_activeClass:'';
//    }
    return '';
//    return $url=='/'.self::$_controllerId.(self::$_actionId?'/'.self::$_actionId:'')?self::$_activeClass:'';
  }

  /**
   * Detect if current menu will be open
   * @param array $controllers
   */
  public static function isOpen($controllers){
    return in_array(self::$_controllerId,$controllers)?self::$_openClass:'';
  }

  private static function _processChildItems($items){
    $parentActive = false;
    if(count($items)){
      foreach($items as &$item){
        if(isset($item['url'][0])){
          $itemClass = isset($item['itemOptions']['class'])?$item['itemOptions']['class']:'';
          $itemOptions = isset($item['itemOptions'])?$item['itemOptions']:[];
          $active = self::isActive($item['url'][0]);
          $itemClass = empty($itemClass)?$active:$itemClass.' '.$active;
          if($active){
            if(!$parentActive) $parentActive = $active;
            $item['itemOptions'] = array_merge($itemOptions,['class'=>$itemClass]);
          }
        }
      }
    }
    return ['items'=>$items,'active'=>$parentActive];
  }

  /**
   * Process CMenu Items
   * @param array $items
   * @return array
   */
  public static function processItems($items){
    if(count($items)){
      foreach($items as &$item){
        $active = false;
        $itemExtraOptions = [];
        if(isset($item['items'])){
          $parsedItems = self::_processChildItems($item['items']);
          $item['items'] = $parsedItems['items'];
          $active = $parsedItems['active'];
          $itemExtraOptions['submenuOptions'] = [
            'class'=>isset($item['submenuOptions']['class'])?$item['submenuOptions']['class'].' '.$active:$active,
            'style'=>'display:'.($active?'block':'none'),
          ];
        }else{
          if(isset($item['url'][0])){
            $active = self::isActive($item['url'][0]);
          }
        }
        $itemExtraOptions['itemOptions'] = [
          'class'=>isset($item['itemOptions']['class'])?$item['itemOptions']['class'].' '.$active:$active,
        ];

        $item = \CMap::mergeArray($item,$itemExtraOptions);
//        echo '<pre>Extra:'.print_r($itemExtraOptions,1).'</pre>';
//        echo 'Active:'.$active.', '.$item['url'][0].', '.self::$_controllerId.', '.self::$_actionId.PHP_EOL;
//        echo '<pre>ITEM:'.print_r($item,1).'</pre>';
//        exit;
      }
    }
    return $items;
  }

  /**
   * Set Controller id
   * @param string $controllerId
   */
  public static function setControllerId($controllerId){
    self::$_controllerId = $controllerId;
  }

  /**
   * Set Action id
   * @param string $actionId
   */
  public static function setActionId($actionId){
    self::$_actionId = $actionId;
  }

  /**
   * Set Active Class
   * @param string $class
   */
  public static function setActiveClass($class){
    self::$_activeClass = $class;
  }

  /**
   * Set Open Class
   * @param string $class
   */
  public static function setOpenClass($class){
    self::$_openClass = $class;
  }

}
