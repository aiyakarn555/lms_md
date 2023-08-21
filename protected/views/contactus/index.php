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
        <h1 class="text-center" style="color:#010C65;font-size: 36px;" ><?= Yii::app()->session['lang'] == 1?'Thoresen & Co.,(Bangkok) Ltd. (TCB)':'บริษัท โทรีเซน (กรุงเทพ) จำกัด'; ?></h1>
            <div class="card-text" style="padding: 20px 20px 30px 20px;text-align: center;">
                <h4 style="font-size: 18px;"><?= Yii::app()->session['lang'] == 1?'Address : 26/32-34 Orakarn Building 10th Floor, Soi Chidlom, Lumpinee, Pathumwan Bangkok 10330, Thailand':' ที่ตั้งสำนักงาน : 26/32-34 อาคารอรกานต์ ชั้น 10 ซอยชิดลม ถนนเพลินจิต แขวงลุมพินี เขตปทุมวัน กรุงเทพฯ 10330 ประเทศไทย'; ?>
                
            </h4>
        </div>

    </div>
 
<!-- <div class="contact-map">
            <div class="well">
                <div class="mapouter"><div class="gmap_canvas"><iframe width="1300" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Thoresen%20Thai%20Agencies%20&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.embedgooglemap.net">embed custom google maps</a></div><style>.mapouter{position:relative;text-align:right;height:500px;width:1300px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:1300px;}</style></div> 
            </div>
            <h4 class="text-center"><?= Yii::app()->session['lang'] == 1?'Map : THORESEN THAI AGENCIES PUBLIC COMPANY LIMITED (TTA)':'แผนที่ : บริษัท โทรีเซนไทย เอเยนต์ซีส์ จำกัด (มหาชน)'; ?></h4>
        </div> -->

        <h1 class="text-center" style="padding-top: 20px;padding-bottom: 20px;color:#010C65;font-size: 36px; " ><i class="fa fa-users" aria-hidden="true"style="padding-right: 20px;"></i><?= Yii::app()->session['lang'] == 1?'Administrator':'ผู้ดูแลระบบ'; ?></h1>
        <div class="row">
            <div class="col-md-3">
                <div class="well contact-well" style="border: 0px;">
                    <div class="card-img">
                        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
                    </div>
                    <div class="card-body">
                      <h4 class="card-title" >
                            <?php if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                echo 'Firstname Lastname';
                            }else{
                                echo 'ชื่อ  นามสกุล ';
                            } ?>
                        </h4>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Position :':'ตำแหน่ง :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Telephone :':'เบอร์โทรติดต่อ :'; ?></span>
                            lorem
                         </div>
                         <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Email :':'อีเมล :'; ?></span>
                        lorem
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well contacts-well"style="border: 0px;">
                    <div class="card-img">
                        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
                    </div>
                    <div class="card-body">
                      <h4 class="card-title" >
                            <?php if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                echo 'Firstname Lastname';
                            }else{
                                echo 'ชื่อ  นามสกุล ';
                            } ?>
                        </h4>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Position :':'ตำแหน่ง :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Telephone :':'เบอร์โทรติดต่อ :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Email :':'อีเมล :'; ?></span>
                        lorem
                        </div>
                        

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well contact-well"style="border: 0px;">
                    <div class="card-img">
                        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
                    </div>
                    <div class="card-body">
                      <h4 class="card-title" >
                            <?php if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                echo 'Firstname Lastname';
                            }else{
                                echo 'ชื่อ  นามสกุล ';
                            } ?>
                        </h4>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Position :':'ตำแหน่ง :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Telephone :':'เบอร์โทรติดต่อ :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Email :':'อีเมล :'; ?></span>
                        lorem
                        </div>
                        

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="well contacts-well"style="border: 0px;">
                    <div class="card-img">
                        <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="Card image" style="width:100%">
                    </div>
                    <div class="card-body">
                      <h4 class="card-title" >
                            <?php if (Yii::app()->session['lang'] == 1 || Yii::app()->session['lang'] == Null) {
                                echo 'Firstname Lastname';
                            }else{
                                echo 'ชื่อ  นามสกุล ';
                            } ?>
                        </h4>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Position :':'ตำแหน่ง :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Telephone :':'เบอร์โทรติดต่อ :'; ?></span>
                            lorem
                        </div>
                        <div class="card-text">
                        <span><?= Yii::app()->session['lang'] == 1?'Email :':'อีเมล :'; ?></span>
                        lorem
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>
        <?php
        $form = $this->beginWidget('CActiveForm');
        ?>
<!--         <div class="well">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_firstname  ?></label><br>
                        <?php echo $form->textField($model, 'contac_by_name', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_name'); ?></font>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_lastname  ?></label>
                        <?php echo $form->textField($model, 'contac_by_surname', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_surname'); ?></font>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_phone  ?></label>
                        <?php echo $form->textField($model, 'contac_by_tel', array('class' => 'form-control input-lg', 'onKeyPress' => 'return check_number()', 'maxlength' => '15')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_tel'); ?></font>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for=""><?= $label->label_email  ?></label>
                        <?php echo $form->textField($model, 'contac_by_email', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_by_email'); ?></font>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for=""><?= $label->label_topic  ?></label>
                        <?php echo $form->textField($model, 'contac_subject', array('class' => 'form-control input-lg', 'maxlength' => '100')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_subject'); ?></font>
                    </div>
                </div>  -->
                <?php
                // $criteria = new CDbCriteria;
                // $criteria->compare('active',y);
                // $ProblemType = ProblemType::model()->findAll($criteria);
                // $Problemdata = array();
                // foreach ($ProblemType as $key => $value) {
                //         $Problemdata[$value->id]=$value->Problem_title;
                //     }
                ?>
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">ประเภท</label>
                        <?php
                        $htmlOptions = array('class' => 'form-control input-lg');
                        echo $form->dropDownList($model, 'contac_type', $Problemdata, $htmlOptions);
                        ?>
                    </div>
                </div> -->
                <!-- <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">ประเภท</label>
                        <?php echo $form->textField($model, 'contac_type', array('class' => 'form-control input-lg')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_type'); ?></font>
                    </div>
                </div> -->
<!--             </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for=""><?= $label->label_detail  ?></label>
                        <?php echo $form->textarea($model, 'contac_detail', array('class' => 'form-control', 'rows' => '6')); ?>
                        <font color="red"><?php echo $form->error($model, 'contac_detail'); ?></font>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <div style="display: inline-block;" class="g-recaptcha" data-sitekey="6LdMXXcUAAAAAN1JhNtbE94ISS3JPEdP8zEuoJPD"></div>
                        <?php echo $form->error($model, 'captcha',array('class' => 'error2')); ?>
                    </div>
                </div>
            </div>          

            <div class="text-center">
                <?php echo CHtml::submitButton($label->label_button, array('class' => 'btn btn-warning btn-lg')); ?>
            </div>
        </div> -->

        <?php $this->endWidget();
        ?>
    </div>
</section>
