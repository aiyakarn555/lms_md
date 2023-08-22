<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/Export/socket.io.js"></script>


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
                    if(isset(Yii::app()->user->isSuperuser) && Yii::app()->user->isSuperuser == true) {
        
                        if($model->categoryUniversity==NULL){
                            foreach ($model->categoryUniiversityList as $key => $val) {
                                $model->categoryUniversity=$key;
                                break;
                            }
                        }
                        
                        
                        echo '<div class="row">';
                        echo "<label>หลักสูตร</label>";
                        echo $form->dropDownList($model, 'categoryUniversity', $model->categoryUniiversityList,
                            array(
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
        <div class="widget-bod  y" id="dvData">
        <meta http-equiv=Content-Type content="text/html; charset=utf-8">
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto" class="text-center">
                
            </div>
            <div id="divbr">
               
            </div>
            <!-- Table -->
            <div class="div-table" style="overflow:auto;" >
            <table class="table table-bordered table-striped">
                <!-- Table heading -->
                <thead>
                <tr>
                    <th style="width: 60px;" class="center">ลำดับที่</th>
                    <th class="center">ชื่อ-นามสกุล</th>
                    <?php
                    $cate_type = array('university'=>1,'company'=>2);
                    if($model->typeOfUser != '') {
                        $cate_id = '';
                        if($model->typeOfUser == 'university'){
                            if($model->categoryUniversity != ''){
                                $cate_id = $model->categoryUniversity;
                            }
                        }
                        if($model->typeOfUser == 'company'){
                            if($model->categoryCompany != ''){
                                $cate_id = $model->categoryCompany;
                            }
                        }
                        if($cate_id == '') {
                            $course = CourseOnline::model()->with('cates')->findAll(array(
                                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                                'order' => 'sortOrder'
                            ));
                        }else{
                            $course = CourseOnline::model()->with('cates')->findAll(array(
                                'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                                'order' => 'sortOrder'
                            ));
                        }
                    }else{
                        $course_id = $model->categoryUniversity;
                        
                        $course = CourseOnline::model()->findAll(array(
                            'condition' => 'active = "y" AND course_id='.$course_id,
                            'order' => 'sortOrder'
                        ));
                    }
                    $courseAllCountTotal = 0;
                    $coursePassCountTotal = 0;
                    $courseAllCount = array();
                    $coursePassCount = array();

                    foreach ($course as $key => $courseItem) {
                        $courseTitle[$key] = $courseItem->course_title;
                        $courseAllCount[$key] = 0;
                        $coursePassCount[$key] = 0;

                        if(isset($owner_id)) {
                            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                        }else{
                            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
                        }
                        foreach ($lesson as $lessonItem) {/** @var Lesson $lessonItem */
                            $sqlAll = " SELECT COUNT(*) FROM tbl_learn INNER JOIN tbl_users ON tbl_learn.user_id = tbl_users.id ";
                            if($model->typeOfUser == 'university') {
                                $sqlAll .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                            }
                            $sqlAll .= " WHERE lesson_id = '".$lessonItem->id."' AND tbl_users.status = '1' ";
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
                                $start = date("Y-d-m",strtotime($start))." 00:00:00";
                                $end = date("Y-d-m",strtotime($end))." 23:59:59";
                                $sqlAll .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                            }

                            $allCount = Yii::app()->db->createCommand($sqlAll)->queryScalar();

                            $sqlPass = " SELECT COUNT(*) FROM tbl_learn learnmain INNER JOIN tbl_users ON learnmain.user_id = tbl_users.id";
                            if($model->typeOfUser == 'university' ) {
                                $sqlPass .= " INNER JOIN university ON tbl_users.student_house = university.id ";
                            }
                            $sqlPass .=" WHERE lesson_id = '".$lessonItem->id."' AND (SELECT COUNT(*) FROM tbl_file WHERE lesson_id = learnmain.lesson_id) = (SELECT COUNT(*) FROM tbl_learn_file WHERE learn_id = learnmain.learn_id AND learn_file_status = 's')";
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
                                $start = date("Y-d-m",strtotime($start))." 00:00:00";
                                $end = date("Y-d-m",strtotime($end))." 23:59:59";
                                $sqlPass .= " AND learn_date BETWEEN '" . $start . "' AND '".$end."'";
                            }
                            $passCount = Yii::app()->db->createCommand($sqlPass)->queryScalar();
                            $courseAllCount[$key] += $allCount;
                            $coursePassCount[$key] += $passCount;

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
                    $sqlUser = " SELECT *,tbl_users.id AS user_id FROM tbl_users INNER JOIN tbl_profiles ON tbl_users.id = tbl_profiles.user_id ";
                    $sqlUser .= " WHERE status='1' ";
                    
                    if($model->typeOfUser !='' ) {
                        $sqlUser .= ' AND authitem_name = "'.$model->typeOfUser.'" ';
                    }
                    // CDB Criteria Join

                    $orgcourse=OrgCourse::model()->findAll('course_id='.$course_id);
                    $org_id=array();
                    foreach ($orgcourse as $oc) {
                        array_push($org_id,$oc->orgchart_id);
                    }

                    $criteria = new CDbCriteria();
                    $criteria->with=array('user');
                    // $criteria->compare('CourseOnline.course_id',$courseItem->course_id);
                    $criteria->compare('status','1');
                    $criteria->addInCondition('department_id',$org_id);
                    $user=profiles::model()->findAll($criteria);
                 
                    // $user = Yii::app()->db->createCommand($sqlUser)->queryAll();
                    $orderNumber = 1;
                    $statusArray = array(
                        'pass'=>'<div style="color: green;"><strong>ผ่าน</strong></div>',
                        'learning'=>'<div style="color: #0000ff;"><strong>กำลังเรียน</strong></div>',
                        'notLearn'=>'<div style="color: red;"><strong>ไม่ได้เข้าเรียน</strong></div>',
                    );
                    $lesAllCount=array();
                    $lesPassCount=array();
                    foreach ($user as $userItem) { /** @var User $userItem */?>
                    <tr>
                        <td class="center"><?php echo $orderNumber++; ?></td>
                        <td class="center"><?php echo $userItem->firstname." ".$userItem->lastname; ?></td>
                        <?php
                        $cate_type = array('university'=>1,'company'=>2);
                        if($model->typeOfUser != '') {
                            $cate_id = '';
                            if($model->typeOfUser == 'university'){
                                if($model->categoryUniversity != ''){
                                    $cate_id = $model->categoryUniversity;
                                }
                            }
                            if($model->typeOfUser == 'company'){
                                if($model->categoryCompany != ''){
                                    $cate_id = $model->categoryCompany;
                                }
                            }
                            if($cate_id == '') {
                                $course = CourseOnline::model()->with('cates')->findAll(array(
                                    'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '"',
                                    'order' => 'sortOrder'
                                ));
                            }else{
                                $course = CourseOnline::model()->with('cates')->findAll(array(
                                    'condition' => 'courseonline.active = "y" AND cate_type="' . $cate_type[$model->typeOfUser] . '" AND categorys.cate_id ="'.$cate_id.'"',
                                    'order' => 'sortOrder'
                                ));
                            }
                        }else{
                            $course = CourseOnline::model()->findAll(array(
                                'condition' => 'active = "y"',
                                'order' => 'sortOrder'
                            ));
                        }
                        // 
                        if(isset($owner_id)) {
                            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $course_id . '" AND active ="y" AND create_by ="'.$owner_id.'"', 'order' => 'title'));
                        }else{
                            $lesson = Lesson::model()->findAll(array('condition' => 'course_id = "' . $course_id . '" AND active ="y"', 'order' => 'title'));
                        }
                        $passJa=0;
                        $notpassJa=0;
                        $allLes=0;
                        
                        foreach ($lesson as $key => $lessonItem) {
                        ?>
                            <td>
                               <?php  
                                    $criteria = new CDbCriteria();
                                    $criteria->compare('lesson_id',$lesson_Item->id);
                                    $criteria->compare('user_id',$userItem->user_id);
                                    $criteria->compare('type',"post");
                                    $criteria->compare('score_past',"y");
                                    $score=Score::model()->find($criteria);
                                    if($score){
                                        echo $statusArray['pass']; 
                                        $lesPassCount[$key] = $lesPassCount[$key]+1;
                                    }else{
                                        $file=File::model()->findAll('lesson_id='.$lessonItem->id);
                                        $i=0;
                                        foreach ($file as $fl) {
                                            $learnfile=LearnFile::model()->find('user_id_file='.$userItem->user_id." AND file_id=".$fl->id);
                                            if($learnfile){
                                                 $i=1;
                                            }
                                        }
                                        if($i==1){
                                            echo $statusArray['learning'];
                                        }else{  
                                            echo $statusArray['notLearn'];
                                        }
                                        
                                    }
                               ?> 

                            </td>
                             <!-- foreach ($lesson as $lessonItem) {/** @var Lesson $lessonItem */ ?> -->
                                <!-- <td><?php //echo $statusArray[Helpers::lib()->checkLessonPassById($lessonItem,$userItem['user_id'],$model->dateRang)]; ?></td> -->
                            <?php
                            $lesAllCount[$key] =$lesAllCount[$key]+1;
                           
                            // }
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

        </div>
    </div>
</div>
<?php
$categories = '';
$pass = '';
$notPass = '';
    foreach ($lesson as $key => $lessonItem) {
        $categories .= "'".$lessonItem->title."',";
        $pass .= $lesPassCount[$key].",";
        $notPass .= $lesAllCount[$key] - $lesPassCount[$key].",";
        
    }
// foreach ($courseAllCount as $key => $value) {
//     if($value !=0) {
//         $categories .= "'".$courseTitle[$key]."',";
//         $pass .= $coursePassCount[$key].",";
//         $notPass .= $courseAllCount[$key] - $coursePassCount[$key].",";
//     }
// }

// Yii::app()->clientScript->registerScript('chart', "

//     $('#container').highcharts({
//         credits: {
//             enabled: false
//         },
//         chart: {
//             type: 'column'
//         },
//         title: {
//             text: '".$titleName."'
//         },
//         xAxis: {
//             categories: [
//                 ".$categories."
//             ],
//             crosshair: true
//         },
//         yAxis: {
//             min: 0,
//             title: {
//                 text: 'จำนวนคน'
//             }
//         },
//         tooltip: {
//             headerFormat: '<span style=\"font-size:10px\">{point.key}</span><table>',
//             pointFormat: '<tr><td style=\"color:{series.color};padding:0\">{series.name}: </td>' +
//                 '<td style=\"padding:0\"><b>{point.y} คน</b></td></tr>',
//             footerFormat: '</table>',
//             shared: true,
//             useHTML: true
//         },
//         plotOptions: {
//             column: {
//                 pointPadding: 0.2,
//                 borderWidth: 0
//             }
//         },
//         series: [{
//             name: 'ผ่าน',
//             data: [".$pass."]

//         }, {
//             name: 'ไม่ผ่าน',
//             data: [".$notPass."]

//         }]
//     });

// ", CClientScript::POS_READY);
?>
<div class="text-center">
<input type="button" id="btnExport" value=" Export Excel" class="btn btn-primary" />
</div>


<div class="output form-horizontal" style="display: none">
    <div>
        <strong class="col-sm-2 text-right">Size:</strong>
        <div class="col-sm-10">
            <span class="size"></span>
        </div>
    </div>
    <div>
        <strong class="col-sm-2 text-right">Text:</strong>
        <div class="col-sm-10">
            <textarea class="form-control textbox"></textarea>
        </div>
    </div>
    <div>
        <strong class="col-sm-2 text-right">Link:</strong>
        <div class="col-sm-10">
            <a href="#" class="link"></a>
        </div>
    </div>
    <div>
        <strong class="col-sm-2 text-right">Image:</strong>
        <div class="col-sm-10">
            <img class="img">
        </div>
    </div>
</div>

<script>

    var socket = io('111.223.52.8:3334');
    $(function () {
        var exportUrl = 'http://export.highcharts.com/';
        function testPOST() {
            
            var optionsStr = JSON.stringify({
                "credits": {
                    enabled: false
                },
                "chart": {
                    type: 'column'
                },
                "title": {
                    text: "The follow-up report"
                },
                "xAxis": {
                    categories: [
                        "<?php echo $categories; ?>"
                    ],
                    crosshair: true
                },
                "yAxis": {
                    min: 0,
                    title: {
                        text: 'People'
                    }
                },
                 "tooltip": {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y} คน</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                "plotOptions": {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                "series": [{
                    "name": 'Pass',
                    "data": [<?php echo $pass; ?>]

                }, {
                    "name": 'Not Pass',
                    "data": [<?php echo $notPass; ?>]

                }]
            }),
            dataString = encodeURI('async=true&type=jpeg&width=600&options=' + optionsStr);

            if (window.XDomainRequest) {
                var xdr = new XDomainRequest();
                xdr.open("post", exportUrl+ '?' + dataString);
                xdr.onload = function () {
                    console.log(xdr.responseText);
                    $('#container').html('<img src="' + exporturl + xdr.responseText + '" />');
                };
                xdr.send();
            } else {
                $.ajax({
                    type: 'POST',
                    data: dataString,
                    url: exportUrl,
                    success: function (data) {
                        console.log('get the file from relative url: ', data);
                        // $('#container').html('<img src="' + exportUrl + data + '" />');
                        var link=exportUrl+data;
                        var res = data.substring(6);
                        console.log('res -> '+res);
                        socket.emit('FREEDOM', { my: link, name: res });
                        socket.on('res', function (data) {
                            $('#container').html('<img src="http://111.223.52.8/brotherLMS/admin/Export/file/'+ res + '" /><br><br><br><br>');
                        });
                    },
                    error: function (err) {
                        debugger;
                        console.log('error', err.statusText)
                    }
                });
            }

        }
        testPOST();

    });
    // $("#btnExport").click(function (e) {
    //     window.open('data:application/vnd.ms-excel,' + $('#dvData').html());
    //     e.preventDefault();
    // });
    $("#btnExport").click(function(e) {
        $('#divbr').html("<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>");
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( $('#dvData').html()));
        e.preventDefault();
         $('#divbr').html("");
    });
</script>



