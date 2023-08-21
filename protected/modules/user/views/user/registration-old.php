<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gsdk-base.css" rel="stylesheet"/>

<script>
    function fillfield(val){
        $('#RegistrationForm_bookkeeper_id').val(val);
    }
    $(function(){
        $('.mem').hide();
        $('#Profile_type_user').val('');
        $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
    });
    function typemem(val){
        if(val == 'สมาชิกทั่วไป') {
            $('.mem').hide();
            $('#bookkeeper').show();
            $('#RegistrationForm_card_id').val('');
            $('#RegistrationForm_auditor_id').val('');
            $('#RegistrationForm_bookkeeper_id').val('');
            $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
            $('#RegistrationForm_card_id').attr('required', false);
            $('#RegistrationForm_auditor_id').attr('required', false);
        } else if(val == 'ผู้ทำบัญชี'){
            $('.mem').hide();
            $('#bookkeeper').show();
            $('#pic_cardid').show();
            $('#RegistrationForm_card_id').val('');
            $('#RegistrationForm_auditor_id').val('');
            $('#RegistrationForm_bookkeeper_id').val('');
            $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
            $('#RegistrationForm_auditor_id').attr('required', false);
            $('#RegistrationForm_card_id').attr('required', true);
        } else if(val == 'ผู้สอบบัญชี'){
            $('.mem').hide();
            $('#auditor').show();
            $('#pic_cardid').show();
            $('#RegistrationForm_card_id').val('');
            $('#RegistrationForm_auditor_id').val('');
            $('#RegistrationForm_bookkeeper_id').val('');
            $('#RegistrationForm_card_id').attr('required', true);
            $('#RegistrationForm_auditor_id').attr('required', true);
        } else if(val == 'ผู้ทำบัญชี และ ผู้สอบบัญชี'){
            $('.mem').hide();
            $('#auditor').show();
            $('#bookkeeper').show();
            $('#pic_cardid').show();
            $('#RegistrationForm_card_id').val('');
            $('#RegistrationForm_auditor_id').val('');
            $('#RegistrationForm_bookkeeper_id').val('');
            $('#RegistrationForm_bookkeeper_id').val($('#RegistrationForm_username').val());
            $('#RegistrationForm_card_id').attr('required', true);
            $('#RegistrationForm_auditor_id').attr('required', true);
        } else {
            $('.mem').hide();
            $('#RegistrationForm_card_id').val('');
            $('#RegistrationForm_auditor_id').val('');
        }
    }
</script>

