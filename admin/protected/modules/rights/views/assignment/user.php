<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Assignments')=>array('assignment/view'),
	$model->getName(),
); ?>

<div id="userAssignments" class="innerLR">

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo Rights::t('core', 'Assignments for :username', array(
                    ':username'=>$model->getName()
                )); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <div class="assignments first">

                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'dataProvider'=>$dataProvider,
                        'template'=>'{items}',
                        'hideHeader'=>true,
                        'emptyText'=>Rights::t('core', 'This user has not been assigned any items.'),
                        'htmlOptions'=>array('class'=>'grid-view user-assignment-table mini'),
                        'columns'=>array(
                            array(
                                'name'=>'name',
                                'header'=>Rights::t('core', 'Name'),
                                'type'=>'raw',
                                'htmlOptions'=>array('class'=>'name-column'),
                                'value'=>'$data->getNameText()',
                            ),
                            array(
                                'name'=>'type',
                                'header'=>Rights::t('core', 'Type'),
                                'type'=>'raw',
                                'htmlOptions'=>array('class'=>'type-column'),
                                'value'=>'$data->getTypeText()',
                            ),
                            array(
                                'header'=>'&nbsp;',
                                'type'=>'raw',
                                'htmlOptions'=>array('class'=>'actions-column'),
                                'value'=>'$data->getRevokeAssignmentLink()',
                            ),
                        )
                    )); ?>

                </div>

                <div class="add-assignment last">

                    <div class="widget" style="margin-top: -1px;">
                        <div class="widget-head">
                            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo Rights::t('core', 'Assign item'); ?></h4>
                        </div>

                        <div class="widget-body">
                        <?php if( $formModel!==null ): ?>

                            <div>

                                <?php $this->renderPartial('_form', array(
                                    'model'=>$formModel,
                                    'itemnameSelectOptions'=>$assignSelectOptions,
                                )); ?>

                            </div>

                        <?php else: ?>
                            <p class="info"><?php echo Rights::t('core', 'No assignments available to be assigned to this user.'); ?>

                            <?php endif; ?>
                        </div>
                    </div>











                </div>
            </div>
        </div>
    </div>

</div>
