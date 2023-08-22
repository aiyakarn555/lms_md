<?php
// header("Content-Type: application/vnd.ms-excel");
// header( "Content-type: application/vnd.ms-excel; charset=UTF-8" );
// header('Content-Disposition: attachment; filename="MyXls.xls"');

$strExcelFileName="MyXls.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<BODY>
<?php

if(isset($header)){
    $header_id = $header->survey_header_id;
    ?>
    <h2><?php echo $header->survey_name; ?></h2>
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
                    //radio
                    if($questionValue->input_type_id == '2'){

                        ?>
                        <div>
                            <img
                                src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/<?= $questionValue->question_id ?>.png">
                            <?php
                            for($i=0;$i<=20;$i++){
                                echo "<br />";
                            }
                            ?>
                        </div>

                        <br>
                        <?php
                        //checkbox
                    }else if($questionValue->input_type_id == '3'){
                        ?>
                        <div>
                            <img
                                src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/<?= $questionValue->question_id ?>.png">
                            <?php
                            for($i=0;$i<=20;$i++){
                                echo "<br />";
                            }
                            ?>
                        </div>

                        <br>
                        <?php
                        //contentment
                    }else if($questionValue->input_type_id == '4'){
                        ?>
                        <div>
                            <img
                                src="<?= Yii::app()->getBaseUrl(true) ?>/uploads/<?= $questionValue->question_id ?>.png">
                            <?php
                            for($i=0;$i<=20;$i++){
                                echo "<br />";
                            }
                            ?>
                        </div>
                        <br>
                        <?php
                        //text
                    }else if($questionValue->input_type_id == '5'){
                        ?>
                        <!-- <label style="font-size:20px;">
                            <div><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" class="error"></label></div>
                            <textarea data-rule-required="true" data-msg-required="กรุณาตอบ" name="choice[text][<?php echo $questionValue->choices[0]->option_choice_id; ?>]" rows="8" cols="50"></textarea>
                        </label> -->
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

</BODY>

</HTML>
