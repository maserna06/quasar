<?php
namespace App\User;
/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */

/**
 * User's Roles management
 *
 * @author Diego Castro <ing.diegocastro@gmail.com>
 * @copyright (c) 2016, Diego Castro
 * @version 1.0
 * 
 * @property boolean $isSuper Current user has super admin role?
 * @property boolean $isAdmin Current user has admin role?
 * @property boolean $isSupervisor Current user has supervisor role?
 * @property boolean $isContable Current user has contable role?
 * @property boolean $isVendor Current user has vendor role?
 * @property integer $companyId User's Company id
 * @property \CWebUser $me Current user
 * @property string $sidebarState Current sidebar's state
 */
class User extends \CWebUser{
  /**
   * Collapsed sidebar
   */
  const SIDEBAR_COLLAPSED='sidebar-collapse';
  /**
   * Current instance
   * @var User
   */
  private static $_instance=null;
  /**
   * Current User
   * @var \CWebUser
   */
  private $_user=null;
  /**
   * Is Super?
   * @var boolean
   */
  private $_isSuper=null;
  /**
   * Is Admin?
   * @var boolean
   */
  private $_isAdmin=null;
  /**
   * Is Supervisor?
   * @var boolean
   */
  private $_isSupervisor=null;
  /**
   * Is Contable?
   * @var boolean
   */
  private $_isContable=null;
  /**
   * Is Vendor?
   * @var boolean
   */
  private $_isVendor=null;
  /**
   * Is Customer?
   * @var boolean
   */
  private $_isCustomer=null;
  /**
   * Is Supplier?
   * @var boolean
   */
  private $_isSupplier=null;
  
  /**
   * Class constructor
   */
  public function __construct(){
    $this->_user=\Yii::app()->user;
  }
  
  /**
   * Return a user role instance
   * @return User
   */
  public static function getInstance(){
    if(!self::$_instance){
      self::$_instance=new User();
    }
    return self::$_instance;
  }
  
  /**
   * Is SuperAdmin?
   * @return boolean
   */
  public function getIsSuper(){
    if($this->_user->isGuest) return false;
    if($this->_isSuper===null){
      $this->_isSuper=Role::check(Role::ROLE_SUPER,$this->_user->id);
    }
    return $this->_isSuper;
  }
  /**
   * Is Admin?
   * @return boolean
   */
  public function getIsAdmin(){
    if($this->_user->isGuest) return false;
    if($this->_isAdmin===null){
      $this->_isAdmin=Role::check(Role::ROLE_ADMIN,$this->_user->id);
    }
    return $this->_isAdmin;
  }
  /**
   * Is Supervisor?
   * @return boolean
   */
  public function getIsSupervisor(){
    if($this->_user->isGuest) return false;
    if($this->_isSupervisor===null){
      $this->_isSupervisor=Role::check(ROLE::ROLE_SUPERVISOR,$this->_user->id);
    }
    return $this->_isSupervisor;
  }
  /**
   * Is Contable?
   * @return boolean
   */
  public function getIsContable(){
    if($this->_user->isGuest) return false;
    if($this->_isContable===null){
      $this->_isContable=Role::check(Role::ROLE_CONTABLE,$this->_user->id);
    }
    return $this->_isContable;
  }
  /**
   * Is Vendor?
   * @return boolean
   */
  public function getIsVendor(){
    if($this->_user->isGuest) return false;
    if($this->_isVendor===null){
      $this->_isVendor=Role::check(Role::ROLE_VENDOR,$this->_user->id);
    }
    return $this->_isVendor;
  }
  /**
   * Is Customer?
   * @return boolean
   */
  public function getIsCustomer(){
    if($this->_user->isGuest) return false;
    if($this->_isCustomer===null){
      $this->_isCustomer=Role::check(Role::ROLE_CUSTOMER,$this->_user->id);
    }
    return $this->_isCustomer;
  }
  /**
   * Is Supplier?
   * @return boolean
   */
  public function getIsSupplier(){
    if($this->_user->isGuest) return false;
    if($this->_isSupplier===null){
      $this->_isSupplier=Role::check(Role::ROLE_SUPPLIER,$this->_user->id);
    }
    return $this->_isSupplier;
  }
  /**
   * Current user is Only Admin
   * @return boolean
   */
  public function isOnlyAdmin(){
    return $this->isAdmin && !$this->isSuper;
  }

   /**
   * Current user is Only Contable
   * @return boolean
   */
  public function isOnlyContable(){
    return $this->isContable && !$this->isVendor;
  }

  /**
   * Current user
   * @return \CWebUser
   */
  public function getMe(){
    return $this->_user;
  }

  /**
   * Current userId
   * @return \CWebUser
   */
  public function getMeId(){
    return $this->_user->id;
  }
  /**
   * Current company Id
   */
  public function getCompanyId(){
    return $this->_user->getState('empresa');
  }
  /**
   * Save Sidebar state
   * @param string $state
   */
  protected function setSideBarState($state){
    $cookie=new \CHttpCookie(self::SIDEBAR_COLLAPSED,$state);
    $cookie->expire=time()+3600*24*365;
    \Yii::app()->request->cookies[self::SIDEBAR_COLLAPSED]=$cookie;
  }
  /**
   * Get Sidebar state
   * @return string
   */
  protected function getSideBarState(){
    return \Yii::app()->request->cookies->contains(self::SIDEBAR_COLLAPSED) ? \Yii::app()->request->cookies[self::SIDEBAR_COLLAPSED]->value : '';
  }
  
  
}
