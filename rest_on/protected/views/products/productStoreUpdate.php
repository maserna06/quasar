<td class="text-center" style="width: 20%;">
    <div id="producto<?= $cant ?>">
        <?= $product['name'] ?><br>
        <image class="img-redonda" height="50" width="50" src="<?php echo $product['image'] ?>"/>
    </div>
    <input  type="hidden" name="product[<?= $cant ?>][prod]" id="prod_<?= $cant ?>" value="<?= $product['product_id'] ?>">
</td>

<td style="padding: 1%; width: 25%;">
    <?php
    $whare = CHtml::listData(Wharehouses::model()->findAll('wharehouse_status=1 and company_id =' . Yii::app()->getSession()->get('empresa')), 'wharehouse_id', 'wharehouse_name');
    echo CHtml::dropDownList('product[' . $cant . '][whare]', $product['wharehouse_id'], $whare, array('class' => 'form-control', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => "Seleccione Bodega"));
    ?>
</td>

<td align="center " style="padding: 1%; width: 10%;">
    <input style="text-align: center;width: 50px;" type="number" maxlength="6" name="product[<?= $cant ?>][cant]" id="cant-<?= $cant ?>" onchange="calcular(this)" value="<?= $product['quantity'] ?>" min="1" size="4">
</td>

<td align="center " style="padding: 1%; width: 10%;">
    <?php echo CHtml::dropDownList('product[' . $cant . '][und]', $product['unit_id'], UnitExtend::selectConversion($product['unit_id']), array()); ?>
</td>

<td align="center " style="padding: 1%; width: 15%;">
    <input style="text-align: center;width: 50px;" type="number" onKeyDown="if (this.value.length == 9)
                return false;" step="1000" name="product[<?= $cant ?>][price]" onchange="calcular(this)" id="price-<?= $cant ?>" value="<?= $product['price'] * $tax ?>" min="0" >
           <?php echo CHtml::hiddenField("product[" . $cant . "][precioReal]", $product['price_real'] * $tax); ?>
</td>

<td align="center " style="padding: 1%; width: 15%;">
    <input style="text-align: center;width: 50px;" type="text" name="product[<?= $cant ?>][total]" id="total-<?= $cant ?>" value="<?= number_format($product['total'] * $tax) ?>" readonly="readonly" >
</td>

<td align="center" style="width: 5%;">
    <?php  if($components){ //se habilita si es un producto componente en punto de venta ?>

        <span style="padding: 8%;">

            <a id="component-<?=$cant?>" class="component">
                <i  class="fa fa-pencil fa-lg"></i>
                    <?php echo CHtml::hiddenField("product[". $cant."][components]", $components,array('id'=>'component_'.$cant)); ?>
            </a>
            
        </span>
    
    <?php } ?>
    <span style="padding: 8%;"><a href="javascript:;" onclick="BorrarCampo(<?= $cant ?>)"><i class="fa fa-times fa-lg"></i></a></span>
</td>