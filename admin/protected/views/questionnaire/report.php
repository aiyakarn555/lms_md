<!-- Include Required Prerequisites -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/moment.min.js"></script>
<!-- Include Date Range Picker -->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap-daterangepicker/daterangepicker-bs2.css" />

<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/highcharts.js"></script>-->
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<!--<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/Highcharts-4.1.5/js/modules/exporting.js"></script>-->
<style>
    th {
        background-color: #E25F39;
        color: white;
    }
</style>
<?php
$titleName = 'รายงานแบบสอบถาม';

$this->breadcrumbs=array(
	'ระบบบทเรียน'=>array('Lesson/index'),
	'รายงานแบบสอบถาม',
);

Yii::app()->clientScript->registerScript('search', "
	$('#SearchFormAjax').submit(function(){
	   /* $.fn.yiiGridView.update('$formNameModel-grid', {
	        data: $(this).serialize()
	    });*/
	    return true;
	});
");

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	/*$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("Report[news_per_page]", "news_per_page");*/

	$('.collapse-toggle').click();


EOD
, CClientScript::POS_READY);
?>
<div class="innerLR">

	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
			<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> <?php echo $titleName." ของ บทเรียน".$lesson->title;?></h4>
		</div>
        <div class="widget-body">
            <?php
        if(isset($lesson->header)){
            $header = $lesson->header;
            $header_id = $header->survey_header_id;
            $lesson_id = $lesson->id;
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
                        <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong><label for="choice[radio][<?php echo $questionValue->question_id; ?>]" class="error"></label></div>
                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                        	$labelArray = array();
                        	$countArray = array();
                        	$dataArray = array();
                        	$dataArray[] = array('ตัวเลือก', 'เปอร์เซ็น');
                            $maxValue = 0;
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                            	$label = $choiceValue->option_choice_name;
                            	$sql = "SELECT COUNT(*) AS radiocount FROM q_answers INNER JOIN q_quest_ans ON q_answers.quest_ans_id = q_quest_ans.id ";
                            	$sql .= " WHERE lesson_id ='".$lesson_id."' AND header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";
                            	$count = Yii::app()->db->createCommand($sql)->queryRow();
                            	$count = floatval($count['radiocount']);
                                if($count > $maxValue){
                                    $maxValue = $count;
                                }
                            	$dataArray[] = array($label,$count);
                            }
                            foreach($dataArray as $key => $value){
                                if($key != 0){
                                    $dataArray[$key][1] = floatval(number_format($value[1]*100/($maxValue==0?1:$maxValue),2));
                                }
                            }

                            echo '<div id="container'.$questionValue->question_id.'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
                            $data = json_encode($dataArray);
							Yii::app()->clientScript->registerScript('chart'.$questionValue->question_id, "

							  google.load('visualization', '1.0', {packages:['corechart']});
							  google.setOnLoadCallback(drawChart".$questionValue->question_id.");
							  function drawChart".$questionValue->question_id."() {
							    var data = google.visualization.arrayToDataTable(
							      ".$data."
							    );

							    var options = {
							        title: '".$questionValue->question_name."',
//							        vAxis: {format:'#%'}
                                    vAxis: {
							            minValue: 0,
							            maxValue: 100,
							        }
							    };

							    var chart = new google.visualization.ColumnChart(document.getElementById('container".$questionValue->question_id."'));

							    google.visualization.events.addListener(chart, 'ready', function () {
							        $.post('".$this->createUrl('report/saveChart')."',{name:'".$questionValue->question_id."',image_base64:chart.getImageURI()},function(json){
							            var jsonObj = $.parseJSON( json );
							        });
							    });

							    chart.draw(data, options);
							  }


							", CClientScript::POS_END);
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
                        	$labelArray = array();
                        	$countArray = array();
                        	$dataArray = array();
                        	$dataArray[] = array('ตัวเลือก', 'เปอร์เซ็น');
                            $maxValue = 0;
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                            	$label = $choiceValue->option_choice_name;
                            	$sql = "SELECT COUNT(*) AS radiocount FROM q_answers INNER JOIN q_quest_ans ON q_answers.quest_ans_id = q_quest_ans.id ";
                            	$sql .= " WHERE lesson_id ='".$lesson_id."' AND header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";
                            	$count = Yii::app()->db->createCommand($sql)->queryRow();
                            	$count = floatval($count['radiocount']);
                                if($count > $maxValue){
                                    $maxValue = $count;
                                }
                            	$dataArray[] = array($label,$count);
                            }
                            foreach($dataArray as $key => $value){
                                if($key != 0){
                                    $dataArray[$key][1] = floatval(number_format($value[1]*100/($maxValue==0?1:$maxValue),2));
                                }
                            }

                            echo '<div id="container'.$questionValue->question_id.'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
                            $data = json_encode($dataArray);
							Yii::app()->clientScript->registerScript('chart'.$questionValue->question_id, "

							  google.load('visualization', '1.0', {packages:['corechart']});
							  google.setOnLoadCallback(drawChart".$questionValue->question_id.");
							  function drawChart".$questionValue->question_id."() {
							    var data = google.visualization.arrayToDataTable(
							      ".$data."
							    );

							    var options = {
							        title: '".$questionValue->question_name."',
//							        vAxis: {format:'#%'}
                                    vAxis: {
							            minValue: 0,
							            maxValue: 100,
							        }
							    };

							    var chart = new google.visualization.ColumnChart(document.getElementById('container".$questionValue->question_id."'));

							    google.visualization.events.addListener(chart, 'ready', function () {
							        $.post('".$this->createUrl('report/saveChart')."',{name:'".$questionValue->question_id."',image_base64:chart.getImageURI()},function(json){
							            var jsonObj = $.parseJSON( json );
							        });
							    });

							    chart.draw(data, options);
							  }

							", CClientScript::POS_END);
                        }
                        ?>
                        </div>
                        <br>
