
<h3>Űrlapok áttekintése</h3>

<div class="alert alert-info">
	<p>Szűrhetsz összehasonlító operátorokkal is ( <strong><, <=, >, >=, <>,  =</strong>) minden keresés elején tudod használni ezeket az operátorokat!</p>
</div>
<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'id' => 'forms-grid',
	'fixedHeader' => true,
	'type' => 'striped',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'responsiveTable' => true,
	'template' => "{summary}{items}{pager}",
	'columns' => array(
		array(
			'name' => 'title',
			'type' => 'raw',
			'value' => '$data["title"]',
			'htmlOptions' => array(
				'style' => 'text-align:center',
			),
		),
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => '$data["name"]',
			'htmlOptions' => array(
				'style' => 'text-align:center',
			),
		),
		array(
			'name' => 'name_replace',
			'type' => 'raw',
			'value' => '$data["name_replace"]',
		),
		array(
			'name' => 'method',
			'type' => 'raw',
			'value' => '$data["method"]',
			'htmlOptions' => array(
				'style' => 'text-align:center',
			),
		),
		array(
			'name' => 'action',
			'type' => 'raw',
			'value' => '$data["action"]',
		),
		array(
			'header' => 'Utolsó módosítás',
			'type' => 'raw',
			'value' => 'AActiveRecord::get_last_modified_info($data)',
			'htmlOptions' => array(
				'style' => 'text-align:center',
			),
		),
		array(
			'name' => 'status',
			'type' => 'raw',
			'value' => 'FormDataProvider::items("status", $data["status"])',
			'htmlOptions' => array(
				'style' => 'text-align:center',
			),
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{overview}{bizlogic}{update}{delete}',
			'buttons' => array(
				'overview' => array(
					'label' => 'Előnézet',
					'icon' => 'eye-open',
					'url' => 'Yii::app()->createUrl("#".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small form-overview',
					),
				),
				'bizlogic' => array(
					'label' => 'Üzleti Logika',
					'icon' => 'briefcase white',
					'url' => 'Yii::app()->createUrl("/formgenerator/forms/editbizlogic/".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small btn-primary',
					),
				),
				'update' => array(
					'label' => 'Módosítás',
					'icon' => 'edit',
					//                    'url' => 'Yii::app()->createUrl("Forms/update/".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small',
					),
				),
				'delete' => array(
					'label' => 'Eltávolítás',
					'icon' => 'white remove',
					//                    'url' => 'Yii::app()->createUrl("Forms/delete/".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small btn-danger',
					),
				),
			),
			'htmlOptions' => array(
				'style' => 'width:80px;'
			)
		),
	),
));
?>
