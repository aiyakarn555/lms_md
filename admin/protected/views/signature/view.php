
<?php
$this->breadcrumbs=array(
    'ระบบจัดการลายเซนต์'=>array('index'),
    $model->sign_title,
);
$this->widget('ADetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name'=>'sign_path',
            'type'=>'raw',
            'value'=> ($model->sign_path)?Controller::Image_path($model->sign_path,'signature'):'-',
        ),
        'sign_title',
        array(
                'label'=>'การแสดงผล',
                'format'=>'raw',
                'value'=>$model->getStatus()
            ),
        array(
            'name'=>'create_date',
            'value'=> ClassFunction::datethaiTime($model->create_date)
        ),
        array(
            'name'=>'create_by',
            'value'=>$model->usercreate->username
        )
    ),
)); ?>
