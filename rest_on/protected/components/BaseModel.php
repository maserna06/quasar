<?php
use App\User\User as U;
/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */

/**
 * Base Model
 *
 * @author Diego Castro <ing.diegocastro@gmail.com>
 * @copyright (c) 2016, Diego Castro
 * @version 1.0
 */
class BaseModel extends CActiveRecord{
  /**
   * Current User
   * @var U
   */
  public $user=null;
  
  public function __construct($scenario='insert'){
    $this->user=U::getInstance();
    parent::__construct($scenario);
  }

  public function beforeValidate(){
    if($this->scenario== 'insert'){
      if($this->hasAttribute('created_by')){
        $this->created_by=Yii::app()->user->id;
      }
      if($this->hasAttribute('created_at')){
        $this->created_at=date('Y-m-d H:i:s');
      }
    }else if($this->scenario== 'update'){
      if($this->hasAttribute('updated_by')){
        $this->updated_by=Yii::app()->user->id;
      }
      if($this->hasAttribute('updated_at')){
        $this->updated_at=date('Y-m-d H:i:s');
      }
    }
    if($this->hasAttribute('ip')){
      $this->ip=sprintf('%u',ip2long(Yii::app()->request->userHostAddress));
    }
    return parent::beforeValidate();
  }

}
