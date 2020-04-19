<?php
use yii\helpers\Url;
?>
                <h2>Daftar Siswa</h2>
                <table class="table table-border table-striped">
                <tr>
                    <td>#</td>
                    <td>Siswa ID</td>
                    <td>Nama Siswa</td>
                </tr>
                <?php if(empty($additionalModel)){ ?>
                <tr>
                    <td colspan="3"><i>Tidak ada data!</i></td>
                </tr>
                <?php }foreach($additionalModel as $key => $model){ ?>
                <tr>
                    <td><?=++$key?></td>
                    <td><?=$model->siswa_id?></td>
                    <td><?=$model->siswa_nama?></td>
                </tr>
                <?php } ?>
                </table>