<?php

use App\User\User as U;
use App\User\Role;
use App\Utils\Purifier;

class InventoriesExtend extends Inventories {

  public static function addInventory($product, $date, $idMov, $movimiento, $hour) {

    $inventory = new Inventories;
    $inventory->wharehouse_id = $product['whare'];
    $inventory->product_id = $product['prod'];
    $inventory->inventory_year = date("Y", strtotime($date));
    $inventory->inventory_month = date("m", strtotime($date));
    $inventory->inventory_day = date("d", strtotime($date));
    $inventory->inventory_hour = $hour;
    $inventory->inventory_unit = $product['und'];
    $producto = Products::model()->findByPk($product['prod']);
    if ($producto->unit_id != $product['und']) {
      $inventory->inventory_stock = UnitExtend::Conversion($product['und'], $producto->unit_id, $product['cant']);
      // realizamos conversión
    } else {
      $inventory->inventory_stock = $product['cant'];
    }
    $inventory->inventory_movement_type = $movimiento;
    $inventory->inventory_document_number = $idMov;
    $inventory->inventory_amounts = $product['cant'];
    $inventory->inventory_status = 1;
    $inventory->save();
    if ($movimiento == 'Purchases')
      $producto->stock = $producto->stock + $product['cant'];

    $producto->save();
  }

