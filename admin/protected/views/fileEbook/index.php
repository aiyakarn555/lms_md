<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/jwplayer/jwplayer.js" type="text/javascript"></script>
<script type="text/javascript">jwplayer.key="MOvEyr0DQm0f2juUUgZ+oi7ciSsIU3Ekd7MDgQ==";</script>
<?php
$titleName = 'จัดอันดับวิดีโอ';
$formNameModel = 'File';

$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับวิดีโอ',
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
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
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
						array(
							'name'=>'file_name',
							'value'=>'$data->filename'
						),
				        // array(
				        //     'type'=>'raw',
				        //     'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
				        //     'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
				        //     'header' => 'ย้าย',
				        //     'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
				        // ),
						array(            
							'class'=>'AButtonColumn',
							'visible'=>true,
							'buttons' => array(
								'view'=> array( 
									'visible'=>'false' 
								),
								'update'=> array( 
									'visible'=>'true' 
								),
								'delete'=> array( 
									'visible'=>'true' 
								),
							),
						),
					),
				)); ?>

			</div>
		</div>
	</div>
</div>