<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Roles'),
); ?>
<style type="text/css">
    .spacer {
        margin-top: 10px; /* define margin as you see fit */
    }
    .grid-view table.items th{
        background-image: none;
        border-color: #128EF2;
        background-color: #128EF2;
        color: #fff;
        font-size: 14px;
    }
</style>
<div class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo Rights::t('core', 'Roles'); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php echo Rights::t('core', 'A role is group of permissions to perform a variety of tasks and operations, for example the authenticated user.'); ?><br />
                <?php echo Rights::t('core', 'Roles exist at the top of the authorization hierarchy and can therefore inherit from other roles, tasks and/or operations.'); ?>
            </div>
            <div class="spacer"></div>
            <div class="buttons">

                <?php echo CHtml::link('<button class="btn btn-primary"><i></i>Create a new role</button>', array('authItem/create', 'type'=>CAuthItem::TYPE_ROLE), array(
                    'class'=>'add-role-link',
                )); ?>
            </div>
            <div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'yii-grid',
                    'dataProvider'=>$dataProvider,
                    'template'=>'{items}',
                    'emptyText'=>Rights::t('core', 'No roles found.'),
                    'htmlOptions'=>array('class'=>'grid-view role-table'),
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getGridNameLink()',
                        ),
                        array(
                            'name'=>'description',
                            'header'=>Rights::t('core', 'Description'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'description-column'),
                        ),
                        array(
                            'name'=>'bizRule',
                            'header'=>Rights::t('core', 'Business rule'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'bizrule-column'),
                            'visible'=>Rights::module()->enableBizRule===true,
                        ),
                        array(
                            'name'=>'data',
                            'header'=>Rights::t('core', 'Data'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'data-column'),
                            'visible'=>Rights::module()->enableBizRuleData===true,
                        ),
                        array(
                            'header'=>'อนุญาตเข้าสู่ระบบหลังบ้าน',
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'actions-column','style'=>'width:200px; text-align:center;'),
                            'value'=>function($data){
                                $authitem = Authitem::model()->findByAttributes(array('name'=>$data->name));
                                if($authitem->name == 'Admin'){
                                    return '';
                                }else {
                                    if (isset($authitem) && $authitem->name != '') {
                                        if ($authitem->canLoginBackEnd == "y") {
                                            return CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/check.png'),
                                                '#', array('class' => 'check', 'data-name' => $authitem->name));
                                        } else {
                                            return CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/delete.png'),
                                                '#', array('class' => 'uncheck', 'data-name' => $authitem->name));
                                        }
                                    } else {
                                        return CHtml::link(CHtml::image(Yii::app()->request->baseUrl . '/images/delete.png'),
                                            '#', array('class' => 'uncheck', 'data-name' => $authitem->name));
                                    }
                                }
                            }
                        ),
//                        array(
//                            'name'=>'canLoginBackEnd',
//                            'class'=>'JToggleColumn',
//                            'filter' => array('0' => 'ปิด', '1' => 'เปิด'), // filter
//                            'action'=>'toggle', // other action, default is 'toggle' action
//                            'checkedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/check.png',  // Image,text-label or Html
//                            'uncheckedButtonLabel'=>''.Yii::app()->request->baseUrl.'/images/delete.png', // Image,text-label or Html
//                            'labeltype'=>'image',// New Option - may be 'image','html' or 'text'
//                            'headerHtmlOptions'=>array(
//                                'style'=>'text-align:center;'
//                            ),
//                            'htmlOptions'=>array(
//                                'style'=>'text-align:center;width:100px;'
//                            ),
//                        ),
                        array(
                            'header'=>'&nbsp;',
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'actions-column'),
                            'value'=>'$data->getDeleteRoleLink()',
                        ),
                    )
                )); ?>
            </div>

            <div>
                <?php echo Rights::t('core', 'Values within square brackets tell how many children each item has.'); ?>
            </div>
        </div>
    </div>

</div>
<?php
Yii::app()->clientScript->registerScript('ajaxSetCanLogin',"
    $('.widget-body').on('click','.check',function () {
        var name = $(this).attr('data-name');
        $('img', this).attr('src','".Yii::app()->baseUrl."/images/loading.gif');
        $.post('".Yii::app()->createUrl('/rights/authItem/ajaxSetCanLogin')."',{name:name,status:'uncheck'},function(data){
            $.fn.yiiGridView.update('yii-grid');
        });
    });

    $('.widget-body').on('click','.uncheck',function () {
        var name = $(this).attr('data-name');
        $('img', this).attr('src','".Yii::app()->baseUrl."/images/loading.gif');
        $.post('".Yii::app()->createUrl('/rights/authItem/ajaxSetCanLogin')."',{name:name,status:'check'},function(data){
            $.fn.yiiGridView.update('yii-grid');
        });
    });

",CClientScript::POS_READY);
?>
