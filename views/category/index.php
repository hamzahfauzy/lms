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
        'attribute' => 'mapel_nama',
        'format' => 'raw',
        'label' => 'Nama Mapel',
        'value' => function($model){
            return Html::a($model->mapel_nama,['category/view','id'=>$model->mapel_id]);
        },
    ],
];

?>
<div class="category-index">

    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $columns
    ]); ?>
    </div>

</div>
