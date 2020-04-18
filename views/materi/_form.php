<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
$model->post_status = empty($model->post_status) ? 1 : $model->post_status;
?>
<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_as')->hiddenInput(['value' => 'Materi'])->label(false) ?>
    <?= $form->field($model, 'post_author_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($model, 'post_type')->hiddenInput(['value' => 'post'])->label(false) ?>
    <?= $form->field($model, 'post_status')->hiddenInput(['value' => 1])->label(false) ?>
    <?= Html::hiddenInput('category',$mapel_id) ?>

    <?= $form->field($model, 'post_title')->textInput(['maxlength' => true])->label('Judul') ?>

    <?= $form->field($model, 'post_content')->textarea()->label('Deskripsi') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>