<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;

/**
 * This is the model class for table "tbl_classification".
 *
 * The followings are the available columns in table 'tbl_classification':
 * @property integer $classification_id
 * @property string $classification_name
 * @property string $classification_description
 * @property integer $classification_status
 *
 * The followings are the available model relations:
 * @property TblClassificationProduct[] $tblClassificationProducts
 */
class ClassificationExtend extends Classification {

  public static function getProducts($classification_id = false) {
    $purifier = Purifier::getInstance();
    $user = U::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['p.*', 'c.category_description'])
            ->from('tbl_products p')
            ->join('tbl_categories c', "c.category_id = p.category_id")
            ->where(['and', 'product_iscomponent = 1', ' product_enable=1', 'product_status=1'])
            ->order(['c.category_description', 'p.product_description'])
    ;
    if ($classification_id) {
      $query->select(['p.*', 'c.category_description', 'cp.product_id product_related'])
              ->leftJoin('tbl_classification_product cp', 'cp.product_id = p.product_id AND cp.classification_id = ' . $purifier->purify($classification_id));
    }

    if(!$user->isSuper){
       $query->join('tbl_user u', 'u.company_id = p.company_id')
              ->andWhere('u.user_id=:idu', [ ':idu' => $purifier->purify(Yii::app()->user->id)]);
    }

    return $query->queryAll();
  }

  public static function getWharehouses($classification_id = false) {
    $purifier = Purifier::getInstance();
    $user = U::getInstance();
    $query = Yii::app()->db->createCommand()
      ->select(['w.*'])
      ->from('tbl_wharehouses w')
      ->join('tbl_wharehouses_user wu', 'wu.wharehouse_id = w.wharehouse_id')
      ->where(['and', 'wharehouse_status=1']);

    if ($classification_id) {
      $query->select(['w.*', 'wc.wharehouse_id wharehouse_related'])
        ->leftJoin('tbl_wharehouses_classification wc', 'wc.wharehouse_id = w.wharehouse_id AND wc.classification_id = ' . $purifier->purify($classification_id));
    }

    if(!$user->isSuper){
      $query->join('tbl_user u', 'u.company_id = w.company_id')
        ->andWhere('u.user_id=:idu', [ ':idu' => $purifier->purify(Yii::app()->user->id)]);
    }

    return $query->queryAll();
  }

}
