<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Tasks'),
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
<div id="tasks" class="innerLR">

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo Rights::t('core', 'Tasks'); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php echo Rights::t('core', 'A task is a permission to perform multiple operations, for example accessing a group of controller action.'); ?><br />
                <?php echo Rights::t('core', 'Tasks exist below roles in the authorization hierarchy and can therefore only inherit from other tasks and/or operations.'); ?>
            </div>
            <div class="spacer"></div>
            <div class="buttons">
                <?php echo CHtml::link(Rights::t('core', 'Create a new task'), array('authItem/create', 'type'=>CAuthItem::TYPE_TASK), array(
                    'class'=>'add-task-link btn btn-primary',
                )); ?>
            </div>
            <div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>'{items}',
                    'emptyText'=>Rights::t('core', 'No tasks found.'),
                    'htmlOptions'=>array('class'=>'grid-view task-table'),
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
                            'header'=>'&nbsp;',
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'actions-column'),
                            'value'=>'$data->getDeleteTaskLink()',
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