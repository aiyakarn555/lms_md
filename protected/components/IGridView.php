<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class IGridView extends CGridView
{
	// Set class of table.
	public $itemsCssClass = 'table-striped table-bordered table table-hover';
	
	// pager css class. 
	public $pagerCssClass = 'pagination';

	// css class of rows 1, 2, 3,..  will be assigned by odd, even, odd, ... respectively.
	public $rowCssClass = array('odd', 'even');

	// set pager css class
	public $pager = array(
			'maxButtonCount'=>'11',
			'class'=>'CLinkPager',
			'htmlOptions'=>array(
				'class'=>'',
			),
			'firstPageLabel'=>'<< หน้าแรก',
			'prevPageLabel'=>'< ย้อนกลับ',
			'nextPageLabel'=>'ถัดไป >',        
			'lastPageLabel'=>'หน้าสุดท้าย >>',
			'header'=>false,
			'selectedPageCssClass'=>'active',
	        );

	// clear summary text in header
	public $summaryText = 'ข้อมูลทั้งหมดมี {count} รายการ';

	// set text that will be shown when no data to response.
	public $emptyText = 'ยังไม่มีข้อมูล';

	// disable default sorting by header link
	//public $enableSorting = false;

	public function init()
	{
		$updateSelector = "#table_".$this->id;
	    parent::init();
	}


	/** Overiding initColumns function for change default DataColumn Class 
	 * 	from CDataColumn to ADataColumn (our DataColumn).
	 */
	protected function initColumns()
	{
		foreach($this->columns as $i=>$column)
    	{
    		if(!is_string($column) && !isset($column['class']))
                $this->columns[$i]['class']='ADataColumn';
    	}
		parent::initColumns();	
	}

	// Overiding createDataColumn function for use our DataColumn Class.
	protected function createDataColumn($text)
	{
	    if(!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/',$text,$matches))
	        throw new CException(Yii::t('zii','The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'));
	    // Change DataColumn Class
	    $column=new ADataColumn($this);
	    $column->name=$matches[1];
	    if(isset($matches[3]) && $matches[3]!=='')
	        $column->type=$matches[3];
	    if(isset($matches[5]))
	        $column->header=$matches[5];
	    return $column;
	}

	public function renderFilter()
	{
	    if($this->filter!==null)
	    {
	        echo "<tr class=\"{$this->filterCssClass}\">\n";
	        foreach($this->columns as $column)
	            $column->renderFilterCell();
	        echo "</tr>\n";
	    }
	}
}
?>