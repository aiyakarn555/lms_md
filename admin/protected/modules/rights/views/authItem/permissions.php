<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Permissions'),
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
<div id="permissions" class="innerLR">

    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo Rights::t('core', 'Permissions'); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
                <?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
                    '{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
                    '{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
                    '{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
                )); ?>
            </div>
            <div class="spacer"></div>
            <div class="buttons">
                <?php echo CHtml::link(Rights::t('core', 'Generate items for controller actions'), array('authItem/generate'), array(
                    'class'=>'generator-link btn btn-primary',
                )); ?>
            </div>
            <div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'dataProvider'=>$dataProvider,
                    'template'=>'{items}',
                    'emptyText'=>Rights::t('core', 'No authorization items found.'),
                    'htmlOptions'=>array('class'=>'grid-view permission-table'),
                    'columns'=>$columns,
                )); ?>
            </div>

            <div>
                *) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?>
            </div>
        </div>
    </div>


	<script type="text/javascript">

		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});

	</script>

</div>
