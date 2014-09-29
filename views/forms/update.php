<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span4">
				<h3>Űrlap módosítása</h3>

				<?php
				$this->renderPartial('_form', array(
					'model' => $model,
					'selected_tags' => $selected_tags,
				));
				?>
			</div>
			<div class="span4">
				<h3>Új beviteli mező hozzáadása</h3>
				<div class="row-fluid">
					<div class="span12 well">
						<?php
						$this->renderPartial('application.modules.AFormGenerator.views.inputs._form', array(
							'model' => $new_input,
						));
						?>
					</div>
				</div>
			</div>
			<div class="span4">
				<h3>Hozzárendelt mezők</h3>
				<div class="row-fluid">
					<div class="span12">
						<?php
						$this->renderPartial('application.modules.AFormGenerator.views.inputs._admin', array(
							'model' => $model,
						));
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>