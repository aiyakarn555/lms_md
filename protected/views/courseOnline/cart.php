<?php
/* @var $this SiteController */
$this->breadcrumbs=array(
	'หมวดหลักสูตรอบรมออนไลน์'=>array('//cateOnline/index'),
	'สั่งซื้อหลักสูตรอบรมออนไลน์'=>array('index','id'=>Yii::app()->user->getState('getReturn')),
	'รายการสินค้า'
);
?>

<?php if(Yii::app()->user->hasFlash('BuyCart')): ?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<strong><?php echo Yii::app()->user->getFlash('BuyCart'); ?></strong> 
</div>
<?php endif; ?>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th colspan="2">รายการ</th>
			<th>ราคา</th>
			<th>จำนวน</th>
			<th>รวมราคา</th>
			<th>จัดการ</th>
		</tr>
	</thead>
	<tbody>

	<?php $CheckCourse = array_reverse($CheckCourse); ?>
	<?php foreach($CheckCourse as $numCourse=>$cartResult): ?>	

		<tr>
			<td><?php echo $numCourse+1;?></td>
			<td valign="top">
				<?php
				$imageCart = Controller::ImageShowIndex(Yush::SIZE_THUMB,$cartResult,$cartResult->course_picture,array(
					//"style"=>"vertical-align:text-top; width:335px;",
					//"class"=>"thumbnail"
				));
				?>
				<?php echo $imageCart; ?>
			</td>
			<td width="300">
				<?php echo $cartResult->course_title; ?>
			</td>
			<td width="60">
				<span class="sub-price"><?php echo number_format($cartResult->course_price);?> ฿</span>
			</td>
			<td>				
				<?php echo number_format($cartResult->getQuantity()); ?>
			</td>
			<td width="50">
				<?php echo number_format($cartResult->getSumPrice()); ?> ฿			
			</td>
			<td align="center">
				<?php 
				$imageDel = CHtml::image(Yii::app()->request->baseUrl.'/images/icons/trash.gif',$cartResult->course_title);
				echo CHtml::link($imageDel,array('cart','id'=>$cartResult->course_id,'cartdel'=>'del'),array('onclick'=>'if(confirm("ยืนยันการลบหรือไม่ ?")){ return true; }else{ return false;}')); 
				?>
			</td>
		</tr>

	<?php endforeach; ?>

	<?php if($count == 0):?><tr><td colspan="7"><strong>ไม่มีการสั่งซื้อ</strong></td></tr><?php endif; ?>
	<tr>
		<td colspan="7"><strong>ราคารวม <?php echo number_format($cost); ?> บาท</strong> 
		<?php echo CHtml::link("ยืนยันการสั่งซื้อหลักสูตรอบรมออนไลน์",array('Payment'),array('class'=>'btn btn-primary right','onclick'=>'if(confirm("ยืนยันการสั่งซื้อหลักสูตรอบรมออนไลน์หรือไม่ ?")){ return true; }else{ return false;}')); ?>
		</td>
	</tr>
	</tbody>
</table>



	

