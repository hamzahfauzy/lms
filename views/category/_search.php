<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'name', [
        'template' => '<div class="input-group">{input}
        <div class="input-group-append"><button class="input-group-text"><i class="fas fa-search"></i></button></div></div>{error}{hint}'
    ])->textInput(['placeholder'=>'Cari Mata Pelajaran...'])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
