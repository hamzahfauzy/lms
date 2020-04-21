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
                <form method="post">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="hidden" name="id" value="<?=$id?>">
                <input type="hidden" name="materi_id" value="<?=$materi_id?>">
                <input type="hidden" name="jadwal_id" value="<?=$jadwal->jadwal_id?>">
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
                    <input type="checkbox" id="soal-<?=$key?>" name="soal[]" value="<?=$j->id?>">
                    <label for="soal-<?=$key?>">Tambahkan Ke Tugas</label>
                    </td>
                </tr>
                <?php } ?>
                </table>
                <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>

    </div>
</div>
