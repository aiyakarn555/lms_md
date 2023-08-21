<style type="text/css"> 
    body {
        background-image: url("<?php echo Yii::app()->baseUrl."/uploads/certificate/".$model['bgPath']; ?>"); /*test Path image*/
        background-position: 0 0;
        background-image-resize: 1;
        background-repeat: no-repeat;
        font-family: 'dbhelvethaicax';
    }

    div {
        text-align: center;
        <?php if($model['pageSide']=='1'){ ?>
            width: 185mm;
            <?php } else { ?>
                width: 246mm;
                <?php } ?>
                /*background-color: red;*/
            }
            .b {}
            .size16 { font-size: 16px; }
            .size18 { font-size: 18px; }
            .size20 { font-size: 20px; }
            .size22 { font-size: 22px; }
            .size24 { font-size: 24px; }
            .size26 { font-size: 26px; }
            .size30 { font-size: 30px; }
            .size32 { font-size: 32px; }
            .size36 { font-size: 36px; }
            .size40 { font-size: 40px; }
            .size50 { font-size: 50px; }
            .dark- { color: #262262; }
            . { color: #4E3892; }
            .dark-yellow { color: #EBA022; }
        </style> 

        <?php if($model['pageSide']=='1'){ ?>
        <div class="b size32 " style="position:absolute; top: 70mm;">
            วุฒิบัตรฉบับนี้ให้ไว้เพื่อแสดงว่า
        </div>

        <div class="b size32 " style="position:absolute; top: 85mm; font-weight: bold;">
            <?= $model['fulltitle'] ?>
        </div>
        <div class="b size32 " style="position:absolute; top: 100mm;">
            ได้รับการอบรมครบถ้วนตามหลักสูตร
        </div>
        <div class="b size30 " style="position:absolute; top: 115mm; font-weight: bold;">
            <?= $model['courseTitle'] ?>
        </div>

        <div class="b size26 " style="position:absolute; top: 200mm;">
            ให้ไว้ ณ วันที่ <?= Helpers::lib()->changeFormatDate(date('Y-m-d')) ?>
        </div>

        <!-- <img src="" id="tableBanner" /> -->
        <div style="position:absolute; top: 215mm;" >
            <img src="<?= Yii::app()->baseUrl."/uploads/signature/".$model['renderSign']; ?>">
        </div>
        <div style="position:absolute; top: 250mm;" >
            <span class="b size26 "><?php echo $model['nameSign']; ?></span>
        </div>
        <div style="position:absolute; top: 260mm;" >
            <div class="b size26 "><?php echo $model['positionSign']; ?></div>
        </div>
        <div class="b size26 " style="position:absolute; top: 270mm; ">
            สมาคมบริษัทหลักทรัพย์ไทย
        </div>
        <?php
    } else {
        ?>

<!-- $model['pageSide']=='2' -->
<div class="b size30 " style="position:absolute; top: 88mm; left: 30mm; font-family: 'Maitree', serif;">
            <?= $model['fulltitle'] ?>
</div>

<div class="b size20 " style="position:absolute; top: 101mm;left: 30mm; font-family: 'Trirong', serif;">
            <?= $model['positionUser'] ?>
</div>
<div class="b size20 " style="position:absolute; top: 113mm;left: 30mm; font-family: 'Trirong', serif;">
            <?= $model['companyUser'] ?>
</div>

<div class="size26 black" style="position:absolute; top: 124mm; left: 30mm; font-family: 'Maitree', serif;">
     <?= $model['courseTitle'] ?>
</div>

<!-- Date*************** -->
<?php
    if($model['courseDatePassOver60Percent'] != null) {
?>
<div class="size30 black" style="position:absolute; top: 136mm;left: 44mm; font-family: 'Trirong', serif;">
     <?= Helpers::lib()->changeFormatDate($model['courseDatePassOver60Percent']) ?>
</div>
<?php
    }
?>

<!-- Signature********************
 --><div style="position:absolute; right: 95mm; top: 145mm" >
    <img src="<?= Yii::app()->baseUrl."/uploads/signature/".$model['renderSign']; ?>">
</div>

<div style="position:absolute; left: 102mm; top: 147mm" >
    <img src="<?= Yii::app()->baseUrl."/uploads/signature/".$model['renderSign2']; ?>">
</div>

<div style="position:absolute; right: 97mm; top: 163mm;font-family: 'Trirong', serif;" >
    <span class="b size20 purple"><?php echo $model['nameSign']; ?></span>
</div>

<div style="position:absolute; left: 106mm; top: 163mm;font-family: 'Trirong', serif;" >
    <span class="b size20 purple"><?php echo $model['nameSign2']; ?></span>
</div>
<!-- 
<div style="position:absolute; right: 90mm; top: 179mm;font-family: 'Trirong', serif;" >
    <div class="b size24 purple"><?php echo $model['positionSign']; ?></div>
</div>

<div style="position:absolute; left: 102mm; top: 179mm;font-family: 'Trirong', serif;" >
    <div class="b size24 purple"><?php echo $model['positionSign2']; ?></div>
</div>
 -->    
    <?php    
}
    ?>
    

