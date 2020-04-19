<?php
use yii\helpers\Url;
?>
<ul>
                    <li>
                        <a href="<?= Url::to(['','id'=>$jadwal->jadwal_id]) ?>">Daftar Siswa</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['','id'=>$jadwal->jadwal_id,'page'=>'lembar-nilai']) ?>">Lembar Nilai</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['materi/index','id'=>$jadwal->mapel_id]) ?>">View Mapel</a>
                    </li>
                    <li>
                        <a href="<?= Url::to(['','id'=>$jadwal->jadwal_id,'page'=>'tugas']) ?>">Buat Tugas</a>
                    </li>
                </ul>