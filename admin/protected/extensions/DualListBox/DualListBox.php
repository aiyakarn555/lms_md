<?php
/*
 * DualListBox widget class file.
* @author Chandran Nepolean <chandrantwins@gmail.com>
* @link http://www.testunity.com
* Copyright (c) 2015 Chandran Nepolean
* MADE IN INDIA

* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:

* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.

* DualListBox extends CInputWidget and implements a base class for a DualListBox jQuery plugin.
* more about DualListBox can be found at https://github.com/Geodan/DualListBox
* @version: 1.0
*/
class DualListBox extends CInputWidget
{
	public $nametitle;
	public $title;
	public $lngOptions;
	public $attributes;
	public $selecteddata;
	public $data;
	public $data_id;
	public $data_value;

	public function init()
	{
		parent::init();
		$this->data_id = isset($this->data_id) ? $this->data_id : 'id';
		$this->data_value = isset($this->data_value) ? $this->data_value : 'name';
		$this->nametitle = isset($this->nametitle) ? $this->nametitle : '';
		$this->publishAssets();
		echo CHtml::activeTextField($this->model, $this->attribute, array('class' => 'hidden', 'value' => $this->value));
	}

	public function run()
	{
		list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		$model = $this->model;
		$inputId = $this->attribute;
		$selected = ($this->selecteddata) ? CHtml::listData($this->selecteddata, "user_id", $this->data_value) : array();
		$idModel = strtolower(get_class($this->model));
		$this->attributes = $this->model->attributes;
		$data = ($this->data) ? CJSON::decode(CJSON::encode($this->data, $this->data_id, $this->data_value)) : array();
		echo '<div id="'.$inputId.'" >';
		$ret_sel = '';
		$ret = '<select style="display: none;" multiple = "multiple">';
		$cnt = 0;
		foreach ($data as $key => $value) {
			print_r($value[$this->data_id]);
			if (!in_array($value[$this->data_id], array_keys($selected))) {
				$ret .= '<option value="' . $value[$this->data_id] . '">' . $value[$this->data_value] . '</option>' . "\n";
			} else {
				$cnt++;
				$ret_sel .= '$("#dual-list-box-'.$this->nametitle.' .selected").
                append("<option value=' . $value[$this->data_id] . '>' . $value[$this->data_value] . '</option>");';
			}
		}
		$ret .= '</select>';

		$lng_opt = new CJSON();
		$lng_opt->warning_info = 'Are you sure you want to move this many items?
        Doing so can cause your browser to become unresponsive.';
		$lng_opt->search_placeholder = 'Filter';
		$lng_opt->showing = '- showing';
		$lng_opt->available = 'Available';
		$lng_opt->selected = 'Selected';
		foreach($lng_opt as $key=>$value) {
			$lng_opt->$key = isset($this->lngOptions[$key]) ? $this->lngOptions[$key] : $value;
		}
		$options = 'lngOptions: '. json_encode($lng_opt);
		Yii::app()->clientScript->registerScript($id,"
 			$('#$inputId').DualListBox({
                json: false,
                name: '$idModel',
                id: '$inputId',
                title: '$this->nametitle',
                $options
            });
            $ret_sel
            $('#dual-list-box-$this->nametitle .selected-count').text('$cnt');
            if($cnt != 0)
            	$('#dual-list-box-$this->nametitle .atl').prop('disabled', false);
		");

		echo $ret.'</div>';
	}

	protected static function publishAssets()
	{
		$assets_dual=dirname(__FILE__).'/assets_dual';
		$baseUrl=Yii::app()->assetManager->publish($assets_dual);
		if(is_dir($assets_dual)){
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerScriptFile($baseUrl.'/dual-list-box.js',CClientScript::POS_HEAD);
		} else {
			throw new Exception('DualListBox - Error: Couldn\'t find assets_dual to publish.');
		}
	}
}