<?php
$this->breadcrumbs = array(
	'หมวดหลักสูตรอบรมออนไลน์'=>array('//cateOnline/index'),
	'หลักสูตรยอดนิยม',	
	'รายการสินค้า'=>array('cart')
);
?>

<section class="flx-related-post flx-entry-item">
	<div class="list-carousel responsive">
		<ul id="flx-slides-promotion">
	      	<?php foreach($ImgslideCourse as $key => $value): ?>	
				<?php $imageImgslideShow = Controller::ImageShowIndex(Yush::SIZE_THUMB,$value,$value->imgslide_picture,array()); ?>	
	          	<li align="center"><?php echo CHtml::link($imageImgslideShow,$value->imgslide_link,array('target'=>'_blank'));?></li>
	        <?php endforeach; ?>
		</ul><!--end:flx-slides-3-->
		<div class="clearfix"></div>
	</div><!--end:list-carousel-->
</section><!--end:flx-related-post-->

<?php if(Yii::app()->user->hasFlash('CheckQues')): ?>
<?php
$messages = '';
$flashes = Yii::app()->user->getFlashes(true);
foreach($flashes as $key => $value){   
    $msg = (!is_string($value) && isset($value['msg']))? $value['msg']:$value;
    $class_text = (!is_string($value) && isset($value['class']))? $value['class']:'information';
    $messages = <<<MSG
    <div class="alert alert-$class_text">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>$msg</strong> 
    </div>
MSG;
    echo $messages;
}
?>
<?php endif; ?>
<script type="text/javascript">  
function ShowUp(id){
	$("#Show"+id).parents("tr").next("tr").toggle();
    $("#Show"+id).toggleClass("up");
}
</script>
<?php $this->widget('GGridView', array(
		'id'=>'courseonline-grid',
		//'dataProvider'=>$model->searchBuy(),
		'dataProvider'=>$model->courseshow()->search(),
		'filter'=>$model,
		'columns'=>array(
			array(
				'header'=>'ลำดับ',
			    'value'=>'$this->grid->dataProvider->pagination->currentPage*
			    	$this->grid->dataProvider->pagination->pageSize + $row+1',
			    'htmlOptions' => array(
			     	'style' => 'text-align:center;',
			    	'width'=>'25',
			  	),
			),
			// array(
			// 	'header'=>'รูปภาพ',
			// 	'type'=>'raw',
			// 	'value'=> 'Controller::ImageShowIndex(Yush::SIZE_THUMB,$data,$data->course_picture,array())',
			// 	'htmlOptions'=>array('width'=>'110')
			// ),
			array(
		        'name'  => 'course_title',
		        'value' => 'CHtml::link($data->course_title,Yii::app()->createUrl("courseOnline/view",array("id"=>$data->course_id)), array("target"=>"_blank"))',
		        'type'  => 'raw',
				'htmlOptions' => array(
					'width'=>'240',
				),
		    ),
			array(
		        'name'  => 'course_lecturer',
		        'value' => 'CHtml::link($data->teachers->teacher_name,Yii::app()->createUrl("teacher/view",array("id"=>$data->course_lecturer)), array("target"=>"_blank"))',
		        'type'  => 'raw',
		        'filter'=>$this->listTeacher($model),
				'htmlOptions' => array(
					'width'=>'130',
				),
		    ),
			array(
				'name'=>'course_price',
				'value'=>'number_format($data->course_price)',
				'htmlOptions' => array(
					'width'=>'30',
				),
			),
			// array(
			// 	'name'=>'course_point',
			// 	'value'=>'number_format($data->course_point)',
			// 	'htmlOptions' => array(
			// 		'width'=>'30',
			// 	),
			// ),
			array(
				'header'=>'บทเรียน',
				'value'=>'$data->lessonCount',
				'htmlOptions' => array(
					'width'=>'50',
					'style' => 'text-align:center;'
				),
			),
			array(
			    'header'=>'สั่งซื้อสินค้า',
			    'type' => 'raw',
			    'value' => 'Helpers::lib()->CheckBuyItem($data->course_id,"string")',
			    'htmlOptions' => array(
			        'width'=>'90',
			        'style' => 'text-align:center;'
			    ),
			),
			array(
				'header'=>'เวลาเรียน',
				'type' => 'raw',
				//'value'=>'$data->course_id',
				'value'=>'Helpers::lib()->CheckDateTimeUser($data->course_id)',
				'htmlOptions' => array(
					'width'=>'80',
					'style' => 'text-align:center;'
				),
				'visible'=>$this->checkVisible()
			),
			array(
				'header'=>'พิมพ์',
				'type' => 'raw',
				'value'=>'Helpers::lib()->CheckTestingPass($data->course_id)',
				'htmlOptions' => array(
					'style' => 'text-align:center;'
				),
				'visible'=>$this->checkVisible()
			),
			array(
				'value' => '$data->Arrow',
				'type' => 'raw',
			    'htmlOptions' => array(
			        'style' => 'text-align:center;',
			        'width'=>'10',
			    ),
			),
		),
)); 
?>


