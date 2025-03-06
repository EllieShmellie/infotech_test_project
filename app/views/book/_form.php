<?php
/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Author;

$authorsList = ArrayHelper::map(Author::find()->all(), 'author_id', 'last_name');
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'year')->textInput() ?>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'cover')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'author_ids')->listBox($authorsList, [
        'multiple' => true,
        'size'     => 10,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
