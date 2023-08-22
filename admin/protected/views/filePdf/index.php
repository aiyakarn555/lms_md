<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<!-- <script src="<?php echo Yii::app()->theme->baseUrl; ?>/base_assets/dist/js/jwplayer_init.js" type="text/javascript"></script> -->
<script type="text/javascript">jwplayer.key="J0+IRhB3+LyO0fw2I+2qT2Df8HVdPabwmJVeDWFFoplmVxFF5uw6ZlnPNXo=";</script>
<?php
$titleName = 'จัดการ PDF';
$formNameModel = 'File';

$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดการ PDF',
);

$getUrl = Yii::app()->request->getBaseUrl(true);

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
	$.appendFilter("File[news_per_page]", "news_per_page");

	$(".js-table-sortable > tbody > tr > td > div > div").each(function(index,element){
		var playerInstance = jwplayer(this.id).setup({
			abouttext: "E-learning",
			file: "$getUrl/../uploads/lesson/"+$(this).attr("vdo"),
			width: 220,
			height: 150
		});
		playerInstance.onReady(function() {
			if(typeof $("#"+this.id).find("button").attr("onclick") == "undefined"){
				$("#"+this.id).find("button").attr("onclick","return false");
			}
			playerInstance.onPlay(function(callback) {
			    console.log(callback);
			});
		});
	});

EOD
, CClientScript::POS_READY);
?>

<script type="text/javascript">
</script>


<div class="innerLR">
	
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-left" style="margin-left: 10px;">
					<a class="btn btn-primary btn-icon glyphicons circle_plus"
					   href="<?php echo Yii::app()->createUrl("/FilePdf/create",array("id"=>$id))?>"><i></i> เพิ่ม PDF</a>
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
					'dataProvider'=>$model->search($id),
					'filter'=>$model,
					'rowCssClassExpression'=>'"items[]_{$data->id}"',
					//'selectableRows' => 2,	
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("File[news_per_page]");
						InitialSortTable();	
						$(".js-table-sortable > tbody > tr > td > div > div").each(function(index,element){
							var playerInstance = jwplayer(this.id).setup({
								abouttext: "E-learning",
								file: "'.Yii::app()->request->getBaseUrl(true).'/../uploads/lesson/"+$(this).attr("vdo"),
								width: 220,
		    					height: 150
							});
							playerInstance.onReady(function() {
								if(typeof $("#"+this.id).find("button").attr("onclick") == "undefined"){
									$("#"+this.id).find("button").attr("onclick","return false");
								}
								playerInstance.onPlay(function(callback) {
								    console.log(callback);
								});
							});
						});
					}',
					'columns'=>array(
//						array(
//							'filter'=>false,
//							'name'=>'filename',
//							'type'=>'raw',
//							'value'=>'$data->FileVdo',
//							'header'=>'PDF',
//							'htmlOptions'=>array('style'=>'text-align: center; width:230px;'),
//							'headerHtmlOptions'=>array('style'=>'text-align: center'),
//						),
						array(
                            'header'=>'ชื่อ PDF',
                            'name'=>'file_name',
							'value'=>'$data->RefileName'
						),

				        // array(
				        //     'type'=>'raw',
				        //     'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
				        //     'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
				        //     'header' => 'ย้าย',
				        //     'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
				        // ),
				        array(
							'header'=>'จัดการ',
							'value' => function($val) {
								   $lang = Language::model()->findAll(array('condition' =>'active ="y"'));
								foreach ($lang as $key => $value) {
									if ($key == 0) {
										$menu = FilePdf::model()->findByAttributes(array("lang_id" => $value->id,'id'=> $val->id,'active'=>'y'));
										$menu_lesson = Lesson::model()->findByAttributes(array("lang_id" => $value->id,'id'=> $val->lesson_id,'active'=>'y'));
									}else{
										$menu = FilePdf::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
										$menu_lesson = Lesson::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->lesson_id,'active'=>'y'));
									}
									if ($menu_lesson) {
										$str = ' (เพิ่ม)';
										$link = array("/FilePdf/create","lang_id"=>$value->id,"parent_id"=>$val->id);
										$class = "btn btn-icon";
										if($menu){
											$id = $menu ? $menu->id : $val->id;
											$str = ' (แก้ไข)';
											$class = "btn btn-success btn-icon";
											$link = array("/FilePdf/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
										}
										$langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;'));
									}
									
								}
								return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
							},
								'type'=>'raw',
								'htmlOptions'=>array('style'=>'text-align: center','width'=>'100px;'),
							),
						// array(
				  //           'class' => 'zii.widgets.grid.CButtonColumn',
				  //           'htmlOptions' => array('style' => 'white-space: nowrap'),
				  //           'afterDelete' => 'function(link,success,data) { if (success && data) console.log(data); }',
				  //           'template' => ' {update} {delete}',
				  //           'buttons' => array(
				  //               // 'view' => array(
				  //               //     'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'View'),
				  //               //     'label' => '<button type="button" class="btn btn-primary"><i class="fa fa-list-alt"></i></button>',
				  //               //     'imageUrl' => false,
				  //               // ),
				  //               // 'update' => array(
				  //               //     'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Update'),
				  //               //     'label' => '<button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>',
				  //               //     'imageUrl' => false,
				  //               // ),
				  //               'delete' => array(
				  //                   'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Delete'),
				  //                   'label' => '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>',
				  //                   'imageUrl' => false,
				  //               )
				  //           )
				  //       ),
					),
				)); ?>

			</div>
		</div>
	</div>
</div>