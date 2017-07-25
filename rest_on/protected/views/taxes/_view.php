<?php
/* @var $this TaxesController */
/* @var $data Taxes */
?>

<tr role="row" class="odd">
	<td class='sorting_1'><?php echo CHtml::link(CHtml::encode($data->tax_id), array('view', 'id'=>$data->tax_id)); ?></td>
	<td><?php echo CHtml::encode($data->tax_description); ?></td>
	<td><?php if($data->tax_ishighervalue==1){echo "Aplica";}else{echo "No Aplica";} ?></td>
	<td><?php if($data->tax_islowervalue==1){echo "Aplica";}else{echo "No Aplica";} ?></td>
	<td><?php echo CHtml::encode($data->tax_rate); ?></td>
	<td><?php if($data->tax_cta_income !== null) {echo CHtml::encode($data->taxCtaIncome->account_number);}else{echo "";} ?></td>
	<td><?php if($data->tax_cta_spending !== null) {echo CHtml::encode($data->taxCtaSpending->account_number);}else{echo "";} ?></td>
	<td><?php if($data->economic_activity_cod !== null) {echo CHtml::encode($data->economicActivityCod->economic_activity_description);}else{echo "";} ?></td>
	<td><?php if($data->tax_status==1){echo "Activo";}else{echo "Inactivo";} ?></td>	
</tr>