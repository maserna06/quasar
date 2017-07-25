<?php 
    //echo "<pre>";print_r(Yii::app()->controller->id);echo "</pre>";exit;
    if (Yii::app()->controller->id == 'order') { ?>

    <td class="text-center" style="width: 20%;">
        <div id="producto<?= $cant ?>">
            <?= $product->product->product_description ?><br>
            <image class="img-redonda" height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $product->product->product_image ?>"/>

        </div>
        <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $product->product->product_id ?>">
    </td>

    <td style="padding: 1%; width: 25%;">
        <?php
        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
        echo CHtml::dropDownList('product[' . $cant . '][whare]', $product->wharehouse_id, $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
        ?>
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <input style="text-align: center;width: 50px;" type="number" maxlength="6" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" onchange="calcular(this)" value="<?= $product->order_details_quantity ?>" min="1" size="4">
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product->unit_id, UnitExtend::selectConversion($product->unit_id), array()); ?>
    </td>

    <td align="center " style="padding: 1%; ">
        <input style="text-align: center; width: 15%;" type="number" onKeyDown="if (this.value.length == 9)
                    return false;" step="1000" name="product[<?= $cant ?>][price]" onchange="calcular(this)" id="price-<?= $cant ?>" value="<?= $product->order_details_price * $tax ?>" min="0" >
               <?php echo CHtml::hiddenField("product[" . $cant . "][precioReal]", $product->product->product_price * $tax); ?>
    </td>

    <td align="center " style="padding: 1%;">
        <input style="text-align: center; width: 15%;" type="text" name="product[<?= $cant ?>][total]" id="total-<?= $cant ?>" value="<?= number_format($product->order_details_quantity * $product->order_details_price * $tax) ?>" readonly="readonly" >
    </td>

    <td align="center" style="width: 5%;">
        <a onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times"></i></a>
    </td>

<?php } else if (Yii::app()->controller->id == 'purchases') { ?>

    <td class="text-center" style="width: 20%;">
        <div id="producto<?= $cant ?>">
            <?= $product->product->product_description ?><br>
            <image class="img-redonda" height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $product->product->product_image ?>"/>

        </div>
        <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $product->product->product_id ?>">
    </td>

    <td style="padding: 1%; width: 25%;">
        <?php
        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
        echo CHtml::dropDownList('product[' . $cant . '][whare]', $product->wharehouse_id, $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
        ?>
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <input style="text-align: center;width: 50px;" type="number" maxlength="6" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" onchange="calcular(this)" value="<?= $product->purchase_details_quantity ?>" min="1" size="4">
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product->unit_id, UnitExtend::selectConversion($product->unit_id), array()); ?>
    </td>

    <td align="center " style="padding: 1%; width: 15%;">
        <input style="text-align: center;width: 50px;" type="number" onKeyDown="if (this.value.length == 9)
                    return false;" step="1000" name="product[<?= $cant ?>][price]" onchange="calcular(this)" id="price-<?= $cant ?>" value="<?= $product->purchase_details_price * $tax ?>" min="0" >
               <?php echo CHtml::hiddenField("product[" . $cant . "][precioReal]", $product->product->product_price * $tax); ?>
    </td>

    <td align="center " style="padding: 1%; width: 15%;">
        <input style="text-align: center;width: 50px;" type="text" name="product[<?= $cant ?>][total]" id="total-<?= $cant ?>" value="<?= number_format($product->purchase_details_quantity * $product->purchase_details_price * $tax) ?>" readonly="readonly" >
    </td>

    <td align="center" style="width: 5%;">
        <a onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times"></i></a>
    </td>

<?php } else if (Yii::app()->controller->id == 'requests') { ?>

    <td class="text-center" style="width: 20%;">
        <div id="producto<?= $cant ?>">
            <?= $product->product->product_description ?><br>
            <image class="img-redonda" height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $product->product->product_image ?>"/>

        </div>
        <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $product->product->product_id ?>">
    </td>

    <td style="padding: 1%; width: 25%;">
        <?php
        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
        echo CHtml::dropDownList('product[' . $cant . '][whare]', $product->wharehouse_id, $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
        ?>
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <input style="text-align: center;width: 50px;" type="number" maxlength="6" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" onchange="calcular(this)" value="<?= $product->request_details_quantity ?>" min="1" size="4">
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product->unit_id, UnitExtend::selectConversion($product->unit_id), array()); ?>
    </td>

    <td align="center " style="padding: 1%; width: 15%;">
        <input style="text-align: center;width: 50px;" type="number" onKeyDown="if (this.value.length == 9)
                    return false;" step="1000" name="product[<?= $cant ?>][price]" onchange="calcular(this)" id="price-<?= $cant ?>" value="<?= $product->request_details_price * $tax ?>" min="0" >
               <?php echo CHtml::hiddenField("product[" . $cant . "][precioReal]", $product->product->product_price * $tax); ?>
    </td>

    <td align="center " style="padding: 1%; width: 15%;">
        <input style="text-align: center;width: 50px;" type="text" name="product[<?= $cant ?>][total]" id="total-<?= $cant ?>" value="<?= number_format($product->request_details_quantity * $product->request_details_price * $tax) ?>" readonly="readonly" >
    </td>

    <td align="center" style="width: 5%;">
        <a onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times"></i></a>
    </td>
    
<?php } else if (Yii::app()->controller->id == 'referralsP') { ?>

    <td class="text-center" style="width: 20%;">
        <div id="producto<?= $cant ?>">
            <?= $product->product->product_description ?><br>
            <image class="img-redonda" height="50" width="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/dist/img/<?= $product->product->product_image ?>"/>

        </div>
        <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $product->product->product_id ?>">
    </td>

    <td style="padding: 1%; width: 25%;">
        <?php
        $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
        echo CHtml::dropDownList('product[' . $cant . '][whare]', $product->wharehouse_id, $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
        ?>
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <input style="text-align: center;width: 50px;" type="number" maxlength="6" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" onchange="calcular(this)" value="<?= $product->referralP_details_quantity ?>" min="1" size="4">
    </td>

    <td align="center " style="padding: 1%; width: 10%;">
        <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product->unit_id, UnitExtend::selectConversion($product->unit_id), array()); ?>
    </td>

    <td align="center " style="padding: 1%; width: 15%;">
        <input style="text-align: center;width: 50px;" type="number" onKeyDown="if (this.value.length == 9)
                    return false;" step="1000" name="product[<?= $cant ?>][price]" onchange="calcular(this)" id="price-<?= $cant ?>" value="<?= $product->referralP_details_price * $tax ?>" min="0" >
               <?php echo CHtml::hiddenField("product[" . $cant . "][precioReal]", $product->product->product_price * $tax); ?>
    </td>

    <td align="center " style="padding: 1%; width: 15%;">
        <input style="text-align: center;width: 50px;" type="text" name="product[<?= $cant ?>][total]" id="total-<?= $cant ?>" value="<?= number_format($product->referralP_details_quantity * $product->referralP_details_price * $tax) ?>" readonly="readonly" >
    </td>

    <td align="center" style="width: 5%;">
        <a onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times"></i></a>
    </td>
    
<?php } ?>