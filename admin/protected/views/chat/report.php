<?php 
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Chat.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
 ?>

<style>
table {
    width:80%;
    border:1px;
    solid:#ddd;
    margin:auto;
	
}
thead{
	background-color:#128ef2;
	color:#fff;
}
th{
	width:20%;
}
</style>
<div>
	<div  id='dvData'  style='margin-left:50px;margin-right:50px;'>
		<meta http-equiv=Content-Type content="text/html; charset=utf-8">
		<table>
		<?php
	 	$dataProvider->pagination->pageSize=$dataProvider->totalItemCount;
		$this->widget('zii.widgets.CListView', array(
		    'dataProvider'=>$model,
		    // 'template'=>"{items}<br/><br/><br/>{pager}",
		    'template'=>"<div>
		
			<table class='items table table-striped table-bordered table-condensed'>
				<thead>
					<th style='text-align:center;'>ผู้ส่ง / เวลาส่ง</th>
					<th style='text-align:center;'>ข้อความ</th>
				</thead>
				{items}
			</table>
			
		    </div>
		    <div style='margin-left:50px;margin-right:50px;'>{pager}</div>",
		    'itemView'=>'_view',
		)); ?>
		<!-- </table> -->
		</table>
		
	</div>
</div>