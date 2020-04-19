<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Materi';
$this->title = 'Update Topik: ' . $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => 'Topik', 'url' => ['index','id'=>$mapel_id]];
$this->params['breadcrumbs'][] = ['label' => $model->post_title, 'url' => ['view', 'id' => $model->id,'post_as'=>$post_as]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">

    <?= $this->render('_form', [
        'model' => $model,
        'mapel_id' => $mapel_id
    ]) ?>

</div>