  public static function deleteInventory($product, $cantidad) {

    $producto = Products::model()->findByPk($product);
    $producto->stock = $producto->stock - $cantidad;
    $producto->save();
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   *
   * Typical usecase:
   * - Initialize the model fields with values from filter form.
   * - Execute this method to get CActiveDataProvider instance which will filter
   * models according to data in model fields.
   * - Pass data provider to CGridView, CListView or any similar widget.
   *
   * @return CActiveDataProvider the data provider that can return the models
   * based on the search/filter conditions.
   */
  public function search() {
    // @todo Please modify the following code to remove attributes that should not be searched.

    $criteria = new CDbCriteria;

    $criteria->with = array('product' => array('joinType' => 'INNER JOIN', 'together' => true, 'with' => array('category' => array('joinType' => 'INNER JOIN', 'together' => true,))));
    $criteria->addCondition('product.product_status = 1');

    $criteria->compare('inventory_id', $this->inventory_id);
    $criteria->compare('wharehouse_id', $this->wharehouse_id);
    $criteria->compare('product_id', $this->product_id);
    $criteria->compare('inventory_year', $this->inventory_year, true);
    $criteria->compare('inventory_month', $this->inventory_month, true);
    $criteria->compare('inventory_unit', $this->inventory_unit);
    $criteria->compare('inventory_stock', $this->inventory_stock);
    $criteria->compare('inventory_movement_type', $this->inventory_movement_type, true);
    $criteria->compare('inventory_document_number', $this->inventory_document_number);
    $criteria->compare('inventory_amounts', $this->inventory_amounts);
    $criteria->compare('inventory_status', $this->inventory_status);

    $user = U::getInstance();

    if ($user->isSupervisor && !$user->isSuper) {
      $criteria->compare('product.company_id', $user->companyId);
      $criteria->order = 'product.category_id ASC';
    } else {
      //$criteria->compare('product.company_id',$user->companyId,true);
      $criteria->order = 'product.category_id ASC';
      $criteria->order = 'category.category_description ASC';
    }

    $criteria->group = 'product.product_id';
    return Inventories::model()->findAll($criteria);

    /* return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
      )); */
  }

  /**
   * Load data products
   * @param numeric $limit
   * @param numeric $offset
   * @return array
   */
  public static function getProducts($limit = 12, $offset = 0, $querytext = false, $product = false, $company = false) {
    $purifier = Purifier::getInstance();
    $user = U::getInstance();
    
//    $dependency = new CDbCacheDependency('SELECT count(*) number FROM tbl_post');
    
    $query = Yii::app()->db->createCommand()
            ->select(['p.*', 'c.category_description'], 'SQL_CALC_FOUND_ROWS')
            ->from('tbl_products p')
            ->join('tbl_categories c', 'c.category_id=p.category_id')
            ->where(['and', 'p.product_status=1', 'c.category_status=1'])
    ;

    if ($querytext && $product == 0) {
      $query->andWhere(
              "p.product_barCode LIKE '%".$purifier->purify($querytext)."%' OR p.product_description LIKE '%".$purifier->purify($querytext)."%' OR c.category_description LIKE '%".$purifier->purify($querytext)."%' OR p.product_id LIKE '%".$purifier->purify($querytext)."%'");
    } else if ($product) {
      $query->andWhere('p.product_id=:idp', [
          ':idp' => $purifier->purify($product)
      ]);
    }
    
    if ($company) {
      $query->andWhere('p.company_id=:idc', [
          ':idc' => $purifier->purify($company)
      ]);
    }

    $query->order(['c.category_description', 'p.product_description'])
            ->limit($limit, $offset * $limit);
    
    
    if(!$user->isSuper){
      $query->join('tbl_user u', 'u.company_id = p.company_id')
              ->andWhere('u.user_id=:idu', [ ':idu' => $purifier->purify(Yii::app()->user->id)])
              ;
    }
    else{
      $query->order('p.company_id, p.product_description')
              ;
    }
    
    $rows = $query->queryAll();
    $pages = 0;
    if (count($rows)) {
      $totalRows = self::foundRows();
      $pages = new CPagination($totalRows);
      $pages->currentPage = $offset;
      $pages->pageSize = $limit;
      $pages->params = array();
      return array('data' => $rows, 'paginator' => Yii::app()->controller->widget('CLinkPager', array(
              'pages' => $pages,
              'selectedPageCssClass' => 'active',
              'hiddenPageCssClass' => 'disabled',
              'header' => false,
              'firstPageLabel' => '<<',
              'lastPageLabel' => '>>',
              'prevPageLabel' => '<',
              'nextPageLabel' => '>',
              'htmlOptions' => array(
                  'class' => 'pagination',
              )), true));
    }else{
      return false;
    }

  }

  public static function foundRows() {
    return Yii::app()->db->createCommand('SELECT FOUND_ROWS()')->queryScalar();
  }

  /**
   * Load data products to autocomplete
   * @param string $text
   * @return array
   */
  public static function getProductsByTerm($text) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['p.*', 'c.category_description'])
            ->from('tbl_products p')
            ->join('tbl_categories c', 'c.category_id=p.category_id')
            ->where([
        'and', 'c.category_status=1', 'p.product_status=1', [
            'or',
            "p.product_barCode LIKE '%" . $purifier->purify($text) . "%'",
            "p.product_description LIKE '%" . $purifier->purify($text) . "%'",
            "c.category_description LIKE '%" . $purifier->purify($text) . "%'",
            "p.product_id LIKE '%" . $purifier->purify($text) . "%'",
        ]
            ])
    ;
    return $query->queryAll();
  }
  /**
   * return data of product by product_id
   * @param numeric $product_id
   * @return array
   */
  public static function getProductById($product_id) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['p.*', 'c.category_description', 'u.unit_name'])
            ->from('tbl_products p')
            ->join('tbl_categories c', 'c.category_id=p.category_id')
            ->join('tbl_unit u', 'u.unit_id=p.unit_id')
            ->where(['and', 'c.category_status=1', 'p.product_status=1', 'p.product_id='.$purifier->purify($product_id)])
    ;
    return $query->queryRow();
  }
  /**
   * return data of stock inventory by product_id and wharehouse
   * @param numeric $product_id
   * @return array
   */
  public static function getStockByWharehouse($product_id) {
    $purifier = Purifier::getInstance();
    $query = Yii::app()->db->createCommand()
            ->select(['w.wharehouse_name', 'i.inventory_stock'])
            ->from('tbl_inventories i')
            ->join('tbl_wharehouses w', 'w.wharehouse_id = i.wharehouse_id')
            ->where(['and', 'i.product_id='.$purifier->purify($product_id)])
            ->order("CONCAT(DATE_FORMAT(i.inventory_date,'%y%m%d'),RPAD(i.inventory_movement_type,10,' '),LPAD(i.inventory_id,10,0))  DESC")
    ;
//    echo $query->text;
//    die();
    return $query->queryAll();
  }

}
