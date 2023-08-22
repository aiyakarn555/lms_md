<?php
class AdvanceSearchForm extends CDetailView
{
	public $itemTemplate = "<div class='row'><label>{label}</label>{value}</div>";
	public $data;
	public $route;
	public $searchForm;

	public function run()
	{
		echo <<<EOD
		<div class="widget" data-toggle="collapse-widget" data-collapse-closed="true">
			<div class="widget-head">
				<h4 class="heading  glyphicons search"><i></i>search</h4>
			</div>
			<div class="widget-body collapse of-out">
				<div class="search-form">
					<div class="wide form" style="padding-top:6px;">
EOD;

			$form=$this->beginWidget('CActiveForm', array(
				'action'=>Yii::app()->createUrl($this->route),
				'method'=>'get',
				'id'=>'SearchFormAjax',
			)); 
			$this->_searchForm($form);
			echo '<div class="row">';
			echo CHtml::tag('button',array('class' => 'btn btn-primary mt-10 btn-icon glyphicons search'),'<i></i> search');
			echo '</div>';
			$this->endWidget(); 
		echo <<<EOD
					</div>
				</div>
			</div>
		</div>
EOD;
	}

	protected function renderItem($options,$templateData)
	{
	    echo strtr(isset($options['template']) ? $options['template'] : $this->itemTemplate,$templateData);
	}

	protected function _searchForm($form)
	{
	    $i=0;
	    $n=is_array($this->itemCssClass) ? count($this->itemCssClass) : 0;

	    foreach($this->attributes as $attribute)
	    {
	        if(is_string($attribute))
	        {
	            if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$attribute,$matches))
	                throw new CException(Yii::t('zii','The attribute must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
	            $attribute=array(
	                'name'=>$matches[1],
	                'type'=>isset($matches[3]) ? $matches[3] : 'text',
	            );
	            if(isset($matches[5]))
	                $attribute['label']=$matches[5];
	        }

	        if(isset($attribute['visible']) && !$attribute['visible'])
	            continue;

	        $tr=array('{label}'=>'', '{class}'=>$n ? $this->itemCssClass[$i%$n] : '');
	        if(isset($attribute['cssClass']))
	            $tr['{class}']=$attribute['cssClass'].' '.($n ? $tr['{class}'] : '');

	        if(isset($attribute['label']))
	            $tr['{label}']=$attribute['label'];
	        elseif(isset($attribute['name']))
	        {
	            if($this->data instanceof CModel)
	                $tr['{label}']=$this->data->getAttributeLabel($attribute['name']);
	            else
	                $tr['{label}']=ucwords(trim(strtolower(str_replace(array('-','_','.'),' ',preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $attribute['name'])))));
	        }

	        if(!isset($attribute['type']))
	            $attribute['type']='text';
	        if(isset($attribute['value']))
	            $value=$attribute['value'];
	        elseif(isset($attribute['name']))
	            $value=CHtml::value($this->data,$attribute['name']);
	        else
	            $value=null;

	        if($attribute['type'] == 'text')
	        {
		        $tr['{value}'] = $form->textField($this->data,$attribute['name'],array(
		        	'class'=>'span6','autocomplete'=>'off','placeholder' => $attribute['placeholder']
		        ));
	        }else if($attribute['type'] == 'textArea' or $attribute['type'] == 'textarea')
	        {
		        $tr['{value}'] = $form->textArea($this->data,$attribute['name'],array(
			        	'class'=>'span6'
			        ));
	        }else if($attribute['type'] == 'list'){
	        	if(isset($attribute['query']))
				$tr['{value}'] =  $form->DropDownList($this->data,$attribute['name'],$attribute['query'] , array(
					'empty'=>'ทั้งหมด',
					'class'=>'span6 chosen'
				));
	        }else if($attribute['type'] == 'listChoose'){
	        	if(isset($attribute['query']))
				$tr['{value}'] =  $form->DropDownList($this->data,$attribute['name'],$attribute['query'] , array(
					'empty'=>'กรุณาเลือก',
					'class'=>'span6'
				));
			}else if($attribute['type'] == 'listMultiple'){
	        	if(isset($attribute['query']))
				$tr['{value}'] =  $form->DropDownList($this->data,$attribute['name'],$attribute['query'] , array(
					'empty'=>'กรุณาเลือก',
					'class'=>'chosen span6',
					'multiple'=>'multiple chosen'
				));
	        }else if($attribute['type'] == 'date'){
	        	echo '<div class="row">';
	        	echo '<label>'.$attribute['titleDate'].'</label>';
			    $tr[''] = $this->widget('zii.widgets.jui.CJuiDatepicker', array(
				               'model'=>$this->data,
				               'attribute'=>$attribute['name'],
				               'htmlOptions' => array(
				                   'class' => 'span6',
				               ),  
				               'options' => array(
				                	'mode'=>'focus',
				                	'dateFormat'=>'dd/mm/yy',
				                   	'showAnim' => 'slideDown',
				            	   	'showOn' => 'focus', 
				            	   	'showOtherMonths' => true,
				            		'selectOtherMonths' => true,
				                   	'yearRange' => '-5:+2', 
				            		'changeMonth' => true,
				            		'changeYear' => true,
				                   	'dayNamesMin' => array('อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'),
				                   	'monthNamesShort' => array('ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.',
				                    'ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'),
				              )
				));
			    echo '</div>';
	        }else{
	        	$tr['{value}'] = $form->textField($this->data,$attribute['name'],array(
		        	'class'=>'span6'
		        ));
	        }

	        $this->renderItem($attribute, $tr);

	        $i++;
	    }

	}



}

?>
