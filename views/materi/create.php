<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Materi';
$this->title = 'Buat '.$post_as;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => $post_as, 'url' => ['index','id'=>$mapel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
        'mapel_id' => $mapel_id
    ]) ?>

</div>
