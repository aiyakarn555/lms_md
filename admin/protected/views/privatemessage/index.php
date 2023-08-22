<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> -->
<div class="innerLR">
	<div class="widget widget-tabs border-bottom-none">
		<div class="widget-head">
			<ul>
				<li class="active">
					<a class="glyphicons edit" href="#account-details" data-toggle="tab">
						<i></i>ระบบข้อความส่วนตัว
					</a>
				</li>
			</ul>
		</div>
		<div class="widget-body">
			<?php
				$this->breadcrumbs=array(
				    'ระบบข้อความส่วนตัว'
				);
				$this->widget('AGridView', array(
				'id'=>$formNameModel.'-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns'=>array(	
					array(
                        'header'=>'No.',
                        'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                        
                   ),	///แสดงลำดับตัวเลย		
					array(
						'header'=>'หัวข้อ',
                        'value'=>function($data){
							return $data->pm_topic;
						}
				    ),//หัวข้อ
					array(
                    'header' => 'ผู้ส่ง',
                    'type'=>'raw',
                    'value'=>function($val) {
                    	if($val->create_by){
								$model = Profiles::model()->find(array('condition'=> 'user_id = '.$val->create_by));
								return $title." ".$model->firstname.' '.$model->lastname;
							}
						},	
                    ),//ผู้ส่ง
                    array(
                    'header' => 'ผู้รับ',
                    'type'=>'raw',
                    'value' => function($val) {
                    	if($val->pm_to){
                                $AdminUser = Profiles::model()->find(array('condition' => 'user_id ='. $val->pm_to));
								return $title." ".$AdminUser->firstname.' '.$AdminUser->lastname;
							}
						},
                    ),
                    array(
                    'header' => 'วันที่',
                    'type'=>'raw',
                    'value' => function($val) {
                    	return !empty($val->msgReturn[sizeof($val->msgReturn)-1]->create_date) ? Helpers::lib()->changeFormatDate($val->msgReturn[sizeof($val->msgReturn)-1]->create_date) : Helpers::lib()->changeFormatDate($val->create_date); //;
                    },
                    ),
					array(
					'header'=>'จัดการ',
					'value'=>function($data){
						$count_return = PrivateMessageReturn::model()->findall(array(
											'condition' =>'status_answer = 0 and pm_id='.$data->pm_id));
						$count_mrt = count($count_return);
						return '<a class="btn btn-info btn-icon" href = " ' . $this->createUrl('privatemessage/view?id='.$data->pm_id).' ">
			               ตอบคำถาม <span class="badge">'. $count_mrt .'</span></a>';
			           },
					'type'=>'raw',
					'htmlOptions'=>array('width'=>'100px'),
					),//จัดการ
				),
			)); ?>
		</div>
	</div>
</div>
<style>
	.circleBase {
    border-radius: 50%;
    behavior: url(PIE.htc); /* remove if you don't care about IE8 */
}
.type3 {
   width: 4px;
    height: 4px;
    background: #ffffff;
    border: 10px solid #ffffff;
}
.num-icon{
	color: #5bc0de;
    margin-top: -7px;
    margin-left: -2px;
}
</style>


