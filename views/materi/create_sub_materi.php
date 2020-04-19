<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Sub Materi';
$this->title = 'Buat Materi';
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => 'Materi', 'url' => ['index','id'=>$mapel_id]];
$this->params['breadcrumbs'][] = ['label' => $materi->post_title, 'url' => ['view','id'=>$materi_id,'mapel_id'=>$mapel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">

    <?= $this->render('_form_sub_materi', [
        'model' => $model,
        'materi_id' => $materi_id,
        'mapel_id' => $mapel_id
    ]) ?>

</div>
