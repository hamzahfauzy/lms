<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$post_as = 'Materi';
$this->title = $post_as.' '.$mapel->mapel_nama;
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['site/mapel']];
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Judul',
        'value' => function($model) use ($mapel_id){
            return Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
        },
    ],
    [
        'attribute' => 'post_content',
        'format' => 'raw',
        'label' => 'Deskripsi',
        'value' => function($model){
            return $model->post_content;
        },
    ],
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
if(!$is_admin)
$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    // 'post_title',
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Judul',
        'value' => function($model) use ($mapel_id){
            return Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
        },
    ],
    [
        'attribute' => 'post_content',
        'format' => 'raw',
        'label' => 'Deskripsi',
        'value' => function($model){
            return $model->post_content;
        },
    ]
];
?>
<div class="post-index">
    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
                <ul>
                    <li>
                        <a href="javascript:void(0)" onclick="show('deskripsi')">Deskripsi</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="show('capaian')">Capaian</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="show('topik')">Topik</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 col-md-9">
            <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">

                <div class="deskripsi content-toggle d-none">
                <?php if($is_admin){ ?>
                <?= Html::a('<i class="fas fa-pencil-alt"></i> Edit', ['edit','id'=>$_GET['id']], ['class' => 'btn btn-success']) ?>
                <p></p>
                <?php } ?>
                <h3>Deskripsi</h3>
                <p><?= $mapel->el ? $mapel->el->deskripsi : '<i>Tidak ada deskripsi</i>' ?></p>
                <br>
                </div>

                <div class="capaian content-toggle d-none">
                <?php if($is_admin){ ?>
                <?= Html::a('<i class="fas fa-pencil-alt"></i> Edit', ['edit','id'=>$_GET['id']], ['class' => 'btn btn-success']) ?>
                <p></p>
                <?php } ?>
                <h3>Capaian</h3>
                <p><?= $mapel->el ? $mapel->el->capaian_pembelajaran : '<i>Tidak ada capaian</i>' ?></p>
                <p></p>
                </div>

                <div class="topik content-toggle d-none">
                <p>
                <?php if(Yii::$app->user->identity->adminMapel && $is_admin){ ?>
                    <?= Html::a('Buat Topik', ['create','post_as'=>$post_as, 'mapel_id'=>$mapel_id], ['class' => 'btn btn-success']) ?>
                <?php } ?>
                </p>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columns,
                ]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script defer>
function show(class_name)
{
    $('.content-toggle').addClass('d-none');
    $('.'+class_name).removeClass('d-none');
    localStorage.setItem('active-content',class_name)
}

window.onload = function(){
    var activeContent = localStorage.getItem('active-content') == null ? 'topik' : localStorage.getItem('active-content')
    show(activeContent)
}
</script>