<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">

                <div class="wizard-container panel-body">
                    <?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration");
                    $this->breadcrumbs = array(
                        UserModule::t("Registration"),
                    );
                    ?>

                    <?php if (Yii::app()->user->hasFlash('registration')): ?>
                        <div class="success">
                            <div class="card wizard-card ct-wizard-orange" id="wizard">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <?php echo Yii::app()->user->getFlash('registration'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>

                        <div class="form">
                            <?php $form = $this->beginWidget('UActiveForm', array(
                                'id' => 'registration-form',
                                'enableAjaxValidation' => true,
                                // 'disableAjaxValidationAttributes'=>array('RegistrationForm_verifyCode'),
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                ),
                                'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            )); ?>

                            <?php echo $form->errorSummary(array($model, $profile)); ?>


                            <div class="card wizard-card ct-wizard-orange" id="wizard">
                                <!--        You can switch "ct-wizard-orange"  with one of the next bright colors: "ct-wizard-blue", "ct-wizard-green", "ct-wizard-orange", "ct-wizard-red"             -->
                                <div class="wizard-header">
                                    <h3>
                                        <b><?php echo UserModule::t("Registration"); ?></b><br>
                                        <small
                                            class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></small>
                                    </h3>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12" align="center">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img
                                                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/default-avatar.png"
                                                    class="picture-src" id="wizardPicturePreview" title=""/>
                                                <?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?>
                                            </div>
                                            <h6><?php echo UserModule::t("Choose Picture"); ?></h6>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6"></div> -->
                                    <div class="col-sm-10 col-sm-offset-1">
                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($model, 'username'); ?> เป็นเลขที่บัตรประชาชน (ใช้ในการเข้าสู่ระบบ)</label>
                                            <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้','oninput' => 'fillfield(this.value)')); ?>
                                            <?php echo $form->error($model, 'username'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($model, 'password'); ?></label>
                                            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ข้อมูลควรเป็น (A-z0-9) และต้องมากกว่า 6 ตัวอักษร)')); ?>
                                            <?php echo $form->error($model, 'password'); ?>
                                            <!-- <p class="hint">
                                        <?php //echo UserModule::t("Minimal password length 4 symbols."); ?>
                                        </p> -->
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($model, 'verifyPassword'); ?></label>
                                            <?php echo $form->passwordField($model, 'verifyPassword', array('class' => 'form-control', 'placeholder' => 'ยืนยันรหัสผ่าน')); ?>
                                            <?php echo $form->error($model, 'verifyPassword'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'title_id'); ?></label>
                                            <?php echo $form->dropDownList($profile, 'title_id', ProfilesTitle::getTitleList(), array('empty' => '---เลือกคำนำหน้าชื่อ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                            <?php echo $form->error($profile, 'title_id'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                            <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง')); ?>
                                            <?php echo $form->error($profile, 'firstname'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                            <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                                            <?php echo $form->error($profile, 'lastname'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'type_user'); ?></label>
                                            <?php 
                                            $typeuser = array('สมาชิกทั่วไป' => 'สมาชิกทั่วไป',
                                                'ผู้ทำบัญชี' => 'ผู้ทำบัญชี',
                                                'ผู้สอบบัญชี' => 'ผู้สอบบัญชี',
                                                'ผู้ทำบัญชี และ ผู้สอบบัญชี' => 'ผู้ทำบัญชี และ ผู้สอบบัญชี');
                                            echo $form->dropDownList($profile, 'type_user', $typeuser, array('empty' => '---เลือกประเภท---', 'class' => 'form-control', 'style' => 'width:100%', 'onchange' => 'typemem(this.value)')); 
                                            ?>
                                            <?php echo $form->error($profile, 'type_user'); ?>
                                        </div>

                                        <div class="form-group mem" id="auditor">
                                            <label>เลขทะเบียนผู้สอบบัญชี <?php echo UserModule::t('star'); ?></label>
                                            <?php echo $form->textField($model, 'auditor_id', array('class' => 'form-control', 'placeholder' => 'เลขทะเบียนผู้สอบบัญชี')); ?>
                                            <?php echo $form->error($model, 'auditor_id'); ?>
                                        </div>

                                        <div class="form-group mem" id="bookkeeper">
                                            <label>รหัสผู้ทำบัญชี <?php echo UserModule::t('star'); ?></label>
                                            <?php echo $form->textField($model, 'bookkeeper_id', array('class' => 'form-control', 'placeholder' => 'รหัสผู้ทำบัญชี','readonly' => 'readonly')); ?>
                                            <?php echo $form->error($model, 'bookkeeper_id'); ?>
                                        </div>

                                        <div class="form-group mem" id="pic_cardid">
                                            <label>แนลไฟล์รูปภาพบัตรประชาชน <?php echo UserModule::t('star'); ?></label>
                                            <?php echo $form->fileField($model, 'card_id',array('class'=>'form-control')); ?>
                                            <?php echo $form->error($model, 'card_id'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'sex'); ?></label>
                                            <?php 
                                            $sex = array('1' => 'ชาย',
                                                '2' => 'หญิง',);
                                            echo $form->dropDownList($profile, 'sex', $sex, array('empty' => '---เลือกเพศ---', 'class' => 'form-control', 'style' => 'width:100%')); 
                                            ?>
                                            <?php echo $form->error($profile, 'sex'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'birthday'); ?></label>
                                            <?php echo $form->textField($profile, 'birthday',array('data-format'=>'YYYY-MM-DD','data-template'=>'YYYY MMMM D','class' => 'form-control','id'=>'datepicker')); ?>
                                            <?php echo $form->error($profile, 'birthday'); ?>

                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'age'); ?></label>
                                            <?php echo $form->textField($profile, 'age', array('class' => 'form-control', 'placeholder' => 'อายุ')); ?>
                                            <?php echo $form->error($profile, 'age'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'education'); ?></label>
                                            <?php 
                                            $education = array('ปวช' => 'ปวช',
                                                'ปวส' => 'ปวส',
                                                'ปริญญาตรี' => 'ปริญญาตรี',
                                                'ปริญญาโท' => 'ปริญญาโท',
                                                'ปริญญาเอก' => 'ปริญญาเอก',
                                                'อื่น ๆ' => 'อื่น ๆ',);
                                            echo $form->dropDownList($profile, 'education', $education, array('empty' => '---เลือกวุฒิการศึกษา---', 'class' => 'form-control', 'style' => 'width:100%')); 
                                            ?>
                                            <?php echo $form->error($profile, 'education'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'occupation'); ?></label>
                                            <?php 
                                            $typeoccu = array('ธุรกิจส่วนตัว/เจ้าของกิจการ' => 'ธุรกิจส่วนตัว/เจ้าของกิจการ',
                                                'นักเรียน/นักศึกษา' => 'นักเรียน/นักศึกษา',
                                                'รับราชการ' => 'รับราชการ',
                                                'พนักงานรัฐวิสาหกิจ' => 'พนักงานรัฐวิสาหกิจ',
                                                'พนักงานเอกชน' => 'พนักงานเอกชน',
                                                'อื่น ๆ' => 'อื่น ๆ');
                                            echo $form->dropDownList($profile, 'occupation', $typeoccu, array('empty' => '---เลือกอาชีพ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                            <?php echo $form->error($profile, 'occupation'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label>ตำแหน่งของท่าน <?php echo UserModule::t('star'); ?></label>
                                            <?php echo $form->textField($profile, 'position', array('class' => 'form-control', 'placeholder' => 'ชื่อตำแหน่ง')); ?>
                                            <?php echo $form->error($profile, 'position'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label>ท่านมีเว็บไซต์หรือไม่</label>
                                            <div class="web">
                                            <?php echo CHtml::radioButton('webcheck',false,array('value'=>0,'class' => 'webcheck','id'=>'webcheck0')); ?>
                                            <label>ไม่มี</label>
                                            <?php echo CHtml::radioButton('webcheck',false,array('value'=>1,'class' => 'webcheck','id'=>'webcheck1')); ?>
                                            <label>มี</label>
                                            <?php echo $form->textField($profile, 'website', array('class' => 'form-control web', 'placeholder' => 'ชื่อเว็บไซต์ (ถ้ามี)','id'=>'web')); ?>
                                            </div>
                                            <?php echo $form->error($profile, 'website'); ?>
                                        </div>

                                        <script type="text/javascript">
                                            $(function(){
                                                $('input:radio[id="webcheck0"]').prop('checked', true);
                                            });
                                                $('.webcheck').click(function(){
                                                    var isChecked = jQuery("input[name=webcheck]:checked").val();
                                                     if(isChecked == 0){
                                                         $(".web").blur();
                                                         $('#web').val('');
                                                         $('#web').attr('required', false);
                                                     }else {
                                                         $(".web").focus();
                                                         $('#web').attr('required', true);
                                                     }
                                                });
                                             
                                                $('#web').click(function(){
                                                    $('input:radio[id="webcheck1"]').prop('checked', true);
                                                    $('#web').attr('required', true);
                                                });
                                        </script>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'address'); ?></label>
                                            <?php echo $form->textArea($profile, 'address', array('class' => 'form-control')); ?>
                                            <?php echo $form->error($profile, 'address'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'province'); ?></label>
                                            <?php 
                                            echo $form->dropDownList($profile, 'province', Province::getProvinceList(), array('empty' => '---เลือกจังหวัด---', 'class' => 'form-control', 'style' => 'width:100%'));
                                            ?>
                                            <?php echo $form->error($profile, 'province'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'tel'); ?> (02)</label>
                                            <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                            <?php echo $form->error($profile, 'tel'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'phone'); ?></label>
                                            <?php echo $form->textField($profile, 'phone', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์เคลื่อนที่')); ?>
                                            <?php echo $form->error($profile, 'phone'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($profile, 'fax'); ?></label>
                                            <?php echo $form->textField($profile, 'fax', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรสาร')); ?>
                                            <?php echo $form->error($profile, 'fax'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                            <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'ป้อนอีเมล')); ?>
                                            <?php echo $form->error($model, 'email'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label>ท่านทราบข่าวนี้จากช่องทางใด <?php echo UserModule::t('star'); ?></label>
                                            <div class="channel">
                                            <?php 
                                            $contactfrom = array('เว็บไซต์กรมพัฒนาธุรกิจการค้า' => 'เว็บไซต์กรมพัฒนาธุรกิจการค้า',
                                                'เว็บไซต์อื่นๆ' => 'เว็บไซต์อื่นๆ',
                                                'รับราชการ' => 'รับราชการ',
                                                'แผ่นพับ' => 'แผ่นพับ',
                                                'เพื่อน' => 'เพื่อน',
                                                'อื่น ๆ' => 'อื่น ๆ');
                                            echo $form->checkBoxList($profile, 'contactfrom', $contactfrom); ?>
                                            <?php echo $form->error($profile, 'contactfrom'); ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Upload เอกสาร PDF</label>
                                            <?php echo $form->fileField($profile, 'file_user',array('class'=>'form-control')); ?>
                                            <?php echo $form->error($profile, 'file_user'); ?>
                                        </div>

                                        <?php if (UserModule::doCaptcha('registration')): ?>
                                            <div class="form-group">
                                                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                                                <?php $this->widget('CCaptcha'); ?>
                                                <?php echo $form->textField($model, 'verifyCode', array('class' => 'form-control')); ?>
                                                <?php echo $form->error($model, 'verifyCode'); ?>

                                                <p class="hint"
                                                   style="margin-top:5px;"><?php echo UserModule::t("Please enter the letters as they are shown in the image above."); ?>
                                                    <br/><?php echo UserModule::t("Letters are not case-sensitive."); ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>

                                        <!-- <div class="form-group">
                                            <label>หน่วยงาน</label> -->
                                            <?php
                                            // $orgchart = OrgChart::model()->findAll(array(
                                            //     'condition' => 'level=2',
                                            // ));
                                            // $orgchart = CHtml::listData($orgchart, 'id', 'title');

                                            // if ($model->department_id != '') {
                                            //     $orgchart_select = OrgChart::model()->find(array(
                                            //         'condition' => 'id=' . $model->department_id,
                                            //     ));
                                            //     $model->orgchart_lv2 = $orgchart_select->parent_id;
                                            // }

                                            // echo $form->dropDownList($model, 'orgchart_lv2', $orgchart, array(
                                            //     'empty' => '---หน่วยงาน---',
                                            //     'class' => 'form-control',
                                            //     'ajax' =>
                                            //         array('type' => 'POST',
                                            //             'url' => CController::createUrl('/user/registration/sub_category'), //url to call.
                                            //             'update' => '#' . CHtml::activeId($model, 'department_id'), // here for a specific item, there should be different update
                                            //             'data' => array('orgchart_lv2' => 'js:this.value'),
                                            //         ))); ?>
                                            <?php // echo $form->error($model, 'orgchart_lv2'); ?>
                                        <!-- </div>
                                        <div class="form-group">
                                            <label>แผนก</label> -->
                                            <?php
                                            // if ($model->department_id != '') {
                                            //     $data = $this->loadDepartment($model->department_id);
                                            // } else {
                                            //     $data = array();
                                            // }
                                            // echo $form->dropDownList($model, 'department_id', $data, array('empty' => '---แผนก---', 'class' => 'form-control')); ?>
                                            <?php //echo $form->error($model, 'department_id'); ?>
                                        <!-- </div>

                                        <div class="form-group">
                                            <label>หน่วยงาน</label> -->
                                            <?php
//                                             echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
//                                                 'empty' => '---เลือกหน่วยงาน---',
//                                                 'class' => 'form-control',
//                                                 'style' => 'width:100%',
//                                                 'ajax' =>
//                                                     array('type' => 'POST',
//                                                         'dataType' => 'json',
//                                                         'url' => CController::createUrl('/user/registration/division'), //url to call.
// //                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
//                                                         'success' => 'function(data){
//                                                         $("#division_id").empty();
//                                                         $("#division_id").append(data.data_dsivision);
//                                                         $("#position_id").empty();
//                                                         $("#position_id").append(data.data_position);
//                                                     }',
//                                                         'data' => array('company_id' => 'js:this.value'),
//                                                     ))); ?>
                                            <?php //echo $form->error($model, 'company_id'); ?>
                                        <!-- </div>
                                        <div class="form-group">
                                            <label>ศูนย์/แผนก</label> -->
                                            <?php
                                            //                                        var_dump($model->division_id);
                                            //echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                                            <?php //echo $form->error($model, 'division_id'); ?>
                                        <!-- </div>
                                        <div class="form-group">
                                            <label>ตำแหน่ง</label> -->
                                            <?php
                                            //echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                                            <?php //echo $form->error($model, 'position_id'); ?>
                                        <!-- </div> -->

                                        <?php
                                        // $profileFields = $profile->getFields();
                                        // if ($profileFields) {
                                        //     foreach ($profileFields as $field) {
                                                ?>
                                                <!-- <div class="form-group"> -->
                                                    <?php // echo $form->labelEx($profile, $field->varname); ?>
                                                    <?php
                                                    // if ($widgetEdit = $field->widgetEdit($profile)) {
                                                    //     echo $widgetEdit;
                                                    // } elseif ($field->range) {
                                                    //     echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                                                    // } elseif ($field->field_type == "TEXT") {
                                                    //     echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50, 'class' => 'form-control'));
                                                    // } else {
                                                    //     echo $form->textField($profile, $field->varname, array('size' => 60, 'class' => 'form-control', 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                                                    // }
                                                    ?>
                                                    <?php // echo $form->error($profile, $field->varname); ?>
                                                <!-- </div> -->
                                                <?php
                                        //     }
                                        // }
                                        ?>

                                        <div class="form-group" style="text-align: right;">
                                            <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'btn btn-primary',)); ?>
                                        </div>


                                    </div>

                                </div>
                            </div>


                            <?php $this->endWidget(); ?>
                        </div><!-- form -->
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>
