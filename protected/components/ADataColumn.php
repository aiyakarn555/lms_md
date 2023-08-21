<?php
class ADataColumn extends CDataColumn
{
	// Overiding function to change color of link to white.
	protected function renderHeaderCellContent()
	{
		if($this->grid->enableSorting && $this->sortable && $this->name!==null)
        	echo $this->grid->dataProvider->getSort()->link($this->name,$this->header,array('class'=>'sort-link'));
    	else if($this->name!==null && $this->header===null)
	    {
	        if($this->grid->dataProvider instanceof CActiveDataProvider)
	            echo CHtml::encode($this->grid->dataProvider->model->getAttributeLabel($this->name));
	        else
	            echo CHtml::encode($this->name);
	    }
	    else
	        parent::renderHeaderCellContent();
	}

}

?>