<div class="form">
    {form name="form" id="forms-form" htmlOptions=["class"=>"form-horizontal"]}
    <p class="note">A <span class="required">*</span>-al megjelölt mezők kitöltése kötelező!</p>

    {$form->errorSummary($model)}

    <div class="control-group row">
        {$form->labelEx($model,'title', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'title',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'title')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'name', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'name',['size'=>60,'maxlength'=>160, 'class'=>'span12'])}
            {$form->error($model,'name')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'name_replace', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'name_replace',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'name_replace')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'method', ['class'=>'control-label'])}
        <div class="controls">
            {$form->dropDownList($model,'method',FormDataProvider::items('method'))}
            {$form->error($model,'method')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'action', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'action',['size'=>60,'maxlength'=>160, 'class'=>'span12'])}
            {$form->error($model,'action')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'class', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'class',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'class')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'style', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'style',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'style')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'status', ['class'=>'control-label'])}
        <div class="controls">
            {$form->dropDownList($model,'status',FormDataProvider::items('status'))}
            {$form->error($model,'status')}
        </div>
    </div>
        
    <div class="control-group row">
        {CHtml::label('Cimkék', 'tags', ['class'=>'control-label'])}
        <div class="controls">
            {Tags::tagField('selected_tags', $selected_tags, Tags::get_source())}
        </div>
    </div>

    <div class="control-group row">
        <div class="controls">
            {CHtml::submitButton('Mentés', ['class' => 'btn btn-primary'])}
        </div>
    </div>

    {/form}

</div><!-- form -->