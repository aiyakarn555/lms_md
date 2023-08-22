<?php
$strExcelFileName="ข้อสอบ_บทเรียน_".date("YmdHis").".xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
			<tr>
				<td>คำถาม</td>
				<td>ประเภท</td>
				<?php 
				$num_col = 0;
				foreach ($question as $key => $value) {
					if($num_col < count($value->choices)){
						$num_col = count($value->choices);
					}
				}
				for ($i=1; $i <= $num_col; $i++) {
					?>
					<td>ตัวเลือกที่ <?= $i ?></td>
					<?php
				}
				?>
				<td>อธิบายคำตอบ</td>
			</tr>		
			<?php 			
			foreach ($question as $key => $value_q) {
				?>
				<tr>
					<td><?= $value_q->ques_title; ?></td>
					<?php 
					if($value_q->ques_type == 1){
						$text = "checkbox";
					}elseif($value_q->ques_type == 2){
						$text = "radio";
					}elseif($value_q->ques_type == 3){
						$text = "textarea";
					}elseif($value_q->ques_type == 4){
						$text = "dropdown";
					}elseif($value_q->ques_type == 6){
						$text = "hidden";
					}else{
						$text = $value_q->ques_type;
					}
					?>
					<td><?= $text; ?></td>
					<?php 
					foreach ($value_q->choices as $key => $value_c) {						
						?>
						<td>
							<?php 
							if($value_c->choice_answer == 1){
								echo "*".strip_tags($value_c->choice_detail);
							}else{
								echo strip_tags($value_c->choice_detail);
							}
							?>
						</td>
						<?php
					}
					if($num_col > count($value_q->choices)){
						for ($i=1; $i <= ($num_col-count($value_q->choices)); $i++) {
							?>
							<td></td>
							<?php
						}
					}
					?>
					<td><?= $value_q->ques_explain?></td>
				</tr>
				<?php
			}

			?>	
	</table>
</body>
</html>