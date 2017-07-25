<?php

namespace App\User;

/*
 *  Created by Diego Castro <ing.diegocastro@gmail.com>
 */

/**
 * User Role
 *
 * @author Diego Castro <ing.diegocastro@gmail.com>
 * @copyright (c) 2016, Diego Castro
 * @version 1.0
 */
abstract class Role{

  /**
   * Super Admin Role Name
   */
  const ROLE_SUPER='super';

  /**
   * Admin Role Name
   */
  const ROLE_ADMIN='admin';

  /**
   * Supervisor Role Name
   */
  const ROLE_SUPERVISOR='supervisor';

  /**
   * Contable Role Name
   */
  const ROLE_CONTABLE='contable';

  /**
   * Vendor Role Name
   */
  const ROLE_VENDOR='vendor';

  /**
   * Customer Role Name
   */
  const ROLE_CUSTOMER='customer';

  /**
   * Supplier Role Name
   */
  const ROLE_SUPPLIER='supplier';

  /**
   * Check access
   * @param string $role Role to check
   * @param integer $userId User id
   * @param array $params
   * @return boolean
   */
  public static function check($role,$userId,$params=[]){
    if(!self::checkRoleName($role)) return false;
    return \Yii::app()->authManager->checkAccess($role,$userId,$params);
  }

  /**
   * Assign role
   * @param string $role Role to check
   * @param integer $userId User id
   * @param string $bizRule
   * @param mixed $data
   * @return \CAuthAssignment|boolean
   */
  public static function assign($role,$userId,$bizRule=null,$data=null){
    if(!self::checkRoleName($role)) return false;
    try{
      return \Yii::app()->authManager->assign($role,$userId,$bizRule,$data);
    } catch(\CException $e){
      return false;
    }
  }
  /**
   * <var>$role</var> is assigned in user?
   * @param string $role
   * @param integer $userId
   * @return boolean
   */
  public static function isAssigned($role,$userId){
    if(!self::checkRoleName($role)) return false;
    return \Yii::app()->authManager->isAssigned($role,$userId);
  }

  /**
   * <var>$role</var> is a valid role name
   * @param string $role
   * @return boolean
   */
  public static function checkRoleName($role){
    switch($role){
      case self::ROLE_SUPER:
      case self::ROLE_ADMIN:
      case self::ROLE_SUPERVISOR:
      case self::ROLE_CONTABLE:
      case self::ROLE_VENDOR:
      case self::ROLE_CUSTOMER:
      case self::ROLE_SUPPLIER:
        return true;
    }
    return false;
  }

  /**
   * Delete role in user
   * @param string $role Role to revoke
   * @param integer $userId
   * @return boolean
   */
  public static function revoke($role,$userId){
    if(!self::checkRoleName($role)) return false;
    return \Yii::app()->authManager->revoke($role,$userId);
  }
  /**
   * Return all roles
   * @return array
   */
  public static function getAll(){
    return [
      self::ROLE_SUPER,
      self::ROLE_ADMIN,
      self::ROLE_CONTABLE,
      self::ROLE_SUPERVISOR,
      self::ROLE_VENDOR,
      self::ROLE_CUSTOMER,
      self::ROLE_SUPPLIER,
    ];
  }
  /**
   * Return admin y super role as array
   * @return array
   */
  public static function getAdmins(){
    return [
      self::ROLE_SUPER,
      self::ROLE_ADMIN,
    ];
  }

}
