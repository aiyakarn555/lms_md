<style type="text/css"> 
    body { 
        background-image: url("<?php echo Yii::app()->baseUrl."/images/dbd_certificate_background.jpg"; ?>");
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
    .size30 { font-size: 30px; }
    .size32 { font-size: 32px; }
    .size36 { font-size: 36px; }
    .size40 { font-size: 40px; }
    .size50 { font-size: 50px; }
    .dark-purple { color: #262262; }
    .purple { color: #4E3892; }
    .dark-yellow { color: #EBA022; }
</style> 

<div class="b size32 purple" style="position:absolute; top: 52mm; ">
    กรมพัฒนาธุรกิจการค้า กระทรวงพาณิชย์
</div>

<div class="b size40 purple" style="position:absolute; top: 62mm; ">
    หนังสือรับรองฉบับนี้ให้ไว้เพื่อแสดงว่า
</div> 

<div class="b size50 dark-yellow" style="position:absolute; top: 80mm; ">
    <?= $model['fulltitle'] ?>
</div>
<div class="b size32 purple" style="position:absolute; top: 95mm; ">
    ผ่านการอบรม
</div>
<div class="b size36 purple" style="position:absolute; top: 105mm; ">
    การบริหารจัดการและการตลาดผ่านสื่อออนไลน์ (E-Learning) ประจำปี 2560
</div>
<div class="b size30 dark-purple" style="position:absolute; top: 120mm; ">
    วิชา <?= $model['courseTitle'] ?>
</div>
<?php
    if($model['courseDatePassOver60Percent'] != null) {
?>
<div class="b size30 purple" style="position:absolute; top: 130mm; font-family: 'dbhelvethaicax';">
    ให้ไว้ ณ วันที่ <?= Helpers::lib()->changeFormatDate($model['courseDatePassOver60Percent']) ?>
</div>
<?php
    }
?>

<div style="position:absolute; top: 145mm;" >
    <img src="<?php echo Yii::app()->baseUrl."/images/".$model['renderSign']; ?>">
</div>
<div style="position:absolute; top: 175mm;" >
    <span class="b size30 purple"><?php echo $model['nameSign']; ?></span>
</div>
<div style="position:absolute; top: 183mm;" >
    <div class="b size30 purple"><?php echo $model['positionSign']; ?></div>
</div>