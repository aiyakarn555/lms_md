<?php
$this->breadcrumbs=array(
    'ระบบข้อความส่วนตัว'=>array('index'),
    'รายละเอียดข้อความส่วนตัว',
);
?>

<style>/*
body {
    margin: 0 auto;
    max-width: 1000px;
    padding: 0 20px;
}*/

div.scroll {
    background-color: #a7b7b7;
    width: 100%;
    height: 300px;
    padding: 10px;
    overflow: scroll;
}
.container {
    border: 2px solid #dedede;
    background-color: #6f6694;
    border-radius: 5px;
    padding: 10px;
    margin: 10px;
    width: auto;
}
.darker {
    border-color: #ccc;
    background-color: #ddd;
}
/*
.container::after {
    content: "";
    clear: both;
    display: table;
}*/
.container img {
    float: left;
    max-width: 60px;
    width: 100%;
    margin-right: 20px;
    border-radius: 50%;
} 
.container img.right {
    float: right;
    margin-left: 20px;
    margin-right:0;
}
.time {
    float: left;
    color: #e1d31c;
} 

.time.right {
    float: right !important;
    color: #e1d31c !important;
}

.msg{
    color: #ffffff;
}
</style>
 
<div class="form">
<?php
                        $form = $this->beginWidget('AActiveForm', array(
                            'id' => 'Privatemessage',
                            'action'=>Yii::app()->createUrl('/Privatemessage/save')
                        ));
                    ?>
    <!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

    <div class="col-md-6">
        <?php echo $form->labelEx($profile,'firstname'); ?>
        <?php echo $form->textField($profile,'firstname',array('maxlength'=>255,'disabled'=>'disabled','style'=>'width:100%')); ?>
        <?php echo $form->error($profile,'firstname'); ?>
    </div>

    <div class="col-md-6">
        <?php echo $form->labelEx($profile,'lastname'); ?>
        <?php echo $form->textField($profile,'lastname',array('maxlength'=>255,'disabled'=>'disabled','style'=>'width:100%')); ?>
        <?php echo $form->error($profile,'lastname'); ?>
    </div>

    <div class="col-md-6">
        <?php echo $form->labelEx($profile,'advisor_email1'); ?>
        <?php echo $form->textField($profile,'advisor_email1',array('maxlength'=>255,'disabled'=>'disabled','style'=>'width:100%')); ?>
        <?php echo $form->error($profile,'advisor_email1'); ?>
    </div>

    <div class="col-md-6">
        <?php echo $form->labelEx($profile,'phone'); ?>
        <?php echo $form->textField($profile,'phone',array('maxlength'=>255,'disabled'=>'disabled','style'=>'width:100%')); ?>
        <?php echo $form->error($profile,'phone'); ?> 
    </div>
 
<div  class="col-md-12">
    <h2>Chat Messages</h2>      
        <div class="scroll">
            
            <div class="container">
                <img src="<?php echo Yii::app()->baseUrl; ?>/../themes/template2/images/user.png" alt="Avatar" style="width:100%;">
                <div class="msg"><p><?=$model->pm_quest ?> </p></div>
                <span class="time"><?=$model->create_date?></span>
            </div>

        <?php 
            foreach ($pmr as $key => $value) {
                if ($value->pm_id == $model->pm_id) {
                   $cls = $value->status_answer==1 ? 'right' : '';
                    ?>
                <div class="container">
                <div style="width: 100%;">
                <img class="<?= $cls ?>" src="<?php echo Yii::app()->baseUrl; ?>/../themes/template2/images/user.png" alt="Avatar">
                <div class="msg <?= $cls ?>"><p><?= $value->pmr_return; ?></p></div>
                <div class="time <?= $cls; ?>"><?=$value->create_date?></div>
                </div>
                </div>
               <?php  }
        }  ?>
        </div>
</div>
<div class="clearfix"></div><br>
    <div class="col-md-12">
        <?php echo $form->labelEx($profile,'privatemessage_return'); ?>
        <input type="textArea" name="privatemessage_return" rows = '6' cols = '50' style='width:100%' class='tinymce'>
        <?php echo $form->error($profile,'firstname'); ?>
    </div>
    <br>


<br>
        <div class="col-md-6">
                    <input type="hidden" name="PrivateMessageReturn[user_id]" value="<?= $profile->user_id ?>">

                    <input type="hidden" name="PrivateMessageReturn[ptivatemessage]" value="<?= $id ?>">

        <?php echo CHtml::tag('button',array('class' => 'btn btn-primary btn-icon glyphicons ok_2','type'=>'submit'),'<i></i>ส่งข้อมูล');?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(function () {
        init_tinymce();
    });
</script>