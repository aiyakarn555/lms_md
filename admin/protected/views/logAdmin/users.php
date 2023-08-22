<?php
$formNameModel = 'LogUsers';
$titleName = 'Log การใช้งานผู้เรียน';

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
	$.appendFilter("LogUsers[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);
?>
    <!-- <div class="separator bottom form-inline small">
    <span class="pull-right">
        <label class="strong">แสดงแถว:</label>
        <?php echo $this->listPageShow($formNameModel);?>
    </span>
    </div> -->
    <div class="innerLR">
<div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>
        <div class="widget-body">
            <div class="separator bottom form-inline small">
                <span class="pull-right">
                    <label class="strong">แสดงแถว:</label>
                    <?php echo $this->listPageShow($formNameModel);?>
                </span> 
            </div>
            <div class="clear-div"></div>
            <div class="overflow-table">
                <?php $this->widget('AGridView', array(
                    'id'=>$formNameModel.'-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'selectableRows' => 2,
                    'rowCssClassExpression'=>'"items[]_{$data->id}"',
                    'htmlOptions' => array(
                        'style'=> "margin-top: -1px;",
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        $.appendFilter("LogUsers[news_per_page]");
                        InitialSortTable(); 
                        jQuery("#course_date").datepicker({
                            "dateFormat": "dd/mm/yy",
                            "showAnim" : "slideDown",
                            "showOtherMonths": true,
                            "selectOtherMonths": true,
                            "yearRange" : "-5+10", 
                            "changeMonth": true,
                            "changeYear": true,
                            "dayNamesMin" : ["อา.","จ.","อ.","พ.","พฤ.","ศ.","ส."],
                            "monthNamesShort" : ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.",
                                "ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."],
                       })
                    }',
                    'columns'=>array(
                        array(
            'header' => 'ลำดับ',
            // 'name' => 'cert_id',
            'sortable' => false,
            'htmlOptions' => array(
                'width' => '40px',
                'text-align' => 'center',
            ),
            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        // array(
        //     'header' => 'รหัสบัตรประชาชน - พาสปอร์ต',
        //     'name'=>'search_passport',
        //     'type'=>'raw',
        //     'value'=>function($data){
        //         return $data->member->identification;
        //     }
        // ),
        array(
            'header' => 'ชื่อ - นามสกุล',
            'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                if ($data->member->firstname_en != null && $data->member->lastname_en != null) {
                    return $data->member->firstname_en . ' ' . $data->member->lastname_en;
                }else{
                    return $data->member->firstname . ' ' . $data->member->lastname;
                } 
            }
        ),
        array(
            'header' => 'ฟังก์ชั่นการใช้งาน',
            'name'=>'controller',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                if($data->module){
                    $text = Helpers::lib()->changeNameFunction($data->module);
                } else {
                    $text = Helpers::lib()->changeNameFunction($data->controller);
                }
                return $text;
            }
        ),
        array(
            'header' => 'รายละเอียด',
            'name'=>'action',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                $link = '';
                $action = $data->action;
                $text = Helpers::lib()->changeNameFunction($data->action);
                return $text;
            }
        ),
        array(
            'header' => 'วันและเวลา',
            'name'=>'create_date',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->create_date;
            }
        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
