    <?php 

 ?>
<style type="text/css">
    body {
        background-image: url('<?= Yii::app()->basePath."/../uploads/certificate/".$model['bgPath']; ?>');
        background-position: 0 0;
        background-image-resize: 4;
        background-repeat: no-repeat;
        font-family: 'kanit';
    }
    div {
        text-align: center;
        <?php if($model['pageSide']=='1'){ ?>
            width: 185mm;
        <?php }elseif($model['pageSide']=='3'){ ?>
            width: 185mm;
        <?php } else { ?>
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

if($model['certType'] == 1){ ?>

    <!-- padding-left:610px; -->

    <div style="position:absolute; top: 101mm;right: -26mm;">
     <div class="b size22 "><b><?= $model['fulltitle_en']; ?></b></div>
 </div>

 <div style="position:absolute; top: 112mm; left: -42mm;">
     <div class="b size16 "><b><?php echo Helpers::lib()->changeFormatDateNewEn($model['pro_birth'],'full'); ?></b></div>
 </div>

 <div style="position:absolute; top: 112mm; left: 28mm;">
     <div class="b size16 "><b><?= $model['pro_iden']; ?></b></div>
 </div>

 <div class="b size24 " style="position:absolute; top: 145mm;right: -26mm;">
     <b><?= nl2br($model['courseTitle_en']); ?> </b>
 </div>

 <div style="position:absolute; top: 163.6mm; right: -45mm;">
    <div class="b size16 "><b><?php echo Helpers::lib()->changeFormatDateNewEn(date_format(date_create($model['courseStr']),"Y-m-d")); ?> to <?php echo Helpers::lib()->changeFormatDateNewEn(date_format(date_create($model['courseEnd']),"Y-m-d")); ?></b></div>
 </div>

<div style=" position:absolute; top: 175mm;right: 13mm;width: 680px;">
   <div class="b size18">
      <?php echo nl2br($model['cert_text']); ?>
  </div>
</div>

<div style="position:absolute; top: 235mm; left: 28mm;">
   <img style="width: 150px;max-height: 100px; object-fit: contain;" src="<?php echo Yii::app()->basePath."/../uploads/signature/".$model['renderSign2']; ?>" >
</div>

<div style="position:absolute; top: 214mm; left: -87mm;">
    <img style="width: 135px;height: 180px;object-fit: contain;" src="<?php echo Yii::app()->basePath."/../uploads/users/".Yii::app()->user->id."/".$model['pro_pic']; ?>" >
</div> 

<div style="position:absolute; top: 245mm; right: -15mm;">
 <div class="b size16 "><b><?php echo Helpers::lib()->changeFormatDateNewEn(date_format(date_create($model['endLearnDate']),"Y-m-d") ); ?></b></div>
</div>

<div style="position:absolute; top: 226mm; right: -15mm;">
 <div class="b size16 "><b><?= $model['coursenumber']?></b></div>
</div>

<div style="position:absolute; top: 255mm; left: 28.5mm;">
 <div class="b size14 ">
    <b><?= nl2br($model['nameSign2']) ?></b>
    <p><b><?= $model['positionSign2']?></b></p>
</div>
</div>

<?php }else{ ?>

    <div style="position:absolute; top: 17.2mm; left: -60mm;">
     <div class="b size16 "><?= $model['coursenumber']?></div>
 </div>


 <div style="position:absolute; top: 80mm;right: -26mm;">
     <div class="b size30 "><b><?= $model['fulltitle_en'] ?></b></div>
 </div>

 <div class="b size30 " style="position:absolute; top: 125mm;right: -26mm;">
      <b><?= nl2br($model['courseTitle_en']); ?> </b>
 </div>

 <div style="position:absolute; top: 149mm; right: -34mm;">
     <div class="b size22 "><b><?php echo Helpers::lib()->changeFormatDateNewEn(date_format(date_create($model['courseStr']),"Y-m-d"),'full'); ?> to <?php echo Helpers::lib()->changeFormatDateNewEn(date_format(date_create($model['courseEnd']),"Y-m-d"),'full'); ?></b></div>
 </div>

 <div style=" position:absolute; top: 160mm;right: -26mm;">
   <div class="b size18" >
      <?php echo nl2br($model['cert_text']); ?>
  </div>
</div>

<div style="position:absolute; top: 206mm; left: 22.5mm;">
    <img style="width: 100px;height: 100px;" src="<?php echo Yii::app()->basePath."/../uploads/signature/".$model['renderSign2']; ?>" >
</div>

<div style="position:absolute; top: 188mm; left: -77mm;">
    <img style="width: 130px;height: 162px;" src="<?php echo Yii::app()->basePath."/../uploads/users/".Yii::app()->user->id."/".$model['pro_pic']; ?>" >
</div> 


<div style="position:absolute; top: 235mm; left: 22.5mm;">
 <div class="b size14 ">
    <b><?= nl2br($model['nameSign2']) ?></b>
    <p><b><?= $model['positionSign2']?></b></p>
</div>
</div>

<?php } ?>