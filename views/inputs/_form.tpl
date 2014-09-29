<div class="form">
    {form name="form" id="inputs-form" htmlOptions=["class"=>"form-horizontal"]}
    <p class="note">A <span class="required">*</span>-al megjelölt mezők kitöltése kötelező!</p>

    {$form->errorSummary($model)}

    <div class="control-group row">
        {$form->labelEx($model,'type', ['class'=>'control-label'])}
        <div class="controls">
            {$form->dropDownList($model,'type',FormDataProvider::items('input_type'), ['class'=>'span12'])}
            {$form->error($model,'type')}
        </div>
    </div>
{*
    <div class="control-group row">
        {$form->labelEx($model,'model_class', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'model_class',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'model_class')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'model_attribute', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'model_attribute',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'model_attribute')}
        </div>
    </div>
*}
    <div class="control-group row">
        {$form->labelEx($model,'label', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'label',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'label')}
        </div>
    </div>
        
    <div class="control-group row">
        {$form->labelEx($model,'name', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'name',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'name')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'value', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'value',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'value')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'placeholder', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'placeholder',['size'=>60,'maxlength'=>100, 'class'=>'span12'])}
            {$form->error($model,'placeholder')}
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
        {$form->labelEx($model,'order_num', ['class'=>'control-label'])}
        <div class="controls">
            {$form->dropDownList($model,'order_num',FormDataProvider::items('order'), ['class'=>'span12'])}
            {$form->error($model,'order_num')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'status', ['class'=>'control-label'])}
        <div class="controls">
            {$form->dropDownList($model,'status',FormDataProvider::items('status'), ['class'=>'span12'])}
            {$form->error($model,'status')}
        </div>
    </div>

    <div class="control-group row">
        <div class="controls">
            {if $model->isNewRecord}
                {CHtml::submitButton('Létrehozás', ['class' => 'btn btn-success'])}
            {else}
                {CHtml::submitButton('Módosítás', ['class' => 'btn btn-danger'])}
                {CHtml::link('Mégsem', ['/formgenerator/forms/update?id='|cat:$model->form_id] ,['class' => 'btn'])}
            {/if}
        </div>
    </div>

    {/form}

</div><!-- form -->