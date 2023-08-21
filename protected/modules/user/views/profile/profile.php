<?php
// var_dump($model);
// exit();
//YiiBase::import("webroot.protected.components");
?>
<?php $this->pageTitle = Yii::app()->name . ' - ' . UserModule::t("Profile");
$this->breadcrumbs = array(
UserModule::t("Profile"),
);
?>
<?php if (Yii::app()->user->hasFlash('profileMessage')): ?>
<div class="success">
    <?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>
<?php endif; ?>
<style>
.label-deteil {
margin-bottom: 15px;
}
.label-edit {
margin-bottom: 15px;
font-weight: bold;
color: #363636;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
    border:0;
}
</style>
<!-- Start Page Banner -->
<div class="page-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="text-white"><?php echo UserModule::t('Your profile'); ?></h2>
                <p class="grey lighten-1">ดูประวัติส่วนตัว</p>
            </div>
            <div class="col-md-6">
                <ul class="breadcrumbs">
                    <li><a href="#">หน้าแรก</a></li>
                    <li><?php echo UserModule::t('Your profile'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Page Banner -->
<div class="container bg-white50 mt-2em">
<div class="row pd-2em border">
    <div class="col-md-5 center">
        <?php
                                // if($model->pic_user!=""){
                                $registor = new RegistrationForm;
                                $registor->id = $model->id;
                                // }
                                ?>
                                <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $model, $model->pic_user, $registor, array('class' => 'img-circle img-thumbnail', 'id' => 'wizardPicturePreview', 'style' => 'width:150px; height:150px;')); ?>
                                
    </div>
    <div class="col-md-7">
    <div class="table-responsive">
        <table class="table">
            <tbody>
                <tr>
                    <td><strong><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></strong></td>
                    <td><?php echo CHtml::encode($model->username); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('title_id')); ?></strong></td>
                    <?php
                        $data = ProfilesTitle::model()->findbyPk($profile->title_id);
                        $title = $data->prof_title;
                    ?>
                    <td><?php echo $title; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('firstname')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->firstname); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('lastname')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->lastname); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('type_user')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->type_name->name); ?></td>
                </tr>
                <?php if($model->auditor_id) { ?>
                <tr>
                    <td><strong><?php echo CHtml::encode($model->getAttributeLabel('auditor_id')); ?></strong></td>
                    <td><?php echo CHtml::encode($model->auditor_id); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('sex')); ?></strong></td>
                    <td><?php if($profile->sex == 'Male'){echo 'ชาย';}elseif($profile->sex == 'Female'){ echo 'หญิง';} ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('birthday')); ?></strong></td>
                    <td><?= Helpers::changeFormatDate($profile->birthday) ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('age')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->age); ?> ปี</td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('education')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->education); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('occupation')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->occupation); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('position')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->position); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('website')); ?></strong></td>
                    <td><?php if($profile->website){echo CHtml::encode($profile->website);}else{ echo 'ไม่มี';} ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('address')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->address); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('province')); ?></strong></td>
                    <?php 
                        $data = Province::model()->findbyPk($profile->province);
                        $province = $data->pv_name_th;
                    ?>
                    <td><?php echo CHtml::encode($province); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('tel')); ?></strong></td>
                    <td><?php if($profile->tel){echo CHtml::encode($profile->tel);}else{ echo 'ไม่มี';} ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('phone')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->phone); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('fax')); ?></strong></td>
                    <td><?php if($profile->fax){echo CHtml::encode($profile->fax);}else{ echo 'ไม่มี';} ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($profile->getAttributeLabel('contactfrom')); ?></strong></td>
                    <td><?php echo CHtml::encode($profile->contactfrom); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></strong></td>
                    <td><?php echo CHtml::encode($model->email); ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($model->getAttributeLabel('create_at')); ?></strong></td>
                    <td><?php echo $model->create_at; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($model->getAttributeLabel('lastvisit_at')); ?></strong></td>
                    <td><?php echo $model->lastvisit_at; ?></td>
                </tr>
                <tr>
                    <td><strong><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></strong></td>
                    <td><?php echo CHtml::encode(User::itemAlias("UserStatus", $model->status)); ?></td>
                </tr>                
            </tbody>
        </table>
        <a href="<?php echo $this->createUrl('/user/profile/edit'); ?>" class="btn btn-success">แก้ไขโปรไฟล์</a>
    </div>
    </div>
