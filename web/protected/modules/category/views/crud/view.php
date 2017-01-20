<?php
/* @var $this CrudController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Category', 'url'=>array('index')),
	array('label'=>'Add Child Category', 'url'=>array('create', 'id'=>$model->id)),
	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Category', 'url'=>array('admin')),
);
?>

<h1>View Category <?php echo $model->title; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(               // related city displayed as a link
            'label'=>'Parent',
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($model->parent->title),
				array('view','id'=>$model->parent->id)),
        ),
		'link',
		'title',
	),
));
