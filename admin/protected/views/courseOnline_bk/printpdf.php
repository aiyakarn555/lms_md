<style type="text/css">
    body {
        background-image: url("<?php echo Yii::app()->baseUrl."/images/certificate_bronew.jpg"; ?>");
        background-image-resize: 1;
        background-repeat: no-repeat;
        /*font-family: arial, tahoma, helvetica, sans-serif;*/
    }

    div {
        text-align: center;
        width: 246mm;
        /*background-color: red;*/
    }
</style>

<div style="position:absolute; top: 57mm; font-size: 20px; font-family: 'timesf';">
    ASC Name : GNINE CO.,LTD.
</div>

<div style="position:absolute; top: 68mm; font-weight: bold; font-size: 5em; font-family: 'kunstler';">
    <?php echo ucfirst($model->Profiles->firstname) . " " . ucfirst($model->Profiles->lastname); ?>
</div>

<div style="position:absolute; top: 101mm; font-size: 20px; font-family: 'timesf';">
    Has successfully completed Brother Commercial Thailand’s
</div>
<div style="position:absolute; top: 110mm; font-size: 20px; font-family: 'timesf';">
    Course and Technical Exam
</div>
<div style="position:absolute; top: 119mm; font-size: 20px; font-family: 'timesf';">
    for the following course:
</div>
<div style="position:absolute; top: 130mm; font-size: 24px; font-weight: bold; font-family: 'garait';">
    <?php echo str_replace("หลักสูตร", "", $model->CourseOnlines->course_title); ?>
</div>

<div style="position:absolute; top: 145mm; font-size: 14px;">
    <?php
    $date=date_create($model->passcours_date);
    echo date_format($date,"d F Y");
    ?>
</div>
<?php
if($_GET['style']==1){
 ?>

    <div style="position:absolute; top: 165mm; font-size: 14px;">
        <div style="clear: both"></div>
        <div style="float: left; width: 30%; padding-left: 20%">
            <div><hr style="width: 200px;"></div>
            <span style="color: #789FB2; font-size: 1.2em; font-family: 'timesf';">Worrasak Praditkul</span>
            <div style="font-family: 'timesf';">General Manager</div>
            <div style="font-family: 'timesf';">Customer Service</div>
        </div>
        <div style="float: left; width: 30%; padding-right: 20%;">
            <div><hr style="width: 200px;"></div>
            <span style="color: #789FB2; font-size: 1.2em; font-family: 'timesf';">Tomoyuki Fujimoto</span>
            <div style="font-family: 'timesf';">Managing Director</div>
            <div style="font-family: 'timesf';">(Thailand)</div>
        </div>
        <div style="clear: both"></div>
    </div>

<?php
}else{
?>

    <div style="position:absolute; top: 165mm; font-size: 14px;">
        <div style="clear: both"></div>
        <div style="float: left; width: 60%; padding-left: 40%;">
            <div><hr style="width: 200px;"></div>
            <span style="color: #789FB2; font-size: 1.2em; font-family: 'timesf';">Worrasak Praditkul</span>
            <div style="font-family: 'timesf';">General Manager</div>
            <div style="font-family: 'timesf';">Customer Service</div>
        </div>
        <div style="clear: both"></div>
    </div>

<?php
}
?>