<?php
/* @var $this CourseNotificationController */
/* @var $model CourseNotification */
/* @var $form CActiveForm */
?>
<style type="text/css">
input.inline { float:left; margin-bottom: 0px;}
.clearBoth { clear:both; }
</style>

<script language="JavaScript">
function toggle(source) {
  checkboxes = document.getElementsByName('CourseNotification[course_id_data][]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

	$(document).ready(function(){
	    $("#CourseNotification_end_date").datepicker({
	        // numberOfMonths: 2,
	});
});

</script>
<!-- innerLR -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i><?php echo $formtext;?>
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
		<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'course-notification-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<!-- <div class="form-group" style="width: 500px; height: 300px; overflow-y: scroll;"> -->
		

	<?php
		$courseMem = array();
        if($model->course_id!="") {
            $courseMem = explode(',', $model->course_id);
        }

        $course = CourseOnline::model()->findAll(array(
			'condition' =>'active="y" and lang_id = 1', 
			));
		$course = CHtml::listData($course,'course_id','course_title');
		$attSearch = array("class"=>"form-control span8",'disable_search' => false);
	?>
		<!-- <?php echo $form->labelEx($model,'course_id_data'); ?> -->
		<!-- <input type="checkbox" onClick="toggle(this)" /> เลือกทั้งหมด<br/><br/> -->
		<!-- <?php 
	        foreach ($course as $key => $value) {
		        echo CHtml::checkBox('CourseNotification[course_id_data][]', (in_array($key, $courseMem))?TRUE:FALSE, array('value'=>$key,'class'=>'inline'));
		        echo '<label>'.$value.'</label></br>';
	    	}
		?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'course_id_data'); ?> -->
	<!-- </div> -->


			<!-- Chosen Multiple -->
			<?php echo $form->labelEx($model,'course_id'); ?>
			<?php 
				$name = 'course_id'; 
				// $data =  array( // list of select options
				// 	       '1'=>'Option 1',
				// 	       '2'=>'Option 2',
				// 	       '3'=>'Option 3',
				// 	       '4'=>'Option 4',
				// 	    );
				// $select = 67; //defual value;
				if($model){
					$select = $model->course_id; //defual value;
				}
			?>
			<?php echo Chosen::multiSelect($name, $select, $course, $attSearch); ?>
			<button type="button" class="chosen-toggle select">เลือกทั้งหมด</button>
  			<button type="button" class="chosen-toggle deselect">ยกเลิกทั้งหมด</button>
  			<?php echo $this->NotEmpty();?>
			<?php echo $form->error($model,'course_id'); ?>
	</div>
	<div class="row">
	<?php
		// $gen = Generation::model()->findAll(array(
		// 	'condition' =>'active=1', 
		// 	));
		// $gen = CHtml::listData($gen,'id_gen','name');
	?>
		<!-- <?php echo $form->labelEx($model,'generation_id'); ?>
		<?php echo $form->dropDownList($model,'generation_id',$gen,array('empty'=>'---รุ่น---')); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'generation_id'); ?> -->
	</div>

	<!-- <div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'end_date'); ?>
	</div> -->

	<div class="row">
		<?php echo $form->labelEx($model,'notification_time'); ?>
		<?php 
			$time = array('1' => '1',
		    '3' => '3',
		    '7' => '7',
		    '10' => '10',
		    '15' => '15',
		    '20' => '20',
		    '30' => '30',
		    '40' => '40',
		    '50' => '50',
		    '60' => '60',
		    '90' => '90',
		    '120' => '120',
		    '150' => '150',);
		?>
		<?php echo $form->dropDownList($model,'notification_time',$time,array('empty'=>'---วัน---')); ?>
		<?php echo $this->NotEmpty();?>
		<?php echo $form->error($model,'notification_time'); ?>
	</div>
	<?php
	    $active = array('0' => 'ระงับการใช้งาน',
	    '1' => 'เปิดการใช้งาน');
    ?>
	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->dropDownList($model, 'active', $active, array('class' => 'form-control')); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
		</div>
	</div>
</div>
<script type="text/javascript">
	
$('.chosen-toggle').each(function(index) {
// console.log(index);
    $(this).on('click', function(){
    // console.log($(this).parent().find('option').text());
         $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
});

</script>
