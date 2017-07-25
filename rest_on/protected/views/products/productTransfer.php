<?php
//$data = '<td><div id="producto' . $cant . '">' . $product->product_description . '</div><input type="hidden" name="component[' . $cant . '][prod]" id="prod_' . $cant . '" value="' . $id . '"></td>';
//                $data.= '<td>';
//                $data.=CHtml::dropDownList('component[' . $cant . '][und]', '', CHtml::listData(Unit::model()->findAll('unit_status=1'), 'unit_id', 'unit_name'), array('empty' => '...'));
//                $data.='</td>';
//                $data.='<td align="center " style="padding: 8px;"><input style="text-align: center;width: 50px;" type="text" name="component[' . $cant . '][cant]" id="cant' . $cant . '" value="" size="4"></td>';
//                $data.='<td align="center"><a href="#" onclick="BorrarCampo(' . $cant . ')"><i class="fa fa-times"></i></a></td>';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<td class="text-center" style="width: 25%;">
    <div id="producto<?= $cant ?>">
        <?= $product->product_description ?><br>
        <image class="img-redonda" height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $product->product_image ?>"/>   
    </div>
    <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $id ?>">
</td>
<td style="padding: 1%; width: 22.5%;">
    <?php
    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
    echo CHtml::dropDownList('product[' . $cant . '][whare]', Yii::app()->getSession()->get('warehouse'), $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
    ?>
</td>
<td style="padding: 1%; width: 25.5%;">
    <?php
    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
    echo CHtml::dropDownList('product[' . $cant . '][whare-in]', Yii::app()->getSession()->get('warehouse'), $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
    ?>
</td>
<td align="center " style="padding: 1%; width: 10%;"><input style="text-align: center;width: 50px;" type="number" max="999999" maxlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" class="calcular" value="1" min="1" size="4"></td>
<td  align="center " style="padding: 1%; width: 15%;">
    <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product->unit_id, UnitExtend::selectConversion($product->unit_id)); ?>
</td>
<!--<td align="center"><a href="#" id="deleteProduct"><i id="deleteProduct" class="fa fa-times"></i></a></td>-->
<td align="center" style="width: 5%;">
    <?php  #if($components){ //se habilita si es un producto componente en punto de venta ?>
    <!--<span style="padding: 8px;">
        <a id="component-<?=$cant?>" class="component">
            <i  class="fa fa-pencil fa-lg"></i>
                <?php #echo CHtml::hiddenField("product[". $cant."][components]", $components,array('id'=>'component_'.$cant)); ?>
        </a>
        
    </span>-->
    
    <?php #} ?>
    <span style="padding: 3%;"><a href="javascript:;" onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times fa-lg"></i></a></span>
</td>