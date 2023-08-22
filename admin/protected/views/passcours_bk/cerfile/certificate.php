
<style type="text/css"> 
    body { 
        /* background-image: url("<?php echo Yii::app()->baseUrl."/images/bgcer1.jpg"; ?>"); */
        background-image: url('<?= Yii::app()->getBaseUrl(true)."/../uploads/certificate/".$model['bgPath']; ?>');
        background-position: 0 0;
        background-image-resize: 1;
        background-repeat: no-repeat;
        font-family: 'coco';
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

<div class="b size40 black" style="position:absolute; top: 52mm; ">
    สำนักงานเลขาธิการสภาผู้แทนราษฏร 
</div>

<div class="size27 black" style="position:absolute; top: 63mm;">
    เลขที่ 2 ถนนอู่ทองใน เขตดุสิต กรุงเทพมหานคร 10300
</div>

<div class="b size32 black" style="position:absolute; top: 80mm; ">
    หนังสือรับรองฉบับนี้ให้ไว้เพื่อแสดงว่า
</div> 

<div class="b size36 dark-yellow" style="position:absolute; top: 93mm; ">
   รหัสบัตรประชาชน :     <?php echo $model['identification'] ;?>
</div>
<div class="b size50 dark-yellow" style="position:absolute; top: 100mm; ">
    <?= $model['fulltitle'] ?>
</div>
<div class="size32 black" style="position:absolute; top: 120mm; ">
    ได้ผ่านการอบรมหลักสูตร  <?= $model['courseTitle'] ?>


</div>

<?php
    if($model['courseDatePassOver60Percent'] != null) {
?>
<div class="size32 black" style="position:absolute; top: 140mm; font-family: 'dbhelvethaicax';">
     ณ วันที่ <?= Helpers::lib()->changeFormatDate($model['courseDatePassOver60Percent']) ?>
</div>
<?php
    }
?>

<div style="position:absolute; top: 148mm;" >
    <img src="<?php echo Yii::app()->baseUrl."/images/dbd_certificate_dbd_sign.png"; ?>" >
</div>
<div style="position:absolute; top: 178mm;" >
    <span class="b size30 purple"><?php echo $model['nameSign']; ?></span>
</div>
<div style="position:absolute; top: 186mm;" >
    <div class="b size30 purple"><?php echo $model['positionSign']; ?></div>
</div>