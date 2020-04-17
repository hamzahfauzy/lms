<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

<?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'username', [
        'template' => '<div class="input-group">{input}
        <div class="input-group-append"><button class="input-group-text"><i class="fas fa-search"></i></button></div></div>{error}{hint}'
    ])->textInput(['placeholder'=>'Cari Pengguna...'])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
