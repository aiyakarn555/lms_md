<link href="<?php echo Yii::app()->theme->baseUrl; ?>/css/gsdk-base.css" rel="stylesheet"/>

<div id="user" class="innerLR">
    <div class="widget" style="margin-top: -1px;">
        <div class="widget-head">
            <h4 class="heading glyphicons show_thumbnails_with_lines">
                <i></i> <?php echo $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Registration"); ?></h4>
        </div>
        <div class="widget-body">
            <div>
                <?php //echo Rights::t('core', 'Here you can view which permissions has been assigned to each user.'); ?>
            </div>
            <div class="spacer"></div>
            <div>

                <div class="wizard-container panel-body">
                    <?php
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
                            'id' => 'user-form',
                            'enableAjaxValidation' => true,
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
                                            <?php if ($model->pic_user == "") { ?>
                                                <img
                                                    src="<?php echo Yii::app()->theme->baseUrl; ?>/images/default-avatar.png"
                                                    class="picture-src" id="wizardPicturePreview" title=""/>
                                            <?php } else { ?>
                                                <img
                                                    src="<?php echo Yii::app()->baseUrl; ?>/../uploads/user/<?= $model->pic_user ?>"
                                                    class="picture-src" id="wizardPicturePreview" title=""/>
                                            <?php } ?>
                                            <?php echo $form->fileField($model, 'pic_user', array('id' => 'wizard-picture')); ?>
                                        </div>
                                        <h6><?php echo UserModule::t("Choose Picture"); ?></h6>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6"></div> -->
                                <div class="span7 offset3">
                                    <div class="form-group">
                                        <label>กลุ่มหลักสูตร</label>
                                        <?php
                                        $orgchart = OrgChart::model()->findAll(array(
                                            'condition' => 'level=2',
                                        ));
                                        $orgchart = CHtml::listData($orgchart, 'id', 'title');

                                        if ($model->department_id != '') {
                                            $orgchart_select = OrgChart::model()->find(array(
                                                'condition' => 'id=' . $model->department_id,
                                            ));
                                            $model->orgchart_lv2 = $orgchart_select->parent_id;
                                        }

                                        echo $form->dropDownList($model, 'orgchart_lv2', $orgchart, array(
                                            'empty' => '---กลุ่มหลักสูตร---',
                                            'class' => 'form-control',
                                            'style' => 'width:100%',
                                            'ajax' =>
                                                array('type' => 'POST',
                                                    'url' => CController::createUrl('/user/admin/sub_category'), //url to call.
                                                    'update' => '#' . CHtml::activeId($model, 'department_id'), // here for a specific item, there should be different update
                                                    'data' => array('orgchart_lv2' => 'js:this.value'),
                                                ))); ?>
                                        <?php echo $form->error($model, 'orgchart_lv2'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>กลุ่มหลักสูตรย่อย</label>
                                        <?php
                                        if ($model->department_id != '') {
                                            $data = $this->loadDepartment($model->department_id);
                                        } else {
                                            $data = array();
                                        }
                                        echo $form->dropDownList($model, 'department_id', $data, array('empty' => '---กลุ่มหลักสูตรย่อย---', 'class' => 'form-control', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($model, 'department_id'); ?>
                                    </div>


                                    <div class="form-group">
                                        <label>หน่วยงาน</label>
                                        <?php
                                        echo $form->dropDownList($model, 'company_id', Company::getCompanyList(), array(
                                            'empty' => '---เลือกหน่วยงาน---',
                                            'class' => 'form-control',
                                            'style' => 'width:100%',
                                            'ajax' =>
                                                array('type' => 'POST',
                                                    'dataType' => 'json',
                                                    'url' => CController::createUrl('/user/admin/division'), //url to call.
//                                                    'update' => '#' . CHtml::activeId($model, 'division_id'), // here for a specific item, there should be different update
                                                    'success' => 'function(data){
                                                        $("#division_id").empty();
                                                        $("#division_id").append(data.data_dsivision);
                                                        $("#position_id").empty();
                                                        $("#position_id").append(data.data_position);
                                                    }',
                                                    'data' => array('company_id' => 'js:this.value'),
                                                ))); ?>
                                        <?php echo $form->error($model, 'company_id'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>ศูนย์/แผนก</label>
                                        <?php
//                                        var_dump($model->division_id);
                                        echo $form->dropDownList($model, 'division_id', Division::getDivisionList(), array('empty' => '---เลือก ศุนย์/แผนก---', 'class' => 'form-control', 'style' => 'width:100%', 'id' => 'division_id')); ?>
                                        <?php echo $form->error($model, 'division_id'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label>ตำแหน่ง</label>
                                        <?php
                                        echo $form->dropDownList($model, 'position_id', Position::getPositionList(), array('empty' => '---เลือกตำแหน่ง---', 'class' => 'form-control', 'style' => 'width:100%','id'=>'position_id')); ?>
                                        <?php echo $form->error($model, 'position_id'); ?>
                                    </div>
                                </div>
                                <div class="span7 offset3">
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'username'); ?></label>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'ชื่อผู้ใช้', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($model, 'username'); ?>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'password'); ?></label>
                                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'รหัสผ่าน (ข้อมูลควรเป็น (A-z0-9) และต้องมากกว่า 6 ตัวอักษร)', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($model, 'password'); ?>
                                        <!-- <p class="hint">
										<?php //echo UserModule::t("Minimal password length 4 symbols."); ?>
										</p> -->
                                    </div>


                                    <div class="form-group">
                                        <label><?php echo $form->labelEx($model, 'email'); ?></label>
                                        <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'E-Mail', 'style' => 'width:100%')); ?>
                                        <?php echo $form->error($model, 'email'); ?>
                                    </div>
                                </div>
                                <div class="span7 offset3">
                                    <div class="form-group">
                                        <div class="row">
                                            <?php
                                            $profileFields = $profile->getFields();
                                            if ($profileFields) {
                                                foreach ($profileFields as $field) {
                                                    ?>
                                                    <div class="span7">
                                                        <?php echo $form->labelEx($profile, $field->varname); ?>
                                                        <?php
                                                        if ($widgetEdit = $field->widgetEdit($profile)) {
                                                            echo $widgetEdit;
                                                        } elseif ($field->range) {
                                                            echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                                                        } elseif ($field->field_type == "TEXT") {
                                                            echo $form->textArea($profile, $field->varname, array('rows' => 6, 'cols' => 50, 'class' => 'form-control', 'style' => 'width:100%'));
                                                        } else {
                                                            echo $form->textField($profile, $field->varname, array('size' => 60, 'class' => 'form-control', 'style' => 'width:100%', 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                                                        }
                                                        ?>
                                                        <?php echo $form->error($profile, $field->varname); ?>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="span7">
                                                <?php echo $form->labelEx($model, 'superuser'); ?>
                                                <?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus'), array('class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'superuser'); ?>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="span7">
                                                <?php echo $form->labelEx($model, 'status'); ?>
                                                <?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus'), array('class' => 'form-control', 'style' => 'width:100%')); ?>
                                                <?php echo $form->error($model, 'status'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" style="text-align: right;">
                                        <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'btn btn-primary',)); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php $this->endWidget(); ?>
                </div>
                <!-- form -->
                <?php endif; ?>

            </div>


        </div>
        <!-- form -->
    </div>
</div>
</div>
<!-- END innerLR -->
