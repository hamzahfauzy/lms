<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Materi';
$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['site/mapel']];
$this->params['breadcrumbs'][] = ['label' => $post_as, 'url' => ['index','id'=>$mapel_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'post_title',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'format' => 'raw',
        'label' => 'Title',
        'value' => function($model, $key, $index){
            return Html::a($model->post_title,['open','id'=>$model->post_parent_id,'sub_materi'=>$index+1]);
        },
    ],
    'post_excerpt:raw',
    [
        'class'    => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'template' => '{update} {delete}',
        'buttons'  => [
            'update' => function($url, $m) use ($model,$mapel_id,$post_as){
                return Html::a('<span class="fas fa-sm fa-pencil-alt"></span>', ['materi/update-sub-materi','id'=>$m->id, 'materi_id' => $m->post_parent_id, 'mapel_id' => $mapel_id, 'post_as' => $post_as], [
                    'title' => 'Update'
                ]);
            },
            'delete' => function($url, $m) use ($model,$mapel_id,$post_as){
                return Html::a('<span class="fas fa-sm fa-trash"></span>', ['materi/remove-sub-materi','id'=>$m->id, 'mapel_id' => $mapel_id], [
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

if(Yii::$app->user->identity->guru_id != $model->mapelPost->mapel_id)
$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'post_title',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'format' => 'raw',
        'label' => 'Title',
        'value' => function($model, $key, $index){
            return Html::a($model->post_title,['open','id'=>$model->post_parent_id,'sub_materi'=>$index+1]);
        },
    ],
    'post_excerpt:raw',
    
];
?>
<div class="post-view">

    <?php if(Yii::$app->user->identity->guru_id == $model->mapelPost->mapel_id){ ?>
    <p>
        <?= Html::a('<i class="fas fa-pencil-alt"></i> Update', ['update', 'id' => $model->id, 'post_as' => $post_as, 'mapel_id'=>$mapel_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id, 'mapel_id'=>$mapel_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'category',
                'format' => 'raw',
                'label' => 'Mata Pelajaran',
                'value' => function($model){
                    return $model->mapelPost->mapel->mapel_nama;
                },
            ],
            'post_content:raw',
            [
                'attribute' => 'post_status',
                'format' => 'raw',
                'label' => 'Status',
                'value' => function($model){
                    return $model->post_status == 1 ? 'Publish' : 'Draft';
                },
            ],
            'post_date:date',
            'post_modified:date',
        ],
    ]) ?>

    <?php if($post_as == 'Materi'){ ?>
    <br>
    <h1 class="h3 mb-0 text-gray-800">Sub Materi</h1>
    <?php if(Yii::$app->user->identity->guru_id == $model->mapelPost->mapel_id){ ?>
    <p>
        <?= Html::a('<i class="fas fa-plus-alt"></i> Tambah Sub Materi', ['create-sub-materi', 'materi_id' => $model->id, 'mapel_id' => $mapel_id], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>
    </div>
    <?php } ?>
</div>
