<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = 'Materi';
$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
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
        'value' => function($model){
            return Html::a($model->post_title,['sub-materi-view','id'=>$model->id]);
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

if(in_array(Yii::$app->user->identity->level,['Guru']))
$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'post_title',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'format' => 'raw',
        'label' => 'Title',
        'value' => function($model){
            return Html::a($model->post_title,['sub-materi-view','id'=>$model->id]);
        },
    ],
    'post_excerpt:raw',
    [
        'attribute' => 'post_as',
        'format' => 'raw',
        'label' => 'Status',
        'value' => function($model){
            return $model->post_as;
        },
    ],
    
];
?>
<div class="post-view">


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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'category',
                'format' => 'raw',
                'label' => 'Mata Pelajaran',
                'value' => function($model){
                    return $model->categoryPosts[0]->category->name;
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
    <p>
        <?= Html::a('<i class="fas fa-plus-alt"></i> Tambah Sub Materi', ['create-sub-materi', 'materi_id' => $model->id, 'mapel_id' => $mapel_id], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>
    </div>
    <?php } ?>
</div>
