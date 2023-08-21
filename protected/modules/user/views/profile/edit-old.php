<!-- <link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gsdk-base.css" rel="stylesheet"/>
<style>
    .form-control {
        border: 1px solid #61B8FF !important;
        box-shadow: 0 0 1px rgb(150, 208, 255) !important;
    }

    .form-control-material {
        border-bottom: 1px solid #686868;
    }

    .form-control-material .form-control {
        font-size: 1.6rem;
        border: none !important;
        box-shadow: none !important;
    }
</style> -->

<script>
    $(function(){
        <?php
        if($profile->type_user == 'สมาชิกทั่วไป') {
        ?>
            $('.mem').hide();
            $('#bookkeeper').show();
        <?php
        } else if($profile->type_user == 'ผู้ทำบัญชี'){
        ?>
            $('.mem').hide();
            $('#bookkeeper').show();
        <?php
        } else if($profile->type_user == 'ผู้สอบบัญชี'){
        ?>
            $('.mem').hide();
            $('#auditor').show();
        <?php
        } else if($profile->type_user == 'ผู้ทำบัญชี และ ผู้สอบบัญชี'){
        ?>
            $('.mem').hide();
            $('#auditor').show();
            $('#bookkeeper').show();
        <?php
        } 
        ?>
    });
</script>

