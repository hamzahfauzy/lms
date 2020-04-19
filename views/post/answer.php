<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$this->title = 'Tambah Jawaban';
$this->params['breadcrumbs'][] = ['label' => 'Bank Soal', 'url' => ['index','PostSearch[post_as]'=>'Soal']];
$this->params['breadcrumbs'][] = ['label' => $model->post_title, 'url' => ['view', 'id'=>$model->mapelPost->mapel_id, 'model_id' => $model->id,'post_as'=>'Soal']];
$this->params['breadcrumbs'][] = 'Tambah Jawaban';
?>
<div class="post-update" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
    <?= $this->render('_form-answer', [
        'model' => $model,
        'answer' => $answer
    ]) ?>
</div>