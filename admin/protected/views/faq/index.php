<?php
///* @var $this FaqController */
///* @var $dataProvider CActiveDataProvider */
//
//$this->breadcrumbs=array(
//	'Faqs',
//);
//
//$this->menu=array(
//	array('label'=>'Create Faq', 'url'=>array('create')),
//	array('label'=>'Manage Faq', 'url'=>array('admin')),
//);
//?>
<!---->
<!--<h1>Faqs</h1>-->
<!---->
<?php //$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); ?>

<?php
$titleName = 'คำถามที่พบบ่อย';
$formNameModel = 'Faq';

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
$.appendFilter("Faq[news_per_page]", "news_per_page");
EOD
	, CClientScript::POS_READY);
?>

<div class="innerLR">
	<?php $this->widget('AdvanceSearchForm', array(
		'data'=>$model,
		'route' => $this->route,
		'attributes'=>array(
			array(
				'name'=>'faq_THtopic',
				'type'=>'text'
			),
		),
	));?>
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
		<div class="widget-body">
			<div class="separator bottom form-inline small">
				<span class="pull-right" style="margin-left: 10px;">
					<a class="btn btn-primary btn-icon glyphicons circle_plus"
					   href="<?php echo Yii::app()->createUrl("/Faq/create")?>"><i></i> เพิ่มคำถาม</a>
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
					'dataProvider'=>$model->faqcheck()->search(),
					//'filter'=>$model,

					'rowCssClassExpression'=>'"items[]_{$data->faq_nid_}"',
					'selectableRows' => 2,
					'htmlOptions' => array(
						'style'=> "margin-top: -1px;",
					),
					'afterAjaxUpdate'=>'function(id, data){
						$.appendFilter("Faq[news_per_page]");
						InitialSortTable();
					}',
					'columns'=>array(
						array(
							'visible'=>Controller::DeleteAll(
								array("Faq.*", "Faq.Delete", "Faq.MultiDelete")
							),
							'class'=>'CCheckBoxColumn',
							'id'=>'chk',
						),
						array(
							'name'=>'faq_type_id',
							'type'=>'html',
							'value'=>'$data->faq_type->faq_type_title_TH'
						),
						array(
							'name'=>'faq_THtopic',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"faq_THtopic")'
						),
						array(
							'name'=>'create_date',
							'type'=>'html',
							'value'=>'UHtml::markSearch($data,"create_date")'
						),
						array(
							'type'=>'html',
							'value'=>'CHtml::link("<i></i>","", array("class"=>"glyphicons move btn-action btn-inverse"))',
							'htmlOptions'=>array('style'=>'text-align: center; width:50px;', 'class'=>'row_move'),
							'header' => 'ย้าย',
							'headerHtmlOptions'=>array( 'style'=>'text-align:center;'),
						),
						array(
                        'header'=>'ภาษา',
                        'value' => function($val) {
                           	$lang = Language::model()->findAll(array('condition' =>'active ="y"'));
					        foreach ($lang as $key => $value) {
					    		$menu = Faq::model()->findByAttributes(array("lang_id" => $value->id,'parent_id'=> $val->id,'active'=>'y'));
					    		$str = ' (เพิ่ม)';
					    		$class = "btn btn-icon";
					    		$link = array("/Faq/create","lang_id"=>$value->id,"parent_id"=>$val->id);
					    		if($menu || $key == 0){
					    			$id = $menu ? $menu->id : $val->id;
					    			$str = ' (แก้ไข)';
					    			$class = "btn btn-success btn-icon";
					    			$link = array("/Faq/update","id"=>$id,"lang_id"=>$value->id,"parent_id"=>$val->id);
					    		} 
					            $langStr .= CHtml::link($value->language.$str, $link, array("class"=>$class,"style" => 'width:100px;border: 1px solid;'));
					        }
					        return '<div class="btn-group" role="group" aria-label="Basic example">'.$langStr.'</div>';
                    	},
	                    'type'=>'raw',
	                    'htmlOptions'=>array('style'=>'text-align: center','width'=>$this->getWidthColumnLang().'px;'),
	                ),
						array(
							'class'=>'AButtonColumn',
							'visible'=>Controller::PButton(
								array("Faq.*", "Faq.View", "Faq.Update", "Faq.Delete")
							),
							'buttons' => array(
								'view'=> array(
									'visible'=>'Controller::PButton( array("Faq.*", "Faq.View") )'
								),
								'update'=> array(
									'visible'=>'Controller::PButton( array("Faq.*", "Faq.Update") )'
								),
								'delete'=> array(
									'visible'=>'Controller::PButton( array("Faq.*", "Faq.Delete") )'
								),
							),
						),
					),
				)); ?>
			</div>
		</div>
	</div>

	<?php if( Controller::DeleteAll(array("Faq.*", "Faq.Delete", "Faq.MultiDelete")) ) : ?>
		<!-- Options -->
		<div class="separator top form-inline small">
			<!-- With selected actions -->
			<div class="buttons pull-left">
				<?php
				echo CHtml::link("<i></i> ลบข้อมูลทั้งหมด",
					"#",
					array("class"=>"btn btn-primary btn-icon glyphicons circle_minus",
						"onclick"=>"return multipleDeleteNews('".$this->createUrl('//'.$formNameModel.'/MultiDelete')."','$formNameModel-grid');"));
				?>
			</div>
			<!-- // With selected actions END -->
			<div class="clearfix"></div>
		</div>
		<!-- // Options END -->
	<?php endif; ?>

</div>
