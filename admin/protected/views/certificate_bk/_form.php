
<!-- innerLR -->
<?php 
$formNameModel = 'Certificate'; 
?>
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
                        <?php echo $form->labelEx($model,'cert_background'); ?>
                        <div class="col-sm-5 col-offset-sm-4">
                            <div class="slim" data-will-remove="imageRemoved" data-min-size="145,20" >
                                <input type="file" name="cert_background" />
                                <?php
                                if ($model->cert_background!=""){
                                    echo Controller::Image_path($model->cert_background,'certificate');
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div>
                         <?php echo 'ลายเซนต์ด้านซ้าย'; ?>
                        </div>
                        <!-- <?php echo $form->labelEx($model,'sign_id'); ?> -->
                        <?php echo $form->dropDownList($model,'sign_id', CHtml::listData(Signature::model()->findAll('active="y"'), 'sign_id', 'sign_title'), array('empty'=>'-- กรุณาเลือกลายเซนต์ --','class'=>'span8')); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($model,'sign_id'); ?>
                        <div>
                         <?php echo 'ลายเซนต์ด้านขวา'; ?>
                        </div>
                        <!-- <?php echo $form->labelEx($model,'sign_id'); ?> -->
                        <?php echo $form->dropDownList($model,'sign_id2', CHtml::listData(Signature::model()->findAll('active="y"'), 'sign_id', 'sign_title'), array('empty'=>'-- กรุณาเลือกลายเซนต์ --','class'=>'span8')); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($model,'sign_id'); ?>
                    </div>
                    <?php 
                    $display[1] = 'รูปแบบแนวตั้ง แบบที่1';
                    $display[3] = 'รูปแบบแนวตั้ง แบบที่2';
                    $display[2] = 'รูปแบบแนวนอน';
                    ?>
                    <div class="row">
                        <?php echo $form->labelEx($model,'cert_display'); ?>
                        <?php echo $form->dropDownList($model,'cert_display', $display, array('empty'=>'-- กรุณาเลือกรูปแบบแสดงผล --','class'=>'span8')); ?>
                        <?php echo $form->error($model,'cert_display'); ?>
                    </div>

                    <!-- <div class="row">
                        <?php echo $form->labelEx($model,'cert_number'); ?>
                        <?php echo $form->textField($model,'cert_number',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                        <?php echo $form->error($model,'cert_number'); ?>
                    </div> -->

                    <div class="row buttons">
                        <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2'),'<i></i>บันทึกข้อมูล');?>
                    </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>

<script>
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
                    url: "<?php echo $this->createUrl('certificate/delImg'); ?>",
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
