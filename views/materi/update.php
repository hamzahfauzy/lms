<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Materi';
$this->title = 'Update '.$post_as.': ' . $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => $post_as, 'url' => ['index','id'=>$mapel_id]];
$this->params['breadcrumbs'][] = ['label' => $model->post_title, 'url' => ['view', 'id' => $model->id,'post_as'=>$post_as]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
        'mapel_id' => $mapel_id
    ]) ?>

</div>
