
<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Todo Item Name</th>
            <th>Category</th>
            <th>Timestamp</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($todos as $todo): ?>
            <tr>
                <td><?= Html::encode($todo->name) ?></td>
                <td><?= Html::encode($todo->category->name) ?></td>
                <td><?= Yii::$app->formatter->asDatetime($todo->timestamp) ?></td>
                <td>
                    <?= Html::button('Delete', [
                        'class' => 'btn btn-danger',
                        'onclick' => "deleteTodo($todo->id)"
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
