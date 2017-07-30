<?php

use App\Utils\Purifier;

/**
 * This is the model class for table "tbl_wharehouses".
 *
 * The followings are the available columns in table 'tbl_wharehouses':
 * @property integer $wharehouse_id
 * @property string $company_id
 * @property string $wharehouse_name
 * @property string $wharehouse_phone
 * @property string $wharehouse_address
 * @property integer $deparment_id
 * @property integer $city_id
 * @property integer $wharehouse_status
 *
 * The followings are the available model relations:
 * @property TblInventories[] $tblInventories
 * @property TblCities $city
 * @property TblCompanies $company
 * @property TblDepartaments $deparment
 */
class WharehousesExtend extends Wharehouses {

  public static function deleteWharehouseUser($id) {
    WharehousesUser::model()->deleteAll('wharehouse_id = ' . $id);
  }

  /**
   * Load user relationship
   * @param int $id
   * @return Array
   */
  public static function getUsersByWharehouses($id) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['*'])
            ->from('tbl_wharehouses_user wu')
            ->join('tbl_wharehouses w', 'w.wharehouse_id = wu.wharehouse_id')
            ->join('tbl_user u', 'u.user_id = wu.user_id')
            ->where('wu.wharehouse_id=' . $purifier->purify($id))
            ->andWhere('u.company_id = w.company_id')
            ->order('user_name')
    ;
    return $query->queryAll();
  }

  /**
   * load data to users in wharehouse
   * @param int $id
   * @return Array
   */
  public static function getUsersWharehouses($id) {
    $purifier = Purifier::getInstance();
    $dataReturn = [];
    $query = Yii::app()->db->createCommand()
            ->select(['*'])
            ->from('tbl_wharehouses_user wu')
            ->join('tbl_wharehouses w', 'w.wharehouse_id = wu.wharehouse_id')
            ->join('tbl_user u', 'u.user_id = wu.user_id')
            ->where('wu.wharehouse_id=' . $purifier->purify($id))
            ->andWhere('u.company_id = w.company_id')
            ->order('user_name')
    ;
    $dataUsers = $query->queryAll();
    foreach ($dataUsers as $userData) {
      $dataReturn[] = [
        'wharehouse_id'=>$userData['wharehouse_id'],  
        'user_id'=>$userData['user_id'],
        'user_name'=>$userData['user_name'],
        'user_firtsname'=>$userData['user_firtsname'],
        'user_lastname'=>$userData['user_lastname'],
        'user_status'=>$userData['user_status'],
        'link'=> CHtml::link("On", array("wharehouses/removeuser", "id" => $id, "item" => $userData['user_id']), array("class" => "btn btn-success pull-right")),
      ];
    }
    return $dataReturn;
  }

  /**
   * load data to user wharehouse
   * @param int $id
   * @param int $user
   * @return Array
   */
  public function getUserByWharehouse($id, $user) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['*'])
            ->from('tbl_wharehouses_user wu')
            ->join('tbl_wharehouses w', 'w.wharehouse_id = wu.wharehouse_id')
            ->join('tbl_user u', 'u.user_id = wu.user_id')
            ->where('wu.wharehouse_id=' . $purifier->purify($id))
            ->andWhere('wu.user_id=' . $purifier->purify($user))
    ;
    return $query->queryRow();
  }

  public function getUserTypeWharehouse($id, $userText, $type) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['u.*'])
            ->from('tbl_user u')
            ->join('AuthAssignment a', "a.userid = u.user_id AND a.itemname = '" . $purifier->purify($type) . "'")
            ->join('tbl_wharehouses w', 'w.company_id = u.company_id AND wharehouse_id = ' . $purifier->purify($id) . ' AND u.company_id = w.company_id')
            ->leftJoin('tbl_wharehouses_user wu', 'wu.user_id = u.user_id AND w.wharehouse_id = wu.wharehouse_id')
            ->where([
        'and', 'wu.user_id IS NULL', 'u.user_status=1', [
            'or',
            "u.user_firtsname LIKE '%" . $purifier->purify($userText) . "%'",
            "u.user_lastname LIKE '%" . $purifier->purify($userText) . "%'",
            "u.user_name LIKE '%" . $purifier->purify($userText) . "%'",
            "u.user_id LIKE '%" . $purifier->purify($userText) . "%'",
        ]
            ])
    ;

    return $query->queryAll();
  }

}
