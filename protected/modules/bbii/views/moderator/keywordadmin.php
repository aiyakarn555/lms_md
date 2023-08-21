<?php
/* @var $this IpaddressController */
/* @var $model Ipaddress */

$this->bbii_breadcrumbs=array(
	Yii::t('BbiiModule.bbii', 'Forum')=>array('forum/index'),
	Yii::t('BbiiModule.bbii', 'Blocked Keyword'),
);

$approvals = BbiiPost::model()->unapproved()->count();
$reports = BbiiMessage::model()->report()->count();

$item = array(
	array('label'=>Yii::t('BbiiModule.bbii', 'เว็บบอร์ด'), 'url'=>array('forum/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'สมาชิก'), 'url'=>array('member/index'), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'การอนุมัติ'). ' (' . $approvals . ')', 'url'=>array('moderator/approval'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'รายงาน'). ' (' . $reports . ')', 'url'=>array('moderator/report'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'โพส'), 'url'=>array('moderator/admin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'กรองคำหยาบ'), 'url'=>array('moderator/keywordadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ไอพีที่ถูกบล็อค'), 'url'=>array('moderator/ipadmin'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
	array('label'=>Yii::t('BbiiModule.bbii', 'ส่งเมล'), 'url'=>array('moderator/sendmail'), 'visible'=>$this->isModerator(), 'linkOptions'=>array('class'=>'btn btn-primary')),
);
?>
<style>
	.grid-view{
		padding: 0 !important;
	}
</style>
<div class="parallax bg-white page-section">
	<div class="container parallax-layer" data-opacity="true">
		<div class="media v-middle">
			<div class="media-body">
				<h1 class="text-display-2 margin-none">เว็บบอร์ด</h1>
				<p class="text-light lead">เว็บบอร์ดของหลักสูตร</p>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="page-section">
		<div class="row">
			<div class="col-md-12" style="padding-bottom: 15px;">

				<?php echo $this->renderPartial('_header', array('item'=>$item)); ?>

			</div>
			<div class="col-md-8 col-lg-9" style="padding-bottom:10px;">
				<a id="add-keyword" class="btn btn-primary" data-toggle="modal" data-target="#myModal">เพิ่มคำกรอง</a>
			</div>
			<div class="col-md-8 col-lg-9">

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'ipaddress-grid',
		'dataProvider'=>$model->search(),
		'template' => '{items}{pager}',
		'htmlOptions'=>array(
			'class'=>'panel panel-default',
		),
		'itemsCssClass'=>'table v-middle',
		'columns'=>array(
			'keyword',
			array(
				'header'=>'Action',
				'class'=>'CButtonColumn',
				'template'=>'{delete}',
				'buttons' => array(
					'delete' => array(
						'url'=>'array("moderator/keywordDelete", "id"=>$data->id)',
						'imageUrl'=>$this->module->getRegisteredImage('delete.png'),
						'options'=>array('style'=>'margin-left:5px;'),
					),
				)
			),
		),
	)); ?>
				<br/>
			</div>




			<?php
			//right Menu
			echo $this->renderPartial('_right'); ?>


		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">เพิ่มคำกรอง</h4>
      </div>
      <div class="modal-body">
        <form id="keyword-form">
        	<div class="form-group">
	        	<label for="keyword" class="control-label">Keyword:</label>
	            <input type="text" class="form-control" id="keyword">
	        </div>
        </form>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" id="btn-save">บันทึก</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(function(){
		$('#btn-save').click(function(event){
			event.preventDefault();
			var keyword = $('#keyword').val();
			$.post('<?php echo $this->createUrl("keywordadd"); ?>',{keyword:keyword},function(data){
				var obj = $.parseJSON(data);
				if(obj.status == "error"){
					alert('เกิดข้อผิดพลาด กรุณราลองใหม่อีกครั้ง');
				}else{
					$('#keyword').val('');
					$.fn.yiiGridView.update('ipaddress-grid');
					$('#myModal').modal('hide');
				}
			});
		});
	});
</script>