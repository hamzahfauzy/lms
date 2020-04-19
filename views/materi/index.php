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
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Judul',
        'value' => function($model) use ($mapel_id){
            // return '<a href="#">'.$model->post_title.'</a>';
            // return Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
            // $return = Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
            $return = '<a href="javascript:void(0)" onclick="expand(this)" data-id="'.$model->id.'" data-expanded="0" data-url="'.Url::to(['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]).'">'.$model->post_title.'</a>';
            $return .= '<div style="font-size:12px">';
            $return .= Html::a('<i class="fas fa-plus"></i> Sub Topik',['materi/create-sub-materi','materi_id'=>$model->id,'mapel_id'=>$mapel_id],['class'=>'text-success']);
            $return .= ' | '.Html::a('<i class="fas fa-pencil-alt"></i> Edit',['materi/update','id'=>$model->id,'mapel_id'=>$mapel_id]);
            $return .= ' | '.Html::a('<i class="fas fa-trash"></i> Hapus',['materi/delete','id'=>$model->id,'mapel_id'=>$mapel_id],['data-confirm'=>'apakah anda yakin akan menghapus data ini?','data-method'=>'post','class'=>'text-danger']);
            $return .= '</div>';
            return $return;
        },
    ]
];
if(!$is_admin)
$columns = [
    [
        'attribute' => 'post_title',
        'format' => 'raw',
        'label' => 'Judul',
        'value' => function($model) use ($mapel_id){
            // return '<a href="#">'.$model->post_title.'</a>';
            // return Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
            // $return = Html::a($model->post_title,['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]);
            $return = '<a href="javascript:void(0)" onclick="expand(this)" data-id="'.$model->id.'" data-expanded="0" data-url="'.Url::to(['materi/view','id'=>$model->id,'post_as'=>$model->post_as, 'mapel_id' => $mapel_id]).'">'.$model->post_title.'</a>';
            return $return;
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

                <div class="topik content-toggle">
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

function expand(el)
{
    var row = $(el)
    var url = row.data('url')+'&mode=ajax'
    var id = row.data('id')
    if(row.data('expanded'))
    {
        row.data('expanded',0)
        $('.child-'+id).remove()
        return
    }
    fetch(url).
    then(res => res.json()).
    then(res => {
        var tr = ''
        if(res.length)
        {
            res.forEach((val,index) => {
                var no = ++index
                tr += `<tr class="child-${id}">`
                tr += `<td><div style="margin-left:50px">`
                tr += `<a href="<?= Url::to(['materi/open']) ?>?id=${val.post_parent_id}&sub_materi=${no}">${no}. ${val.post_title}</a>`
                tr += `<div style="font-size:12px">
                <a href="<?= Url::to(['materi/open']) ?>?id=${val.post_parent_id}&sub_materi=${no}" class="text-success"><i class="fas fa-eye"></i> Buka</a>
                        <?php if($is_admin){ ?>
                        | <a href="<?= Url::to(['materi/update-sub-materi']) ?>?id=${val.id}&materi_id=${val.post_parent_id}&mapel_id=<?=$mapel_id?>"><i class="fas fa-pencil-alt"></i> Edit</a> |
                        <a href="<?= Url::to(['materi/remove-sub-materi']) ?>?id=${val.id}&mapel_id=<?=$mapel_id?>" class="text-danger" data-confirm="apakah anda yakin akan menghapus data ini?" data-method="post"><i class="fas fa-pencil-alt"></i> Hapus</a>
                        <?php } ?>
                        </div>`
                tr += `</div></td>`
                tr += '</tr>'
            })
        }
        else
        {
            tr = `<tr class="child-${id}"><td><i>Tidak ada data</i></td></tr>`
        }
        $(tr).insertAfter(row.closest('tr'))
        row.data('expanded',1)
    })
}

window.onload = function(){
    var activeContent = localStorage.getItem('active-content') == null ? 'topik' : localStorage.getItem('active-content')
    show(activeContent)
}
</script>