<?php

use yii\helpers\Html;
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
        'label' => 'Title',
        'value' => function($model){
            return Html::a($model->post_title,['post/view','id'=>$model->id,'post_as'=>$model->post_as]);
        },
    ],
    'post_excerpt:raw',
    [
        'attribute' => 'post_author_id',
        'format' => 'raw',
        'label' => 'Author',
        'value' => function($model){
            return $model->author->username;
        },
    ],
    [
        'class'    => 'yii\grid\ActionColumn',
        'template' => '{update} {delete}',
        'buttons'  => [
            'update' => function($url) use ($post_as) {
                return Html::a(
                    '<span class="fas fa-sm fa-pencil-alt"></span>',
                    $url.'&post_as='.$post_as, 
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
if(Yii::$app->user->identity->level == 'Guru')
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Title',
        'value' => function($model){
            return Html::a($model->post_title,['post/view','id'=>$model->id,'post_as'=>$model->post_as]);
        },
    ],
    'post_excerpt:raw',
    [
        'attribute' => 'post_author_id',
        'format' => 'raw',
        'label' => 'Mata Pelajaran',
        'value' => function($model){
            return $model->categoryPosts[0]->category->name;
        },
    ]
];
?>
<div class="post-index">

    <p>
    <?php if(Yii::$app->user->identity->level != 'Guru'){ ?>
        <?= Html::a('Buat '.$post_as, ['create','post_as'=>$post_as], ['class' => 'btn btn-success']) ?>
    <?php } ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel, 'post_as' => $post_as]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns
    ]); ?>


</div>
