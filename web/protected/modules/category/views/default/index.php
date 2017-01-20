<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Test regexp',
);

$data = ['55.10', '55.01', '50.01', '55.00', '50.00'];

echo <<<'EOF'
<h1>Code</h1>

<pre>
$data = ['55.10', '55.01', '50.01', '55.00', '50.00'];

$result = array_map(function($number){
	return preg_replace('/(0|\.00)$/', '', $number);
}, $data);

array_walk($result, function($item, $index, $data){
	echo $data[$index] . ' => ' . $item . '<br>';
}, $data);
</pre>
EOF;

$result = array_map(function($number){
	return preg_replace('/(0|\.00)$/', '', $number);
}, $data);

array_walk($result, function($item, $index, $data){
	echo $data[$index] . ' => ' . $item . '<br>';
}, $data);