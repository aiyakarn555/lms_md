<?php
/* @var $this UsabilityController */
/* @var $dataProvider CActiveDataProvider */
/*
$this->breadcrumbs=array(
	'Usabilities',
);

$this->menu=array(
	array('label'=>'Create Usability', 'url'=>array('create')),
	array('label'=>'Manage Usability', 'url'=>array('admin')),
);
?>

<h1>Usabilities</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); */?>
<style>
	.custom-color1{
		background-color: #2599F8;
	}
</style>
<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i class="fa fa-fw fa-archive"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none">วิธีการใช้งาน</h3>
                <!--                <p class="text-white text-subhead" style="font-size: 1.6rem;">รวมข่าวสารของ Brother</p>-->
            </div>
        </div>
    </div>
</div>
<div class="container">
		<div class="panel panel-default paper-shadow" data-z="0.5" style="margin-top: 25px;">
			<div class="panel-body">
				<?php echo htmlspecialchars_decode($usability_data->usa_detail)?>
			</div>
		</div>
</div>