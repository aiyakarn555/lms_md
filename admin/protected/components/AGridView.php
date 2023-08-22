<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
Yii::import('zii.widgets.grid.*');
class AGridView extends CGridView
{
	// Set template of View
	public $template = '{items}{pager}';

	// Set class of table.
	public $itemsCssClass = 'table table-striped table-bordered table-condensed dataTable table-primary js-table-sortable';

	// pager css class.
	public $pagerCssClass = 'pagination pull-right';

	// css class of rows 1, 2, 3,..  will be assigned by odd, even, odd, ... respectively.
	public $rowCssClass = array('odd selectable', 'even selectable');

	// set pager css class
	public $pager = array(
	        'class'=>'CLinkPager',
	        'htmlOptions'=>array('class'=>''),
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
		if($this->loadProcessing)
		{
			$seq_path = $this->controller->createUrl('Sequence');
	    	Yii::app()->clientScript->registerScript('updateSortTalbe', <<<EOD
	    	function InitialSortTable()
	    	{
	    		var rowCount = $(".js-table-sortable > thead > tr > th").length;
	    	
				$('#divLoadingPage').ajaxStart(function() {
					$(this).show();
				});
				$('#divLoadingPage').ajaxStop(function() {
					$(this).hide();
				});

				$("a[rel^='prettyPhoto']").prettyPhoto({
					social_tools: false,
					animationSpeed: 'normal', /* ลักษณะการแสดงแอนิเมชั่น fast/slow/normal */
					padding: 40, /* กำหนดระยะห่างระหว่างรูปภาพกับตัวบ้อก */
					opacity: 0.35, /* กำหนดค่าความโปร่งแสง  0 - 1 */
					showTitle: true, /* กำหนดให้แสดง title หรือไม่ true/false */
					allowresize: true, /* อนุญาติให้ยูสเซ่อร์ย่อหรือขยายหรือไม่ true/false */
					counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
					theme: 'light_rounded' /* ธีม light_rounded / dark_rounded / light_square / dark_square */
				});
				
			    $('.js-table-sortable').sortable({
					placeholder: 'ui-state-highlight',
				    'start': function (event, ui) 
				    {
				        ui.placeholder.html("<td colspan='"+rowCount+"'></td>")
				    },
					items: 'tbody tr',
					handle: '.row_move',
					forcePlaceholderSize: true,
			        update : function (event, ui) 
			        {

			            serial = $('.js-table-sortable').sortable('serialize', {key: 'items[]', attribute: 'class'});
					    bootbox.confirm('ยืนยันการย้ายตำแหน่งหรือไม่ ?', function(result) 
						{
							if (result){
					            $.ajax({
					                'url': '$seq_path',
					                'type': 'post',
					                'data': serial,
					                'success': function(data)
					                {
					                	jQuery('#$this->id').yiiGridView('update');
					                	notyfy({dismissQueue: false,text: 'ย้ายตำแหน่งเรียบร้อย',type: 'success'});	
					                },
					                'error': function(request, status, error)
					                {
					                    notyfy({dismissQueue: false,text: 'เกิดข้อผิดพลาด',type: 'error'});	
					                }
					            });
				       		 }
						});
						return false;
			        },
			        helper: function(e, ui) {
			       		ui.children().each(function() { $(this).width($(this).width()); });
			        	return ui;
			    	},
			    });
			}
			InitialSortTable();
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