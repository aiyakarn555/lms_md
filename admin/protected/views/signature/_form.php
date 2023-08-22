
<!-- innerLR -->
<?php 
$formNameModel = 'Signature'; 
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
                        <?php echo $form->labelEx($model,'sign_title'); ?>
                        <?php echo $form->textField($model,'sign_title',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                        <?php echo $form->error($model,'sign_title'); ?>
                    </div>
                    <div class="row">
                        <?php echo $form->labelEx($model,'sign_position'); ?>
                        <?php echo $form->textField($model,'sign_position',array('size'=>60,'maxlength'=>255, 'class'=>'span8')); ?>
                        <?php echo $form->error($model,'sign_position'); ?>
                    </div> 
                   
                    <br>

                    <div class="row">
                        <?php echo $form->labelEx($model,'sign_path'); ?>
                        <div class="col-sm-5 col-offset-sm-4">(กว้าง 125 x ยาว 125 )
                            <div class="slim" data-will-remove="imageRemoved" data-min-size="125,125" style="width: 145px;">
                                <input type="file" name="sign_path" />
                                <?php
                                if ($model->sign_path!=""){
                                    echo Controller::Image_path($model->sign_path,'signature');
                                }
                                ?>
                            </div>
                        </div>
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
                    url: "<?php echo $this->createUrl('signature/delImg'); ?>",
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