<div class="parallax overflow-hidden page-section bg-blue-300">
    <div class="container parallax-layer" data-opacity="true">
        <div class="media media-grid v-middle">
            <div class="media-left">
                <span class="icon-block half bg-blue-500 text-white" style="height: 45px;"><i
                        class="fa fa-fw fa-user"></i></span>
            </div>
            <div class="media-body">
                <h3 class="text-display-2 text-white margin-none"><?php echo UserModule::t('Edit profile'); ?></h3>
                <p class="text-white text-subhead" style="font-size: 1.6rem;">แก้ไขประวัติส่วนตัว</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="page-section">
        <div class="row">
            <div class="col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2">
                <!-- Tabbable Widget -->
                <div class="tabbable paper-shadow relative" data-z="0.5">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a><i class="fa fa-fw fa-lock"></i> <span
                                    class="hidden-sm hidden-xs"><?php echo UserModule::t('Edit profile'); ?></span></a>
                        </li>
                    </ul>
                    <!-- // END Tabs -->
                    <!-- Panes -->
                    <div class="tab-content">
                        <div id="account" class="tab-pane active">
                            <?php $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'profile-form',
                                'enableAjaxValidation' => true,
                                'htmlOptions' => array(
                                    'enctype' => 'multipart/form-data',
                                    'class' => 'form-horizontal'
                                ),
                            )); ?>
                            <?php echo $form->errorSummary(array($model, $profile)); ?>
                            <div class="form-group">
                                <label for="inputPic3" class="col-sm-3 control-label">รูปภาพ *</label>
                                <div class="col-md-6">
                                    <div class="wizard-card">
                                        <div class="picture-container">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;padding: 0.5em">
                                                  <?php
                                                    // if($model->pic_user!=""){
                                                    $registor = new RegistrationForm;
                                                    $registor->id = $model->id;
                                                    // }
                                                    ?>
                                                    <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $model, $model->pic_user, $registor, array('class' => 'picture-src', 'id' => 'wizardPicturePreview')); ?>
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"></div>
                                                <div>
                                                  <span class="btn btn-success btn-small btn-file"><span class="fileinput-new">เลือกรูปภาพ</span><span class="fileinput-exists">เปลี่ยน</span><?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?></span>
                                                  <a href="#" class="btn btn-danger btn-small fileinput-exists" data-dismiss="fileinput">ลบ</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputUsername3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($model, 'username'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($model, 'username', array('size' => 20, 'maxlength' => 20, 'class' => 'form-control','disabled'=>'true')); ?>
                                            <?php echo $form->error($model, 'username'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputTitle3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'title_id'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->dropDownList($profile, 'title_id', ProfilesTitle::getTitleList(), array('empty' => '---เลือกคำนำหน้าชื่อ---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                            <?php echo $form->error($profile, 'title_id'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputFirstname3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'firstname'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'firstname', array('class' => 'form-control', 'placeholder' => 'ชื่อจริง')); ?>
                                            <?php echo $form->error($profile, 'firstname'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputLastname3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'lastname'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'lastname', array('class' => 'form-control', 'placeholder' => 'นามสกุล')); ?>
                                            <?php echo $form->error($profile, 'lastname'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputTypeuser3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'type_user'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php 
                                            $typeuser = array('สมาชิกทั่วไป' => 'สมาชิกทั่วไป',
                                                'ผู้ทำบัญชี' => 'ผู้ทำบัญชี',
                                                'ผู้สอบบัญชี' => 'ผู้สอบบัญชี',
                                                'ผู้ทำบัญชี และ ผู้สอบบัญชี' => 'ผู้ทำบัญชี และ ผู้สอบบัญชี');
                                            echo $form->dropDownList($profile, 'type_user', $typeuser, array('empty' => '---เลือกประเภท---', 'class' => 'form-control', 'style' => 'width:100%','disabled'=>'true')); 
                                            ?>
                                            <?php echo $form->error($profile, 'type_user'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mem" id="auditor">
                                <label for="inputLastname3"
                                       class="col-md-3 control-label"><label>เลขทะเบียนผู้สอบบัญชี <?php echo UserModule::t('star'); ?></label></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($model, 'auditor_id', array('class' => 'form-control', 'placeholder' => 'เลขทะเบียนผู้สอบบัญชี')); ?>
                                            <?php echo $form->error($model, 'auditor_id'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mem" id="bookkeeper">
                                <label for="inputLastname3"
                                       class="col-md-3 control-label"><label>รหัสผู้ทำบัญชี <?php echo UserModule::t('star'); ?></label></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($model, 'bookkeeper_id', array('class' => 'form-control', 'placeholder' => 'รหัสผู้ทำบัญชี','disabled' => 'true')); ?>
                                            <?php echo $form->error($model, 'bookkeeper_id'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputSex3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'sex'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php 
                                            if($profile->sex == 'Male'){
                                                $profile->sex = 1;
                                            } else {
                                                $profile->sex = 2;
                                            }
                                            $sex = array('1' => 'ชาย',
                                                '2' => 'หญิง',);
                                            echo $form->dropDownList($profile, 'sex', $sex, array('empty' => '---เลือกเพศ---', 'class' => 'form-control', 'style' => 'width:100%')); 
                                            ?>
                                            <?php echo $form->error($profile, 'sex'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBirthday3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'birthday'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'birthday',array('class' => 'form-control','disabled'=>'true')); ?>
                                            <?php echo $form->error($profile, 'birthday'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputAge3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'age'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'age', array('class' => 'form-control', 'placeholder' => 'อายุ')); ?>
                                            <?php echo $form->error($profile, 'age'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEducation3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'education'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
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
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputOccupation3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'occupation'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
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
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPosition3"
                                       class="col-md-3 control-label">ตำแหน่งของท่าน <?php echo UserModule::t('star'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'position', array('class' => 'form-control', 'placeholder' => 'ชื่อตำแหน่ง')); ?>
                                            <?php echo $form->error($profile, 'position'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputWebsite3"
                                       class="col-md-3 control-label">ท่านมีเว็บไซต์หรือไม่</label>
                                <div class="input-group col-md-6">
                                    <div class="col-md-2">
                                        <?php echo CHtml::radioButton('webcheck',false,array('value'=>0,'class' => 'webcheck','id'=>'webcheck0')); ?>
                                        <label>ไม่มี</label>
                                    </div>
                                    <div class="col-md-2">
                                        <?php echo CHtml::radioButton('webcheck',false,array('value'=>1,'class' => 'webcheck','id'=>'webcheck1')); ?>
                                        <label>มี</label>
                                    </div>
                                    <div class="col-md-8 form-control-material">
                                        <?php echo $form->textField($profile, 'website', array('class' => 'form-control web', 'placeholder' => 'ชื่อเว็บไซต์ (ถ้ามี)','id'=>'web')); ?>
                                    </div>
                                        <?php echo $form->error($profile, 'website'); ?>
                                </div>
                            </div>

                            <script type="text/javascript">
                                $(function(){
                                    <?php if($profile->website){ ?>
                                    $('input:radio[id="webcheck1"]').prop('checked', true);
                                    <?php } else { ?>
                                    $('input:radio[id="webcheck0"]').prop('checked', true);
                                    <?php } ?>
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
                                <label for="inputAddress3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'address'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textArea($profile, 'address', array('class' => 'form-control')); ?>
                                            <?php echo $form->error($profile, 'address'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputProvince3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'province'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php 
                                            echo $form->dropDownList($profile, 'province', Province::getProvinceList(), array('empty' => '---เลือกจังหวัด---', 'class' => 'form-control', 'style' => 'width:100%'));
                                            ?>
                                            <?php echo $form->error($profile, 'province'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputTel3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'tel'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'tel', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์')); ?>
                                            <?php echo $form->error($profile, 'tel'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPhone3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'phone'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'phone', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรศัพท์เคลื่อนที่')); ?>
                                            <?php echo $form->error($profile, 'phone'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputFax3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($profile, 'fax'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $form->textField($profile, 'fax', array('class' => 'form-control', 'placeholder' => 'เบอร์โทรสาร')); ?>
                                            <?php echo $form->error($profile, 'fax'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3"
                                       class="col-md-3 control-label"><?php echo $form->labelEx($model, 'email'); ?></label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128, 'class' => 'form-control','disabled'=>'true')); ?>
                                        <?php echo $form->error($model, 'email'); ?>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="inputContactfrom3"
                                       class="col-md-3 control-label">ท่านทราบข่าวนี้จากช่องทางใด --> <?php //echo UserModule::t('star'); ?><!-- </label> -->
                                <!-- <div class="col-md-6"> -->
                                    <?php 
                                        // $contactfrom = array('เว็บไซต์กรมพัฒนาธุรกิจการค้า' => 'เว็บไซต์กรมพัฒนาธุรกิจการค้า',
                                        //     'เว็บไซต์อื่นๆ' => 'เว็บไซต์อื่นๆ',
                                        //     'รับราชการ' => 'รับราชการ',
                                        //     'แผ่นพับ' => 'แผ่นพับ',
                                        //     'เพื่อน' => 'เพื่อน',
                                        //     'อื่น ๆ' => 'อื่น ๆ');
                                        // echo $form->checkBoxList($profile, 'contactfrom', $contactfrom); ?>
                                    <?php //echo $form->error($profile, 'contactfrom'); ?>
                                <!-- </div>
                            </div> -->
                            <div class="form-group">
                                <label for="inputFileuser3"
                                       class="col-md-3 control-label">Upload เอกสาร PDF</label>
                                <div class="col-md-6">
                                    <?php echo $form->fileField($profile, 'file_user',array('class'=>'form-control')); ?>
                                    <?php echo $form->error($profile, 'file_user'); ?>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label for="inputEmail3"
                                       class="col-md-3 control-label">รหัสผ่านใหม่</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group"> -->
                                            <?php //echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
                                            <?php //echo $form->error($model, 'password'); ?>
                                       <!--  </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="form-group margin-none">
                                <div class="col-md-offset-3 col-md-10">
                                    <?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array("class" => "btn btn-primary paper-shadow relative")); ?>
                                </div>
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                    <!-- // END Panes -->
                </div>
                <!-- // END Tabbable Widget -->
                <br/>
                <br/>
            </div>
        </div>
    </div>

                                <!-- <div class="form-group">
                                <label for="inputPassword3" class="col-md-3 control-label">หน่วยงาน *</label>
                                <div class="col-md-6"> -->
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
                                    //             'url' => CController::createUrl('/user/profile/sub_category'), //url to call.
                                    //             'update' => '#' . CHtml::activeId($model, 'department_id'), // here for a specific item, there should be different update
                                    //             'data' => array('orgchart_lv2' => 'js:this.value'),
                                    //         ))); ?>
                                    <?php //echo $form->error($model, 'orgchart_lv2'); ?>
                               <!--  </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="inputPassword3" class="col-md-3 control-label">แผนก *</label>
                                <div class="col-md-6"> -->
                                    <?php
                                    // if ($model->department_id != '') {
                                    //     $data = $this->loadDepartment($model->department_id);
                                    // } else {
                                    //     $data = array();
                                    // }
                                    // echo $form->dropDownList($model, 'department_id', $data, array('empty' => '---แผนก---', 'class' => 'form-control')); ?>
                                    <?php //echo $form->error($model, 'department_id'); ?>
                                <!-- </div>
                            </div> -->


                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label">หน่วยงาน</label>
                                <div class="col-md-6"> -->
                                    <?php
//                                     echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
//                                         'empty' => '---เลือกหน่วยงาน---',
//                                         'class' => 'form-control',
//                                         'style' => 'width:100%',
//                                         'ajax' =>
//                                             array('type' => 'POST',
//                                                 'dataType' => 'json',
//                                                 'url' => CController::createUrl('/user/registration/division'), //url to call.
//                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
//                                                 'success' => 'function(data){
//                                                         $("#division_id").empty();
//                                                         $("#division_id").append(data.data_dsivision);
//                                                         $("#position_id").empty();
//                                                         $("#position_id").append(data.data_position);
//                                                     }',
//                                                 'data' => array('company_id' => 'js:this.value'),
//                                             ))); ?>
                                    <?php //echo $form->error($model, 'company_id'); ?>
                                <!-- </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label">ศูนย์/แผนก</label>
                                <div class="col-md-6"> -->
                                    <?php
//                                    var_dump($model->division_id);
                                    //echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                                    <?php //echo $form->error($model, 'division_id'); ?>
                                <!-- </div>
                            </div> -->

                            <!-- <div class="form-group">
                                <label class="col-md-3 control-label">ตำแหน่ง</label>
                                <div class="col-md-6"> -->
                                    <?php
                                    //echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                                    <?php //echo $form->error($model, 'position_id'); ?>
                                <!-- </div>
                            </div> -->


                            <?php
                            // $profileFields = $profile->getFields();
                            // if ($profileFields) {
                            //     foreach ($profileFields as $field) {
                                    ?>
                                   <!--  <div class="form-group">
                                        <label for="inputEmail3"
                                               class="col-md-3 control-label"> --><?php //echo $form->labelEx($profile, $field->varname); ?><!-- </label> -->
                                        <!-- <div class="col-md-6">
                                            <div class="form-control-material">
                                                <div class="input-group"> -->
                                                    <?php

                                                    // if ($widgetEdit = $field->widgetEdit($profile)) {
                                                    //     echo $widgetEdit;
                                                    // } elseif ($field->range) {
                                                    //     echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                                                    // } elseif ($field->field_type == "TEXT") {
                                                    //     echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50, 'class' => 'form-control'));
                                                    // } else {
                                                    //     echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255), 'class' => 'form-control'));
                                                    // }
                                                    // echo $form->error($profile, $field->varname); ?>
                                                <!-- </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php
                            //     }
                            // }
                            ?>
