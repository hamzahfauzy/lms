<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$post_as = $_GET['PostSearch']['post_as'];
$this->title = $post_as == 'Soal' ? 'Bank Soal' : $post_as;
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Judul',
        'value' => function($model){
            return Html::a($model->post_title,['post/view','id'=>$_GET['id'],'model_id'=>$model->id,'post_as'=>$model->post_as]);
        },
    ],
    [
        'attribute' => 'post_excerpt',
        'format' => 'raw',
        'label' => 'Ringkasan',
        'value' => function($model){
            return $model->post_excerpt;
        },
    ],
    [
        'attribute' => 'post_parent_id',
        'format' => 'raw',
        'label' => 'Topik',
        'value' => function($model){
            return $model->parent->post_title;
        },
    ],
    [
        'attribute' => 'post_author_id',
        'format' => 'raw',
        'label' => 'Author',
        'value' => function($model){
            return $model->author->guru_nama;
        },
    ],
    [
        'class'    => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
        'buttons'  => [
            'update' => function($url,$m) use ($post_as) {
                return Html::a(
                    '<span class="fas fa-sm fa-pencil-alt"></span>',
                    Url::to(['update','id'=>$_GET['id'],'model_id'=>$m->id,'post_as'=>$post_as]), 
                    [
                        'title' => 'Edit',
                        'data-pjax' => '0',
                    ]
                );
            },
            'delete' => function($url){
                return Html::a('<span class="fas fa-sm fa-trash"></span>', $url, [
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
if($mapel[0]->mapel->guru_admin_id != Yii::$app->user->identity->guru_id)
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Judul',
        'value' => function($model){
            return Html::a($model->post_title,['post/view','id'=>$_GET['id'],'model_id'=>$model->id,'post_as'=>$model->post_as]);
        },
    ],
    [
        'attribute' => 'post_excerpt',
        'format' => 'raw',
        'label' => 'Ringkasan',
        'value' => function($model){
            return $model->post_excerpt;
        },
    ],
    [
        'attribute' => 'post_parent_id',
        'format' => 'raw',
        'label' => 'Topik',
        'value' => function($model){
            return $model->parent->post_title;
        },
    ],
    [
        'attribute' => 'post_author_id',
        'format' => 'raw',
        'label' => 'Author',
        'value' => function($model){
            return $model->author->guru_nama;
        },
    ],
];
?>
<div class="post-index" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">

    <p>
    <?php if($mapel[0]->mapel->guru_admin_id == Yii::$app->user->identity->guru_id){ ?>
        <?= Html::a('Buat '.$post_as, ['create','id'=>$_GET['id'], 'post_as'=>$post_as], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel, 'post_as' => $post_as]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns
    ]); ?>


</div>
