<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = $_GET['post_as'];
$this->title = 'Buat '.$post_as;
$this->params['breadcrumbs'][] = ['label' => $post_as == 'Soal' ? 'Bank Soal' : $post_as, 'url' => ['index','PostSearch[post_as]'=>$post_as]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <?= $this->render('_form', [
        'model' => $model,
        'mapel' => $mapel
    ]) ?>

</div>
