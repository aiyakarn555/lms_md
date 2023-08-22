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
<?php
$this->breadcrumbs=array(
	'Chats'=>array('admin'),
	'ดูข้อมูล chat',
);
?>
<div style="float:right;margin:20px;margin-bottom:10px;">
 	<button type="button" id="btnExport" class="btn btn-primary btn-icon glyphicons file"><i></i> Export</button>
</div>
<div style="margin:20px;" class="div-table">
	<table class="table table-bordered">
		<thead>
			<th>ผู้สนทนา</th>
			<th>ข้อความ</th>
			<th>เวลา</th>
		</thead>
		<tbody>
			<?php foreach ($chat as $ch) { ?>
			<tr>
				<td><?php echo $ch->from_rel->profiles->firstname; ?></td>
				<td><?php echo $ch->message; ?></td>
				<td><?php echo date('วันที่ d/m/Y เวลา H:i',$ch->sent); ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<div style="margin:20px;text-align:center;">
	<?php $this->widget('CLinkPager', array(
	    'pages' => $pages,
	)) ?>
	</div>
</div>



<script>
	 $('#btnExport').click(function(e) {
        window.open('data:application/vnd.ms-excel,' + encodeURIComponent( '<h2>ข้อมูลการสนทนา</h2>'+$('.div-table').html()));
        e.preventDefault();
      });
</script>