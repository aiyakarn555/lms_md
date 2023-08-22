
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
				<?php $form = $this->beginWidget('AActiveForm', array(
					'id'=>'news-form',
			        'enableClientValidation'=>true,
			        'clientOptions'=>array(
			            'validateOnSubmit'=>true
			        ),
			        'errorMessageCssClass' => 'label label-important',
			        'htmlOptions' => array('enctype' => 'multipart/form-data')
				)); ?>
				<p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
					<!-- <div class="row"> -->
	                   <!--  <?php echo $form->labelEx($model, 'lang_id'); ?>
	                    <?php echo $this->listlanguageShow($model, 'lang_id','span8'); ?> -->
	                    <!-- <?php echo $form->textField($model, 'lang_id',array('readonly' => true)); ?> -->
	                    <!-- <?php echo $this->NotEmpty(); ?>
	                    <?php echo $form->error($model, 'lang_id'); ?> -->
                	<!-- </div> -->
                	<?php 
                	////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
            $check_user = User::model()->findByPk(Yii::app()->user->id);
            $group = $check_user->group;
            $group_arr = json_decode($group);
            $see_all = 2;
            if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                $see_all = 1;
            }
            //////////////////
            if($see_all != 1){
            	$list = CHtml::listData(CourseOnline::model()->findAll( 
								array('condition' => "active='y' and lang_id = 1 and create_by='".Yii::app()->user->id."'",'order'=>'course_title ASC')),
								'course_id', 'course_title');
                	}else{
                		$list = CHtml::listData(CourseOnline::model()->findAll( 
								array('condition' => "active='y' and lang_id = 1",'order'=>'course_title ASC')),
								'course_id', 'course_title');

                	}



                		$attSearch = array("class"=>"span8",'disable_search' => false,'empty' => "--- กรุณาเลือกหลักสูตร ---");
					 ?>

					<!-- <div class="row"> -->
						<!-- <?php echo $form->labelEx($model,'course_id'); ?> -->
						<!-- <?php echo $this->listcourseOnline($model,'course_id','span8'); ?> -->
						<!-- <?php echo $this->NotEmpty();?> -->
						<!-- <?php echo $form->error($model,'course_id'); ?> -->
					<!-- </div> -->
					<!-- <div class="row">
						<?php echo $form->labelEx($model,'course_id'); ?>
						<?php echo Chosen::activeDropDownList($model, 'course_id', $list, $attSearch); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'course_id'); ?>
					</div> -->

					<div class="row">
						<?php echo $form->labelEx($model,'group_title'); ?>
						<?php echo $form->textField($model,'group_title',array('size'=>60,'maxlength'=>250, 'class'=>'span8')); ?>
						<?php echo $this->NotEmpty();?>
						<?php echo $form->error($model,'group_title'); ?>
					</div>
					<div class="row buttons">
						<!-- <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?> -->
						<?php 
					echo CHtml::submitButton('บันทึกข้อมูล', array('class' => 'btn btn-primary btn-icon  ok_2','id'=>'formSave','name' => 'submit'));
					?>
					</div>
				<?php $this->endWidget(); ?>
			</div><!-- form -->
		</div>
	</div>
</div>

<script type="text/javascript">

	$(function () {
		$('#news-form').submit(function(){
			var group_course_id = $("#Coursegrouptesting_course_id").chosen().val();
			var group_title = $('#Coursegrouptesting_group_title').val();
			if(group_course_id != "" && group_title != ""){
				setTimeout(function () {
					document.getElementById('formSave').value = 'กำลังประมวล…';
					document.getElementById('formSave').disabled = true;
				}, 300);
			}
		});
	});

	function getParentList(value){
		console.log(value);
	$(document).ready(function(){

        $.ajax({
            type: 'POST',
            url: "<?=Yii::app()->createUrl('Coursegrouptesting/onchangeList');?>",
            data:{ lang_id:value},
                success: function(data) {
                        $("#Coursegrouptesting_course_id").html(data);
                         // alert(data);
                    }
                })

		});
	}

</script>
<!-- END innerLR -->
