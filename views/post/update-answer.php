<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$this->title = 'Update Jawaban';
$this->params['breadcrumbs'][] = ['label' => 'Bank Soal', 'url' => ['index','PostSearch[post_as]'=>'Soal']];
$this->params['breadcrumbs'][] = ['label' => $model->post_title, 'url' => ['view', 'id' => $model->id,'post_as'=>'Soal']];
$this->params['breadcrumbs'][] = 'Update Jawaban';
?>
<div class="post-update">
    <?= $this->render('_form-answer', [
        'model' => $model,
        'answer' => $answer
    ]) ?>
</div>