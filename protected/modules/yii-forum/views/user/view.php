<?php
$this->widget('zii.widgets.CBreadcrumbs', array('links'=>array(
    'ฟอร์ม'=>array('/forum'),
    $user->name
)));

$siglink = (!Yii::app()->user->isGuest && (Yii::app()->user->isAdmin() || Yii::app()->user->forumuser_id == $user->id))?' ['. CHtml::link('แก้ไข', array('user/update', 'id'=>$user->id)) .']':'';

$this->widget('ADetailView', array(
    'data'=>$user,
    'attributes'=>array(
        array(
            'name'=>'-',
            'value'=>'รายละเอียด',
        ),
        array(
            'label'=>'ชื่อผู้ใช้',
            'value'=>$user->name,
        ),
        array(
            'label'=>'First seen',
            'value'=>Yii::app()->controller->module->format_date($user->firstseen),
        ),
        array(
            'label'=>'Last seen',
            'value'=>Yii::app()->controller->module->format_date($user->lastseen),
        ),
        array(
            'label'=>'จำนวนการโพส',
            'value'=>$user->postCount,
        ),
        array(
            'label'=>'โปรไฟล์',
            'type'=>'html',
            'value'=>isset(Yii::app()->controller->module->userUrl)?CHtml::link('Details', $this->evaluateExpression(Yii::app()->controller->module->userUrl, array('id'=>$user->siteid))):'n/a',
        ),
        array(
            'name'=>'signature',
            'label'=>'Signature'. $siglink,
            // 'type'=>'html',
        ),
    ),
    // 'htmlOptions'=>array(
    //     'class'=>Yii::app()->controller->module->forumDetailClass,
    // )
));
