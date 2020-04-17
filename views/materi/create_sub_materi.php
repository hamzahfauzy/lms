<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Sub Materi';
$this->title = 'Buat '.$post_as;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => 'Materi', 'url' => ['index','id'=>$mapel_id]];
$this->params['breadcrumbs'][] = ['label' => $materi->post_title, 'url' => ['view','id'=>$materi_id,'mapel_id'=>$mapel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form_sub_materi', [
        'model' => $model,
        'materi_id' => $materi_id,
        'mapel_id' => $mapel_id
    ]) ?>

</div>
