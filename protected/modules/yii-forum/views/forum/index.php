<?php
$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('หน้าแรก', array('/site/index')),
    'links'=>array('กระดานสนทนา')
));

if(!Yii::app()->user->isGuest && Yii::app()->user->isAdmin()){
    echo '<div style="margin-top:10px;">'.CHtml::link('สร้างหมวดหมู่', array('/forum/forum/create'), array('class'=>'btn btn-primary')) .'</div>';
}

foreach($categories as $category)
{
    $this->renderpartial('_subforums', array(
        'forum'=>$category,
        'subforums'=>new CActiveDataProvider('Forum', array(
            'criteria'=>array(
                'scopes'=>array('forums'=>array($category->id)),
            ),
            'pagination'=>false,
        )),
    ));
}