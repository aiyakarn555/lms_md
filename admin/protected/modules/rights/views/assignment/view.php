<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Assignments'),
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
    .name-column{
        vertical-align: top;
    }
</style>
<div id="assignments" class="innerLR">

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo Rights::t('core', 'Assignments'); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php echo Rights::t('core', 'Here you can view which permissions has been assigned to each user.'); ?>
            </div>
            <div class="spacer"></div>
            <div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>"{items}\n{pager}",
                    'emptyText'=>Rights::t('core', 'No users found.'),
                    'htmlOptions'=>array('class'=>'grid-view assignment-table'),
                    'columns'=>array(
                        array(
                            'name'=>'name',
                            'header'=>Rights::t('core', 'Name'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'name-column'),
                            'value'=>'$data->getAssignmentNameLink()',
                        ),
                        array(
                            'name'=>'assignments',
                            'header'=>Rights::t('core', 'Roles'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'role-column'),
                            'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
                        ),
                        array(
                            'name'=>'assignments',
                            'header'=>Rights::t('core', 'Tasks'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'task-column'),
                            'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
                        ),
                        array(
                            'name'=>'assignments',
                            'header'=>Rights::t('core', 'Operations'),
                            'type'=>'raw',
                            'htmlOptions'=>array('class'=>'operation-column'),
                            'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
                        ),
                    )
                )); ?>
            </div>

        </div>
    </div>

</div>