<?php
class ADetailView extends CDetailView
{
	private $_formatter;
	public $data;
	public $attributes;
	public $nullDisplay;
	public $tagName = 'table';
	public $itemTemplate="<tr class=\"{class}\"><th class='span3'>{label}</th><td colspan=\"{colspan}\">{value}</td></tr>\n";
	public $itemCssClass=array('odd','even');
	public $htmlOptions=array('class'=>'table table-bordered table-striped');
	public $checkTableSup = null;
	public $checkItemShop = null;
	public $checkcolspan = null;

	//Check Question & Check Item Shopping
	public function renderTableSup()
	{
		if(isset($this->checkTableSup))
		{
			$imageCheck = CHtml::image(Yii::app()->request->baseUrl.'/images/check.png', 'ถูก', array('title' => 'ถูก'));
			$imageDelete = CHtml::image(Yii::app()->request->baseUrl.'/images/delete.png', 'ผิด', array('title' => 'ผิด'));
			$dataProvider = new CActiveDataProvider($this->checkTableSup['table'],
					array('criteria'=>array('condition'=>$this->checkTableSup['condition']))
			);
			foreach($dataProvider->getData() as $i=>$result):
			$sum = $i+1;

			if($result->choice_answer == 2)
				echo "<tr class=\"{class}\"><th class='span3'>{$this->checkTableSup['text']} $sum</th><td>".CHtml::decode($result->choice_detail)." $imageDelete</td></tr>\n";
			else
				echo "<tr class=\"{class}\"><th class='span3'>{$this->checkTableSup['text']} $sum</th><td>".CHtml::decode($result->choice_detail)." $imageCheck</td></tr>\n";
			endforeach;
		}

		if(isset($this->checkItemShop))
		{
			$dataProvider = new CActiveDataProvider($this->checkItemShop['table'],array(
				'criteria'=>array(
					'condition'=>$this->checkItemShop['condition'],
					'with'=>array($this->checkItemShop['with']),
				)
			));
			echo "<tr class=\"{class}\"><th class='span3'>Image</th><th class='span8'>รายการ</th><th class='span1'>จำนวน</th><th class='span1'>ราคา</th></tr>\n";
			foreach($dataProvider->getData() as $i=>$result):
			$sum = $i+1;
			$numcount = number_format($result->count);
			$price = number_format($result->price);

			if($this->checkItemShop['with'] == 'shops')
			{
				$imageItem = Controller::ImageShowIndex($result->shops,$result->shops->shop_picture);

				echo "<tr class=\"{class}\"><th class='span3'>$imageItem</th><td>{$result->shops->shop_name}</td><td>{$numcount}</td><td>{$price}</td></tr>\n";			
			}
			else 
			{
				$imageItem = Controller::ImageShowIndex($result->courses,$result->courses->course_picture);

				echo "<tr class=\"{class}\"><th class='span3'>$imageItem</th><td>{$result->courses->course_title}</td><td>{$numcount}</td><td>{$price}</td></tr>\n";
			}

			endforeach;
		}
	}

	public function run()
	{
		echo <<<EOD
<div class="innerLR">
	<div class="widget" style="margin-top: -1px;">
		<div class="widget-head">
				<h4 class="heading glyphicons show_thumbnails_with_lines"><i></i> detail</h4>
		</div>
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

			$tr['{colspan}']=$this->checkcolspan;
			$tr['{value}']=$value===null ? $this->nullDisplay : $formatter->format($value,$attribute['type']);

			$this->renderItem($attribute, $tr);
			$i++;
		}

		$this->renderTableSup();

		if ($this->tagName!==null)
			echo CHtml::closeTag($this->tagName);
	}

}
