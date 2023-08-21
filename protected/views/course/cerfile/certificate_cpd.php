<style type="text/css"> 
    body { 
        background-image: url("<?php echo Yii::app()->baseUrl."/images/dbd_certificate_background_cpd.jpg"; ?>");
        background-position: 0 0;
        background-image-resize: 1;
        background-repeat: no-repeat; 
    }

    div {
        text-align: center;
        width: 246mm;
        /*background-color: red;*/
    }
    .b { font-weight: bold; }
    .size16 { font-size: 16px; }
    .size18 { font-size: 18px; }
    .size20 { font-size: 20px; }
    .size22 { font-size: 22px; }
    .size24 { font-size: 24px; }
    .size26 { font-size: 26px; }
    .size32 { font-size: 32px; }
    .size34 { font-size: 36px; }
    .size36 { font-size: 36px; }
    .size46 { font-size: 40px; }
    .dark-purple { color: #262262; }
    .purple { color: #4E3892; }
    .dark-yellow { color: #EBA022; }
</style> 

<div class="b size32 purple" style="position:absolute; top: 42mm; ">
    กรมพัฒนาธุรกิจการค้า กระทรวงพาณิชย์
</div>

<div class="size22 purple" style="position:absolute; top: 52.5mm; ">
    563 ถนนนนทบุรี ตำบลบางกระสอ อำเภอเมืองนนทบุรี จังหวัดนนทบุรี 11000
</div>

<div class="b size32 purple" style="position:absolute; top: 60.5mm; ">
    หนังสือรับรองการพัฒนาความรู้ต่อเนื่องทางวิชาชีพ (CPD) ให้ไว้เพื่อแสดงว่า
</div>
<?php
    $top_position = ($model['userAccountCode']!=null)?'71mm':'79mm';
?>
<div class="b size46 dark-yellow" style="position:absolute; top: <?= $top_position ?>; ">
    <?= $model['fulltitle'] ?>
</div>
<div class="b size26 purple" style="position:absolute; top: 87mm; ">
    <?= $model['userAccountCode'] ?>
</div>
<div class="b size26 purple" style="position:absolute; top: 97mm; ">
    ได้ผ่านการอบรมและทดสอบในหลักสูตร e-Learning
</div>
<div class="b size34 dark-purple" style="position:absolute; top: 107mm;">
    <?= $model['courseTitle'] ?>
</div>
<div class="b size26 purple" style="position:absolute; top: 120mm; ">
    <?= $model['courseCode'] ?>
</div>
<div class="b size26 purple" style="position:absolute; top: 130mm; font-family: 'dbhelvethaicax';">
    ระหว่างวันที่ <?= Helpers::lib()->changeFormatDate($model['startLearnDate']) ?> ถึงวันที่ <?= Helpers::lib()->changeFormatDate($model['endLearnDate']) ?>
</div>
<div class="b size26 purple" style="position:absolute; top: 140mm; font-family: 'dbhelvethaicax';">
    กรณีผู้ประกอบวิชาชีพบัญชี สามารถนับชั่วโมงด้านการบัญชีได้ <?= (int)$model['courseAccountHour'] ?> ชั่วโมง <?= ($model['courseEtcHour']!=null)?'อื่นๆ '.(int)$model['courseEtcHour'].' ชั่วโมง':null ?>
</div>
<?php
    if($model['courseDatePassOver60Percent'] != null) {
?>
<div class="b size26 purple" style="position:absolute; top: 150mm; font-family: 'dbhelvethaicax';">
    ให้ไว้ ณ วันที่ <?= Helpers::lib()->changeFormatDate($model['courseDatePassOver60Percent']) ?>
</div>
<?php
    }
?>

<div style="position:absolute; top: 153mm;" >
    <div style="float: right; width: 30%; padding-left: 20%">
        <!--<img src="<?php //echo Yii::app()->baseUrl."/images/dbd_certificate_dbd_sign.png"; ?>" >-->
          <img src="<?php echo Yii::app()->baseUrl."/images/".$model['renderSign']; ?>" width="150px" >
    </div>
</div>
<div style="position:absolute; top: 170mm;" > 
    <div style="float: right; width: 30%; padding-left: 20%">
        <span class="b size26 purple"><?php echo $model['nameSign']; ?></span>
        <div class="b size24 purple"><?php echo $model['positionSign']; ?></div> 
    </div>
    <div style="clear: both"></div>
</div>