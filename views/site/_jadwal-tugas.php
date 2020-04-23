<?php
use yii\helpers\Url;
$this->params['breadcrumbs'][] = 'Tugas';
?>
                <h2>Buat Tugas</h2>
                <a href="<?= Url::to(['site/view-jadwal','id'=>$_GET['id'],'page'=>'create-tugas']) ?>" class="btn btn-success">Tambah Tugas</a>
                <p></p>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Tugas</td>
                    <td>Topik</td>
                </tr>
                <?php if(empty($additionalModel)){ ?>
                <tr>
                    <td colspan="3"><i>Tidak ada data!</i></td>
                </tr>
                <?php }foreach($additionalModel as $key => $model){ ?>
                <tr>
                    <td><?=++$key?></td>
                    <td>
                    <a href="<?= Url::to(['site/tugas','id'=>$model->parent->mapelPost->mapel_id,'materi_id'=>$model->id,'jadwal_id'=>$model->post_excerpt]) ?>"><?=$model->post_title?></a><br>
                    Mulai : <?=str_replace('T',' ',$model->meta('time_start')) ?><br>
                    Selesai : <?=str_replace('T',' ',$model->meta('time_end')) ?><br>
                    <br>
                        <a href="<?= Url::to(['site/view-jadwal','page'=>'update-tugas','id'=>$_GET['id'],'model_id'=>$model->id,'jadwal_id'=>$model->post_excerpt]) ?>"><i class="fas fa-pencil-alt"></i> Edit</a>
                        |
                        <a href="<?= Url::to(['site/remove-tugas','id'=>$model->id,'jadwal_id'=>$model->post_excerpt]) ?>" style="color:red" data-method="post" data-confirm="apakah anda yakin akan menghapus tugas ini ?"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                    <td><?=$model->parent->post_title?></td>
                </tr>
                <?php } ?>
                </table>