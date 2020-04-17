<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pengguna';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Tambah Pengguna', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'username',
                'format' => 'raw',
                'label' => 'Username',
                'value' => function($model){
                    return Html::a($model->username,['user/view','id'=>$model->id]);
                },
            ],
            'email:email',
            'level',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'label' => 'Status',
                'value' => function($model){
                    return "<center>".($model->status == 9 ? 'Non-Aktif' : 'Aktif')."<br>".Html::a($model->status == 9 ? '<i class="fas fa-check"></i> Aktifkan' : '<i class="fas fa-times"></i> Non-Aktifkan',['user/change-status','id'=>$model->id],[
                        'data' => [
                            'confirm' => 'Apakah anda yakin akan mengubah status data ini?',
                            'method' => 'post',
                        ],
                    ])."</center>";
                },
            ],
            'created_at:date',
            //'updated_at',
            //'verification_token',

            [
                'class'    => 'yii\grid\ActionColumn',
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
        ],
    ]); ?>
    </div>


</div>
