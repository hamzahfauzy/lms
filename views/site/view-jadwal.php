<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = $jadwal->mapel_nama.' '.$jadwal->kelas.', '.$toHari($jadwal->hari).' '.$jadwal->jam;
$this->params['breadcrumbs'][] = 'Jadwal '.$jadwal->mapel_nama;
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-3">
                <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
                    <?php require '_jadwal-sidebar.php' ?>
                </div>
            </div>
            <div class="col-lg-9">
                <div style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
                    <?php require '_jadwal-'.(isset($_GET['page']) ? $_GET['page'] : 'daftar-siswa').'.php' ?>
                </div>
            </div>
        </div>

    </div>
</div>
