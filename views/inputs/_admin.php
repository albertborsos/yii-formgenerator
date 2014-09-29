<?php
$this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'id' => 'inputs-grid',
	'fixedHeader' => true,
	'type' => 'striped',
	'dataProvider' => Inputs::model()->search_by_form($model->id),
	'responsiveTable' => true,
	'template' => "{summary}{items}{pager}",
	'columns' => array(
		array(
			'header' => 'No.',
			'type' => 'raw',
			'value' => '$data["order_num"]."."',
			'htmlOptions' => array(
				'style' => 'text-align:center',
			),
		),
		array(
			'name' => 'type',
			'type' => 'raw',
			'value' => '$data["type"]',
		),
		array(
			'name' => 'name',
			'type' => 'raw',
			'value' => '$data["name"]',
		),
		array(
			'name' => 'status',
			'type' => 'raw',
			'value' => 'FormDataProvider::items("status", $data["status"])',
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
			'template' => '{update}{delete}',
			'buttons' => array(
				'update' => array(
					'label' => 'Módosítás',
					'icon' => 'edit',
					'url' => 'Yii::app()->createUrl("/formgenerator/forms/update?id='.$model->id.'&inputid=".$data["id"])',
					'options' => array(
						'class' => 'btn btn-small',
					),
				),
				'delete' => array(
					'label' => 'Eltávolítás',
					'icon' => 'white remove',
					'url' => 'Yii::app()->createUrl("/formgenerator/inputs/update/".$data["id"])',
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
