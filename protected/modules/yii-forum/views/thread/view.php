<?php

$this->widget('zii.widgets.CBreadcrumbs', array('links'=>$thread->getBreadcrumbs()));

$header = '<div class="preheader forum"><div class="preheaderinner">'. CHtml::encode($thread->subject) .'</div></div>';
$footer = $thread->is_locked?'':'<div class="footer">'. CHtml::link(CHtml::image(Yii::app()->controller->module->registerImage("newreply.gif")), array('/forum/thread/newreply', 'id'=>$thread->id)) .'</div>';
?>

<?php
    $this->widget('zii.widgets.CListView', array(
    	//'itemsCssClass'=>'table table-bordered table-striped',
        //'htmlOptions'=>array('class'=>'thread-view'),
        'dataProvider'=>$postsProvider,
        'emptyText' => 'ยังไม่มีข้อมูล',
        'summaryText' => 'แสดงความคิดเห็นทั้งหมด {count} ความคิดเห็น',
        'template'=>'{summary}{pager}'. $header .'{items}{pager}'. $footer,
        'itemView'=>'_post',
        'htmlOptions'=>array(
            'class'=>Yii::app()->controller->module->forumListviewClass,
            'style'=>'margin:20px 0;'
        ),
    ));