<?php
                        //contentment
                        }else if($questionValue->input_type_id == '4'){
?>
                        <div style="font-size:20px;"><strong><?php echo $questionValue->question_name; ?></strong></div>
                        <div>
                        <?php
                        if(count($questionValue->choices) > 0){
                        	$labelArray = array();
                        	$countArray = array();
                        	$dataArray = array();
                        	$dataArray[] = array('คำถาม', 'เปอร์เซ็น');
                            foreach ($questionValue->choices as $choiceKey => $choiceValue) {
                            	$label = $choiceValue->option_choice_name;
                                if($questionValue->question_range == "" || $questionValue->question_range == "5"){
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
    								FROM q_answers INNER JOIN q_quest_ans ON q_answers.quest_ans_id = q_quest_ans.id ";
                                	$sql .= " WHERE lesson_id ='".$lesson_id."' AND header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";
                                	$count = Yii::app()->db->createCommand($sql)->queryRow();
                                	$totalCount = $count['five']+$count['four']+$count['three']+$count['two']+$count['one'];
                                	$totalCountM = $count['fivem']+$count['fourm']+$count['threem']+$count['twom']+$count['onem'];
                                	$average = $totalCountM/(($totalCount!=0)?$totalCount:1);
                                	$percent = ($average*100/5)-5;
                                }else{
                                    $sql = "SELECT 
                                    SUM(CASE WHEN (answer_numeric=10) THEN 1 ELSE 0 END) AS ten,
                                    SUM(CASE WHEN (answer_numeric=9) THEN 1 ELSE 0 END) AS nine,
                                    SUM(CASE WHEN (answer_numeric=8) THEN 1 ELSE 0 END) AS eight,
                                    SUM(CASE WHEN (answer_numeric=7) THEN 1 ELSE 0 END) AS seven,
                                    SUM(CASE WHEN (answer_numeric=6) THEN 1 ELSE 0 END) AS six,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END) AS five,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END) AS four,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END) AS three,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END) AS two,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END) AS one,
                                    SUM(CASE WHEN (answer_numeric=10) THEN 1 ELSE 0 END)*10 AS tenm,
                                    SUM(CASE WHEN (answer_numeric=9) THEN 1 ELSE 0 END)*9 AS ninem,
                                    SUM(CASE WHEN (answer_numeric=8) THEN 1 ELSE 0 END)*8 AS eightm,
                                    SUM(CASE WHEN (answer_numeric=7) THEN 1 ELSE 0 END)*7 AS sevenm,
                                    SUM(CASE WHEN (answer_numeric=6) THEN 1 ELSE 0 END)*6 AS sixm,
                                    SUM(CASE WHEN (answer_numeric=5) THEN 1 ELSE 0 END)*5 AS fivem,
                                    SUM(CASE WHEN (answer_numeric=4) THEN 1 ELSE 0 END)*4 AS fourm,
                                    SUM(CASE WHEN (answer_numeric=3) THEN 1 ELSE 0 END)*3 AS threem,
                                    SUM(CASE WHEN (answer_numeric=2) THEN 1 ELSE 0 END)*2 AS twom,
                                    SUM(CASE WHEN (answer_numeric=1) THEN 1 ELSE 0 END)*1 AS onem 
                                    FROM q_answers INNER JOIN q_quest_ans ON q_answers.quest_ans_id = q_quest_ans.id ";
                                    $sql .= " WHERE lesson_id ='".$lesson_id."' AND header_id='".$header_id."' AND choice_id ='".$choiceValue->option_choice_id."' ";
                                    $count = Yii::app()->db->createCommand($sql)->queryRow();
                                    $totalCount = $count['ten']+$count['nine']+$count['eight']+$count['seven']+$count['six']+$count['five']+$count['four']+$count['three']+$count['two']+$count['one'];
                                    $totalCountM = $count['tenm']+$count['ninem']+$count['eightm']+$count['sevenm']+$count['sixm']+$count['fivem']+$count['fourm']+$count['threem']+$count['twom']+$count['onem'];
                                    $average = $totalCountM/(($totalCount!=0)?$totalCount:1);
                                    $percent = $average*100/10;
                                }
                            	$dataArray[] = array($label,$percent);
                            }

                            echo '<div id="container'.$questionValue->question_id.'" style="min-width: 310px; height: 400px; margin: 0 auto"></div>';
                            $data = json_encode($dataArray);
							Yii::app()->clientScript->registerScript('chart'.$questionValue->question_id, "

							  google.load('visualization', '1.0', {packages:['corechart']});
							  google.setOnLoadCallback(drawChart".$questionValue->question_id.");
							  function drawChart".$questionValue->question_id."() {
							    var data = google.visualization.arrayToDataTable(
							      ".$data."
							    );

							    var options = {
							        title: '".$questionValue->question_name."',
//							        vAxis: {format:'#%'}
                                    vAxis: {
							            minValue: 0,
							            maxValue: 100,
							        }
							    };

							    var chart = new google.visualization.ColumnChart(document.getElementById('container".$questionValue->question_id."'));

							    google.visualization.events.addListener(chart, 'ready', function () {
							        $.post('".$this->createUrl('report/saveChart')."',{name:'".$questionValue->question_id."',image_base64:chart.getImageURI()},function(json){
							            var jsonObj = $.parseJSON( json );
							        });
							    });

							    chart.draw(data, options);
							  }


							", CClientScript::POS_END);
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
            <a href="<?=Yii::app()->createUrl('Questionnaire/excel',array('lesson_id'=>$lesson_id));?>" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</a>
        </div>
	</div>
</div>

