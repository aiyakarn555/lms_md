<style>
.generalform {
	padding: 20px;
	margin-bottom: 30px;
-webkit-box-shadow: 1px 1px 4px 0px rgba(50, 50, 50, 0.55);
-moz-box-shadow:    1px 1px 4px 0px rgba(50, 50, 50, 0.55);
box-shadow:         1px 1px 4px 0px rgba(50, 50, 50, 0.55);
}
.generalform p {
	margin-bottom: 10px !important;
}
.generalform table td, .generalform table th {
	border: 1px solid #ccc;
	padding: 5px;
}
</style>


<div class="widget" data-toggle="collapse-widget" data-collapse-closed="false">
				<div class="widget-head">
					<h4 class="heading glyphicons pie_chart"><i></i>FormDynamic</h4>
				<span class="collapse-toggle"></span></div>
				<div class="widget-body in collapse" style="height: auto;">		


<div class="container generalform">
    <div class="row">
    	<?php $linehr='<hr style="width:95%;margin:auto">'; ?>
    	<div><?php echo $model->fs_title;echo $linehr; ?></div>
    	<br/>
    	<?php $lastid=1; ?>
    	<?php $countall=count($model->FormSurveyHeader); ?>
    	<?php foreach ($model->FormSurveyHeader as $key => $value): ?>
    		
    		<div><h4><?php echo $value->fsh_title ?></h4>
    		<p>
   				<?php 
    				if($value->fsh_type=="checkbox"){
    					$i = 0;
    					?>
    					<div class="row" style="margin:auto">

	    					<?php
	    					foreach ($value->FormSurveyList as $key => $valuelist) {

				                    if ($i%2=="0")
				                    {
				                   	?>
				                    	<div class="span5">
											<p>
												<label class="checkbox-inline">
												  <input type="checkbox" id="inlineCheckbox1" value="<?php echo $valuelist->fsl_id; ?>"> <?php echo $valuelist->fsl_value; ?>
												</label>
											</p>
										</div>
				                  <?php
				                    }
				                    else
				                    {
				                    ?>
				                    	<span>
											<p>
												<label class="checkbox-inline">
												  <input type="checkbox" id="inlineCheckbox1" value="<?php echo $valuelist->fsl_id; ?>"> <?php echo $valuelist->fsl_value; ?>
												</label>
											</p>
										</span>
				                    <?php
				                    }
    						}
    						?>
    					</div>
    					<?php
    					echo $linehr;
    				}
    				else if($value->fsh_type=="radio"){
    					$i = 0;
    					?>
    					<div class="row" style="margin:auto">
	    					<?php
	    					foreach ($value->FormSurveyList as $key => $valuelist) {

				                    if ($i%2=="0")
				                    {
				                   	?>
				                    	<div class="span5">
											<p>
												<label class="radio-inline">
												  <input type="radio" name="inlineRadioOptions" id="inlineRadio-<?php echo $valuelist->fsl_id; ?>" value="<?php echo $valuelist->fsl_id; ?>"> <?php echo $valuelist->fsl_value; ?>
												</label>
											</p>
										</div>
				                  <?php
				                    }
				                    else
				                    {
				                    ?>
				                    	<span>
											<p>
												<label class="radio-inline">
												 	<input type="radio" name="inlineRadioOptions" id="inlineRadio-<?php echo $valuelist->fsl_id; ?>" value="<?php echo $valuelist->fsl_id; ?>"> <?php echo $valuelist->fsl_value; ?>
												</label>
											</p>
										</span>
				                    <?php
				                    }
    						}
    						?>
    					</div>
    					<?php
    					echo $linehr;
    				}
    				else if($value->fsh_type=="tablescore"){
    					?>
    					<table border="1" style="width:100%">
						    <tbody><tr>
						        <td rowspan="2" align="center"> <b>รายการ</b>
						        </td>
						        <td colspan="5" align="center"> <b>ระดับความพึงพอใจ</b>
						        </td>
						    </tr>

							    <tr>
							        <td align="center"><b>น้อยที่สุด (1)</b></td>
							        <td align="center"><b>น้อย (2)</b></td>
							        <td align="center"><b>ปานกลาง (3)</b></td>
							        <td align="center"><b>มาก (4)</b></td>
							        <td align="center"><b>มากที่สุด (5)</b></td>
							    </tr>
							    <?php 
							    $idx = 1;
							    foreach ($value->FormSurveyList as $key => $valuelist) { 
							    ?>
							    <tr>
							        <td><?php echo $idx++.". ".$valuelist->fsl_value; ?></td>
							        <td align="center"><input type="radio" name="choice[<?php echo $valuelist->fsl_id; ?>]" value="1"></td>
							        <td align="center"><input type="radio" name="choice[<?php echo $valuelist->fsl_id; ?>]" value="2"></td>
							        <td align="center"><input type="radio" name="choice[<?php echo $valuelist->fsl_id; ?>]" value="3"></td>
							        <td align="center"><input type="radio" name="choice[<?php echo $valuelist->fsl_id; ?>]" value="4"></td>
							        <td align="center"><input type="radio" name="choice[<?php echo $valuelist->fsl_id; ?>]" value="5"></td>
							    </tr>
							    <?php } ?>
							</tbody>
						</table>
    					<?php

    				}
    				else if($value->fsh_type=="textField"){
    				?>
    					<input type="text" name="textField">
    				<?php
    					echo $linehr;
    				}
    				else if($value->fsh_type=="textArea"){
    				?>
    					<textarea></textarea>
    				<?php
    					//echo $linehr;
    				}
    				else
    				{
    					//echo "ไม่ได้เลือก type";
    				}



    			 ?>
    			 </p>
    			 </div>
    	<?php 
    	// if($lastid!=$countall){

    	// }
$lastid++;
    	?>
    	<br/>

    	<?php endforeach; ?>

	</div>
</div>
 	</div>
</div>