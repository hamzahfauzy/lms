<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'LMS Dashboard';
?>
<div class="site-index">

    <div class="body-content" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">

        <div class="row">
            <div class="col-lg-12">
                <h2>Jadwal</h2>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Mapel</td>
                    <td>Kelas</td>
                    <td>Hari</td>
                    <td>Jam</td>
                    <td>Aksi</td>
                </tr>
                <?php if(empty($jadwal)){ ?>
                <tr>
                    <td colspan="6"><i>Tidak ada data</i></td>
                </tr>
                <?php }foreach($jadwal as $key => $j){ ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $j->mapel_nama ?></td>
                    <td><?= $j->kelas ?></td>
                    <td><?= $toHari($j->hari) ?></td>
                    <td><?= $j->jam ?></td>
                    <td><a href="<?= Url::to(['materi/index','id'=>$j->mapel_id]) ?>"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <?php } ?>
                </table>
            </div>

            <div class="col-lg-12">
                <h2>Mapel Admin</h2>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Mapel</td>
                    <td>Aksi</td>
                </tr>
                <?php if(empty($adminMapel)){ ?>
                <tr>
                    <td colspan="6"><i>Tidak ada data</i></td>
                </tr>
                <?php }foreach($adminMapel as $key => $j){ ?>
                <tr>
                    <td><?= ++$key ?></td>
                    <td><?= $j->mapel_nama ?></td>
                    <td><a href="<?= Url::to(['materi/index','id'=>$j->mapel_id]) ?>"><i class="fas fa-eye"></i> View</a></td>
                </tr>
                <?php } ?>
                </table>
            </div>
        </div>

    </div>
</div>
