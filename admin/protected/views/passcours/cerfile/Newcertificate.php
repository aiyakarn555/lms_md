<style type="text/css">
    body {
        background-image: url('<?= Yii::app()->basePath."/../../uploads/certificate/".$model['bgPath']; ?>');
        background-position: 0 0;
        background-image-resize: 4;
        background-repeat: no-repeat;
        font-family: 'tahoma';
    }
    div {
        text-align: center;
        <?php if($model['pageSide']=='1'){ ?>
            width: 185mm;
        <?php }elseif($model['pageSide']=='3'){
            ?>
            width: 185mm;
            <?php
        } else { ?>
            width: 260mm;
        <?php } ?>
    }
    .b {}
    .size10 { font-size: 10px; }
    .size12 { font-size: 12px; }
    .size14 { font-size: 14px; }
    .size16 { font-size: 16px; }
    .size18 { font-size: 18px; }
    .size20 { font-size: 20px; }
    .size22 { font-size: 22px; }
    .size24 { font-size: 24px; }
    .size26 { font-size: 26px; }
    .size28 { font-size: 28px; }
    .size30 { font-size: 30px; }
    .size32 { font-size: 32px; }
    .size36 { font-size: 36px; }
    .size40 { font-size: 40px; }
    .size42 { font-size: 42px; }
    .size50 { font-size: 50px; }
    .dark- { color: #262262; }
    . { color: #4E3892; }
    .dark-yellow { color: #EBA022; }
    .red { color: #d05951; }

</style>

<?php
$fontTH = "font-family: 'garuda'";

 ?>


<div style="position:absolute; top: 10mm;text-align: center;" ><img width="140mm" src="../admin/images/cer_1.png" ></div>

 <div class="b size30 " style="position:absolute; top: 80mm;<?= $fontTH ?>">
    <?= $model['fulltitle'] ?>
</div>

<div style="position:absolute; top: 100mm;" ><img width="90mm" src="../admin/images/cer_2.png" ></div>

<div style="position:absolute; top: 10mm;left: 130mm " ><img width="50mm" src="../admin/images/cer_3.png" ></div>

<!-- padding-left:610px; -->

    
    <div style="position:absolute; top: 125mm;">
     <div class="b size30 "><?= $model['courseTitle_en'] ?></div>
 </div>







<div style="position:absolute; top: 170mm; <?= $fontTH ?> ">
 <div class="b size30">ให้ไว้ ณ วันที่ <?php echo Helpers::lib()->changeFormatDate(date("Y-m-j")); ?> </div>
</div>





