<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$columns = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'user_id',
        'format' => 'raw',
        'label' => 'Guru',
        'value' => function($model){
            return $model->user->username;
        },
    ],
    [
        'class'    => 'yii\grid\ActionColumn',
        'template' => '{delete}',
        'buttons'  => [
            'delete' => function($url, $m) use ($model){
                return Html::a('<span class="fas fa-sm fa-trash"></span>', ['category/remove-assign','id'=>$model->id, 'cat_user' => $m->id], [
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
    [
        'attribute' => 'user_id',
        'format' => 'raw',
        'label' => 'Guru',
        'value' => function($model){
            return $model->user->username;
        },
    ],
];

?>
<div class="category-view">
    <?php if(Yii::$app->user->identity->level == 'Super Admin'){ ?>
    <p>
        <?= Html::a('<i class="fas fa-pencil-alt"></i> Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
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
            'id',
            'name',
            'description:ntext',
        ],
    ]) ?>

    <br>
    <h1 class="h3 mb-0 text-gray-800">Guru Pengampuh</h1>
    <?php if(Yii::$app->user->identity->level == 'Super Admin'){ ?>
    <p>
        <?= Html::a('<i class="fas fa-marker"></i> Assign Guru', ['assign', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>
    <?php } ?>
    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>
    </div>

</div>
