<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span6">
                <h3>Űrlap létrehozása</h3>

				<?php
				$this->renderPartial('_form', array(
					'model' => $model,
					'selected_tags' => $selected_tags,
				));
				?>
            </div>
        </div>
    </div>
</div>