<script src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/dist/js/jquery-sortable.js" type="text/javascript"></script>
<?php
$titleName = 'ชื่อบทเรียน: '.$lesson->lesson_name;
$this->headerText = $titleName;
$formNameModel = 'File';

$this->breadcrumbs=array(
	'จัดการบทเรียน'=>array('lesson/index'),
	'จัดอันดับวิดีโอ',
);

$getUrl = Yii::app()->request->getBaseUrl(true);

Yii::app()->clientScript->registerScript('updateGridView', <<<EOD
	$.updateGridView = function(gridID, name, value) {
	    $("#"+gridID+" input[name*="+name+"], #"+gridID+" select[name*="+name+"]").val(value);
	    $.fn.yiiGridView.update(gridID, {data: $.param(
	        $("#"+gridID+" input, #"+gridID+" .filters select")
	    )});
	}
	$.appendFilter = function(name, varName) {
	    var val = eval("$."+varName);
	    $("#$formNameModel-grid").append('<input type="hidden" name="'+name+'" value="">');
	}
	$.appendFilter("File[news_per_page]", "news_per_page");

	$(".js-table-sortable > tbody > tr > td > div > div").each(function(index,element){
		var playerInstance = jwplayer(this.id).setup({
			abouttext: "E-learning",
			file: "$getUrl/../uploads/lesson/"+$(this).attr("vdo"),
			width: 220,
			height: 150
		});
		playerInstance.onReady(function() {
			if(typeof $("#"+this.id).find("button").attr("onclick") == "undefined"){
				$("#"+this.id).find("button").attr("onclick","return false");
			}
			playerInstance.onPlay(function(callback) {
			    console.log(callback);
			});
		});
	});
	$(function  () {
		var group = $("ol.serialization").sortable({
	 	group: 'serialization',
	  	delay: 500,
	  	onDrop: function (item, container, _super) {
	    	var data = group.sortable("serialize").get();
	    	var jsonString = JSON.stringify(data, null, ' ');
	    	$('#serialize_output2').text(jsonString);
	    	_super(item, container);
	    	$.post("$getUrl/lesson/priorityVdo",{text:jsonString},function(data){
		    });
	  	}
		});
	});

EOD
, CClientScript::POS_READY);
?>
<style>
	body.dragging, body.dragging * {
  cursor: move !important;
}

.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}

ol.vertical li {
    display: block;
    margin: 5px;
    padding: 5px;
    border: 1px solid #cccccc;
    color: #0088cc;
    background: #eeeeee;
}
</style>
<script>
function editName(filedoc_id){

    var name = $('#filenamedoc'+filedoc_id).val();
    
    $.get("<?php echo $this->createUrl('lesson/editNameVdo'); ?>",{id:filedoc_id,name:name},function(data){
        $('#filenamedoc'+filedoc_id).hide();
        $('#filenamedoctext'+filedoc_id).text(name);
        $('#filenamedoctext'+filedoc_id).show();
        $('#btnEditName'+filedoc_id).show();
    });

}
</script>
<div class="col-md-4">
	<div class="box">
		<div style="text-align: center; margin-top: 10px;"><label for="">กำหนดลำดับชั้นวิดีโอ</label></div>
		<div class="box-body">
			<ol class="serialization vertical">
				<!-- <li data-id="0" data-name="Item 1" class="">
					Item 1<ol></ol>
				</li> -->
			</ol>
		</div>
	</div>
</div>

<?php
$lessonList = LessonList::model()->with('files')->findByPk($id);
?>
<div class="col-md-4">
	<div class="box">
		<div style="text-align: center; margin-top: 10px;"><label for="">วิดีโอทั้งหมด</label></div>
		<div class="box-body">
			<ol class="serialization vertical">
			<?php
			foreach ($lessonList->files as $key => $value) {
			?>
				<li data-id="<?php echo $value->id ?>" data-name="<?php echo $value->RefileName ?>">
					<?php echo '<strong id="filenamedoctext'.$value->id.'">'.$value->RefileName.'</strong>'; ?>
					<?php echo '<input id="filenamedoc'.$value->id.'" type="text" value="'.$value->file_name.'" style="display:none;" onblur="editName('.$value->id.');">'; ?>
                	<?php echo CHtml::link('<i></i>','', array('title'=>'แก้ไขชื่อ','id'=>'btnEditName'.$value->id,'class'=>'btn-action fa fa-pencil-square-o btn-danger','style'=>'z-index:1; background-color:black; cursor:pointer;','onclick'=>'$("#filenamedoctext'.$value->id.'").hide(); $("#filenamedoc'.$value->id.'").show(); $("#filenamedoc'.$value->id.'").focus(); $("#btnEditName'.$value->id.'").hide(); ')); ?>
                	<ol></ol>
				</li>
			<?php
			}
			?>
			</ol>
		</div>
	</div>
</div>

<div class="col-md-4">
	<pre id="serialize_output2"></pre>
</div>