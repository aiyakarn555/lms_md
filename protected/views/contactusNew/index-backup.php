<script src='https://www.google.com/recaptcha/api.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script language="javascript" type="text/javascript">
    function check_number() {
        e_k=event.keyCode
    //if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
        if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
            event.returnValue = false;
            alert("<?= $label->label_alert_notNumber ?>");
        }
    }
    function chThai()
    {
        if (event.keyCode>=161) 
        {
            return true;
        }
        else
        {
            alert('<?= $label->label_alert_notDefault ?>');
            return false;
        }
    }
</script>
<?php 
$msg = Yii::app()->user->getFlash('contactus');
if(!empty($msg)){
    ?>
    <script type="text/javascript">
         swal({
      title: "System",
      text: "<?= $msg; ?>",
      dangerMode: true,
  });
  </script>
  <?php 
} ?>

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-main">
            <li class="breadcrumb-item"><a href="<?php echo $this->createUrl('/site/index'); ?>"><?php echo $label->label_homepage; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $label->label_contactus ?></li>
        </ol>
    </nav>
</div>

<!-- Content -->
<section class="content" id="contact-us">
    <div class="container">
        <div class="panel panel-default" style="padding: inherit ;background: whitesmoke;padding-top: 20px;">
        <h1 class="text-center" style="color:#010C65;font-size: 36px;" ><?= Yii::app()->session['lang'] == 1?'Thoresen & Co.,(Bangkok) Ltd.':'บริษัท โทรีเซน (กรุงเทพ) จำกัด'; ?></h1>
            <div class="card-text" style="padding: 20px 20px 30px 20px;text-align: left;">
                <h4 style="font-size: 18px;"><?= Yii::app()->session['lang'] == 1?'Address : 26/32-34 Orakarn Building 10th Floor, Soi Chidlom, Lumpinee, Pathumwan Bangkok 10330, Thailand <br> Telephone : +66 (0) 2254 8437, +66 (0) 2250 0569':' ที่ตั้งสำนักงาน : 26/32-34 อาคารอรกานต์ ชั้น 10 ซอยชิดลม ถนนเพลินจิต แขวงลุมพินี เขตปทุมวัน กรุงเทพฯ 10330 ประเทศไทย <br> เบอร์ติดต่อ : +66 (0) 2254 8437, +66 (0) 2250 0569'; ?>
                
            </h4>
        </div>

    </div>
 <?php

 ?>
<div class="contact-map">
            <div class="well">
                <div class="mapouter"><div class="gmap_canvas"><iframe src="https://www.google.com/maps/embed?pb=!1m17!1m8!1m3!1d62008.62778976316!2d100.543755!3d13.746323!3m2!1i1024!2i768!4f13.1!4m6!3e6!4m0!4m3!3m2!1d13.7462337!2d100.54378419999999!5e0!3m2!1sth!2sth!4v1598328041024!5m2!1sth!2sth" width="1300" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe><a href="https://www.embedgooglemap.net"></a></div><style>.mapouter{position:relative;text-align:right;height:500px;width:1300px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:1300px;}</style></div>
            </div>
        </div>

        <h1 class="text-center" style="padding-top: 20px;padding-bottom: 20px;color:#010C65;font-size: 36px; " >
        </h1>

        <div class="row">
<?php
if ($ContactusNew_data) {
foreach ($ContactusNew_data as $key => $value) {
?>
            <div class="col-md-3 col-sm-4 col-xs-12 odd-even-contact">
                <?php 
                if ($key%2==0) {
                    echo '<div class="well contact-well contact-well-primary" style="border: 0px;">';
                }else{
                    echo '<div class="well contact-well contact-well-second" style="border: 0px;">';
                } ?>
                    <div class="card-img">
                         <?php
                            if ($value['con_image'] == null) {

                                $img  = Yii::app()->theme->baseUrl . "/images/thumbnail-profile.png";
                            } else {
                            
                                $img = Yii::app()->baseUrl . '/uploads/contactusnew/' . $value['id'] . '/thumb/' . $value['con_image'];
                            }
                          ?>
                        <img class="card-img-top" src="<?= $img ?>" alt="">
                    </div>
                    <div class="card-body">
                         <div class="card-text">
                     <h4 class="card-title" >
                        <?php
                        if (Yii::app()->session['lang'] == 1) {
                        echo $value['con_position_en'];
                        }else{
                        echo $value['con_position'];
                        }
                        ?>   
                    </h4>
                        </div>
                         <div class="card-text">
                            <?php if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                echo $value['con_firstname_en'];?>&nbsp;&nbsp;
                            <?php
                                echo $value['con_lastname_en'];
                            }else{
                                echo $value['con_firstname'];
                                ?>&nbsp;&nbsp;
                            <?php
                                 echo $value['con_lastname'];
                            } ?>
                   
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Telephone :':'เบอร์โทรติดต่อ :'; ?></span>
                          <?php
                        echo $value['con_tel'];
                        ?>
                         </div>
                         <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Email :':'อีเมล :'; ?></span>
                         <?php
                        echo $value['con_email'];
                        ?>
                        </div>

                    </div>
                </div>
            </div>
            <?php
        }
}
            ?>
        </div>
</div>
      
    </div>
</section>

