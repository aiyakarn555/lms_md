<?php
$formNameModel = 'LogApi';
$titleName = 'Log การส่งข้อมูล API';



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
	$.appendFilter("LogApi[news_per_page]", "news_per_page");
EOD
    , CClientScript::POS_READY);
?>
    <!-- <div class="separator bottom form-inline small">
    <span class="pull-right">
        <label class="strong">แสดงแถว:</label>
        <?php echo $this->listPageShow($formNameModel);?>
    </span>
    </div> -->

    <?php $this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'schedule_id','type'=>'text'),
            // array('name'=>'course_number','type'=>'text'),
            // array('name'=>'course_lecturer','type'=>'list','query'=>CHtml::listData(Teacher::model()->findAll(array(
            // "condition"=>" active = 'y' ")),'teacher_id', 'teacher_name')),
             array('name'=>'log_event','type'=>'text'),
            // array('name'=>'course_price','type'=>'text'),
            //array('name'=>'course_point','type'=>'text'),
        ),
    ));?>

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
                    //'filter'=>$model,
                    'selectableRows' => 2,
                    'rowCssClassExpression'=>'"items[]_{$data->log_id}"',
                    'htmlOptions' => array(
                        'style'=> "margin-top: -1px;",
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        $.appendFilter("LogApi[news_per_page]");
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
        array(
            'header' => 'IP',
            'name'=>'search_passport',
            'type'=>'raw',
            'value'=>function($data){
                return $data->log_ip;
            }
        ),
        array(
            'header' => 'กิจกรรม',
            'name'=>'search_name',
            'type'=>'raw',
            'value'=>function($data){
                return $data->log_event;
            }
        ),
        array(
            'header' => 'ข้อมูล',
            'name'=>'controller',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $this->getStrLog($data);
            }
        ),
        // array(
        //     'header' => 'data',
        //     'name'=>'data',
        //     'type'=>'raw',
        //     'filter' => false,
        //     'value'=>function($data){
        //         return ( $data->log_data);
        //     }
        // ),
        array(
            'header' => 'วันและเวลา',
            'name'=>'create_date',
            'type'=>'raw',
            'filter' => false,
            'value'=>function($data){
                return $data->log_date;
            }
        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
