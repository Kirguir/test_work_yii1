<?php
/* @var $this CrudController */
/* @var $tree Category */
$cs=Yii::app()->clientScript;
$cs->coreScriptPosition=CClientScript::POS_HEAD;
$cs->scriptMap=array();
$baseUrl=$this->module->assetsUrl;
$cs->registerCssFile($baseUrl.'/css/style.css');

$this->breadcrumbs=array(
	'Categories',
);

$this->menu=array(
	array('label'=>'Create Category', 'url'=>array('create')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>Categories by _view</h1>

<?php
echo "<ul class=\"treeview\">\n";
foreach ($tree as $node) {
	$this->renderPartial('_view',array(
		'node'=>$node,
	));
}
echo "</ul>\n";

/*
echo "<h1>Categories by ButtonTreeView</h1>";

$this->widget('ButtonTreeView', array(
	'data' => $tree,
	'persist'=>'cookie',
	'buttons' => ['create', 'update', 'delete']
));
 * 
 */
