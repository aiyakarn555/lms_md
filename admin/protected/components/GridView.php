<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */

class GridView extends CGridView
{
	// Set template of View
	public $template = '{items}{pager}';

	// Set class of table.
	public $itemsCssClass = 'table table-striped table-bordered table-condensed dataTable table-primary';

	// pager css class.
	public $pagerCssClass = 'pagination pull-right';

	// css class of rows 1, 2, 3,..  will be assigned by odd, even, odd, ... respectively.
	public $rowCssClass = array('odd selectable', 'even selectable');

	// set pager css class
	public $pager = array(
	        'class'=>'CLinkPager',
	        'htmlOptions'=>array(
	            'class'=>'',
	            ),
	        'header'=>false,
	        'selectedPageCssClass'=>'active',
	        );

	// clear summary text in header
	public $summaryText = false;

	// set text that will be shown when no data to response.
	public $emptyText = 'No data';

	public $loadProcessing = true;

	// disable default sorting by header link
	//public $enableSorting = false;

	public function init()
	{
		$updateSelector = "#table_".$this->id;
		if($this->loadProcessing)
		{
	    	Yii::app()->clientScript->registerScript('updateSortTalbe', <<<EOD
			$.InitialSortTable = function()
			{
				$('#divLoadingPage').ajaxStart(function() {
					$(this).show();
				});
				$('#divLoadingPage').ajaxStop(function() {
					$(this).hide();
				});
			}
			$.InitialSortTable();
EOD
, CClientScript::POS_READY);
		}
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