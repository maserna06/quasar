<?php
/* @var $this InventoriesController */
/* @var $data Inventories */
?>

<tr role="row" class="odd">
		<td class='sorting_1'><?php echo CHtml::link(CHtml::encode($data->inventory_id), array('view', 'id'=>$data->inventory_id)); ?></td>
	
	<td><?php echo CHtml::encode($data->wharehouse_id); ?></td>
	
	<td><?php echo CHtml::encode($data->product_id); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_year); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_month); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_unit); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_stock); ?></td>
	
	<?php /*
	<td><?php echo CHtml::encode($data->inventory_movement_type); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_document_number); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_amounts); ?></td>
	
	<td><?php echo CHtml::encode($data->inventory_status); ?></td>
	
	*/ ?>
</tr>