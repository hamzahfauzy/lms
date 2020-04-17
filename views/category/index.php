<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mata Pelajaran';
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'name',
    [
        'attribute' => 'name',
        'format' => 'raw',
        'label' => 'Name',
        'value' => function($model){
            return Html::a($model->name,['category/view','id'=>$model->id]);
        },
    ],
    'description:ntext',
    [
        'format' => 'raw',
        'label' => 'Materi',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'value' => function($model){
            return Html::a('<i class="fas fa-eye"></i> Lihat Materi',['materi/index','id'=>$model->id]);
        },
    ],
    [
        'class'    => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'template' => '{update} {delete}',
        'buttons'  => [
            'view' => function($url){
                return Html::a(
                    '<span class="fas fa-eye"></span>',
                    $url, 
                    [
                        'title' => 'Lihat',
                        'data-pjax' => '0',
                    ]
                );
            },
            'update' => function($url){
                return Html::a(
                    '<span class="fas fa-sm fa-pencil-alt"></span>',
                    $url, 
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

if(in_array(Yii::$app->user->identity->level,['Guru','Guru Admin']))
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'name',
    [
        'attribute' => 'category',
        'format' => 'raw',
        'label' => 'Name',
        'value' => function($model){
            return Html::a($model->category->name,['category/view','id'=>$model->category->id]);
        },
    ],
    [
        'attribute' => 'category',
        'format' => 'raw',
        'label' => 'Description',
        'value' => function($model){
            return $model->category->description;
        },
    ],
    [
        'format' => 'raw',
        'label' => 'Materi',
        'contentOptions' => ['style' => 'white-space: nowrap;'],
        'value' => function($model){
            return Html::a('<i class="fas fa-eye"></i> Lihat Materi',['materi/index','id'=>$model->category->id]);
        },
    ],
];

?>
<div class="category-index">

    <div class="row">
        <?php if(Yii::$app->user->identity->level == 'Super Admin'){ ?>
        <div class="col-xs-12 col-sm-6">
            <?= Html::a('Tambah Mata Pelajaran', ['create'], ['class' => 'btn btn-success']) ?>
            <p></p>
        </div>
        <div class="col-xs-12 col-sm-6"><?php echo $this->render('_search', ['model' => $searchModel]); ?></div>
        <?php } ?>
    </div>

    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>
    </div>

</div>
