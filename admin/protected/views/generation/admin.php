<?php
/* @var $this GenerationController */
/* @var $model Generation */

$this->breadcrumbs=array(
	'Generations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Generation', 'url'=>array('index')),
	array('label'=>'Create Generation', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#generation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="generation" class="innerLR">
<div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("จัดการรุ่น"); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php echo Rights::t('core', 'Here you can view which permissions has been assigned to each user.'); ?>
            </div>
            <div class="spacer"></div>
            <div>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'generation-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id_gen',
		array(
                 'header'=>'No.',
                 'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
             ),
		'name',
		'start_date',
		'end_date',
		//'active',
		array(
			'name'=>'active',
			'value'=>'User::itemAlias("UserStatus",$data->active)',
			'filter' => User::itemAlias("UserStatus"),
		),
		array(
        'class'=>'CButtonColumn',
        'template'=>'{activate} {deactivate} {update} {delete}', // <-- TEMPLATE WITH THE TWO STATES
        'htmlOptions'=>array(
                'width'=>90,
        ),
        'buttons' => array(
                'activate'=>array(
                        'label'=>'Activate',
                        'url'=>'Yii::app()->createUrl("Generation/active", array("id"=>$data->id_gen))',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/activate.png',
                        'visible'=> '$data->active == 0', // <-- SHOW IF ROW INACTIVE
                ),
                'deactivate'=>array(
                        'label'=>'Deactivate',
                        'url'=>'Yii::app()->createUrl("Generation/deactive", array("id"=>$data->id_gen))',
                        'imageUrl'=>Yii::app()->request->baseUrl.'/images/icons/deactivate.png',
                        'visible'=> '$data->active == 1', // <-- SHOW IF ROW ACTIVE
                ),
        ),
),
	),
)); ?>
		</div><!-- form -->
	</div>
</div>
</div>
