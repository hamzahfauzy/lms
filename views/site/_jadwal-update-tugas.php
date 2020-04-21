<?php
use yii\helpers\Url;
$model = $additionalModel['model'];
$additionalModel = $additionalModel['topik'];
?>
<h2>Update Tugas</h2>
<form method="post" action="<?= Url::to(['site/update-tugas'])?>">
    <input type="hidden" name="id" value="<?= $model->id ?>">
    <input type="hidden" name="jadwal_id" value="<?= $_GET['id'] ?>">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <div class="form-group">
        <label for="">Judul</label>
        <input name="post_title" type="text" class="form-control" value="<?=$model->post_title?>" required>
    </div>
    <div class="form-group">
        <label for="">Deskripsi</label>
        <textarea name="post_content" class="form-control" required><?=$model->post_content?></textarea>
    </div>
    <div class="form-group">
        <label for="">Topik</label>
        <select name="category" class="form-control" required>
            <option value="">- Topik -</option>
            <?php foreach($additionalModel as $topik){ ?>
            <option value="<?=$topik->id?>" <?= $topik->id == $model->post_parent_id ? 'selected' : '' ?>><?=$topik->post_title?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Waktu Mulai</label>
        <input name="meta[time_start]" type="datetime-local" class="form-control" value="<?=@$model->meta('time_start')?>" required>
    </div>
    <div class="form-group">
        <label for="">Waktu Selesai</label>
        <input name="meta[time_end]" type="datetime-local" class="form-control" value="<?=@$model->meta('time_end')?>" required>
    </div>
    <button class="btn btn-success">Simpan</button>
</form>
                