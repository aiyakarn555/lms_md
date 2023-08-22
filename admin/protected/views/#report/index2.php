<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
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

<!--  -->

<div class="innerLR">
   
    <!-- Advanced Search -->
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

                      
                    }else{
                        $user = Yii::app()->getModule('user')->user();
                        $model->typeOfUser = $user->authitem_name;
                        $owner_id = $user->id;
                    }
                    echo '<div class="row">';
                    echo '<label>'.$model->getAttributeLabel('dateRang').'</label>';
                    $this->widget('zii.widgets.jui.CJuiDatepicker', array(
                        'model'=>$model,
                        'attribute'=>'dateRang',
                        'htmlOptions' => array(
                            'class' => 'span6',
                        ),
                        'options' => array(
                            'mode'=>'focus',
                            'dateFormat'=>'dd/mm/yy',
                            'showAnim' => 'slideDown',
                            'showOn' => 'focus',
                            'showOtherMonths' => true,
                            'selectOtherMonths' => true,
                            'yearRange' => '-5:+2',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
                            'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
                                'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
                        )
                    ));
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
    <!-- Data Table -->
    <div class="widget" style="margin-top: -1px;">
        <!-- Data Table -->
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
        </div>
        <div class="widget-body" id="dvData">
            <!-- Chart -->
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
            <div id="divbr">
               
            </div>
            <!-- Table -->
            <table class="table table-bordered table-striped">
                <!-- Table heading -->
                <thead>
                <tr>
                    <th class="center">หลักสูตร/หัวข้อวิชา</th>
                    <th class="center">จำนวนผู้เรียน</th>
                    <th class="center">ผ่านบทเรียน</th>
                    <th class="center">ผ่านการสอบ</th>
              <!--       <th class="center">ไม่ผ่าน</th> -->
                    <th class="center">%การจบ</th>
                </tr>
                </thead>
                <!-- // Table heading END -->
                <!-- Table body -->
                <tbody>
                <!-- Table row -->
                <?php

                // $cate_type = array('university'=>1,'company'=>2);
                $course = CourseOnline::model()->findAll(array(
                    'condition' => 'active = "y"',
                    'order' => 'sortOrder'
                ));
                $courseAllCountTotal = 0;
                $coursePassCountTotal = 0;
                $courseAllCount = array();
                $coursePassCount = array();
                // For Course
                foreach ($course as $key => $courseItem) {
                    $courseTitle[$key] = $courseItem->course_title;
                    $courseAllCount[$key] = 0;
                    $coursePassCount[$key] = 0;
                    $coursePassScoreCount[$key] = 0;
                    ?>

                <?php
                    // criteria
                    $criteria = new CDbCriteria();
                    $criteria->with=array('les.courseonlines');
                    $criteria->compare('CourseOnline.active','y');
                    $criteria->compare('CourseOnline.course_id',$courseItem->course_id);
                    $criteria->compare('Lesson.active','y');
                    $criteria->group='user_id';
        
                    $model_lesson=Learn::model()->findAll($criteria);
                    $count=0;
                    $count_score=0;
                    $dont_pass=0;
                    $dont_score_pass=0;

                    foreach($model_lesson as $ls) {

                        $count=$count+1;
                        $count_score=$count_score+1;
                        if(isset($owner_id)) {
                            $lessonall = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                        }else{
                            $lessonall = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
                        }
                        $check=1;
                        $check1=1;

                        foreach ($lessonall as $lsall) {

                            $check_ls=Learn::model()->find('lesson_id='.$lsall->id.' AND user_id='.$ls->user_id);

                            // if($check_ls->lesson_status!="pass"){
                            //     $check=0;
                            //     $check1=0;
                            //     break;
                            // }
                            // checkLessssonPassById($lsall->id,$ls->user_id,'')
                            // $check_ls = Helpers::lib()->checkLessonPassById($lsall->id, $ls->user_id, $model->dateRang);
                            
                            if($check_ls!="pass"){
                                $check=0;
                                $check1=0;
                                break;
                            }

                            $check_score=Score::model()->find('lesson_id='.$lsall->id.' AND user_id='.$ls->user_id.' AND type="post" AND score_past="y"');
                            
                            if(!$check_score){
                                $check1=0;
                                break;
                            }
                        }
                           
                        if($check==0){
                            $dont_pass=$dont_pass+1;
                        }
                        // echo $check1;
                        if($check1==0){
                            $dont_score_pass=$dont_score_pass+1;
                        }
                    }
                    $pass=$count-$dont_pass;
                    $pass_score=$count_score-$dont_score_pass;
                ?>
                    <?php
                    // foreach ($lesson as $lessonItem) {
                    //     /** @var Lesson $lessonItem */
                    //     $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
                    //     $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
                        
                    //     if($model->typeOfUser !='' ) {
                    //         $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                    //     }

                    //     if($model->dateRang !='' ) {
                    //         list($start,$end) = explode(" - ",$model->dateRang);
                    //         $start = date("Y-d-m",strtotime($start))." 00:00:00";
                    //         $end = date("Y-d-m",strtotime($end))." 23:59:59";
                    //         $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                    //     }

                    //     $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

                    //     $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain INNER JOIN tbl_users ON learnmain.user_id = tbl_users.id";
                    //     // if($model->typeOfUser == 'university' ) {
                    //     //     $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                    //     // }
                    //     $sqlPass .= " WHERE lesson_id = '".$lessonItem->id."' AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's') AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";

                    //     // if($model->typeOfUser == 'university' ) {
                    //     //     if($model->university != '') {
                    //     //         $sqlPass .= " AND university.id = '".$model->university."' ";
                    //     //     }
                    //     // }

                    //     if($model->typeOfUser !='' ) {
                    //         $sqlPass .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                    //     }

                    //     if($model->dateRang !='' ) {
                    //         list($start,$end) = explode(" - ",$model->dateRang);
                    //         $start = date("Y-d-m",strtotime($start))." 00:00:00";
                    //         $end = date("Y-d-m",strtotime($end))." 23:59:59";
                    //         $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                    //     }

                    //     $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();
                        ?>
                         
                        <!-- <tr>
                            <td ><?php// echo $lessonItem->title; ?></td>
                            <td class="center"><?php //echo $courseAllCount[$key] += $allCount; ?></td>
                            <td class="center"><?php //echo $coursePassCount[$key] += $passCount; ?></td>
                            <td class="center"><?php //echo $allCount-$passCount; ?></td>
                            <td class="center"><?php //echo $passCount/(($allCount==0)?1:$allCount)*100; ?></td>
                        </tr> -->
                <?php
                    // } // end for lesson
                ?>
                        <tr>
                            <td><?php echo $courseItem->course_title; ?></td>
                            <td class="center"><?php echo $courseAllCount[$key] += $count; ?></td>
                            <td class="center"><?php echo $coursePassCount[$key] += $pass; ?></td>
                            <td class="center"><?php echo $coursePassScoreCount[$key] += $pass_score; ?></td>
                            <!-- <td class="center"><?php //echo $count-$pass_score; ?></td> -->
                            <td class="center"><?php echo $pass_score/(($count==0)?1:$allCount)*100; ?></td>
                        </tr>
                <?php
                    $courseAllCountTotal += $courseAllCount[$key];
                    $coursePassCountTotal += $coursePassCount[$key];
                    $coursePassScoreCountTotal +=$coursePassScoreCount[$key];
                }
                ?>
                <tr>
                    <td class="center"><strong>รวม</strong></td>
                    <td class="center"><strong><?php echo $courseAllCountTotal; ?></strong></td>
                    <td class="center"><strong><?php echo $coursePassCountTotal; ?></strong></td>
                    <td class="center"><strong><?php echo $coursePassScoreCountTotal; ?></strong></td>
                    <!-- <td class="center"><strong><?php //echo $courseAllCountTotal-$coursePassScoreCountTotal; ?></strong></td> -->
                    <td class="center"><strong><?php echo number_format($coursePassScoreCountTotal/(($courseAllCountTotal==0)?1:$courseAllCountTotal)*100,2); ?></strong></td>
                </tr>
                <!-- // Table row END -->

                </tbody>
                <!-- // Table body END -->

            </table>
            <!-- // Table END -->

        </div>
        <div class="text-center">
            <input type="button" id="btnExport" value=" Export Excel" class="btn btn-primary" />
        </div><br>
    </div>
</div>
<?php

$data = '';

foreach ($courseAllCount as $key => $value) {
    if($coursePassScore[$key] !=0) {
        $data .= "['" . $courseTitle[$key] . "',   " . $coursePassScore[$key]/(($courseAllCount[$key]==0)?1:$courseAllCount[$key])*100 . "],";
        
    }
}


Yii::app()->clientScript->registerScript('chart', "

    $('#container').highcharts({
        credits: {
            enabled: false
        },
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'ภาพรวมผลการเรียน'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Browser share',
            data: [
            ".$data."
            ]
        }]
    });

", CClientScript::POS_READY);
?>

<script>
    $("#btnExport").click(function(e) {
        $('#divbr').html("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#dvData').html()));
        e.preventDefault();
         $('#divbr').html("");
    });
</script>