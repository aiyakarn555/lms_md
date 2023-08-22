
    <?php
    $titleName = 'Group';
    // $this->headerText = $titleName;
    $formNameModel = 'pGroup';
    $formNameId = "PGroup-grid";
    $this->breadcrumbs = array('จัดการ' . $titleName);
    Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameId").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("PGroup[news_per_page]", "news_per_page");
EOD
        , CClientScript::POS_READY);
    ?>
    <div class="innerLR">
    
        <div class="col-md-9">
            <a href="<?= Yii::app()->createUrl('pGroup/create'); ?>" type="button" class="btn btn-primary"><i
                        class="fa fa-plus" aria-hidden="true"></i> 
                เพิ่มกลุ่ม
            </a>
        </div>
        <div class="col-md-3 pull-right" style="text-align: right;">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1">แสดงแถว : </span>
                <?php echo $this->listPageShowNonCss($formNameModel); ?>
            </div>
        </div>
        <div class="col-md-12">
    <?php $this->widget('AGridView', array(
        'id' => $formNameId,
        'dataProvider' => $model->search(),
        'filter' => $model,
        'selectableRows' => 2,
        'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("pGroup[news_per_page]");
        }',
        'rowCssClassExpression' => '"items[]_{$data->id}"',
        'summaryText' => false, // 1st way
        'columns' => array(
            array(
//                'visible' => Helpers::lib()->DeleteAll(
//                    array("PController.*", "PController.Delete", "PController.MultiDelete")
//                ),
                'class' => 'CCheckBoxColumn',
                'id' => 'chk',
            ),
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'htmlOptions' => array('class' => 'text-center','style' => 'width: 200px;'),
            ),
            array(
                'header' => 'Group Id',
                'value' => '$data->id',
                'htmlOptions' => array('class' => 'text-center','style' => 'width: 200px;'),
            ),
            array(
                'name' => 'group_name',
                'type' => 'html',
                'value' => '$data->group_name'
            ),
//            array(
//                'class' => 'booster.widgets.TbToggleColumn',
//                'toggleAction' => 'pGroup/active',
//                'name' => 'active',
//                'header' => Yii::t('language','Active'),
//                'filter' => false,
//                'headerHtmlOptions'=>array('width'=>'70px'),
//                'checkedIcon' => 'glyphicon glyphicon-check',
//                'uncheckedIcon' => 'glyphicon glyphicon-unchecked',
//                'emptyIcon' => 'fa fa-question',
//            ),
            array(
                'class' => 'zii.widgets.grid.CButtonColumn',
                'htmlOptions' => array('style' => 'white-space: nowrap'),
                'afterDelete' => 'function(link,success,data) { if (success && data) alert(data); }',
                'template' => '{view} {update} {delete}',
                'buttons' => array(
                    'view' => array(
                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'View'),
                        'label' => '<button type="button" class="btn btn-primary"><i class="fa fa-list-alt"></i></button>',
                        'imageUrl' => false,
                    ),
                    'update' => array(
                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Update'),
                        'label' => '<button type="button" class="btn btn-warning"><i class="fa fa-pencil"></i></button>',
                        'imageUrl' => false,
                    ),
                    'delete' => array(
                        'options' => array('rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Delete'),
                        'label' => '<button type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>',
                        'imageUrl' => false,
                    )
                )
            ),
        ),
    )); ?>

    <?php if (Controller::DeleteAll(array("pGroup.*", "pGroup.Delete", "pGroup.MultiDelete"))) : ?>
        <!-- Options -->
        <div class="separator top form-inline small">
            <!-- With selected actions -->
            <div class="buttons pull-left">
                <?php echo CHtml::link("<i></i> ลบข้อมูลที่เลือก", "#", array(
                    "class" => "btn btn-primary btn-icon glyphicons circle_minus",
                    "onclick" => "return multipleDelete('" . $this->createUrl('//' . $formNameModel . '/MultiDelete') . "','$formNameId');"
                )); ?>
            </div>
            <!-- // With selected actions END -->
            <div class="clearfix"></div>
        </div>
        <!-- // Options END -->
    <?php endif; ?>
    </div>

</div>
