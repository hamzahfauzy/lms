<h3><?= $mapel->mapel_nama?></h3>
<h4 style="margin:0;padding:0;">Deskripsi</h4>
<div style="margin:0;padding:0;"><?= $mapel->el ? $mapel->el->deskripsi : '<i>Tidak ada deskripsi</i>' ?></div>
<p></p>
<h4 style="margin:0;padding:0;">Capaian</h4>
<div style="margin:0;padding:0;"><?= $mapel->el ? $mapel->el->capaian_pembelajaran : '<i>Tidak ada capaian</i>' ?></div>
<p></p>
<h4 style="margin:0;padding:0;">Satuan Acara</h4>
<p></p>
<table cellpadding="10px" cellspacing="0" width="100%" border="1">
<thead>
<tr>
    <th width="20px" bgcolor="#a8d8d8">#</th>
    <th bgcolor="#a8d8d8">Judul</th>
    <th bgcolor="#a8d8d8">Deskripsi</th>
</tr>
</thead>
<tbody>
<?php foreach($query as $key => $rows){ ?>
<tr>
    <td style="vertical-align:top;"><?=++$key?></td>
    <td style="vertical-align:top;">
    <h4 style="margin:0;padding:0;"><?=$rows->post_title?></h4>
    <ul>
    <?php foreach($rows->submateri() as $materi){ ?>
    <li><?=$materi->post_title?></li>
    <?php } ?>
    </ul>
    </td>
    <td style="vertical-align:top;">
    <?=$rows->post_content?>
    </td>
</tr>
<?php } ?>
</tbody>
</table>