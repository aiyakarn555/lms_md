<?php
	echo CHtml::button('Export',array('id'=>'btnExport'));

	echo CHtml::openTag('table');
	echo CHtml::closeTag('table');

?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/jquery/jquery-1.11.3.min.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl."/js/html2canvas.js"); ?>
<?php Yii::app()->clientScript->registerScriptFile("https://www.google.com/jsapi"); ?>
<?php 
 	include(realpath("themes/bws/views/questionnaire/report_include.php"));
 	$cls = new report_include;
 	echo $cls->render($groupid);
?>

﻿<script type="text/javascript">
  	$('#btnExport').click(function(e){
        window.open('data:application/vnd.ms-excel,' + 
  			encodeURIComponent('<html><meta charset=UTF-8">'+$('#divData').html()+'</head></html>' ));
        e.preventDefault();
  	});

</script>