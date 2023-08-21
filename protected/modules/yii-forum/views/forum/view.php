<?php
$this->widget('zii.widgets.CBreadcrumbs', array(
	'homeLink'=>CHtml::link('หน้าแรก', array('/site/index')),
    'links'=>$forum->getBreadcrumbs(),
));

$this->renderPartial('_subforums', array(
    'inforum'=>true,
    'forum' => $forum,
    'subforums' => $subforumsProvider,
));

$newthread = $forum->is_locked?'':'<div class="newthread" style="float:right;">'. CHtml::link(CHtml::image(Yii::app()->controller->module->registerImage("newthread.gif")), array('/forum/thread/create', 'id'=>$forum->id)) .'</div>';

$gridColumns = array(
    array(
        'name' => 'กระทู้ / โดย',
        'headerHtmlOptions' => array('colspan' => '2'),
        'type' => 'html',
        'value' => 'CHtml::image(Yii::app()->controller->module->registerImage("folder". ($data->is_locked?"locked":"") .".gif"), ($data->is_locked?"Locked":"Unlocked"), array("title"=>$data->is_locked?"Thread locked":"Thread unlocked"))',
        'htmlOptions' => array('style' => 'width:20px;'),
    ),
    array(
        'name' => 'subject',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'type' => 'html',
        'value' =>'$data->renderSubjectCell()',
    ),
    array(
        'name' => 'postCount',
        'header' => 'ตอบ',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'htmlOptions' => array('style' => 'width:65px; text-align:center;'),
    ),
    array(
        'name' => 'view_count',
        'header' => 'ดู',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'htmlOptions' => array('style' => 'width:65px; text-align:center;'),
    ),
    array(
        'name' => 'ตอบล่าสุด',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'type' => 'html',
        'value' => '$data->renderLastpostCell()',
        'htmlOptions' => array('style' => 'width:200px; text-align:right;'),
    ),
);

// For admins, add column to delete and lock/unlock threads
$isAdmin = !Yii::app()->user->isGuest && Yii::app()->user->isAdmin();
if($isAdmin)
{
    // Admin links to show in extra column
    $deleteConfirm = "คุณแน่ใจหรือไม่ว่าจะลบหัวข้อนี้? คำตอบในหัวข้อจะถูกลบไปด้วย!";
    $gridColumns[] = array(
        'class'=>'CButtonColumn',
        'header'=>'จัดการ',
        'template'=>'{delete}{update}',
        'deleteConfirmation'=>"js:'".$deleteConfirm."'",
        'afterDelete'=>'function(){document.location.reload(true);}',
        'buttons'=>array(
            'delete'=>array('url'=>'Yii::app()->createUrl("/forum/thread/delete", array("id"=>$data->id))'),
            'update'=>array('url'=>'Yii::app()->createUrl("/forum/thread/update", array("id"=>$data->id))'),
        ),
        'htmlOptions' => array('style' => 'width:40px;'),
    );
}

$this->widget('forum.extensions.groupgridview.GroupGridView', array(
    'itemsCssClass'=>'table table-bordered table-striped',
    'enableSorting' => false,
    'selectableRows' => 0,
    // 'emptyText'=>'', // No threads? Show nothing
    // 'showTableOnEmpty'=>false,
    'preHeader' => CHtml::encode($forum->title),
    'preHeaderHtmlOptions' => array(
        'class' => 'preheader',
    ),
    'dataProvider' => $threadsProvider,
    'template'=>'{summary}'. $newthread .'{pager}{items}{pager}'. $newthread,
    'extraRowColumns' => array('is_sticky'),
    'extraRowExpression' => '"<b>".($data->is_sticky?"Sticky threads":"กระทู้ปกติ")."</b>"',
    'columns' => $gridColumns,
    'htmlOptions'=>array(
        'class'=>Yii::app()->controller->module->forumTableClass,
    ),
	'summaryText'=>'แสดง {start}-{end} จาก {count} หน้า {page} จาก {pages}',
));

