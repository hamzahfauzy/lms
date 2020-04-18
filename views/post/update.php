<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = $_GET['post_as'];
$this->title = 'Update '.$post_as.': ' . $model->post_title;
$this->params['breadcrumbs'][] = ['label' => $post_as == 'Soal' ? 'Bank Soal' : $post_as, 'url' => ['index','id'=>$_GET['id'],'PostSearch[post_as]'=>$post_as]];
$this->params['breadcrumbs'][] = ['label' => $model->post_title, 'url' => ['view', 'id'=>$_GET['id'],'model_id'=>$model->id,'post_as'=>$post_as]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-update">

    <?= $this->render('_form', [
        'model' => $model,
        'topik' => $topik,
        'mapel' => $mapel
    ]) ?>

</div>
