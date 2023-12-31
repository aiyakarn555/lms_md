<?php
class AMenu extends CMenu
{
	public $items=array();
	public $listQuery=array();
	public $itemTemplate;
	public $encodeLabel=true;
	public $activeCssClass='active';
	public $activateItems=true;
	public $activateParents=false;
	public $hideEmptyItems=true;
	public $htmlOptions=array();
	public $submenuHtmlOptions=array();
	public $linkLabelWrapper;
	public $linkLabelWrapperHtmlOptions=array();
	public $firstItemCssClass;
	public $lastItemCssClass;
	public $itemCssClass;

	/*public function init()
	{
		$this->htmlOptions['id']=$this->getId();
		$route=$this->getController()->getRoute();
		$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}*/


  //   public function init()
  //   {
		// if(isset($item['listQuery']))
		// {
		// 	foreach ($item['listQuery'] as $value) 
		// 	{
		// 		$this->listQuery[] = array('label'=>$value->shoptype_name, 'url'=>array('/t/t'));
		// 	}
		// }
  //       parent::init();
  //   }

	/**
	 * Recursively renders the menu items.
	 * @param array $items the menu items to be rendered recursively
	 */
	protected function renderMenuRecursive($items)
	{
		$count=0;
		$n=count($items);
		foreach($items as $item)
		{
			$count++;
			$options=isset($item['itemOptions']) ? $item['itemOptions'] : array();
			$class=array();
			if($item['active'] && $this->activeCssClass!='')
				$class[]=$this->activeCssClass;
			if($count===1 && $this->firstItemCssClass!==null)
				$class[]=$this->firstItemCssClass;
			if($count===$n && $this->lastItemCssClass!==null)
				$class[]=$this->lastItemCssClass;
			if($this->itemCssClass!==null)
				$class[]=$this->itemCssClass;
			if($class!==array())
			{
				if(empty($options['class']))
					$options['class']=implode(' ',$class);
				else
					$options['class'].=' '.implode(' ',$class);
			}

			echo CHtml::openTag('li', $options);

			$menu=$this->renderMenuItem($item);
			if(isset($this->itemTemplate) || isset($item['template']))
			{
				$template=isset($item['template']) ? $item['template'] : $this->itemTemplate;
				echo strtr($template,array('{menu}'=>$menu));
			}
			else
				echo $menu;

			if(isset($item['items']) && count($item['items']))
			{
				echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
				$this->renderMenuRecursive($item['items']);
				echo CHtml::closeTag('ul')."\n";
			}
			// if(isset($item['listQuery']['model']))
			// {
			// 	foreach ($item['listQuery']['model'] as $value) 
			// 	{
			// 		$this->listQuery[] = array('label'=>$value->$item['listQuery']['modelname'], 'url'=>array('/t/t'));
			// 	}
			// 	echo "\n".CHtml::openTag('ul',isset($item['submenuOptions']) ? $item['submenuOptions'] : $this->submenuHtmlOptions)."\n";
			// 	$this->renderMenuRecursive($this->listQuery);
			// 	echo CHtml::closeTag('ul')."\n";
			// }
			echo CHtml::closeTag('li')."\n";
		}
	}

	/**
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 * @return string
	 * @since 1.1.6
	 */
	protected function renderMenuItem($item)
	{
		if(isset($item['url']))
		{
			$label=$this->linkLabelWrapper===null ? $item['label'] : CHtml::tag($this->linkLabelWrapper, $this->linkLabelWrapperHtmlOptions, $item['label']);
			if(isset($item['icon'])){$icon='<i class="'.$item['icon'].'"></i>';}else{$icon='';}
			return CHtml::link($icon.''.$label,$item['url'],isset($item['linkOptions']) ? $item['linkOptions'] : array());
		}
		else
			return CHtml::tag('span',isset($item['linkOptions']) ? $item['linkOptions'] : array(), $item['label']);
	}

	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if the currently requested URL is generated by the 'url' option
	 * of the menu item. Note that the GET parameters not specified in the 'url' option will be ignored.
	 * @param array $item the menu item to be checked
	 * @param string $route the route of the current request
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item,$route)
	{
		if(isset($item['url']) && is_array($item['url']) && !strcasecmp(trim($item['url'][0],'/'),$route))
		{
			unset($item['url']['#']);
			if(count($item['url'])>1)
			{
				foreach(array_splice($item['url'],1) as $name=>$value)
				{
					if(!isset($_GET[$name]) || $_GET[$name]!=$value)
						return false;
				}
			}
			return true;
		}
		return false;
	}
}