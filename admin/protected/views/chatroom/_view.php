<?php
/* @var $this ChatroomController */
/* @var $data Chatroom */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('room_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->room_id), array('view', 'id'=>$data->room_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('room_code')); ?>:</b>
	<?php echo CHtml::encode($data->room_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('room_user')); ?>:</b>
	<?php echo CHtml::encode($data->room_user); ?>
	<br />


</div>