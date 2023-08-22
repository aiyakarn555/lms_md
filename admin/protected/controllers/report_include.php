<?php
class report_include
{
	public function render($id)
	{
		$cls = new cls_Excel;
		$header = $cls->getHeader($id);
		$group = $cls->getGroup($id);
		$imgName = "Upload_".date('Y-m-d');

		$strHtml = "";
		$strHtml .= CHtml::openTag('div',array('id'=>'divData'));
		$strHtml .= CHtml::openTag('table',array('width'=>'900'));
		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::tag('td',array('colspan'=>'6','align'=>'center','style'=>'background-color:#2CA8FD;padding:10px;')
			,CHtml::label($header[0]['Gna_cNameTH'].'</br>'."วันที่ ".$header[0]['Date'].'</br>'
			,'',array('style'=>'font-size:15px;')));
		$strHtml .= CHtml::closeTag('tr');
		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::tag('td',array('style'=>'padding-bottom:20px;'));
		$strHtml .= CHtml::closeTag('tr');
		$strJS = "<script type='text/javascript'>";
		$strJS .= "google.load('visualization', '1', {packages:['corechart']});";
		$i=0;
		for (; $i <count($group) ; $i++) {
			if($i==0){
				$strHtml .= $this->printTitle($group[$i]['Gna_cNameTH'],$header[$i]['Member']);
			} else{
				if($group[$i]['Tit_nID']!=$group[$i-1]['Tit_nID']){
					$strHtml .= $this->printTitle($group[$i]['Tit_cNameTH']);
				}
			}
			$arr = null;
			switch ($group[$i]['Tan_nID']) {
				case 1:
					$arr = $cls->getSingleChoice($id,$group[$i]['Tit_nID']);
					$strHtml .= $this->printTable($arr,$i);
					$strJS .= $this->JSRender($imgName,$i,$arr);
					break;
				case 2:
					$arr = $cls->getMultiChoiceHeader($id,$group[$i]['Tit_nID']);
					$strHtml .= $this->printTable($arr,$i);
					$strJS .= $this->JSRender($imgName,$i,$arr);
					for ($a=0; $a < count($arr) ; $a++) { 
						$arr2 = $cls->getMultiChoiceDetail($id,$arr[$a]['Cho_nID']);
						if(count($arr2)){
							$strHtml .= $this->printTable($arr2,$a,$a);
							$strJS .= $this->JSRender($imgName,$a,$arr2,$a);
						}
					}
					break;
				case 3:
					$arr = $cls->getGrading($id,$group[$i]['Tit_nID']);
					$strHtml .= $this->printTable($arr,$i,null,true);
					$strJS .= $this->JSRender($imgName,$i,$arr);
					break;
			}
		}
		$arr = $cls->getGroupDescript($id);
		if(count($arr)){
			$strHtml .= CHtml::openTag('tr');
			$strHtml .= CHtml::openTag('td',array('colspan'=>'6'));
			$strHtml .= "<hr width='100%' size='10'/>";
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::closeTag('tr');
			for ($a = 0; $a < count($arr); $a++ ) { 
				$arr2 = $cls->getDescript($id,$arr[$a]['Tit_nID']);
				if(count($arr2)){
					$strHtml .= $this->printDescribe($arr2,$i++);
				}
			}
		}

		//$strHtml .= CHtml::closeTag('tr');
		$strHtml .= CHtml::closeTag('table');
		$strHtml .= CHtml::closeTag('div');

		$strJS .= "</script>";
		echo $strHtml;
		echo $strJS;
	}
	private function printTitle($title,$member=0){
		$strHtml = "";

		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::tag('td',array('style'=>'height:20px;'));
		$strHtml .= CHtml::closeTag('tr');

		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::openTag('td',array('colspan'=>'3'));
		$strHtml .= CHtml::label($title,'',array('style'=>'background-color:#E5F9F9;border:double;'));
		$strHtml .= CHtml::closeTag('td');
		if($member){
			$strHtml .= CHtml::openTag('td',array('colspan'=>'3','style'=>'background-color:#99CCFE;','align'=>'center'));
			$strHtml .= CHtml::label('จำนวนผู้เข้าอบรม '.'100'.' ท่าน' ,'');
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::closeTag('tr');

			$strHtml .= CHtml::openTag('tr');
			$strHtml .= CHtml::tag('td',array('colspan'=>'3'));
			$strHtml .= CHtml::openTag('td',array('colspan'=>'3','style'=>'background-color:#E5F9F9;','align'=>'center'));
			$strHtml .= CHtml::label('จำนวนผู้ตอบแบบสอบถาม '.$member.' ท่าน' ,'');
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::closeTag('tr');
		}else{
			$strHtml .= CHtml::tag('td',array('colspan'=>'3'));
			$strHtml .= CHtml::closeTag('tr');
			$strHtml .= CHtml::openTag('tr');
			$strHtml .= CHtml::tag('td',array('colspan'=>'3'));
			$strHtml .= CHtml::tag('td',array('colspan'=>'3'));
			$strHtml .= CHtml::closeTag('tr');
		}
		return $strHtml;
	}
	private function printDescribe($model,$count){
		$strHtml = "";
		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::openTag('td',array('colspan'=>'6'));
		$strHtml .= CHtml::label(" ".$count.") ".$model[0]['Text'],'');
		$strHtml .= CHtml::closeTag('td');
		$strHtml .= CHtml::closeTag('tr');
		for ($i=0; $i < count($model) ; $i++) { 
			$strHtml .= CHtml::openTag('tr');
			$strHtml .= CHtml::openTag('td',array('colspan'=>'6'));
			$strHtml .= CHtml::label(" ".($i+1).") ".$model[$i]['Descript'],'',array('style'=>'margin-left:50px;'));
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::closeTag('tr');
		}
		return $strHtml;
	}
	private function printTable($model,$count,$specialCount=null,$flag = false){
		$strHtml = "";
		$sum = 0;

		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::tag('td',array('style'=>'height:20px;'));
		$strHtml .= CHtml::closeTag('tr');

		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::openTag('td',array('colspan'=>'6'));
		if($specialCount!=null)
			$count .= $count."_".$specialCount;
		$strHtml .= CHtml::image('#','#',array('id'=>'imgchart'.$count,'width'=>'900','height'=>'350'));
		$strHtml .= CHtml::openTag('div',array('id'=>'divchart'.$count));
		$strHtml .= CHtml::closeTag('div');
		$strHtml .= CHtml::closeTag('td');
		$strHtml .= CHtml::closeTag('tr');

		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::openTag('td',array('colspan'=>'6','align'=>'center'));

		$strHtml .= CHtml::openTag('table',array('width'=>'60%','border'=>'1','style'=>'border:solid;border-color:#000;margin-top:20px;'));
		$strHtml .= CHtml::openTag('tr');
		$strHtml .= CHtml::openTag('td',array('style'=>'background-color:#2CA8FD;','align'=>'center'));
		$strHtml .= CHtml::label('หัวข้อ','');
		$strHtml .= CHtml::closeTag('td');
		$strHtml .= CHtml::openTag('td',array('style'=>'background-color:#99CCFE;','align'=>'center','width'=>'130px'));
		$strHtml .= CHtml::label('คะแนนแบบสอบถาม','');
		$strHtml .= CHtml::closeTag('td');
		$strHtml .= CHtml::closeTag('tr');
		for ($i=0; $i < count($model) ; $i++) {
			$sum += $model[$i]['Avg'];
			$strHtml .= CHtml::openTag('tr');
			$strHtml .= CHtml::openTag('td',array('style'=>'background-color:#E1E1E1;margin-left:10px;'));
			$strHtml .= CHtml::label($model[$i]['Text'],'');
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::openTag('td',array('style'=>'background-color:#E5F9F9;','align'=>'center'));
			$strHtml .= CHtml::label($model[$i]['Avg'].'%','');
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::closeTag('tr');
		}
		if($flag){
			$strHtml .= CHtml::openTag('tr');
			$strHtml .= CHtml::openTag('td',array('align'=>'center'));
			$strHtml .= CHtml::label('ผลประเมินเฉลี่ย','');
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::openTag('td',array('align'=>'center'));
			$strHtml .= CHtml::label(number_format($sum/count($model), 2, '.', '')."%",'');
			$strHtml .= CHtml::closeTag('td');
			$strHtml .= CHtml::closeTag('tr');
		}

		$strHtml .= CHtml::closeTag('table');

		$strHtml .= CHtml::closeTag('td');
		$strHtml .= CHtml::closeTag('tr');
		return $strHtml;
	}
	private function JSRender($imgName,$count,$model,$specialCount=null){
		if($specialCount!=null)
			$count .= $count."_".$specialCount;
		$strJS = "";
		$strJS .= "google.setOnLoadCallback(drawChart".$count.");";
		$strJS .= "function drawChart".$count."() {
			var arr = new Array();";
		$strJS .= "arr.push(['Element', 'Density', { role: 'style' } ]);";
		for ($i=0; $i < count($model); $i++) { 
			$strJS .= "arr.push(['".$model[$i]['Text']."',".$model[$i]['Avg'];
			if($i&1)
				$strJS .= ",'gold']);";
			else
				$strJS .= ",'silver']);";
		}
		$strJS .= "var data = google.visualization.arrayToDataTable(arr);

		    var view = new google.visualization.DataView(data);
		    view.setColumns([0, 1,
		                       { calc: 'stringify',
		                         sourceColumn: 1,
		                         type: 'string',
		                         role: 'annotation'},
		                       2]);

		    var options = {
		        title: '".$model[0]['Title']."',
		        width: 900,
		        height: 350,
		        bar: {groupWidth: '50%'},
		        legend: { position: 'none' },
		        vAxis: { maxValue : 100 , minValue : 0 , gridlines: { count: 6 } },
		    };
		    var chart = new google.visualization.ColumnChart(document.getElementById('divchart".$count."'));

		    google.visualization.events.addListener(chart, 'ready', function () {
	        $.post('index.php?r=Questionnaire/SaveChart',{
	        		name: '".$imgName."_".$count.$specialCount."',
	        		data: chart.getImageURI(),
	        	},function(result){
	        		$('#imgchart".$count."').attr('src',result);
	        		$('#divchart".$count."').remove();
	        	});
	    	});
		    chart.draw(view, options);
	  	}";
	  	return $strJS;
	}
}
?>