</div>
        <div class="row">
            <div class="col-md-12">
                <!-- Tabbable Widget -->
                <div class="tabbable paper-shadow relative" data-z="0.5">
                    <!-- Tabs -->
                    <!-- <ul class="nav nav-tabs">
                        <li class="active"><a><i class="fa fa-fw fa-lock"></i> <span class="hidden-sm hidden-xs"
                        style="font-size: 23px;"><?php echo UserModule::t('Your profile'); ?></span></a>
                    </li>
                </ul> -->
                <!-- // END Tabs -->
                <!-- Panes -->
                <!-- <div class="tab-content">
                    <div id="account" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-3" style="text-align: center"> -->
                                <?php
                                // if($model->pic_user!=""){
                                $registor = new RegistrationForm;
                                $registor->id = $model->id;
                                // }
                                ?>
                                <!-- <?php echo Controller::ImageShowUser(Yush::SIZE_THUMB, $model, $model->pic_user, $registor, array('class' => 'img-circle img-thumbnail', 'id' => 'wizardPicturePreview', 'style' => 'width:150px; height:150px;')); ?>
                                <br><br>
                                <a href="<?php echo $this->createUrl('/user/profile/edit'); ?>" class="btn btn-success" style="font-size: 20px;">แก้ไขโพรไฟล์</a> -->
                                
                            </div>
                            <!-- <div class="col-md-9" style="padding-top: 40px;">
                                
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?></div>
                                <div
                                class="col-xs-8 label-deteil"><?php echo CHtml::encode($model->username); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('title_id')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->title_id); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('firstname')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->firstname); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('lastname')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->lastname); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('type_user')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->type_user); ?></div>
                                <?php
                                if(($profile->type_user == 'ผู้สอบบัญชี') || ($profile->type_user == 'ผู้ทำบัญชี และ ผู้สอบบัญชี')){
                                ?>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($model->getAttributeLabel('auditor_id')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($model->auditor_id); ?></div>
                                <?php
                                }
                                ?>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('sex')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->sex); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('birthday')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->birthday); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('age')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->age); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('education')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->education); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('occupation')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->occupation); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('position')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->position); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('website')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php if($profile->website){echo CHtml::encode($profile->website);}else{ echo 'ไม่มี';} ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('address')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->address); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('province')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->province); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('tel')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php if($profile->tel){echo CHtml::encode($profile->tel);}else{ echo 'ไม่มี';} ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('phone')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->phone); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('fax')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php if($profile->fax){echo CHtml::encode($profile->fax);}else{ echo 'ไม่มี';} ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('contactfrom')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($profile->contactfrom); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($profile->getAttributeLabel('file')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php if($profile->file){echo CHtml::encode($profile->file);}else{ echo 'ไม่มี';} ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($model->getAttributeLabel('email')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo CHtml::encode($model->email); ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($model->getAttributeLabel('create_at')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo $model->create_at; ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($model->getAttributeLabel('lastvisit_at')); ?></div>
                                <div class="col-xs-8 label-deteil"><?php echo $model->lastvisit_at; ?></div>
                                <div
                                class="col-xs-4 label-edit"><?php echo CHtml::encode($model->getAttributeLabel('status')); ?></div>
                                <div
                                class="col-xs-8 label-deteil"><?php echo CHtml::encode(User::itemAlias("UserStatus", $model->status)); ?></div>
                                <!--                                    <div-->
                                <!--                                        class="col-xs-9 label-deteil">--><?php //echo CHtml::link('Edit profile', array('profile/edit'), array('class' => 'btn btn-primary')); ?><!--</div>-->
                            <!-- </div>
                        </div>
                    </div>
                </div> -->
                <!-- // END Panes -->
            </div>
            <!-- // END Tabbable Widget -->
        </div>
    </div>
</div>