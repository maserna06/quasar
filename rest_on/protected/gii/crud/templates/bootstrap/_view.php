<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $data <?php echo $this->getModelClass(); ?> */
?>

<tr role="row" class="odd">
	<?php
	/*echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$this->tableSchema->primaryKey}')); ?>:</b>\n";*/
	echo "\t<td class='sorting_1'><?php echo CHtml::link(CHtml::encode(\$data->{$this->tableSchema->primaryKey}), array('view', 'id'=>\$data->{$this->tableSchema->primaryKey})); ?></td>\n\t\n";
	$count=0;
	foreach($this->tableSchema->columns as $column)
	{
		if($column->isPrimaryKey)
			continue;
		if(++$count==7)
			echo "\t<?php /*\n";
		/*echo "\t<b><?php echo CHtml::encode(\$data->getAttributeLabel('{$column->name}')); ?>:</b>\n";*/
		echo "\t<td><?php echo CHtml::encode(\$data->{$column->name}); ?></td>\n\t\n";
	}
	if($count>=7)
		echo "\t*/ ?>\n";
	?>
</tr>