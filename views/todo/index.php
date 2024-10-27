<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>


<div class="todo-form">
    <?php $form = ActiveForm::begin(['id' => 'todo-form']); ?>

    <div class="row  items-center">
        <div class="col-4"> <?= $form->field($model, 'category_id')->label(false)->dropDownList(
                                \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                                ['prompt' => 'Select Category', 'class' => 'form-select rounded-0']
                            ) ?></div>
        <div class="col-4"> <?= $form->field($model, 'name')->label(false)->textInput(['placeholder' => 'Type task item here...', 'class' => 'form-control rounded-0']) ?>
        </div>
        <div class="col-4 d-flex align-items-center">
            <div class="form-group"> <?= Html::button('Add', ['class' => 'btn btn-success rounded-0', 'id' => 'add-todo']) ?></div>
        </div>
    </div>





    <?php ActiveForm::end(); ?>
</div>

<div id="todo-list">
    <?= $this->render('todo_list', ['todos' => $todos]) ?>
</div>

<?php

$createUrl = "'" .  yii\helpers\Url::to(['todo/create'], true) . "'";
$deleteUrl = "'" . Url::to(['todo/delete'], true) . "'";
$script = <<< JS

$('#add-todo').on('click', function () {
    $('#todo-category_id').removeClass('is-invalid');
    $('#todo-name').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    if(!$('#todo-name').val()){
            $('#todo-name').addClass('is-invalid').after(`<div class="invalid-feedback">
            This field is required.
            </div>`)
        
    }
    if(!$('#todo-category_id').val()){
            $('#todo-category_id').addClass('is-invalid').after(`<div class="invalid-feedback">
            This field is required.
            </div>`)
        
    }
    if(!$('#todo-name').val()||!$('#todo-category_id').val()){
        return
    }
    $.ajax({
        url: $createUrl,
        type: 'POST',
        data: $('#todo-form').serialize(),
        success: function (response) {
            $('#todo-list').html(response);
            $('#todo-form')[0].reset(); 
        }
    });
});

window.deleteTodo = function(id) {
 
  
$.ajax({
    url: $deleteUrl, 
    type: 'POST',
    data: { id: id }, 
    headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') 
    },
    success: function (response) {
        $('#todo-list').html(response); 
    },
    error: function() {
        alert('An error occurred while trying to delete the item.');
    }
});
}


JS;

$this->registerJs($script);

?>