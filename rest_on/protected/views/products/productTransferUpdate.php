<td class="text-center" style="width: 25%;">
    <div id="producto<?= $cant ?>">
        <?= $product['name'] ?><br>
        <image class="img-redonda" height="50" width="50" src="<?php echo $product['image'] ?>"/>   
    </div>
    <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $product['product_id'] ?>">
</td>
<td style="padding: 1%; width: 22.5%;">
    <?php
    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
    echo CHtml::dropDownList('product[' . $cant . '][whare]', $product['wharehouse_out'], $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
    ?>
</td>
<td style="padding: 1%; width: 22.5%;">
    <?php
    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
    echo CHtml::dropDownList('product[' . $cant . '][whare-in]', $product['wharehouse_id'], $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
    ?>
</td>
<td align="center " style="padding: 1%; width: 10%;"><input style="text-align: center;width: 50px;" type="number" max="999999" maxlength="6" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" class="calcular" value="<?= $product['quantity'] ?>" min="1" size="4"></td>
<td  align="center " style="padding: 1%; width: 15%;">
    <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product['unit_id'], UnitExtend::selectConversion($product['unit_id'])); ?>
</td>
<!--<td align="center"><a href="#" id="deleteProduct"><i id="deleteProduct" class="fa fa-times"></i></a></td>-->
<td align="center" style="width: 5%;">
    <span style="padding: 3%;"><a href="javascript:;" onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times fa-lg"></i></a></span>
</td>