<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$post_as = 'Materi';
$this->title = $post_as.' '.$mapel->name;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['category/index']];
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

if(in_array(Yii::$app->user->identity->level,['Guru']))
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Title',
        'value' => function($model){
            return Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as]);
        },
    ],
    'post_content:raw',
];
?>
<div class="post-index">

    <p>
    <?php if(Yii::$app->user->identity->level != 'Guru'){ ?>
        <?= Html::a('Buat '.$post_as, ['create','post_as'=>$post_as, 'mapel_id'=>$mapel_id], ['class' => 'btn btn-success']) ?>
    <?php } ?>
        <?= Html::a('Buka '.$post_as, ['open','id'=>$mapel_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>


</div>
