<?php
Yii::import('zii.widgets.CPortlet');
 
class ImageLink extends CPortlet
{
    public function init()
    {
        parent::init();
    }
 
    protected function renderContent()
    {
		$ImageLink = ImgslideLink::model()->findAll();
		$ImageLinkDataProvider=new CArrayDataProvider($ImageLink);
        $this->render('ImageLink',array(
        	'ImageLinkDataProvider' => $ImageLinkDataProvider
        ));
    }
}
?>