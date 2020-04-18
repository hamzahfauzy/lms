<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$post_as = 'Materi';
$this->title = $post_as.' '.$mapel->mapel_nama;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['site/mapel']];
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Title',
        'value' => function($model) use ($mapel_id){
            return Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
        },
    ],
    'post_content:raw',
    [
        'class'    => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'template' => '{update} {delete}',
        'buttons'  => [
            'update' => function($url) use ($post_as, $mapel_id) {
                return Html::a(
                    '<span class="fas fa-sm fa-pencil-alt"></span>',
                    $url.'&post_as='.$post_as.'&mapel_id='.$mapel_id, 
                    [
                        'title' => 'Edit',
                        'data-pjax' => '0',
                    ]
                );
            },
            'delete' => function($url) use ($mapel_id){
                return Html::a('<span class="fas fa-sm fa-trash"></span>', $url.'&mapel_id='.$mapel_id, [
                    'title' => 'Hapus',
                    'data' => [
                        'confirm' => 'Apakah anda yakin akan menghapus data ini?',
                        'method' => 'post',
                    ],
                ]);
            }
        ]
    ],
];
?>
<div class="post-index">
    <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
    <?php if(Yii::$app->user->identity->adminMapel && $is_admin){ ?>
    <?= Html::a('<i class="fas fa-pencil-alt"></i> Edit', ['edit','id'=>$_GET['id']], ['class' => 'btn btn-success']) ?>
    <p></p>
    <?php } ?>

    <h3>Deskripsi</h3>
    <p><?= $mapel->el ? $mapel->el->deskripsi : '<i>Tidak ada deskripsi</i>' ?></p>
    <br>

    <h3>Capaian</h3>
    <p><?= $mapel->el ? $mapel->el->capaian_pembelajaran : '<i>Tidak ada capaian</i>' ?></p>
    </div>
    <p></p>

    <p>
    <?php if(Yii::$app->user->identity->adminMapel && $is_admin){ ?>
        <?= Html::a('Buat '.$post_as, ['create','post_as'=>$post_as, 'mapel_id'=>$mapel_id], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>


</div>
