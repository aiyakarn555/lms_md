<?php
class ADetailView extends CDetailView
{
	private $_formatter;
	public $data;
	public $attributes;
	public $nullDisplay;
	public $tagName = 'table';
	public $itemTemplate="<thead><tr class=\"{class}\"><th class='span3' style='vertical-align:top;'>{label}</th><td bgcolor='#FAFAFA' colspan='3'>{value}</td></tr></thead>\n";
	public $itemCssClass=array('odd','even');
	public $htmlOptions=array('class'=>'table table-bordered table-striped');
	public $checkTableSup = null;

	public function renderTableSup()
	{
		if(isset($this->checkTableSup))
		{
			$dataProvider = new CActiveDataProvider($this->checkTableSup['table'],array(
				'criteria'=>array(
					'condition'=>$this->checkTableSup['condition'],
					'with'=>array($this->checkTableSup['with']),
				)
			));
			echo "<thead><tr class=\"{class}\"><th class='span3'>รูปภาพ</th><th class='span8'>รายการ</th><th class='span1'>จำนวน</th><th class='span1'>ราคา</th></tr></thead>\n";
			foreach($dataProvider->getData() as $i=>$result):
			$sum = $i+1;
			$numcount = number_format($result->count);
			$price = number_format($result->price);
			if($this->checkTableSup['with'] == 'shops')
			{
				$imageItem = Controller::ImageShowIndex(Yush::SIZE_THUMB,$result->shops,$result->shops->shop_picture,array(
				    //"class"=>"thumbnail","style"=>"width:130px"
				));
				echo "<tr class=\"{class}\"><th class='span3'>{$imageItem}</th><td>{$result->shops->shop_name}</td><td>{$numcount}</td><td>{$price}</td></tr>\n";			
			}
			else if($this->checkTableSup['with'] == 'courseOnline')
			{
				$imageItem = Controller::ImageShowIndex(Yush::SIZE_THUMB,$result->courseOnline,$result->courseOnline->course_picture,array(
				    //"class"=>"thumbnail","style"=>"width:130px"
				));
				echo "<tr class=\"{class}\"><th class='span3'>$imageItem</th><td>{$result->courseOnline->course_title}</td><td>{$numcount}</td><td>{$price}</td></tr>\n";
			}
			else 
			{
				$imageItem = Controller::ImageShowIndex(Yush::SIZE_THUMB,$result->courses,$result->courses->course_picture,array(
				    //"class"=>"thumbnail","style"=>"width:130px"
				));
				echo "<tr class=\"{class}\"><th class='span3'>$imageItem</th><td>{$result->courses->course_title}</td><td>{$numcount}</td><td>{$price}</td></tr>\n";
			}

			endforeach;
		}
		else
			return false;
	}

	public function run()
	{
		echo <<<EOD
<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-body">
EOD;
			$this->_DetailViewAll();	
		echo <<<EOD
		</div>
	</div>
</div>
EOD;
	}

	protected function renderItem($options,$templateData)
	{
		echo strtr(isset($options['template']) ? $options['template'] : $this->itemTemplate,$templateData);
	}

	public function _DetailViewAll()
	{
		$formatter=$this->getFormatter();
		if ($this->tagName!==null)
			echo CHtml::openTag($this->tagName,$this->htmlOptions);

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

			$tr['{value}']=$value===null ? $this->nullDisplay : $formatter->format($value,$attribute['type']);

			$this->renderItem($attribute, $tr);
			$i++;
		}

		$this->renderTableSup();

		if ($this->tagName!==null)
			echo CHtml::closeTag($this->tagName);
	}

}
