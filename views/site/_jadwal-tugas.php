<?php
use yii\helpers\Url;
?>
                <h2>Buat Tugas</h2>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Topik</td>
                    <td>Aksi</td>
                </tr>
                <?php if(empty($additionalModel)){ ?>
                <tr>
                    <td colspan="3"><i>Tidak ada data!</i></td>
                </tr>
                <?php }foreach($additionalModel as $key => $model){ ?>
                <tr>
                    <td><?=++$key?></td>
                    <td><?=$model->post_title?></td>
                    <td>
                        <a href="<?= Url::to(['site/tugas','id'=>$model->mapelPost->mapel_id,'materi_id'=>$model->id,'jadwal_id'=>$jadwal->jadwal_id]) ?>"><i class="fas fa-eye"></i> Lihat Tugas</a>
                    </td>
                </tr>
                <?php } ?>
                </table>