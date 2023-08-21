<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-validation-1.14.0/dist/jquery.validate.min.js"></script>

<style>
    form label.error {
        display: none;
        color: red;
        vertical-align: baseline;
        font-size: 20px;
    }
</style>
<div class="bs-example">

    <?php $form=$this->beginWidget('AActiveForm', array(
        'id'=>'questionnaire-form',
        'errorMessageCssClass' => 'label label-important',
    )); ?>
        
    <?php
        if(isset($lesson->header)){
            $header = $lesson->header;
    ?>
            <h2><?php echo $header->survey_name; ?></h2>
            <input type="hidden" name="header_id" value="<?php echo $header->survey_header_id; ?>">
            <?php echo CHtml::decode($header->instructions); ?>
            <hr>
    <?php
            if(count($header->sections) > 0){
                $sections = $header->sections;
                foreach ($sections as $sectionKey => $sectionValue) {
    ?>
                 <h4><?php echo $sectionValue->section_title; ?></h4>
                 <hr>
                 <?php
                 if(count($sectionValue->questions) > 0){
                    foreach ($sectionValue->questions as $questionKey => $questionValue) {
                        //input text
                        if($questionValue->input_type_id == '1'){
?>
                        <label style="font-size:20px;">
                            <div><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                            <input type="text" name="choice[input][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" data-rule-required="true" data-msg-required="กรุณาตอบ">
                        </label>
<?php
                        //radio
                        }else if($questionValue->input_type_id == '2'){

?>
                        <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[radio][<?php echo $questionValue->question_id; ?>]" class="error"></label></div>
                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>

                        <label style="font-size:20px;">
                            <input style="margin:0px;" type="radio" name="choice[radio][<?php echo $questionValue->question_id; ?>]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                            <?php echo $choiceValue->option_choice_name; ?>
                            <?php 
                            if($choiceValue->option_choice_type == 'specify'){
                            ?>
                            <input type="text" style="margin-left:10px;" name="choice[radioOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                            <?php
                            }
                            ?>
                        </label>

                        <?php
                            }
                        }
                        ?>
                        </div>
                        <br>
<?php
                        //checkbox
                        }else if($questionValue->input_type_id == '3'){
?>
                        <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" class="error"></label></div>
                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>

                        <label style="font-size:20px;">
                            <input style="margin:0px;" type="checkbox" name="choice[checkbox][<?php echo $questionValue->question_id; ?>][]" value="<?php echo $choiceValue->option_choice_id; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ">
                            <?php echo $choiceValue->option_choice_name; ?>
                            <?php 
                            if($choiceValue->option_choice_type == 'specify'){
                            ?>
                            <input type="text" style="margin-left:10px;" name="choice[checkboxOther][<?php echo $questionValue->question_id; ?>][<?php echo $choiceValue->option_choice_id; ?>]">
                            <?php
                            }
                            ?>
                        </label>
                        <?php
                            }
                        }
                        ?>
                        </div>
                        <br>
<?php
                        //contentment
                        }else if($questionValue->input_type_id == '4'){
?>
                        <div style="font-size:20px;">
                        <table class="span10" border="1">
                                <tr>
                                    <th><strong><?php echo $questionValue->question_name; ?></strong></th>
                                    <?php
                                    $scoreDetails = array('5' => 'มากที่สุด', '4' => 'มาก', '3' => 'ปายกลาง', '2' => 'น้อย', '1' => 'น้อยที่สุด');
                                    for($i=5;$i>=1;$i--){
                                    ?>
                                    <th class="text-center" width="120"><strong><?php echo $i." ".$scoreDetails[$i]; ?></strong></th>
                                    <?php
                                    }
                                    ?>
                                </tr>
                        <?php
                        if(count($questionValue->choices) > 0){
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                        ?>
                                <tr>
                                    <td <?php echo ($choiceKey%2==0)?'style="background-color:#d8d8d8"':''; ?>><?php echo $choiceValue->option_choice_name; ?><label for="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" class="error"></label></td>
                                    <?php
                                    for($i=5;$i>=1;$i--){
                                    ?>
                                    <td class="text-center" <?php echo ($choiceKey%2==0)?'style="background-color:#d8d8d8"':''; ?> ><input style="margin:0px;" type="radio" name="choice[contentment][<?php echo $choiceValue->option_choice_id; ?>]" value="<?php echo $i; ?>" data-rule-required="true" data-msg-required="กรุณาเลือกคำตอบ"></td>
                                    <?php
                                    }
                                    ?>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                        </table>
                        </div>
                        <br>
<?php
                        //text
                        }else if($questionValue->input_type_id == '5'){
?>
                        <label style="font-size:20px;">
                            <div><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                            <textarea data-rule-required="true" data-msg-required="กรุณาตอบ" name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" rows="8" cols="50"></textarea>
                        </label>
<?php
                        }
                    }
                 }
                 ?>
                 <hr>
    <?php
                }
            }

        }
    ?>

    <?php echo CHtml::tag('button',array('class' => 'btn btn-icon btn-warning'),'บันทึกข้อมูล'); ?>

    <?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#questionnaire-form").validate();
    });
</script>

<script type="text/javascript">
    $(function(){ // document ready

     
    });
</script>