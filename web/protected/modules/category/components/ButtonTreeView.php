<?php
//Yii::import('web.widgets.CTreeView');
/**
 * Description of ButtonTreeView
 *
 * @author Aleksey Shutiy<a.shutiy@gmail.com>
 */
class ButtonTreeView extends CTreeView{

	public $buttons = ['view', 'update', 'delete'];

	protected static $_buttons = [];

	/**
	 * Initializes the widget.
	 * This method registers all needed client scripts and renders
	 * the tree view content.
	 */
	public function init()
	{
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$id=$this->htmlOptions['id']=$this->getId();
		if($this->url!==null)
			$this->url=CHtml::normalizeUrl($this->url);
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('treeview');
		$options=$this->getClientOptions();
		$options=$options===array()?'{}' : CJavaScript::encode($options);
		$cs->registerScript('Yii.CTreeView#'.$id,"jQuery(\"#{$id}\").treeview($options);");
		if($this->cssFile===null)
			$cs->registerCssFile($cs->getCoreScriptUrl().'/treeview/jquery.treeview.css');
		elseif($this->cssFile!==false)
			$cs->registerCssFile($this->cssFile);

		self::$_buttons = $this->buttons;

		echo CHtml::tag('ul',$this->htmlOptions,false,false)."\n";
		echo self::saveDataAsHtml($this->data);
	}
	
	/**
	 * Generates tree view nodes in HTML from the data array.
	 * @param array $data the data for the tree view (see {@link data} for possible data structure).
	 * @return string the generated HTML for the tree view
	 */
	public static function saveDataAsHtml($data)
	{
		$html='';
		if(is_array($data))
		{
			foreach($data as $node)
			{
				if(!isset($node['text']) || !isset($node['id']))
					continue;

				if(isset($node['expanded']))
					$css=$node['expanded'] ? 'open' : 'closed';
				else
					$css='';

				if(isset($node['hasChildren']) && $node['hasChildren'])
				{
					if($css!=='')
						$css.=' ';
					$css.='hasChildren';
				}

				$options=isset($node['htmlOptions']) ? $node['htmlOptions'] : array();
				if($css!=='')
				{
					if(isset($options['class']))
						$options['class'].=' '.$css;
					else
						$options['class']=$css;
				}

				if(isset($node['id']))
					$options['id']=$node['id'];

				$html.=CHtml::tag('li',$options,$node['text'],false);
				$html.="\n<div class=\"tree-buttons\">\n";
				foreach (self::$_buttons as $button) {
					$url = Yii::app()->controller->createUrl($button, array("id"=>$node['id']));
					$html.=CHtml::link($button,$url);
				}
				$html.="</div>\n";
				if(!empty($node['children']))
				{
					$html.="\n<ul>\n";
					$html.=self::saveDataAsHtml($node['children']);
					$html.="</ul>\n";
				}
				$html.=CHtml::closeTag('li')."\n";
			}
		}
		return $html;
	}
}
