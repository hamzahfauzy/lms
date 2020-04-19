<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Tugas '.$mapel->mapel_nama.' '.$jadwal->kelas;
?>
<div class="site-index">

    <div class="body-content" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">

        <div class="row">
            <div class="col-lg-12">
                <h4><?=$materi->post_title?></h4>
                <a href="<?= Url::to(['add-tugas','id'=>$id,'materi_id'=>$materi->id,'jadwal_id'=>$jadwal->jadwal_id]) ?>" class="btn btn-success">Tambah Tugas</a>
                <p></p>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Judul</td>
                    <td>Ringkasan</td>
                    <td>Aksi</td>
                </tr>
                <?php if(empty($model)){ ?>
                <tr>
                    <td colspan="6"><i>Tidak ada data</i></td>
                </tr>
                <?php }foreach($model as $key => $j){ ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><a href="<?= Url::to(['post/view','model_id'=>$j->soal_id,'post_as'=>'Soal','id'=>$j->materi->mapelPost->mapel_id]) ?>"><?= $j->soal->post_title ?></a></td>
                    <td><?= $j->soal->post_excerpt ?></td>
                    <td>
                        <a href="<?= Url::to(['site/delete-tugas','id'=>$j->id]) ?>" data-confirm="apakah anda yakin menghapus tugas ini?" data-method="post"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                </tr>
                <?php } ?>
                </table>
            </div>
        </div>

    </div>
</div>
