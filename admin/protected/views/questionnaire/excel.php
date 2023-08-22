<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="MyXls.xls"');


?>

<html xmlns:o=”urn:schemas-microsoft-com:office:office”

      xmlns:x=”urn:schemas-microsoft-com:office:excel”

      xmlns=”http://www.w3.org/TR/REC-html40″>

<HTML>

<HEAD>
    <meta http-equiv=”Content-type” content=”text/html;charset=UTF-8″/>

</HEAD>
<BODY>
<?php

if (isset($lesson->header)) {
    $header = $lesson->header;
    $header_id = $header->survey_header_id;
    $lesson_id = $lesson->id;
    ?>
    <h2><?php echo $header->survey_name; ?></h2>
    <?php echo CHtml::decode($header->instructions); ?>
    <hr>
    <?php
    if (count($header->sections) > 0) {
        $sections = $header->sections;
        foreach ($sections as $sectionKey => $sectionValue) {
            ?>
            <h4><?php echo $sectionValue->section_title; ?></h4>
            <hr>
            <?php
            if (count($sectionValue->questions) > 0) {
                foreach ($sectionValue->questions as $questionKey => $questionValue) {
                    //radio
                    if ($questionValue->input_type_id == '2') {

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

                        <?php
                        //checkbox
                    } else if ($questionValue->input_type_id == '3') {
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

                        <?php
                        //contentment
                    } else if ($questionValue->input_type_id == '4') {
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
                        <?php
                        //text
                    } else if ($questionValue->input_type_id == '5') {
                        ?>


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
