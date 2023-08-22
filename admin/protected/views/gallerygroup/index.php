
<?php
$titleName = 'ระบบสไลด์รูปภาพ';
$formNameModel = 'GalleryGroup';

$this->breadcrumbs=array($titleName);

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
	$.appendFilter("GalleryGroup[news_per_page]", "news_per_page");
EOD
, CClientScript::POS_READY);
?>
			<div class="innerLR">
				<?php $this->widget('AdvanceSearchForm', array(
					'data'=>$model,
					'route' => $this->route,
					'attributes'=>array(
						array(
							'type'=>'list',
							'name'=>'gallery_type_id',
							'query'=>CHtml::listData(GalleryType::model()->findAll(),'id', 'name_gallery_type')
						),
					),
				));?> 

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
							<?php 
                              // var_dump($model->gallerygroupcheck()->search());
							$this->widget('AGridView', array(
								'id'=>$formNameModel.'-grid',
								'dataProvider'=>$model->gallerygroupcheck()->search(),
							    //'filter'=>$model,
								// 'selectableRows' => 2,	
								// 'htmlOptions' => array(
								// 	'style'=> "margin-top: -1px;",
								// ),
								// 'afterAjaxUpdate'=>'function(id, data){
								// 	$.appendFilter("GalleryGroup[news_per_page]");
								// 	InitialSortTable();	
								// }',
								'columns'=>array(

									array(
										'visible'=>Controller::DeleteAll(
											array("GalleryGroup.*", "GalleryGroup.Delete", "GalleryGroup.MultiDelete")
										),
										'class'=>'CCheckBoxColumn',
										'id'=>'chk',
									),
									// array(
         //                                 'header'=>'No.',
         //                                 'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
         //                            ), 
									array(
										'header'=>'image',
										'type' => 'raw',
										'value'=> function ($model){
											 $criteria = new CDbCriteria;
                                             $criteria->addCondition('group_gallery_id ="'.$model->id.'"');
                                             $Gallery = Gallery::model()->find($criteria);
											if ($Gallery->image) {
												echo CHtml::image(yii::app()->baseUrl.'../../uploads/gallery/'.$Gallery->image);
											}else
											{
												echo 'No image';
											}
										},
										'htmlOptions'=>array('width'=>'110')			
									),
									array(
										'name'=>'gallery_type_id',
										'type'=>'html',
										'value'=> function ($model){
											//  $criteria = new CDbCriteria;
           //                                   $criteria->addCondition('id ="'.$model->gallery_type_id.'"');
           //                                   $GalleryType = GalleryType::model()->find($criteria);
											// return $GalleryType->name_gallery_type;

											 return $model->gType->name_gallery_type;
										
										},
									),
									array(
										'header'=>'จำนวนรูป',
										'type'=>'html',
										'value'=> function ($model){
											 $criteria = new CDbCriteria;
                                             $criteria->addCondition('group_gallery_id ="'.$model->id.'"');
                                             $Gallery = Gallery::model()->findAll($criteria);
                                             return count($Gallery); 
										},
									),
									array(            
										'class'=>'AButtonColumn',
										'visible'=>Controller::PButton( 
											array("GalleryGroup.*", "GalleryGroup.View", "GalleryGroup.Update", "GalleryGroup.Delete") 
										),
										'buttons' => array(
											'view'=> array( 
												'visible'=>'Controller::PButton( array("GalleryGroup.*", "GalleryGroup.View") )' 
											),
											'update'=> array( 
												'visible'=>'Controller::PButton( array("GalleryGroup.*", "GalleryGroup.Update") )' 
											),
											'delete'=> array( 
												'visible'=>'Controller::PButton( array("GalleryGroup.*", "GalleryGroup.Delete") )' 
											),
										),
									),
								),
							)); 
							?>
						</div>		
					</div>
				</div>

				<?php if( Controller::DeleteAll(array("GalleryGroup.*", "GalleryGroup.Delete", "GalleryGroup.MultiDelete")) ) : ?>
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
