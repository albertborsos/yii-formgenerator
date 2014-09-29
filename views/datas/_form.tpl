<div class="form">
    {form name="form" id="datas-form" htmlOptions=["class"=>"form-horizontal"]}
    <p class="note">A <span class="required">*</span>-al megjelölt mezők kitöltése kötelező!</p>

    {$form->errorSummary($model)}

    <div class="control-group row">
        {$form->labelEx($model,'input_id', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'input_id')}
            {$form->error($model,'input_id')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'key', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'key',['size'=>60,'maxlength'=>100])}
            {$form->error($model,'key')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'value', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'value',['size'=>60,'maxlength'=>100])}
            {$form->error($model,'value')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'order_num', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'order_num')}
            {$form->error($model,'order_num')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'user_create', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'user_create')}
            {$form->error($model,'user_create')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'date_create', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'date_create')}
            {$form->error($model,'date_create')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'user_update', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'user_update')}
            {$form->error($model,'user_update')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'date_update', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'date_update')}
            {$form->error($model,'date_update')}
        </div>
    </div>

    <div class="control-group row">
        {$form->labelEx($model,'status', ['class'=>'control-label'])}
        <div class="controls">
            {$form->textField($model,'status',['size'=>1,'maxlength'=>1])}
            {$form->error($model,'status')}
        </div>
    </div>

    <div class="control-group row">
        <div class="controls">
            {CHtml::submitButton('Mentés', ['class' => 'btn btn-primary'])}
        </div>
    </div>

    {/form}

</div><!-- form -->