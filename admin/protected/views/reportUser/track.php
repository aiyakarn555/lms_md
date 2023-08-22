<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานติดตามผลการเรียน';
$formNameModel = 'Report';

$this->breadcrumbs=array($titleName);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
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
    /*$this->widget('AdvanceSearchForm', array(
        'data'=>$model,
        'route' => $this->route,
        'attributes'=>array(
            array('name'=>'typeOfUser','type'=>'list','query'=>$model->typeOfUserList),
            array('name'=>'course','type'=>'list','query'=>$model->courseList),
            array('name'=>'dateRang','type'=>'text'),

            //array('name'=>'course_point','type'=>'text'),
        ),
    ));*/?>

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
                    if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true) {

                        echo '<div class="row">';
                        /** @var CActiveForm $form */
                        echo "<label>หลักสูตร</label>";
                        echo $form->dropDownList($model, 'categoryUniversity', $model->categoryUniiversityList,
                            array(
                                'empty' => 'ทั้งหมด',
                                'class' => 'span6'
                            ));
                        echo '</div>';

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

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName;?></h4>
		</div>
        <div class="widget-body">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

            <!-- Table -->
            <div class="div-table" style="overflow:auto;">
            <table class="table table-bordered table-striped">

                <!-- Table heading -->
                <thead>
                <tr>
                    <th style="width: 60px;" class="center">ลำดับที่</th>
                    <th style="width: 120px;" class="center">ชื่อ นามสกุล</th>
                    <?php
                    $cate_type = array('university'=>1,'company'=>2);
                    if($model->typeOfUser == ''){
                        if(isset($_GET["Report"]["categoryUniversity"]) && $_GET["Report"]["categoryUniversity"] !=''){
                            $lesson = Lesson::model()->findAll(array(
                                'condition' => 'course_id='.$_GET["Report"]["categoryUniversity"],
                            ));
                        }else{
                            $lesson = Lesson::model()->findAll();
                        }
                    }
                    $lessonAllCountNotLearnTotal = 0;
                    $lessonAllCountTotal = 0;
                    $lessonPassCountTotal = 0;
                    $lessonAllCountNotLearn = array();
                    $lessonAllCount = array();
                    $lessonPassCount = array();

//                    var_dump($lesson);
//                    exit();
                    foreach ($lesson as $key => $lessonItem) {

                        $lessonTitle[$key] = $lessonItem->title;
                        $lessonAllCountNotLearn[$key] = 0;
                        $lessonAllCount[$key] = 0;
                        $lessonPassCount[$key] = 0;

                        if(isset($owner_id)) {
                            $lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                        }else{
                            $lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y"', 'order' => 'title'));
                        }
                        foreach ($lesson as $lessonItem) {/** @var Lesson $lessonItem */

                            $sqlAllNotLearn = " SELECT COUNT(*) FROM tbl_users INNER JOIN tbl_orgchart ON tbl_users.department_id = tbl_orgchart.id
                            INNER JOIN tbl_org_course ON tbl_orgchart.id = tbl_org_course.orgchart_id
                            INNER JOIN tbl_lesson ON tbl_lesson.course_id = tbl_org_course.course_id ";
                            $sqlAllNotLearn .= " WHERE tbl_lesson.id = '".$lessonItem->id."' AND tbl_users.status = '1'";
                            if($model->typeOfUser == 'university' ) {
                                if($model->university != '') {
                                    $sqlAllNotLearn .= " AND university.id = '".$model->university."' ";
                                }
                            }
                            if($model->typeOfUser !='' ) {
                                $sqlAllNotLearn .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                            }

                            if($model->company_id !='' ) {
                                $sqlAllNotLearn .= " AND tbl_users.company_id = '".$model->company_id."' ";
                            }
                            if($model->division_id !='' ) {
                                $sqlAllNotLearn .= " AND tbl_users.division_id = '".$model->division_id."' ";
                            }
                            if($model->position_id !='' ) {
                                $sqlAllNotLearn .= " AND tbl_users.position_id = '".$model->position_id."' ";
                            }


                            $allCountNotLearn = Yii::app()->db->createCommand($sqlAllNotLearn)->queryScalar();

                            /*$sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
                            $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1'";
                            if($model->typeOfUser == 'university' ) {
                                if($model->university != '') {
                                    $sqlAll .= " AND university.id = '".$model->university."' ";
                                }
                            }
                            if($model->typeOfUser !='' ) {
                                $sqlAll .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                            }
                            if($model->dateRang !='' ) {
                                list($start,$end) = explode(" - ",$model->dateRang);
                                $start = date("Y-m-d",strtotime($start))." 00:00:00";
                                $end = date("Y-m-d",strtotime($end))." 23:59:59";
                                $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                            }

                            if($model->asc !='' ) {
                                $sqlAll .= " AND tbl_users.asc_id = '".$model->asc."' ";
                            }

                            $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();*/

                            $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain
 INNER JOIN tbl_users
 ON learnmain.user_id = tbl_users.id";
                            if($model->typeOfUser == 'university' ) {
                                $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                            }
                    $sqlPass .="
 WHERE lesson_id = '".$lessonItem->id."'
 AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')";
 /*$sqlPass .="
 WHERE lesson_id = '".$lessonItem->id."'
 AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')
 AND ((SELECT COUNT(*) FROM tbl_score WHERE lesson_id = learnmain.lesson_id AND user_id = learnmain.user_id AND tbl_score.type='post' AND score_past='y') > 0 OR (SELECT COUNT(*) FROM tbl_manage WHERE id = learnmain.lesson_id AND type='post') = 0)";*/

                            if($model->typeOfUser == 'university' ) {
                                if($model->university != '') {
                                    $sqlPass .= " AND university.id = '".$model->university."' ";
                                }
                            }

                            if($model->typeOfUser !='' ) {
                                $sqlPass .= " AND authitem_name = '" . $model->typeOfUser . "' ";
                            }

                            if($model->dateRang !='' ) {
                                list($start,$end) = explode(" - ",$model->dateRang);
                                $start = date("Y-m-d",strtotime($start))." 00:00:00";
                                $end = date("Y-m-d",strtotime($end))." 23:59:59";
                                $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                            }


                            if($model->company_id !='' ) {
                                $sqlPass .= " AND tbl_users.company_id = '".$model->company_id."' ";
                            }
                            if($model->division_id !='' ) {
                                $sqlPass .= " AND tbl_users.division_id = '".$model->division_id."' ";
                            }
                            if($model->position_id !='' ) {
                                $sqlPass .= " AND tbl_users.position_id = '".$model->position_id."' ";
                            }


                            $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();

                            $lessonAllCountNotLearn[$key] += $allCountNotLearn;
                            // $lessonAllCount[$key] += $allCount;
                            $lessonPassCount[$key] += $passCount;

                            ?>
                        <th class="center"><?php echo $lessonItem->title; ?></th>
                        <?php
                        }

                    }
                    ?>

                </tr>
                </thead>
                <!-- // Table heading END -->

                <!-- Table body -->
                <tbody>
                
                <!-- Table row -->
                <?php
                $learnUser = Learn::model()->findAll(array(
                    'select'=>'distinct user_id'
                ));

                $learnUserArray = array();
                foreach($learnUser as $user){
                    $learnUserArray[] = $user->user_id;
                }
                $sqlUser = " SELECT *,tbl_users.id AS user_id FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id ";

                if($model->typeOfUser == 'university') {
                    $sqlUser .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                }

                $sqlUser .= " WHERE status='1' ";


                if($model->company_id !='' ) {
                    $sqlUser .= " AND tbl_users.company_id = '".$model->company_id."' ";
                }
                if($model->division_id !='' ) {
                    $sqlUser .= " AND tbl_users.division_id = '".$model->division_id."' ";
                }
                if($model->position_id !='' ) {
                    $sqlUser .= " AND tbl_users.position_id = '".$model->position_id."' ";
                }

                if(count($learnUserArray) == 0){
                    $learnUserArray = array(0);
                }

                $sqlUser .= " AND user_id IN (".implode(",",$learnUserArray).") ";
//                $sqlUser .= " WHERE status='1' ";

                if($model->typeOfUser == 'university' ) {
                    if($model->university != '') {
                        $sqlUser .= " AND university.id = '".$model->university."' ";
                    }
                }

                if($model->typeOfUser !='' ) {
                    $sqlUser .= ' AND authitem_name = "'.$model->typeOfUser.'" ';
                }

                $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
                $orderNumber = 1;
                $statusArray = array(
                    'pass'=>'<div style="color: green;"><strong>ผ่าน</strong></div>',
                    'learning'=>'<div style="color: #0000ff;"><strong>กำลังเรียน</strong></div>',
                    'notLearn'=>'<div style="color: red;"><strong>ไม่ได้เข้าเรียน</strong></div>',
                );
                foreach ($user as $userItem) { /** @var User $userItem */?>
                <tr>

                    <td class="center"><?php echo $orderNumber++; ?></td>
                    <td class="center"><?php echo $userItem['firstname']." ".$userItem['lastname']; ?></td>
                    <?php
                    $cate_type = array('university'=>1,'company'=>2);
                    if($model->typeOfUser == ''){
                        if(isset($_GET["Report"]["categoryUniversity"]) && $_GET["Report"]["categoryUniversity"] !=''){
                            $lesson = Lesson::model()->findAll(array(
                                'condition' => 'course_id='.$_GET["Report"]["categoryUniversity"],
                            ));
                        }else{
                            $lesson = Lesson::model()->findAll();
                        }
                    }

                    foreach ($lesson as $key => $lessonItem) {
                        if(isset($owner_id)) {
                            $lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                        }else{
                            $lesson = Lesson::model()->findAll(array('condition' => 'id = "' . $lessonItem->id . '" AND active ="y"', 'order' => 'title'));
                        }

                        foreach ($lesson as $lessonItem) {/** @var Lesson $lessonItem */ ?>
                            <td><?php echo $statusArray[Helpers::lib()->checkLessonPassById($lessonItem,$userItem['user_id'],$model->dateRang)]; ?></td>
                        <?php
                        }

                    }
                    ?>
                </tr>
                <?php } ?>
                <!-- // Table row END -->

                </tbody>
                <!-- // Table body END -->

            </table>
            <!-- // Table END -->

            </div>
            <?php
            /*$params = explode("?",Yii::app()->request->getUrl());
            echo CHtml::link('<i></i> Export',"exporttrack?".$params[1],array('class' => 'btn btn-primary btn-icon glyphicons file','target'=>'_blank'));*/
            ?>
            <button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>

        </div>
	</div>
</div>
<?php

$categories = '';
$pass = '';
$notPass = '';
$all = '';

$data = "['บทเรียน', 'ผ่าน', 'ไม่ผ่าน', 'ทั้งหมด'],";
foreach ($lessonAllCountNotLearn as $key => $value) {
    if($value !=0) {
        $categories = "'".$lessonTitle[$key]."'";
        $pass = $lessonPassCount[$key];
        // $notPass = $lessonAllCount[$key] - $lessonPassCount[$key];
        $notPass = $lessonAllCountNotLearn[$key] - $lessonPassCount[$key];
        $all = $lessonAllCountNotLearn[$key];
        $data .= "[".$categories.",".$pass.",".$notPass.",".$all."],";
    }
}
$strFileName = "รายงานติดตามผลการเรียน-".date('YmdHis').".xlsx";
Yii::app()->clientScript->registerScript('chart', "

  google.load('visualization', '1.0', {packages:['corechart']});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ".$data."
    ]);

    var options = {
        title: 'เปรียบเทียบจำนวนผู้ที่เรียนผ่านกับเรียนไม่ผ่าน',
        //hAxis: {title: 'บทเรียน'}
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('container'));

    google.visualization.events.addListener(chart, 'ready', function () {
        $.post('".$this->createUrl('report/saveChart')."',{name:'track',image_base64:chart.getImageURI()},function(json){
            var jsonObj = $.parseJSON( json );
        });
    });

    chart.draw(data, options);
  }

  $(function(){
      $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>".$titleName."</h2>'+$('.div-table').html()+'<br><img src=".Yii::app()->getBaseUrl(true).'/uploads/track.png'.">' ));
        e.preventDefault();
      });
  });
", CClientScript::POS_END);
?>
