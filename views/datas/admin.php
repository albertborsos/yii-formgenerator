
<h3>Datases áttekintése</h3>

<div class="alert alert-info">
	<p>Szűrhetsz összehasonlító operátorokkal is ( <strong><, <=, >, >=, <>,  =</strong>) minden keresés elején tudod használni ezeket az operátorokat!</p>
</div>
<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'id' => 'datas-grid',
	'fixedHeader' => true,
	'type' => 'striped',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'responsiveTable' => true,
	'template' => "{summary}{items}{pager}",
	'columns' => array(
		array(
			'name' => 'id',
			'type' => 'raw',
			'value' => '$data["id"]',
		),
		array(
			'name' => 'input_id',
			'type' => 'raw',
			'value' => '$data["input_id"]',
		),
		array(
			'name' => 'key',
			'type' => 'raw',
			'value' => '$data["key"]',
		),
		array(
			'name' => 'value',
			'type' => 'raw',
			'value' => '$data["value"]',
		),
		array(
			'name' => 'order_num',
			'type' => 'raw',
			'value' => '$data["order_num"]',
		),
		array(
			'name' => 'user_create',
			'type' => 'raw',
			'value' => '$data["user_create"]',
		),
		array(
			'name' => 'date_create',
			'type' => 'raw',
			'value' => '$data["date_create"]',
		),
		array(
			'name' => 'user_update',
			'type' => 'raw',
			'value' => '$data["user_update"]',
		),
		array(
			'name' => 'date_update',
			'type' => 'raw',
			'value' => '$data["date_update"]',
		),
		array(
			'name' => 'status',
			'type' => 'raw',
			'value' => '$data["status"]',
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array(
					'label' => 'Módosítás',
					'icon' => 'edit',
					//                    'url' => 'Yii::app()->createUrl("Datas/update/".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small',
					),
				),
				'delete' => array(
					'label' => 'Eltávolítás',
					'icon' => 'white remove',
					//                    'url' => 'Yii::app()->createUrl("Datas/delete/".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small btn-danger',
					),
				),
			),
			'htmlOptions' => array(
				'style' => 'min-width:80px;'
			)
		),
	),
));
?>
