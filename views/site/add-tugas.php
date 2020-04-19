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
                
                <p></p>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Judul</td>
                    <td>Ringkasan</td>
                    <td>Aksi</td>
                </tr>
                <?php if(empty($soal)){ ?>
                <tr>
                    <td colspan="6"><i>Tidak ada data</i></td>
                </tr>
                <?php }foreach($soal as $key => $j){ ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $j->post_title ?></td>
                    <td><?= $j->post_excerpt ?></td>
                    <td>
                        <a href="<?= Url::to(['site/add-tugas','id'=>$id,'materi_id'=>$materi->id,'jadwal_id'=>$jadwal->jadwal_id,'soal_id'=>$j->id]) ?>" class="btn btn-primary" data-confirm="apakah anda yakin ingin menambahkan soal ini ke tugas ?" data-method="post"><i class="fas fa-plus"></i> Tambahkan Ke Tugas</a>
                    </td>
                </tr>
                <?php } ?>
                </table>
            </div>
        </div>

    </div>
</div>
