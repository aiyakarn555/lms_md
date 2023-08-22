<?php
/* @var $this ChatController */
/* @var $data Chat */
?>
	
	<tr>
		<td style="<?php if($data->user_from!=1){  }else{ echo 'background-color:#eee;';} ?>">
			<?php echo CHtml::encode($data->user->username); ?>
			<?php echo "<br />" ?>
			<?php echo CHtml::encode(date('Y-m-d H:i:s',$data->time)); ?>
		</td>
		<td style="<?php if($data->user_from!=1){ echo 'color:#00ec00;'; }else{ echo 'background-color:#eee;';} ?>"><?php echo CHtml::encode($data->message); ?></td>
	</tr> 

