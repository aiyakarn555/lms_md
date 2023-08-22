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
            <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">
                
            </div>
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

                //หา Course
                $course = CourseOnline::model()->findAll(array(
                    'condition' => 'active = "y"',
                    'order' => 'sortOrder'
                ));
                //จำนวน course
                $courseAllCountTotal = 0;
                //จำนวน course ที่ผ่าน
                $coursePassCountTotal = 0;
                $courseAllCount = array();
                $coursePassCount = array();

                // For Course
                foreach ($course as $key => $courseItem) {
                    $courseTitle[$key] = $courseItem->course_title; //เก็บชื่อ course
                    $courseAllCount[$key] = 0; //เก็บคีย์ course
                    $coursePassCount[$key] = 0; //เก็บคีย์ที่ผ่าน course
                    $coursePassScoreCount[$key] = 0; //ไม่รู้
                    ?>

                    <?php 
                        $dep=array();
                        $org=OrgCourse::model()->findAll('course_id='.$courseItem->course_id);
                        foreach ($org as $og) {
                            array_push($dep,$og->orgchart_id);
                        }

                        $criteria = new CDbCriteria();
                        $criteria->addCondition("id!='1'");
                        $criteria->compare('status','1');
                        $criteria->addInCondition('department_id',$dep);
                        $userCourse=User::model()->findAll($criteria);
                        
                        $lessonall = Lesson::model()->findAll(array('condition' => 'course_id = "' . $courseItem->course_id . '" AND active ="y"', 'order' => 'title'));
                        $pass=0;
                        $pass_score=0;
                        $count=0;
                        //for user
                        foreach ($userCourse as $uc) {

                            $count++;
                            $nopass=0;
                            $no_pass_score=0;



                            foreach ($lessonall as $lsall) {
                                // checkLessonPassById
                                $check=Helpers::lib()->checkLessonPassById($lsall,$uc->id,$date);
                     
                                // var_dump($check);

                                // var_dump($check);
                                // $criteria = new CDbCriteria();
                                // $criteria->with=array('learnI'); //,'file'
                                // $criteria->compare('learnI.lesson_id',$lsall->id);
                                // $criteria->compare('learnI.user_id',$uc->id);
                                // $criteria->compare('learn_file_status','s');
                                // $check_les=LearnFile::model()->find($criteria);

                                if($check!="pass"){
                                    $nopass=1;
                                    $no_pass_score=1;
                                    break;
                                    // $check_test=Score::model()->find('lesson_id='.$lsall->id.' AND user_id='.$check_les->user_id.' AND type="post" AND score_past="y"');         
                                }else{
                                    $criteria = new CDbCriteria();
                                    $criteria->compare('lesson_id',$lsall->id);
                                    $criteria->compare('user_id',$uc->id);
                                    $criteria->compare('type','post');
                                    $criteria->compare('score_past','y');
                                    $check_score=Score::model()->find($criteria);   

                                    if(!$check_score){
                                        $no_pass_score=1;
                                    }
                                }

                            }
                            if($nopass==0){
                                $pass++;

                                if($no_pass_score==0){
                                    $pass_score++;
                                }
                            }
                            
                            // end lessonAll
                        }
                ?>
                        <tr>
                            <td><?php echo $courseItem->course_title; ?></td>
                            <td class="center"><?php echo $courseAllCount[$key] += $count; ?></td>
                            <td class="center"><?php echo $coursePassCount[$key] += $pass; ?></td>
                            <td class="center"><?php echo $coursePassScoreCount[$key] += $pass_score; ?></td>
                            <!-- <td class="center"><?php //echo $count-$pass_score; ?></td> -->
                            <td class="center"><?php echo $pass_score/(($count==0)?1:$count)*100; ?></td>
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

$data="";
foreach ($courseAllCount as $key => $value) {
    if($coursePassScoreCount[$key] !=0) {
        $data .= "{name:'".$courseTitle[$key]."',y:".$coursePassScoreCount[$key]."},";
        // $data .= "['" . $courseTitle[$key] . "',   " . $coursePassScore[$key]/(($courseAllCount[$key]==0)?1:$courseAllCount[$key])*100 . "],";
       
    }
}


// Yii::app()->clientScript->registerScript('chart', "
//     $('#container').highcharts({
//         credits: {
//             enabled: false
//         },
//         chart: {
//             plotBackgroundColor: null,
//             plotBorderWidth: null,
//             plotShadow: false
//         },
//         title: {
//             text: 'Chart'
//         },
//         tooltip: {
//             pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
//         },
//         plotOptions: {
//             pie: {
//                 allowPointSelect: true,
//                 cursor: 'pointer',
//                 dataLabels: {
//                     enabled: true,
//                     format: '<b>{point.name}</b>: {point.percentage:.1f} %',
//                     style: {
//                         color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                     }
//                 }
//             }
//         },
//         series: [{
//             type: 'pie',
//             name: 'Browser share',
//             data: [
//             ".$data."
//             ]
//         }]
//     });

// ", CClientScript::POS_READY);
?>

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
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                "title": {
                    text: "Overall Grade"
                },
                 "tooltip": {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                "plotOptions": {
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
                "series": [{
                    "type": 'pie',
                    "name": 'Browser share',
                    "data": [
                        <?php echo $data; ?>
                    ]

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
                            $('#container').html('<img src="http://111.223.52.8/brotherLMS/admin/Export/file/'+ res + '" style="margin-left:200px;" /><br><br><br><br>');
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

