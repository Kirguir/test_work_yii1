<?php
/* @var $this CrudController */

$buttons = ['create', 'update', 'delete'];
?>

<li class="<?= $class ?>">
	<b><?= $node['text']; ?></b>
	<div class="tree-buttons">
	<?php foreach ($buttons as $button) {
		$url = Yii::app()->controller->createUrl($button, array("id"=>$node['id']));
		if($button == 'delete'){
			echo CHtml::link($button, '#',array('submit'=>$url,'confirm'=>'Are you sure you want to delete this item?'));
		} else {
			echo CHtml::link($button,$url);
		}
	} ?>
	</div>

<?php
if(!empty($node['children'])){
	echo "<ul style=\"display: block;\">\n";
}
$last_key = end(array_keys($node['children']));
foreach ($node['children'] as $key => $child) {
	$this->renderPartial('_view',array(
		'node'  => $child,
		'class' => ($key == $last_key) ? 'last' : ''
	));
} 
if(!empty($node['children'])){
	echo "</ul>\n";
}
?>

</li>