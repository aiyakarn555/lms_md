
    <?php
    $titleName = 'Controller';
    // $this->headerText = $titleName;
    $formNameModel = 'PController';
    $formNameId = "PController-grid";
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
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("PController[news_per_page]", "news_per_page");
EOD
        , CClientScript::POS_READY);



    $str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
 		function installSortable() {
            $('#".$formNameId." tbody').sortable({
                items: 'tr',
                forceHelperSize: false,
                forcePlaceholderSize: true,
                tolerance: 'pointer',
                axis: 'y',
                update : function () {
                    serial = $('#".$formNameId." tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
                    $.ajax({
                        'url': '" . $this->createUrl('PController/priority',array('model'=>$formNameModel)) . "',
                        'type': 'post',
                        'data': serial,
                        'success': function(data){
                            $.fn.yiiGridView.update('".$formNameId."');
                        },
                        'error': function(request, status, error){
                            alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                        }
                    });
                },
                helper: fixHelper
            });
            $('#".$formNameId." tbody').disableSelection();
        }
        installSortable();
        
        function reInstallSortable(id, data) {
            installSortable();
            
        }
    ";

    Yii::app()->clientScript->registerScript('controller', $str_js,CClientScript::POS_END);

    ?>
<div class="innerLR">

        <div class="col-md-9">
            <div class="btn-group" role="group" aria-label="...">
                <a href="<?=Yii::app()->createUrl('pController/create');?>" type="button" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>
                    เพิ่ม Controller
                </a>

            </div>
        </div>
        <div class="col-md-3 pull-right" style="text-align: right;">
            <div class="input-group">
                 <span class="input-group-addon" id="basic-addon1">แสดงแถว : </span>
                <?php echo $this->listPageShowNonCss($formNameModel); ?>
            </div>
        </div>
        <div class="col-md-12">
    <?php $this->widget('booster.widgets.TbGridView', array(
        'id'=>'PController-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'afterAjaxUpdate'=>'function(id, data){
            $.appendFilter("PController[news_per_page]");
            reInstallSortable();
        }',
        'selectableRows' => 2,
        'rowCssClassExpression' => '"items[]_{$data->id}"',
        'summaryText' => false, // 1st way
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'chk',
            ),
            array(
                'header' => 'No.',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            ),
            array(
                'name' => 'title',
                'type' => 'html',
                'value' => '$data->title'
            ),
            array(
                'name' => 'controller',
                'type' => 'html',
                'value' => '$data->controller'
            ),
           /* array(
                'class' => 'booster.widgets.TbToggleColumn',
                'toggleAction' => 'pcontroller/active',
                'name' => 'active',
                'header' => Yii::t('language','Active'),
                'filter' => false,
                'headerHtmlOptions'=>array('width'=>'70px'),
                'checkedIcon' => 'glyphicon glyphicon-check',
                'uncheckedIcon' => 'glyphicon glyphicon-unchecked',
                'emptyIcon' => 'fa fa-question',
            ),*/
            array(            // display 'author.username' using an expression
                'header'=>'priority',
                'type'=>'raw', //because of using html-code <br/>
                'htmlOptions'=>array('style'=>'text-align: center; width:100px;'),
                'value'=>'CHtml::label("<i class=\"fa fa-arrows\"></i>","");',
            ),
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
    </div>
    <?php if (Controller::DeleteAll(array("PController.*", "PController.Delete", "PController.MultiDelete"))) : ?>
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