<script>
    $(function () {
        $('.text_user').hide();
        $(".type_send_mail").on('change', function () {
            var select_option = $(this).val();
            if (select_option == 1) {
                $('.text_user').hide();
                $('.text_group').show();
            } else {
                $('.text_group').hide();
                $('.text_user').show();
            }
        });
    });
</script>
<div class="innerLR">
    <div class="widget widget-tabs border-bottom-none">
        <div class="widget-head">
            <ul>
                <li class="active">
                    <a class="glyphicons edit" href="#account-details" data-toggle="tab">
                        <i></i><?php echo $formtext; ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="widget-body">
            <div class="form">
                <?php $form = $this->beginWidget('AActiveForm', array(
                    'id' => 'send-email-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                )); ?>
                <p class="note">ค่าที่มี <?php echo $this->NotEmpty(); ?> จำเป็นต้องใส่ให้ครบ</p>

                <style>
                    #type_send_mail input {
                        float: left;
                    }

                    #type_send_mail label {
                        padding-left: 30px;
                    }
                </style>
                <div class="row">
                    <?php echo CHtml::radioButtonList('type_send_mail', 1, array('1' => ' ส่งอีเมล์แบบกลุ่ม', '2' => ' ส่งอีเมล์รายบุคคล'), array('separator' => '', 'class' => 'type_send_mail')); ?>
                </div>

                <div class="row text_user">
                    <?php echo $form->labelEx($model, 'group_name'); ?>
                    <?php echo $form->textField($model, 'group_name',array('class' => 'span8')); ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model, 'group_name'); ?>
                </div>

                <div class="row text_group">
                    <?php echo $form->labelEx($model_group, 'id'); ?>
                    <?php
                    $group_mail = Mailgroup::model()->findAll();
                    $data_group = CHtml::listData($group_mail, 'id', 'group_name');

                    echo $form->DropDownList($model_group, 'id', $data_group, array(
                        'empty' => 'เลือกกลุ่มในการส่งอีเมล์',
                        'class' => 'span8'
                    ));
                    ?>
                    <?php echo $this->NotEmpty(); ?>
                    <?php echo $form->error($model_group, 'id'); ?>
                </div>

                <br>
                <div class="row buttons">
                    <?php echo CHtml::tag('button', array('class' => 'btn btn-primary btn-icon glyphicons ok_2'), '<i></i>บันทึกข้อมูล'); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!-- form -->
        </div>
    </div>
</div>
