<style>
    .quiz { list-style-type: none; margin-bottom: 40px; }
    .quiz li { float: left; margin-right: 20px; }
    .head-quiz { padding-left: 20px; padding-right: 20px; }
    thead { background-color: #94CFFF; }
    .mb-quiz { margin-bottom: 10px; }
    .form-control{ border: 1px solid #D1D1D1; }
    .radio label::before { border: 1px solid #4193D0; }
    .checkbox label::before { border: 1px solid #4193D0; }
    .ml-15{ margin-left: 15px; }
    .mb-10{ margin-bottom: 15px; }
    .span5 { width: 500px; }
    .header-text { margin-bottom: 20px; }
    .header-text span { font-size: 30px; color: rgb(0, 183, 243); vertical-align: middle; }
    .tbl-score, .tbl-profile { font-size: 1.2em; color: black; }
    .td-head { padding-left: 20px; width: 200px; }
    .body.section { padding: 0 20px; }
    .head.section { padding: 0 20px; }
    .head { margin-bottom: 20px; }
</style>
<div class="container">
    <div class="text-center bg-transparent margin-none">
<?php
$this->breadcrumbs = array(
    'หลักสูตร'=>array('//category/index'),
    'แบบทดสอบ',
);
?>
<style>
    .title-question{
        font-size: 22px;
    }

    #question-form p{
        display: inline;
    }
    .panel-body { padding: 20px; }
</style>

    </div>
    <div class="page-section">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-md-12 col-sm-12 text-center header-text">
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/head-subject/quiz.png" alt="person" />
                    <span>คะแนน FINAL ที่สอบได้</span>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="panel-body">
                        <div class="head section">
                            <i class="fa fa-user pull-left" style="font-size: 30px; " aria-hidden="true"></i> <h4 style="font-size: 2.2em; line-height: 28px; ">รายละเอียดผู้เรียน</h4>
                        </div>
                        <div class="body section">
                            <?php
                                if(!Yii::app()->user->isGuest) {
                                    $currentUser = User::model()->findByPk(Yii::app()->user->id);
                                    if(isset($currentUser->profile)) {
                                        ?>
                                        <table class="tbl-profile table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <td class="td-head text-left"><strong>ชื่อ - นามสกุล :</strong></td>
                                                    <td class="text-left"><strong><?= $currentUser->profile->ProfilesTitle->prof_title ?> <?= $currentUser->profile->firstname ?> <?= $currentUser->profile->lastname ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-head text-left"><strong>ประเภทผู้เรียน :</strong></td>
                                                    <td class="text-left"><strong><?= $currentUser->profile->type_name->name ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-head text-left"><strong>ผู้ทำบัญชีรหัสเลขที่ :</strong></td>
                                                    <td class="text-left"><strong><?= $currentUser->bookkeeper_id ?></strong></td>
                                                </tr>
                                                <?php if($currentUser->auditor_id != null) { ?>
                                                <tr>
                                                    <td class="td-head text-left"><strong>ผู้สอบบัญชีรับอนุญาต :</strong></td>
                                                    <td class="text-left"><strong><?= $currentUser->auditor_id ?></strong></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
                $ModdelOnline = CourseOnline::model()->findByPk($model->course_id);
                $sumPoint = number_format($model->score_number/$model->score_total*100,2);
                if($sumPoint <= 60) {
                    if($sumPoint <= 30) {
                        $color = "#ff3b30";
                    } else {
                        $color = "#ff9800";
                    }
                } else {
                    $color = "#05ae0e";
                }

                if($model->score_past == 'n'){ $textPast = '<font color="#ff3b30"><i class="fa fa-close" aria-hidden="true"></i> <b>ไม่ผ่าน</b></font>'; }else{ $textPast = '<font color="#05ae0e"><i class="fa fa-check" aria-hidden="true"></i> <b>ผ่าน</b></font>'; }
            ?>
        <div class="col-md-12 col-sm-12">
            <div class="panel-body">
                <div class="head section">
                    <i class="fa fa-desktop pull-left" style="font-size: 30px; " aria-hidden="true"></i> <h4 style="font-size: 2.2em; line-height: 28px; ">รายละเอียดการสอบ</h4>
                </div>
                <div class="body section">
                    <table class="tbl-score table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td class="td-head text-left"><strong>หัวข้อ</strong></td>
                                <td class="text-left"><strong>รายละเอียด</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="td-head text-left">ชื่อหลักสูตร</td>
                                <td><?= $ModdelOnline->course_title ?></td>
                            </tr>
                            <tr>
                                <td class="td-head text-left">คะแนนที่คุณได้</td>
                                <td><?= $model->score_number.' / '.$model->score_total ?> คะแนน</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php $SettingAll = Helpers::lib()->SetUpSetting(); //Check Setting Open Show Log ?>

    <?php if($SettingAll['SITE_TESTING'] == 1): ?>

        <?php $TitleLogques = Courselogques::model()->findAll("score_id=:score_id", array(
            "score_id" => $model->score_id,
        ));?>

        <?php //echo CHtml::image(Yii::app()->request->baseUrl.'/images/icon_test.png'); // Image ?>

        <?php foreach ($TitleLogques as $keyLogques => $valueLogques): ?>

            <?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/bordertop.png','',array('class'=>'img-responsive')); // Image ?>

            <div class="pull-left">
                <?php echo CHtml::image(Yii::app()->request->baseUrl.'/images/knewstuff.png','',array(
                    'width'  => '20px',
                    'valign' => 'top'
                )); // Image ?>
            </div>

            <div class="title-question"><?php echo CHtml::decode($valueLogques->questions->ques_title);?></div>

            <?php $Logchoice = Courselogchoice::model()->findAll(" score_id=:s AND ques_id=:q ", array(
                "s" => $model->score_id,
                "q" => $valueLogques->ques_id
            ));?>

            <table class="">
            <?php foreach ($Logchoice as $keyLogchoice => $valueLogchoice): ?>
                <tr>
                    <td>
                        <div class="pull-left" style="line-height: 2;margin-right:10px">
                            <?php
                            if($valueLogchoice->logchoice_answer == "1")
                            {
                                if ($valueLogchoice->ques_type == 1)
                                {
                                    echo CHtml::checkbox('', true,array('disabled'=>'disabled'));
                                }
                                else if ($valueLogchoice->ques_type == 2)
                                {
                                    echo CHtml::radioButton('', true,array('disabled'=>'disabled'));
                                }
                            }
                            else
                            {
                                if ($valueLogchoice->ques_type == 1)
                                {
                                    echo CHtml::checkbox('', false,array('disabled'=>'disabled'));
                                }
                                else if ($valueLogchoice->ques_type == 2)
                                {
                                    echo CHtml::radioButton('', false,array('disabled'=>'disabled'));
                                }
                            }
                            ?>
                        </div>
                        <div class="pull-left" style="line-height: 2.3;margin-right:10px"><?php echo CHtml::decode($valueLogchoice->choices->choice_detail); ?></div>
                        <div class="pull-left" style="margin-top:6px">
                            <?php
                            if($valueLogchoice->is_valid_choice != "1")
                            {
                                echo CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png');
                            }
                            else
                            {
                                echo CHtml::image(Yii::app()->request->baseUrl.'/images/check.png');
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </table>

        <?php endforeach; ?>

    <?php endif; ?>

<?php
$lesson = Lesson::model()->findByPk($_GET['id']);
    ?>
    <div class="col-md-12 col-sm-12">
        <div class="panel-body">
            <a href="<?=Yii::app()->createUrl('course/detail',array('id'=>$model->course_id))?>" class="navbar-btn btn btn-primary">ย้อนกลับ</a>
            <?php 
                if($model->score_past == 'y') {
            ?>
                        <a class="btn btn-default PrintCertificate" href="<?php echo $this->createUrl('Course/PrintCertificate', array('id' => $model->course_id)); ?>" target="_self"><i class="fa fa-print"></i> พิมพ์หนังสือรับรอง CPD</a>
                    <?php } ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

