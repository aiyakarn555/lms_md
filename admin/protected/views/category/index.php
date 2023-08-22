
<?php
$titleName = 'ระบบหมวดหลักสูตร';
$formNameModel = 'Category';

$this->breadcrumbs=array('จัดการ'.$titleName);
	Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	    $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });
	    return false;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Category[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>

<?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('success'); ?>
    </div>
<?php endif; ?>


<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
	'data'=>$model,
	'route' => $this->route,
	'attributes'=>array(
		array('name'=>'cate_type','type'=>'list','query'=>array(
			'1'=>'หลักสูตรอบรมออนไลน์','2'=>'หลักสูตรสัมมนาอบรม'
		)),
		// array('name'=>'cate_teacher','type'=>'list','query'=>CHtml::listData(Teacher::model()->findAll(array(
		// "condition"=>" active = 'y' ")),'teacher_id', 'teacher_name')),
		array('name'=>'cate_title','type'=>'text'),
		array('name'=>'cate_short_detail','type'=>'textArea'),
	),
	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="label label-important">
					* หมายเหตุ ถ้าลบหมวดหลักสูตร จะทำให้หลักสูตร, บทเรียน(วิดีโอ), ข้อสอบ จะถูกลบไปด้วย
				</span>
				<span class="pull-right">
					<label class="strong">แสดงแถว:</label>
					<?php echo $this->listPageShow($formNameModel);?>
				</span>	
			</div>
			<div class="clear-div"></div>
			<div class="overflow-table">
				<?php $this->widget('AGridView', array(
					'id'=>$formNameModel.'-grid',
					'dataProvider'=>$model->search(),
					'filter'=>$model,
					'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Category[news_per_page]");
						InitialSortTable();	
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Category.*", "Category.Delete", "Category.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'header'=>'รูปภาพ',
							'type'=>'raw',
							'value'=> 'Controller::ImageShowIndex($data,$data->cate_image)',
							'htmlOptions'=>array('width'=>'110')
						),
						// array(
						// 	'type'=>'html',
						// 	'name'=>'cate_type',
						// 	'value'=> '$data->CateName',
						// 	'filter'=>$this->listCateType($model),
						// 	'htmlOptions' => array(
						// 		'width'=>'150',
						// 	),
						// ),
						array(
							'header'=>'จัดการประเภทหลักสูตร',
							'name'=>'type_name_th',
							'value'=>'$data->type->type_name',
							// 'filter'=>CHtml::activeTextField($model,'cates_search'),
			                'htmlOptions' => array(
			                   'style' => 'width:130px',
			                ),  
						),
						array(
							'name' => 'cate_title',
							'type'=>'raw',
							'value' => 'UHtml::markSearch($data,"cate_title")',
						),   
						/*array(          
					        'name'=>'cate_short_detail',
					        'value'=> 'ClassFunction::textcut($data->cate_short_detail,0,200)',
					        'htmlOptions'=>array('style'=>'width:330px; vertical-align:top;'),
					    ),*/
						// array(
						// 	'header'=>'วีดีโอตัวอย่าง',
						// 	'value'=>'$data->fileCount',
						// 	'htmlOptions'=>array('style'=>'width: 90px; text-align:center;'),
						// ),
				        // array(
				        // 	'name'=>'cate_show',
				        // 	'class'=>'JToggleColumn',
				        //     'filter' => array('0' => 'ปิด', '1' => 'เปิด'), // filter
				        //     'action'=>'toggle', // other action, default is 'toggle' action
				        //     'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
				        //     'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
				        //     'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
				        //     'headerHtmlOptions'=>array(
				        //     	'style'=>'text-align:center;'
				        //     ),
				        //     'htmlOptions'=>array(
				        //     	'style'=>'text-align:center;width:100px;'
				        //     ),
				        // ),
				        array(
							'type'=>'raw',
							'value'=>function($data){
								if($data->cate_show == 0){
									return CHtml::link("ปิด",array("/Category/active","id"=>$data->id), array("class"=>"btn btn-danger"));
								} else {
									return CHtml::link("เปิด",array("/Category/active","id"=>$data->id), array("class"=>"btn btn-success"));
								}
							},
							'header' => 'เปิด/ปิด การแสดงผล',
							'htmlOptions'=>array('style'=>'text-align: center;width:100px;'),
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;width:100px;'),
						),
						array(
							'header'=>'ภาษา',
							'value' => function($val) {
								   $lang = Language::model()->findAll(array('condition' =>'active ="y"'));
								   $width = (count($lang)*100) + 20;
								foreach ($lang as $key => $value) {
									$menu = Category::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
									$str = ' (เพิ่ม)';
									$class = "btn btn-icon";
									$link = array("/Category/create","lang_id"=>$value->id,"parent_id"=>$val->id);
									if($menu || $key == 0){
										$id = $menu ? $menu->id : $val->id;
										$str = ' (แก้ไข)';
										$class = "btn btn-success btn-icon";
										$link = array("/Category/update","id"=>$id);
									} 
									$langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
								}
								return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
								},
							'type'=>'raw',
							'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
								),
					    /*array(
					    	'header'=>'ตั้งค่าการพิมพ์',
					        'value'=>'CHtml::link("ตั้งค่าการพิมพ์หลักสูตร", array(
					      		"course/SetPrint",
					      		"id"=>"$data->id"
					      		), array(
								"class"=>"btn btn-primary btn-icon"
						    )); ',
					        'type'=>'raw',
					        'htmlOptions'=>array('width'=>'170px','style'=>'text-align:center;'),
				            'headerHtmlOptions'=>array(
				            	'style'=>'text-align:center;'
				            ),
					    ),*/
						array(            
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton( 
								array("Category.*", "Category.View", "Category.Update", "Category.Delete") 
							),
							'buttons' => array(
								'view'=> array( 
									'visible'=>'Controller::PButton( array("Category.*", "Category.View") )' 
								),
								'update'=> array( 
									'visible'=>'Controller::PButton( array("Category.*", "Category.Update") )' 
								),
								'delete'=> array( 
									'visible'=>'Controller::PButton( array("Category.*", "Category.Delete") )' 
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Category.*", "Category.Delete", "Category.MultiDelete")) ) : ?>
	<!-- Options -->
	<div class="separator top form-inline small">
		<!-- With selected actions -->
		<div class="buttons pull-left">
			<?php echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด","#",array(
				"class"=>"btn btn-primary btn-icon glyphicons circle_minus",
				"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"
			)); ?>
		</div>
		<!-- // With selected actions END -->
		<div class="clearfix"></div>
	</div>
	<!-- // Options END -->
	<?php endif; ?>

</div>
