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





<?php if($model['pageSide']=='1'){  // แนวตั้ง แบบที่ 1
    ?>
     <div class="size12" style="width:100%; text-align: right; padding-top: -41px; padding-right: -35px;"> 
    Certificate No.: NNNN0004/<?php echo date("y", strtotime(date("Y-m-d"))); ?>
    </div>
    <div class="b size42" style="position:absolute; top: 91mm; line-height:35px; font-family: 'arnoprocaptionsemibold';">
        Mr.Tester Tester
    </div>
    <!-- <div class="b size42" style="position:absolute; top: 86.5mm; line-height:35px; font-family: 'arnoprocaptionsemibold';">
        Mr.TestertesterTitletesterTestertestertester
    </div> -->
    <div style="position:absolute; top: 118mm; line-height:40px; font-family: 'arnoprocaptionsemibold';">
       <div class="b size42 red">COURSE TITLE TEST IMO 2020 GLOBAL SULPHUR CAP</div>
   </div>
   <div style="position:absolute; top: 142mm;">
       <div class="size20"><b>On date <?php echo $model['courseDatePass']; ?></b></div>
   </div> 
   <div style="position:absolute; top: 173mm;">
     <div class="size14">
        <?php echo nl2br($model['cert_text']); ?>
        <!-- This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI. -->
    </div>
</div> 

<?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 184.5mm; left: -150px;" >
       <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
   </div>
   <div class="size14" style="position:absolute; top: 221mm; left: -150px;">
    <b><?php echo $model['nameSign']; ?></b>
    </div>
    <div class="size14" style="position:absolute; top: 227mm; left: -150px;">
    <b><?php echo $model['positionSign']; ?></b>
    </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
    <div style="position:absolute; top: 184.5mm; right: -190px;" >
        <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign2']; ?>" >
    </div>
    <div class="size14" style="position:absolute; top: 221mm; right: -190px;">
    <b><?php echo $model['nameSign2']; ?></b>
    </div>
    <div class="size14" style="position:absolute; top: 227mm; right: -190px;">
    <b><?php echo $model['positionSign2']; ?></b>
    </div>
<?php } ?>







<?php
}else if($model['pageSide']=='3'){  // แนวตั้ง แบบที่ 2
    ?>
    <div class="size12" style="width:100%; text-align: right; padding-top: -41px; padding-right: -35px;"> 
    Certificate No.: NNNN0004/<?php echo date("y", strtotime(date("Y-m-d"))); ?>
    </div>
    <div class="b size42" style="position:absolute; top: 89mm; line-height:35px; font-family: 'arnoprocaptionsemibold';">
        Mr.Tester Tester
    </div>
    <div style="position:absolute; top: 112mm; line-height:40px; font-family: 'arnoprocaptionsemibold';">
       <div class="b size42 red">COURSE TITLE TEST IMO 2020 GLOBAL SULPHUR CAP</div>
   </div>
   <div style="position:absolute; top: 155mm;">
       <div class="size20"><b>On date <?php echo $model['courseDatePass']; ?></b></div>
   </div> 
   <div style="position:absolute; top: 185mm;">
     <div class="size14">
        <?php echo nl2br($model['cert_text']); ?>
        <!-- This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI. -->
    </div>
</div> 
<?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 184.5mm; left: -150px;" >
       <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
   </div>
   <div class="size14" style="position:absolute; top: 221mm; left: -150px;">
    <b><?php echo $model['nameSign']; ?></b>
    </div>
    <div class="size14" style="position:absolute; top: 227mm; left: -150px;">
    <b><?php echo $model['positionSign']; ?></b>
    </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
    <div style="position:absolute; top: 184.5mm; right: -190px;" >
        <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign2']; ?>" >
    </div>
     <div class="size14" style="position:absolute; top: 221mm; right: -190px;">
    <b><?php echo $model['nameSign2']; ?></b>
    </div>
    <div class="size14" style="position:absolute; top: 227mm; right: -190px;">
    <b><?php echo $model['positionSign2']; ?></b>
    </div>
<?php } ?>







<?php
} else {
    ?>
<!-- padding-left:610px; -->
    <div class="size12" style="padding-top:-24px; padding-left:900px;">
    NNNN0004/20
    </div>
    <div style="position:absolute; top: 70mm;">
     <div class="b size40 red">COURSE TITLE</div>
 </div>

 <div class="b size36 " style="position:absolute; top: 115mm;">
    Mr.Tester  Tester
</div>

<div style="position:absolute; top: 132mm;">
   <div class="size12">
    <?php echo nl2br($model['cert_text']); ?>
    <!-- This course is intended to provide with understanding of IMO 2020 Global Sulphur regulation and the ship implementation plan in accorddance with the regulation 14.1.3 of MARPOL Annex VI. -->
</div>
</div> 

<?php if ($model['renderSign']) {?>
    <div style="position:absolute; top: 133mm;left: -130px;" >
        <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign']; ?>" >
    </div>
     <div class="size12" style="position:absolute; top: 169mm; left: -130px;">
    <?php echo $model['nameSign']; ?>
    </div>
    <div class="size12" style="position:absolute; top: 174mm; left: -130px;">
    <?php echo $model['positionSign']; ?>
    </div>
<?php } ?>
<?php if ($model['renderSign2']) {?>
    <div style="position:absolute; top: 133mm; right: -130px;" >
        <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/".$model['renderSign2']; ?>" >
        <!-- <img src="<?php echo Yii::app()->basePath."/../../uploads/signature/sign_border.png"; ?>" > -->
    </div>
    <div class="size12" style="position:absolute; top: 169mm; right: -130px;">
    <?php echo $model['nameSign2']; ?>
    </div>
    <div class="size12" style="position:absolute; top: 174mm; right: -130px;">
    <?php echo $model['positionSign2']; ?>
    </div>
<?php } ?>

<div style="position:absolute; top: 180mm; right: -130px ">
 <div class="size18"><?php echo $model['format_date_pass2']; ?></div>
</div>

<?php
}
?>


