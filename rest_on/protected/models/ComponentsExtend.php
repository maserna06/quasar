<?php

/**
 * This is the model class for table "tbl_components".
 *
 * The followings are the available columns in table 'tbl_components':
 * @property integer $component_id
 * @property integer $base_product_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property double $component_amounts
 *
 * The followings are the available model relations:
 * @property TblProducts $baseProduct
 * @property TblProducts $product
 * @property TblUnit $unit
 */
class ComponentsExtend extends Components
{
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
	public function search($id=null)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('component_id',$this->component_id);
		$criteria->compare('base_product_id',$id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('component_amounts',$this->component_amounts);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
