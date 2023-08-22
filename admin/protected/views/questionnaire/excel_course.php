<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="MyXls.xls"');


?>

<html xmlns:o=”urn:schemas-microsoft-com:office:office”

      xmlns:x=”urn:schemas-microsoft-com:office:excel”

      xmlns=”http://www.w3.org/TR/REC-html40″>

<HTML>

<HEAD>
    <meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />


</HEAD>
<BODY>
<?php
function checkRange($val,$max){
        switch ($max) {
            case 5:
                    if($val >= 4){
                        $msg_range = "มากที่สุด";
                    }else if($val >= 3){
                        $msg_range = "มาก";
                    }else if($val >= 2){
                        $msg_range = "ปานกลาง";
                    }else if($val >= 1){
                        $msg_range = "น้อย";
                    }else if($val >= 0){
                        $msg_range = "น้อยมาก";
                    }
            break;
            case 10:
                    if($val >= 8){
                        $msg_range = "มากที่สุด";
                    }else if($val >= 6){
                        $msg_range = "มาก";
                    }else if($val >= 4){
                        $msg_range = "ปานกลาง";
                    }else if($val >= 2){
                        $msg_range = "น้อย";
                    }else if($val >= 0){
                        $msg_range = "น้อยมาก";
                    }
            break;
        }
        return $msg_range;
    }
if (isset($course->q_header)) {
    // $header = $course->q_header;
    // $header_id = $header->survey_header_id;
    // $course_id = $course->id;

    $header = $course->q_header;
    $teacher_id = $course->teacher_id;
    $header_id = $header->survey_header_id;
    $course_id = $course->course_id;
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
                                src="<?= Yii::app()->getBaseUrl(true) ?>/../uploads/<?= $questionValue->question_id ?>.png">
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
                                src="<?= Yii::app()->getBaseUrl(true) ?>/../uploads/<?= $questionValue->question_id ?>.png">
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
                        <?php 
                            $labelArray = array();
                                            $countArray = array();
                                            $dataArray = array();
                                            $dataArray[] = array('คำถาม', 'ค่าเฉลี่ย');
                                            $date_table = "";
                                            $total_average = 0;
                                            $countQuest = count($questionValue->choices);
                                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                                                $label = $choiceValue->option_choice_name;
                                                
                                                $sql = "SELECT 
                                SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END) AS five,
                                SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END) AS four,
                                SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END) AS three,
                                SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END) AS two,
                                SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END) AS one,
                                SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END)*5 AS fivem,
                                SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END)*4 AS fourm,
                                SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END)*3 AS threem,
                                SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END)*2 AS twom,
                                SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END)*1 AS onem 
                                FROM q_answers_course INNER JOIN q_quest_ans_course ON q_answers_course.quest_ans_id = q_quest_ans_course.id ";
                                                // $sql .= " WHERE course_id ='" . $course_id . "' AND header_id='" . $header_id . "' AND choice_id ='" . $choiceValue->option_choice_id . "' AND q_quest_ans_course.teacher_id='" . $teacher_id . "' ";
                                                $sql .= " WHERE course_id ='" . $course_id . "' AND header_id='" . $header_id . "' AND choice_id ='" . $choiceValue->option_choice_id."'";
                                
                                                if(!empty($teacher_id)){
                                                    $sql .= " AND q_quest_ans_course.teacher_id='" . $teacher_id . "' ";
                                                }

                                                if($schedule){
                                                    $sql .= ' AND (q_quest_ans_course.date >= "'.$schedule->training_date_start.'" AND q_quest_ans_course.date <= "'.$schedule->training_date_end.'")';
                                                }
                                                $sql .= 'AND q_answers_course.user_id IS NOT NULL';
                                                
                                                $count = Yii::app()->db->createCommand($sql)->queryRow();
                                                $totalCount = $count['five'] + $count['four'] + $count['three'] + $count['two'] + $count['one'];
                                                $totalCountM = $count['fivem'] + $count['fourm'] + $count['threem'] + $count['twom'] + $count['onem'];
                                                $average = $totalCountM / (($totalCount != 0) ? $totalCount : 1);
                                                $percent = $average * 100 / 5;
                                                // $dataArray[] = array($label, $percent);
                                                $dataArray[] = array($label, $average);
                                                $total_average += $average;
                                                $msg_range = checkRange($average,$questionValue->question_range);
                                                $date_table .= '<tr>
                                                                    <td>'.$label.'</td>
                                                                    <td  style=" text-align: center;">'.round($average,2).'</td>
                                                                    <td  style=" text-align: center;">'.$msg_range.'</td>
                                                                </tr>';
                                            }
                         ?>
                        <div>
                            <img
                                src="<?= Yii::app()->getBaseUrl(true) ?>/../uploads/<?= $questionValue->question_id ?>.png">
                            <?php
                            for($i=0;$i<=20;$i++){
                                echo "<br />";
                            }
                            ?>
                            <!-- Table  -->
                                    <table class="table table-bordered">
                                        <thead style="background-color: #eec4b7; font-weight: bold;">
                                        <tr>
                                            <th rowspan="2" style=" text-align: center; vertical-align: middle; width: 60%;">หัวข้อประเมิน</th>
                                            <th colspan="2" style=" text-align: center;">ระดับความพึงพอใจ (ร้อยละ)</th>
                                        </tr>
                                        <tr>
                                            <th style=" text-align: center;">ค่าเฉลี่ย</th>
                                            <th style=" text-align: center;">ระดับความพึงพอใจ</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?= $date_table ?>
                                        </tbody>

                                        <tfoot  style="background-color: #eec4b7; font-weight: bold;">
                                            <tr>
                                                <td style=" text-align: center;">รวม</td>
                                                <td style=" text-align: center;"><?= round($total_average/$countQuest,2); ?></td>
                                                <?php $totalCount = ($total_average/$countQuest > 5)? 10: 5; ?>
                                                <td style=" text-align: center;"><?= checkRange($total_average/$countQuest,$totalCount); ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    
                                    <br>
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
