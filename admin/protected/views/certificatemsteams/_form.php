
<!-- innerLR -->
<?php 
$formNameModel = 'CertificateMsTeams'; 
?>
<style type="text/css">
    .slim-btn-remove{
        display: none;
    }
    .slim-btn-edit{
        display: none;
    }
</style>
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext;?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php $form = $this->beginWidget('AActiveForm', array(
                    'id'=>$formNameModel.'-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true
                    ),
                     'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                )); ?>
                <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>                    
                    <div class="row">
                        <?php echo $form->labelEx($model,'cert_name'); ?>
                        <?php echo $form->textField($model,'cert_name',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                        <?php echo $form->error($model,'cert_name'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model,'cert_text'); ?>
                        <?php echo $form->textarea($model,'cert_text',array('row'=>10, 'class'=>'span8')); ?>
                        <?php echo $form->error($model,'cert_text'); ?>
                    </div> 

                    <div class="row">
                        <div>
                         <?php echo 'รูปแบบพื้นหลัง'; ?>
                        </div> 
                         <?php 
                         $arraysign = array(1 =>"รูปแบบที่ 1",2 =>"รูปแบบที่ 2"  );
                          ?>
                        <?php echo $form->dropDownList($model,'cert_type',$arraysign, array('empty'=>'-- กรุณาเลือกรูปแบบพื้นหลัง --','class'=>'span8')); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($model,'cert_type'); ?>
                       
                    </div>

                    
                    <div class="row certificate1" style="display: none">
                        <?php echo $form->labelEx($model,'cert_background'); ?>
                        <div class="col-sm-5 col-offset-sm-4">
                            <div class="slim"  >
                                <input type="file" name="cert_background" />
                                <?php
                                    echo Controller::Image_path("certificate-md-1.jpg",'certificate');
                                ?>
                            </div>
                    </div>
                    </div>

                     <div class="row certificate2" style="display: none">
                        <?php echo $form->labelEx($model,'cert_background'); ?>
                        <div class="col-sm-5 col-offset-sm-4">
                            <div class="slim" >
                                <input type="file" name="cert_background" />
                                <?php
                                    echo Controller::Image_path("certificate-md-2.jpg",'certificate');
                                ?>
                            </div>
                    </div>
                    </div>


                    <div class="row">
                        <!-- <div class="singnone">
                        <div>
                         <?php echo 'ลายเซนต์ด้านซ้าย'; ?>
                        </div> 
                         
                        <?php echo $form->dropDownList($model,'sign_id', CHtml::listData(Signature::model()->findAll('active="y" AND sign_hide="1"'), 'sign_id', 'sign_title'), array('empty'=>'-- กรุณาเลือกลายเซนต์ --','class'=>'span8')); ?>
                        <?php 
                            if(Yii::app()->controller->action->id  == 'create'){
                                echo $this->NotEmpty();
                            }
                        ?>
                        <?php echo $form->error($model,'sign_id'); ?>
                        </div> -->
                        
                        <div>
                         <?php echo 'ลายเซนต์ด้านขวา'; ?>
                        </div> 
                      
                        <?php echo $form->dropDownList($model,'sign_id2', CHtml::listData(Signature::model()->findAll('active="y" AND sign_hide="1"'), 'sign_id', 'sign_title'), array('empty'=>'-- กรุณาเลือกลายเซนต์ --','class'=>'span8')); ?>
                        <?php 
                            if(Yii::app()->controller->action->id  == 'create'){
                                echo $this->NotEmpty();
                            }
                        ?>
                        <?php echo $form->error($model,'sign_id'); ?>
                    </div>

                    <br>

                    <div class="row buttons">
                        <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                    </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>

<script>

     $('#CertificateMsTeams_cert_type').change(function(){
        var chk = $( this ).val();

        if(chk == 1){
            $('.certificate1').show();
            $('.certificate2').hide();

        }else{
            $('.certificate2').show();
            $('.certificate1').hide();


            
        }
    });

    $(function () {
        init_tinymce();
    });
    <?php if(!empty($_GET['id'])){ ?>
    function imageRemoved(data, remove) {
        swal({
            title: "คำเตือน!",
            text: "คุณต้องการลบรูปภาพใช่หรือไม่",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#00a65a",
            confirmButtonText: "ยืนยัน",
            cancelButtonText: "ยกเลิก",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                remove();
                $.ajax({
                    url: "<?php echo $this->createUrl('CertificateMsTeams/delImg'); ?>",
                    data: {'id': <?= $_GET['id'] ?>},
                    type: "POST",
                    success: function(result){
                        if(result == true){
                            swal({
                                title: "สำเร็จ",
                                text: "ลบรูปภาพสำเร็จ",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: "#00a65a",
                                confirmButtonText: "ตกลง",
                                closeOnConfirm: false,
                            });
                        } else {
                            swal({
                                title: "ไม่สำเร็จ",
                                text: "ลบรูปภาพไม่สำเร็จ",
                                type: "error",
                                showCancelButton: false,
                                confirmButtonColor: "#00a65a",
                                confirmButtonText: "ตกลง",
                                closeOnConfirm: false,
                            });
                        }
                    }
                });
            } else {
                swal({
                    title: "ยกเลิก",
                    text: "ยกเลิกการลบรูปภาพ",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "ตกลง",
                    closeOnConfirm: false,
                });
            }
        });
        return false;
    }
    <?php } ?>
</script>
<!-- END innerLR -->
