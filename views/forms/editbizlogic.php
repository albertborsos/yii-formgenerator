<h3><?php echo '<legend>'.$model->name.' üzleti logikájának módosítása</legend>'; ?></h3>
<div class="row-fluid">
	<div class="span12">

		<?php
			echo CHtml::beginForm(null, 'POST');
			$this->widget('yiiwheels.widgets.ace.WhAceEditor',
			array(
				'name'  =>'bizlogic',
				'mode'  => 'php',
				'theme' => 'eclipse',
				'value' => '<?php'.$model->bizlogic,
				'htmlOptions'=> array('style' => 'width:100%;height:400px'),
				'events' => array(
					'change' => 'function(e){'
					. '$("textarea[name=bizlogic]").val(aceEditor_bizlogic.getSession().getValue());'
					. '}',
				),
			));
			echo CHtml::submitButton('Mentés', array('class'=>'btn btn-primary','style'=>'margin-top:5px;'));
			echo CHtml::endForm();
		?>
	</div>
</div>