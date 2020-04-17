<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
$post_as = $_GET['post_as'];
$this->title = $model->post_title;
$this->params['breadcrumbs'][] = ['label' => $post_as == 'Soal' ? 'Bank Soal' : $post_as, 'url' => ['index','PostSearch[post_as]'=>$post_as]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    'post_content:raw',
    [
        'attribute' => 'post_status',
        'format' => 'raw',
        'label' => 'Status',
        'value' => function($model) use ($post_as){
            return $model->post_status ? '<span class="badge badge-success">Jawaban benar</span>' : '<span class="badge badge-danger">Jawaban salah</span> <br> <a href="/post/toggle-answer?id='.$model->id.'&post_as='.$post_as.'" data-confirm="apakah anda yakin akan mengubah jawaban ini menjadi jawaban benar ?" data-method="post" style="font-size:12px"><i class="fas fa-check"></i> Set Jawaban Benar</a>';
        },
    ],
    [
        'class'    => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
        'buttons'  => [
            'update' => function($url, $m) use ($model,$post_as){
                return Html::a('<span class="fas fa-sm fa-pencil-alt"></span>', ['post/update-answer','id'=>$model->id, 'answer_id' => $m->id, 'post_as' => $post_as], [
                    'title' => 'Update'
                ]);
            },
            'delete' => function($url, $m) use ($model,$post_as){
                return Html::a('<span class="fas fa-sm fa-trash"></span>', ['post/remove-answer','id'=>$m->id, 'post_as' => $post_as], [
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
    'post_content:raw',
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
        <?= Html::a('<i class="fas fa-pencil-alt"></i> Update', ['update', 'id' => $model->id, 'post_as' => $post_as], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
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

    <?php if($post_as == 'Soal' && in_array(Yii::$app->user->identity->level,['Super Admin','Guru Admin'])){ ?>
    <br>
    <h1 class="h3 mb-0 text-gray-800">Jawaban</h1>
    <p>
        <?= Html::a('<i class="fas fa-plus-alt"></i> Tambah Jawaban', ['answer', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
