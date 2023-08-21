<style>
    .quiz {
        list-style-type: none;
        margin-bottom: 40px;
    }

    .quiz li {
        float: left;
        margin-right: 20px;
    }

    .head-quiz {
        padding-left: 20px;
        padding-right: 20px;
    }

    thead {
        background-color: #00A550;
        color: #292929;
        font-size: 22px;
    }

    .mb-quiz {
        margin-bottom: 10px;
    }
    .form-control{
        border: 1px solid #D1D1D1;
    }
    .radio label::before {
        border: 1px solid #4193D0;
    }
    .checkbox label::before {
        border: 1px solid #4193D0;
    }
    .ml-15{
        margin-left: 15px;
    }
    .mb-10{
        margin-bottom: 15px;;
    }
    .span5 {
        width: 500px;
    }
</style>
<div class="container" style="margin-bottom: 30px;">
    <div class="text-center bg-transparent margin-none">
<?php
$this->breadcrumbs = array(
    'หลักสูตร'=>array('//category/index'),
    'แบบทดสอบ',
);
?>
<style>
    .title-question{
        font-size: 22px;
    }

    #question-form p{
        display: inline;
    }
</style>

    </div>


    <div class="page-section">
        <div class="panel panel-default head-quiz">
            <div class="row">
                
           <?php
    $i = 0;
    foreach ($model as $get_model){
        $ModdelOnline = CourseOnline::model()->findByPk($get_model->course_id);
        $sumPoint = number_format($get_model->score_number/$get_model->score_total*100,2);
        if($get_model->score_past == 'n'){ $textPast = '<font color="#CC0000"><b>ไม่ผ่าน</b></font>'; }else{ $textPast = '<font color="#00994D"><b>ผ่าน</b></font>'; }
       if($get_model->type == 'pre'){
            ?>
    <div class="col-md-12 col-sm-12" style="margin-top: 20px;margin-bottom: 30px;text-align: center;"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/head-subject/quiz.png" alt="person" style="margin-top: -15px;"/><span style="font-size: 50px;color: rgb(60, 60, 60);">ผลการสอบก่อนเรียน</span></div>
    <table class="table table-bordered table-striped">
        <thead><tr class="odd"><th class="span3" style="vertical-align:top;"></th><td bgcolor="#ffffff">รายละเอียด</td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">ชื่อหลักสูตร</th><td bgcolor="#ffffff"><?php echo $ModdelOnline->course_title; ?></td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">คะแนนที่คุณได้</th><td bgcolor="#ffffff"><span style="font-size: 18px;"><b><?php echo $get_model->score_number.' / '.$get_model->score_total.' คะแนน'; ?></b></span></td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">คิดเป็นเปอร์เซ็น</th><td bgcolor="#ffffff"><span style="font-size: 18px;"><b><?php echo $sumPoint.' เปอร์เซ็น'; ?></b></span></td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">ผลการสอบครั้งนี้</th><td bgcolor="#ffffff"><?php echo $textPast;?></td></tr></thead>
    </table>

        <?php
        }else{
            $i++;
        ?>
    <div class="col-md-12 col-sm-12" style="margin-top: 20px;margin-bottom: 30px;text-align: center;"><span style="font-size: 50px;color: rgb(60, 60, 60);">ผลการสอบหลักสูตร ครั้งที่ (<?=$i?>)</span></div>
    <table class="table table-bordered table-striped">
        <thead><tr class="odd"><th class="span3" style="vertical-align:top;"></th><td bgcolor="#ffffff">รายละเอียด</td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">ชื่อหลักสูตร</th><td bgcolor="#ffffff"><?php echo $ModdelOnline->course_title; ?></td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">คะแนนที่คุณได้</th><td bgcolor="#ffffff"><span style="font-size: 18px;"><b><?php echo $get_model->score_number.' / '.$get_model->score_total.' คะแนน'; ?></b></span></td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">คิดเป็นเปอร์เซ็น</th><td bgcolor="#ffffff"><span style="font-size: 18px;"><b><?php echo $sumPoint.' เปอร์เซ็น'; ?></b></span></td></tr></thead>
        <thead><tr class="even"><th class="span3" style="vertical-align:top;">ผลการสอบครั้งนี้</th><td bgcolor="#ffffff"><?php echo $textPast;?></td></tr></thead>
    </table>
<?php

        }

    }
    ?>
<a href="<?=Yii::app()->createUrl('course/index',array())?>" class="navbar-btn btn-mk btn-mk-success" style="margin-bottom: 10px;">ย้อนกลับ</a>
            </div>
        </div>
    </div>

</div>