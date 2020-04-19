<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$post_as = 'Materi';
$this->title = $sub_materi > 0 ? $model->post_title : $post_as.' '.$mapel->mapel_nama;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['site/mapel']];
$this->params['breadcrumbs'][] = ['label' => 'Topik '.$mapel->mapel_nama, 'url' => ['materi/index','id'=>$mapel->mapel_id]];
$this->params['breadcrumbs'][] = ['label' => $model->parent->post_title, 'url' => ['materi/view','id'=>$model->post_parent_id,'mapel_id'=>$mapel->mapel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
                <h5><?=$model->parent->post_title?></h5>
                <ul>
                    <?php foreach($all as $key => $p){ ?>
                    <li>
                    <a href="<?= Url::to(['open','id'=>$p->post_parent_id,'sub_materi'=>++$key]) ?>"><?=$p->post_title?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-md-9">
            <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
            <?php if($sub_materi > 0): ?>
            <?= $model->post_content ?>
            <?php if($prev): ?>
            <a href="<?= Url::to(['/materi/open','id'=>$model->post_parent_id,'sub_materi'=>$sub_materi-1])?>" class="btn btn-primary"><< <?= $prev->post_title ?></a>
            <?php else: ?>
            <!-- <a href="<?= Url::to(['/materi/view','id'=>$model->post_parent_id,'mapel_id'=>$mapel->mapel_id])?>" class="btn btn-success">Pendahuluan</a> -->
            <?php endif ?>

            <?php if($next): ?>
            <a href="<?= Url::to(['/materi/open','id'=>$model->post_parent_id,'sub_materi'=>++$sub_materi])?>" class="btn btn-primary"><?= $next->post_title ?> >></a>
            <?php else: ?>
            <!-- <a href="/materi/soal?id=<?=$mapel->mapel_id?>" class="btn btn-success">Soal</a> -->
            <?php endif ?>
            
            <?php else: ?>
            <a href="<?= Url::to(['/materi/open','id'=>$mapel->mapel_id,'sub_materi'=>++$sub_materi])?>" class="btn btn-success">Mulai</a>
            <?php endif ?>
            </div>
        </div>
    </div>
</div>
