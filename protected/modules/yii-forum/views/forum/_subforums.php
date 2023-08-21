<?php

$isAdmin = !Yii::app()->user->isGuest && Yii::app()->user->isAdmin();

$gridColumns = array(
    array(
        'name' => 'Forum',
    	'header' => 'หมวดหมู่',
        'headerHtmlOptions' => array('colspan' => '2'),
        'type' => 'html',
        'value' => 'CHtml::image(Yii::app()->controller->module->registerImage("on.gif"), "On")',
        'htmlOptions' => array('style' => 'width:22px;'),
    ),
    array(
        'name' => 'forum',
        'headerHtmlOptions' => array('style' => 'display:none'),
        'type' => 'html',
        'value' => '$data->renderForumCell()',
        'htmlOptions' => array('style' => ' text-align:left;'),
    ),
    array(
        'name' => 'threadCount',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'header' => 'ถาม',
        'htmlOptions' => array('style' => 'width:65px; text-align:center;'),
    ),
    array(
        'name' => 'postCount',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'header' => 'ตอบ',
        'htmlOptions' => array('style' => 'width:65px; text-align:center;'),
    ),
    array(
        'name' => 'Last post',
    	'header' => 'ตอบล่าสุด',
        'headerHtmlOptions' => array('style' => 'text-align:center;'),
        'type' => 'html',
        'value' => '$data->renderLastpostCell()',
        'htmlOptions' => array('style' => 'width:200px; text-align:right;'),
    ),
);

if(isset($inforum) && $inforum == true)
    $preheader = '<div style="text-align:center;">หมวดหมู่ "' . CHtml::encode($forum->title) . '"</div>';
else
    $preheader = CHtml::link(CHtml::encode($forum->title), $forum->url);

// Add some admin controls
if($isAdmin)
{
    $deleteConfirm = "ยืนยันการลบหมวดหมู่หรือไม่ ?";

    $adminheader =
        '<div class="admin" style="float:right; font-size:smaller;">'.
            CHtml::link('สร้างหมวดหมู่', array('/forum/forum/create', 'parentid'=>$forum->id)) .' | '.
            CHtml::link('แก้ไข', array('/forum/forum/update', 'id'=>$forum->id)) .' | '.
            CHtml::ajaxLink('ลบหมวดหมู่',
                array('/forum/forum/delete', 'id'=>$forum->id),
                array('type'=>'POST', 'success'=>'function(){document.location.reload(true);}'),
                array('confirm'=>$deleteConfirm)
            ).
        '</div>';

    $preheader = $adminheader . $preheader;

    // Admin links to show in extra column
    $gridColumns[] = array(
        'class'=>'CButtonColumn',
        'header'=>'จัดการ',
        'template'=>'{delete}{update}',
        'deleteConfirmation'=>"js:'".$deleteConfirm."'",
        'afterDelete'=>'function(){document.location.reload(true);}',
        'buttons'=>array(
            'delete'=>array('url'=>'Yii::app()->createUrl("/forum/forum/delete", array("id"=>$data->id))'),
            'update'=>array('url'=>'Yii::app()->createUrl("/forum/forum/update", array("id"=>$data->id))'),
        ),
        'htmlOptions' => array('style' => 'width:40px;'),
    );
}

$this->widget('forum.extensions.groupgridview.GroupGridView', array(
    'itemsCssClass'=>'table table-bordered table-striped',
    'enableSorting' => false,
    'summaryText' => '',
    'selectableRows' => 0,
    //'emptyText' => 'No forums found',
	'emptyText' => false,
    'showTableOnEmpty'=>$isAdmin,
    'preHeader'=>$preheader,
    'preHeaderHtmlOptions' => array(
        'class' => 'preheader',
    ),
    'dataProvider'=>$subforums,
    'columns' => $gridColumns,
    'htmlOptions'=>array(
        'class'=>Yii::app()->controller->module->forumTableClass,
    )
));
