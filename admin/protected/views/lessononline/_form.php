<script src="<?php echo $this->assetsBase;; ?>/js/jquery.validate.js" type="text/javascript"></script>
<!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
<!-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
<style>
.checkbox label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.checkbox label {
    display: inline-block;
}

.checkbox label input[type="checkbox"]{
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon{
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon{
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr{
    opacity: .5;
}
</style>


<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/uploadifive.css">
<style type="text/css">
body {
    font: 13px Arial, Helvetica, Sans-serif;
}
</style>
<!-- innerLR -->
<?php //echo "<pre>"; var_dump($fileDoc->fileDocs); exit(); ?>
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

                   <?php $form=$this->beginWidget('AActiveForm', array(
                    'id'=>'lesson-form',
                    'enableClientValidation'=>true,
                    'clientOptions'=>array(
                        'validateOnSubmit'=>true
                    ),
                    'errorMessageCssClass' => 'label label-important',
                    'htmlOptions' => array('enctype' => 'multipart/form-data')
                    )); ?>

                        
                        <?php
                        $lang_id = isset($_GET['lang_id']) ? $_GET['lang_id'] : 1 ;
                        $parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 0 ;
                        $modelLang = Language::model()->findByPk($lang_id);

                        // $courseAll = CHtml::listData(MsOnline::model()->findAll('active="y" and lang_id = '.$lang_id), 'ms_teams_id', 'name_ms_teams');

                        // ////////////////// group id 7 และเป็นคนสร้าง ถึงจะเห็น
                        // $check_user = User::model()->findByPk(Yii::app()->user->id);
                        // $group = $check_user->group;
                        // $group_arr = json_decode($group);
                        // $see_all = 2;
                        // if(in_array("1", $group_arr) || in_array("7", $group_arr)){
                        //     $see_all = 1;
                        // }
                        // //////////////////
                        // if($see_all != 1){
                        //     $courseAll = CHtml::listData(MsOnline::model()->findAll('active="y"  and create_by="'.Yii::app()->user->id.'"'), 'id', 'name_ms_teams');
                        // }else{
                        //     $courseAll = CHtml::listData(MsOnline::model()->findAll('active="y" '), 'id', 'name_ms_teams');
                        // }

                        //แสดงตาม Group
                        $criteria = new CDbCriteria;
                        $criteria->compare("active","y");
                        // $criteria->compare("lang_id",$lang_id);
                        $modelUser = Users::model()->findByPk(Yii::app()->user->id);
                        $group = json_decode($modelUser->group);
                        if (!in_array(1, $group)){
                          $groupUser = Helpers::lib()->groupUser(Yii::app()->user->id);
                          $criteria->addInCondition('create_by', $groupUser);    
                        }
                        $courseAll = CHtml::listData(MsOnline::model()->findAll($criteria), 'id', 'name_ms_teams');

                        ?>

                        <?php if ($lang_id != 1){ ?>
                        <p class="note"><span style="color:red;font-size: 20px;">เพิ่มเนื้อหาของภาษา <?= $modelLang->language; ?></span></p>
                        <?php 
                            }
                        ?>
                        <p class="note">ค่าที่มี <?php echo $this->NotEmpty();?> จำเป็นต้องใส่ให้ครบ</p>
                        <?php    
                        if($lang_id == 1){ 
                            $flag = true;
                            $att = array("class"=>"span8");
                            $attCateAmount = array('size'=>60,'maxlength'=>255,'class'=>'span8');
                            $attTime = array('class' => 'default_datetimepicker');
                            $dayCheck = 'onclick="return true;"';
                            $state = false;
                            $attSearch = array("class"=>"span8",'disable_search' => false);
                        }else{ 
                            $flag = false;
                        $lessonChildren = $lesson; //Lesson parent_id not 0
                        $lesson = LessonOnline::model()->FindByPk($parent_id);
                        $rootLesson = $lesson;
                        $conditions = "ms_teams_id = ".$lesson->msteams->id;
                        $courseCh = MsOnline::model()->find("id = '".$lesson->msteams->id."'");
                        $courseAll = CHtml::listData(MsOnline::model()->findAll("id = ".$courseCh->id), 'id', 'name_ms_teams');
                        // $courseAll = CHtml::listData(MsOnline::model()->findAll("ms_teams_id = ".$lesson->msteams->id), 'ms_teams_id', 'name_ms_teams');
                        $lesson->title = "";
                        $lesson->description = "";
                        $lesson->content = "";
                        $att = array("class"=>"span8",'readonly' => true);
                        $attCateAmount = array('size'=>60,'maxlength'=>255,'class'=>'span8','readonly' => true);
                        $attTime = array('class' => 'default_datetimepicker','readonly' => true);
                        $dayCheck = 'onclick="return false;"';
                        $state = true;
                        $attSearch = array("class"=>"span8",'disable_search' => true);
                    } ?>
                   
                    <?php (empty($model->ms_teams_id)? $select = '' : $select = $model->ms_teams_id); ?>
                    <div class="row">
                        <?php echo $form->labelEx($lesson,'ms_teams_id'); ?>
                        <!-- <?php echo Chosen::dropDownList('ms_teams_id', $select, $courseAll, $attSearch); ?> -->
                        <?php echo Chosen::activeDropDownList($lesson, 'ms_teams_id', $courseAll, $attSearch); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($lesson,'ms_teams_id'); ?>
                    </div>
                    <?php if($lessonChildren){
                        $lesson = $lessonChildren;
                    }
                    ?>

                    <div class="row">
                        <!-- <div class="col-md-12"> -->
                        <?php echo $form->labelEx($lesson,'title'); ?>
                        <?php echo $form->textField($lesson,'title',array('size'=>60,'maxlength'=>80,'class'=>'span8')); ?>
                        <?php echo $this->NotEmpty();?>
                        <?php echo $form->error($lesson,'title'); ?>
                        <!-- </div> -->
                    </div>

                     <?php if($state){
                        $lesson = LessonOnline::model()->findByPk($parent_id);
                       } ?>

            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php echo $form->labelEx($lesson,'cate_percent'); ?>
                <?php echo $form->textField($lesson,'cate_percent',$attCateAmount); ?> %
                <?php echo $this->NotEmpty();?>
                <?php echo $form->error($lesson,'cate_percent'); ?>
                <!-- </div> -->
            </div>

            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php echo $form->labelEx($lesson,'cate_amount'); ?>
                <?php echo $form->textField($lesson,'cate_amount',$attCateAmount); ?> ครั้ง
                <?php echo $this->NotEmpty();?>
                <?php echo $form->error($lesson,'cate_amount'); ?>
                <!-- </div> -->
            </div>
            <div class="row">
                <!-- <div class="col-md-12"> -->
                <?php echo $form->labelEx($lesson,'time_test'); ?>
                <?php echo $form->textField($lesson,'time_test',$attCateAmount); ?> นาที
                <?php echo $this->NotEmpty();?>
                <?php echo $form->error($lesson,'time_test'); ?>
                <!-- </div> -->
            </div>

            <br>

            <?php 
            if($state){
            $lesson = $lessonChildren; 
                }
            ?>
            <div class="row">
            <?php echo $form->labelEx($lesson,'status'); ?>
            <?php echo $form->checkBox($lesson,'status',array(
                'data-toggle'=> 'toggle','value'=>"y", 'uncheckValue'=>"n"
            )); ?>
            <?php echo $form->error($lesson,'status'); ?>
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
<!-- END innerLR -->
<script type="text/javascript">
   $('.default_datetimepicker').datetimepicker({
    datepicker:false,
    format:'H:i'
});
   // $('#default_datetimepicker').datetimepicker({step:10});
</script>  