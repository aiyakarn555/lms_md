<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>-->
<?php
$titleName = 'ภาพรวมผลการเรียน';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
    $('#SearchFormAjax').submit(function(){
       /* $.fn.yiiGridView.update('$formNameModel-grid', {
            data: $(this).serialize()
        });*/
        return true;
    });
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
    /*$.updateGridView = function(gridID, name, value) {
        $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
        $.fn.yiiGridView.update(gridID, {data: $.param(
            $("#"+gridID+" input, #"+gridID+" .filters select")
        )});
    }
    $.appendFilter = function(name, varName) {
        var val = eval("$."+varName);
        $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
    }
    $.appendFilter("Report[news_per_page]", "news_per_page");*/

    $('.collapse-toggle').click();
    $('#Report_dateRang').attr('readonly','readonly');
    $('#Report_dateRang').css('cursor','pointer');
    $('#Report_dateRang').daterangepicker();

    $('.type').change(function(){
        var type = $(this).val();
        if(type == ''){
            $('.university').hide();
            $('.company').hide();
        }else if(type == 'university'){
            $('.university').show();
            $('.company').hide();
        }else{
            $('.university').hide();
            $('.company').show();
        }
    });

EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">
    <?php
    /**  */
    /*if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true){
        $attributes[] = array('name'=>'typeOfUser','type'=>'list','query'=>$model->typeOfUserList);
    }
    $attributes[] = array('name'=>'dateRang','type'=>'text');*/

    /*$this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>$attributes,
    ));*/
    ?>
    <div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
        <div class="widget-head">
            <h4 class="heading  glyphicons search"><i></i>ค้นหาขั้นสูง</h4>
        </div>
        <div class="widget-body collapse" style="height: 0px;">
            <div class="search-form">
                <div class="wide form">
                    <?php

                    $form=$this->beginWidget('CActiveForm', array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'id'=>'SearchFormAjax',
                    ));

                    if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true)
                    {

                    ?>
                        <div class="form-group">
                            <label>หน่วยงาน</label>
                            <?php
                            echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
                                'empty' => '---เลือกหน่วยงาน---',
                                'class' => 'form-control',
                                'style' => 'width:100%',
                                'ajax' =>
                                    array('type' => 'POST',
                                        'dataType' => 'json',
                                        'url' => CController::createUrl('/user/admin/division'), //url to call.
//                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
                                        'success' => 'function(data){
                                                        $("#division_id").empty();
                                                        $("#division_id").append(data.data_dsivision);
                                                        $("#position_id").empty();
                                                        $("#position_id").append(data.data_position);
                                                    }',
                                        'data' => array('company_id' => 'js:this.value'),
                                    ))); ?>
                            <?php echo $form->error($model, 'company_id'); ?>
                        </div>
                        <div class="form-group">
                            <label>ศูนย์/แผนก</label>
                            <?php
                            //                                        var_dump($model->division_id);
                            echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                            <?php echo $form->error($model, 'division_id'); ?>
                        </div>
                        <div class="form-group">
                            <label>ตำแหน่ง</label>
                            <?php
                            echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                            <?php echo $form->error($model, 'position_id'); ?>
                        </div>
                    <?php

                        echo '<div class="row">';
                        /** @var CActiveForm $form */
                        echo '<label>'.$model->getAttributeLabel('course').'</label>';
                        echo $form->dropDownList($model,'course',$model->CourseListFreedom,
                            array(
                                'empty'=>'เลือกหลักสูตร',
                                'class'=>'span6 type'
                            ));
                        echo '</div>';

                    }else{
                        $user = Yii::app()->getModule('user')->user();
                        $model->typeOfUser = $user->authitem_name;
                        $owner_id = $user->id;
                    }
                    echo '<div class="row">';
                    echo '<label>'.$model->getAttributeLabel('dateRang').'</label>';

                    echo $form->textField($model,'dateRang',array('class' => 'span6'));

                    echo '</div>';

                    echo '<div class="row">';
                        echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons search'),'<i></i> ค้นหา');
                        echo '</div>';
                    $this->endWidget();
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>
            <?php if($model->course!=""){ ?>
        <div class="widget-body">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            <div class="div-table">
                <!-- Table -->
                <table class="table table-bordered table-striped">

                    <!-- Table heading -->
                    <thead>
                    <tr>
                        <th class="center">บทเรียน</th>
                        <th class="center">จำนวนผู้เรียน</th>
                        <th class="center">ผ่าน</th>
                        <th class="center">ไม่ผ่าน</th>
                        <th class="center">%การจบ</th>
                    </tr>
                    </thead>
                    <!-- // Table heading END -->

                    <!-- Table body -->
                    <tbody>
                    <?php
                        $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $model->course . '" AND active ="y"', 'order' => 'title'));
                        $totalAllCount=0;
                        $totalPassCount=0;
                        foreach ($lesson as $key => $lessonItem) {
                        $lessonTitle[$key] = $lessonItem->title;
                        $lessonAllCount[$key] = 0;
                        $lessonPassCount[$key] = 0;
                        // Query tbl_Learn
                        $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
                        $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
                        
                        if($model->company_id !='' ) {
                            $sqlAll .= " AND tbl_users.company_id = '".$model->company_id."' ";
                        }
                            if($model->division_id !='' ) {
                                $sqlAll .= " AND tbl_users.division_id = '".$model->division_id."' ";
                            }
                            if($model->position_id !='' ) {
                                $sqlAll .= " AND tbl_users.position_id = '".$model->position_id."' ";
                            }

                        if($model->dateRang !='' ) {
                            list($start,$end) = explode(" - ",$model->dateRang);
                            $start = date("Y-m-d",strtotime($start))." 00:00:00";
                            $end = date("Y-m-d",strtotime($end))." 23:59:59";
                            $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                        }

                        $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

                        $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain INNER JOIN tbl_users ON learnmain.user_id = tbl_users.id";

                        $sqlPass .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1'
     AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')
     AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";


                            if($model->company_id !='' ) {
                                $sqlPass .= " AND tbl_users.company_id = '".$model->company_id."' ";
                            }
                            if($model->division_id !='' ) {
                                $sqlPass .= " AND tbl_users.division_id = '".$model->division_id."' ";
                            }
                            if($model->position_id !='' ) {
                                $sqlPass .= " AND tbl_users.position_id = '".$model->position_id."' ";
                            }
                        
                        if($model->dateRang !='' ) {
                            list($start,$end) = explode(" - ",$model->dateRang);
                            $start = date("Y-m-d",strtotime($start))." 00:00:00";
                            $end = date("Y-m-d",strtotime($end))." 23:59:59";
                            $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                        }

                        $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();
                    ?>
                        <tr>
                        <td><?php echo $lessonItem->title; ?></td>
                        <td class="center"><?php echo $lessonAllCount[$key]+=$allCount; ?></td>
                        <td class="center"><?php echo $lessonPassCount[$key]+=$passCount; ?></td>
                        <td class="center"><?php echo $allCount-$passCount; ?></td>
                        <td class="center"><?php echo number_format($passCount/(($allCount==0)?1:$allCount)*100,2); ?></td>
                        </tr>
                    <?php
                        $totalAllCount=$totalAllCount+$allCount;
                        $totalPassCount=$totalPassCount+$passCount;
                        }
                    ?>
                    <!-- // Table row END -->
                    <tr>
                        <td class="center"><strong>รวม</strong></td>
                        <td class="center"><strong><?php echo $totalAllCount; ?></strong></td>
                        <td class="center"><strong><?php echo $totalPassCount; ?></strong></td>
                        <td class="center"><strong><?php echo $totalAllCount-$totalPassCount; ?></strong></td>
                        <td class="center"><strong><?php echo number_format($totalPassCount/(($totalAllCount==0)?1:$totalAllCount)*100,2); ?></strong></td>
                    </tr>
                    </tbody>
                    <!-- // Table body END -->
                </table>
            </div>
            <!-- // Table END -->
            <br>
            <?php
            /*$params = explode("?",Yii::app()->request->getUrl());
            echo CHtml::link('<i></i> Export',"exportindex?".$params[1],array('class' => 'btn btn-primary btn-icon glyphicons file','target'=>'_blank'));*/
            ?>
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
        </div>
        <?php } ?>
    </div>
</div>
<?php
$data = '';
foreach ($lessonAllCount as $key => $value) {
    if($lessonPassCount[$key] !=0) {
        $data .= "['" . $lessonTitle[$key] . "',   " . number_format($lessonPassCount[$key]/(($lessonAllCount[$key]==0)?1:$lessonAllCount[$key])*100,2) . "],";
    }
}

Yii::app()->clientScript->registerScript('chart', "

    // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.

      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'บทเรียน');
        data.addColumn('number', '%การจบ');
        data.addRows([
          ".$data."
        ]);

        // Set chart options
        var options = {
        'title':'%การจบ',
        'width':'%100',
        is3D: true,
                       //'height':300
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('container'));

        google.visualization.events.addListener(chart, 'ready', function () {
            $.post('".$this->createUrl('report/saveChart')."',{name:'index',image_base64:chart.getImageURI()},function(json){
                var jsonObj = $.parseJSON( json );
            });
        });

        chart.draw(data, options);

      }

    $(function(){
      $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()+'<br><img src=".Yii::app()->getBaseUrl(true).'/uploads/index.png'.">' ));
        e.preventDefault();
      });
    });

", CClientScript::POS_END);

?>
