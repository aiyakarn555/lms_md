<?php
$this->breadcrumbs=array(
    'ระบบบทเรียน'=>array('index'),
    $model->cert_id,
);
$this->widget('ADetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name'=>'cert_background',
            'type'=>'raw',
            'value'=> ($model->cert_background)?Controller::Image_path($model->cert_background,'certificate'):'-',
        ),
        'cert_name',
        array(
                'label'=>'การแสดงผล',
                'format'=>'raw',
                'value'=>$model->getStatus()
            ),
         array(
                'label'=>'การแสดงผล',
                'format'=>'raw',
                'value'=>$model->getDisplay()
            ),
        array(
            'name'=>'create_date',
            'value'=> ClassFunction::datethaiTime($model->create_date)
        ),
        array(
            'name'=>'create_by',
            'value'=>$model->usercreate->username
        ),
        array(
            'name'=>'update_date',
            'value'=> ClassFunction::datethaiTime($model->create_date)
        ),
        array(
            'name'=>'update_by',
            'value'=>$model->usercreate->username
        )
    ),
)); ?>
