<?php 
class AButtonColumn extends CButtonColumn
{
	// Overiding Public Properties
	public $deleteButtonImageUrl = false;
	public $deleteButtonLabel = 'delete';
	public $updateButtonImageUrl = false;
	public $updateButtonLabel = 'edit';
	public $viewButtonImageUrl = false;
	public $viewButtonLabel = 'detail';
	public $header = 'action';
	public $deleteButtonOptions = array("class"=>"btn-action glyphicons pencil btn-danger remove_2",);
	public $updateButtonOptions = array("class"=>"btn-action glyphicons pencil btn-success");
	public $viewButtonOptions = array("class"=>"btn-action glyphicons eye_open btn-info");
	public $htmlOptions = array("style"=>'width: 90px;', "class"=>"center");
	public $textConfirmation = 'confirm Delete ?';
	public $textAlertDelete = 'Delete success';

	// Overiding initDefaultBButtons function for rewrite 
	// delete confirm box of system to use bootstrap.
	protected function initDefaultButtons()
	{
		parent::initDefaultButtons();
		if(isset($this->buttons['delete']['click']))
	    {
	    	if(Yii::app()->request->enableCsrfValidation)
	        {
	            $csrfTokenName = Yii::app()->request->csrfTokenName;
	            $csrfToken = Yii::app()->request->csrfToken;
	            $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
	        }
	        else
	            $csrf = '';

	        $text = CJavaScript::encode($this->deleteConfirmation);
	        $this->buttons['delete']['click'] = "";
	    	if(is_string($this->deleteConfirmation))
	            $this->buttons['delete']['click']=<<<EOD
        		function() {
        			var href_url = jQuery(this).attr('href');
        			bootbox.confirm({
        			message: '$this->textConfirmation',
				    buttons: {
				        confirm: {
				            label: 'delete',
				            className: 'btn btn-primary ok'	
				        },
				        cancel: {
				            label: 'cancel',
				            // className: 'btn-danger'
				        }
				    },
				    callback: function (result) {
				    	if(result)
		            	{
		            		$('.ok').attr('disabled', 'disabled');
		            		var th = this,
			            		afterDelete = $this->afterDelete;
							jQuery('#{$this->grid->id}').yiiGridView('update', {
							    type: 'POST',
							    url: href_url, $csrf
							    success: function(data) {
							        jQuery('#{$this->grid->id}').yiiGridView('update');
							        notyfy({dismissQueue: false,text: "$this->textAlertDelete",type: 'success'});
							        bootbox.hideAll();
							    },
							    error: function(XHR) {
							        return afterDelete(th, false, XHR);
							    }
						    });
							return false;
		            	}
				    }
				});

       //  			bootbox.confirm('$this->textConfirmation', function(result){
		     //        	if(result)
		     //        	{
		     //        		var th = this,
			    //         		afterDelete = $this->afterDelete;
							// jQuery('#{$this->grid->id}').yiiGridView('update', {
							//     type: 'POST',
							//     url: href_url, $csrf
							//     success: function(data) {
							//         jQuery('#{$this->grid->id}').yiiGridView('update');
							//         notyfy({dismissQueue: false,text: "$this->textAlertDelete",type: 'success'});
							//         location.reload();
							//     },
							//     error: function(XHR) {
							//         return afterDelete(th, false, XHR);
							//     }
						 //    });
							// return false;
		     //        	}
		     //        });
					return false;
				}
EOD;
		} 
	}	

	// Overinding renderButton function to generate new ICON.
	protected function renderButton($id,$button,$row,$data)
	{
		$button['options']['title'] = Yii::t("default", $button['label']);
		$button['label'] = '<i></i>';
		parent::renderButton($id,$button,$row,$data);
	}

}

?>