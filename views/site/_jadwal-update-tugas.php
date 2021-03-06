<?php
use yii\helpers\Url;
$model = $additionalModel['model'];
$additionalModel = $additionalModel['topik'];
$this->params['breadcrumbs'][] = ['label'=>'Tugas','url'=>['view-jadwal','id'=>$_GET['id'],'page'=>'tugas']];
$this->params['breadcrumbs'][] = 'Update Tugas';
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" rel="stylesheet" type="text/css">
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
            <?php foreach($additionalModel as $key => $topik){ ?>
            <option value="<?=$topik->id?>" <?= $topik->id == $model->post_parent_id ? 'selected' : '' ?>><?=++$key ?>. <?=$topik->post_title?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group">
        <label for="">Waktu Mulai</label>
        <input name="meta[time_start]" id="datetimepicker" type="text" class="form-control" value="<?=@str_replace('T',' ',$model->meta('time_start'))?>" readonly required>
    </div>
    <div class="form-group">
        <label for="">Waktu Selesai</label>
        <input name="meta[time_end]" id="datetimepicker1" type="text" class="form-control" value="<?=@str_replace('T',' ',$model->meta('time_end'))?>" readonly required>
    </div>
    <button class="btn btn-success">Simpan</button>
</form>
<script src="<?=Url::to(['js/jquery-1.8.3.min.js'])?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.js"></script>
<script type="text/javascript">
var allowTimes = []
for(i=0;i<24;i++)
{
    for(j=0;j<60;j++)
    {
        var _time = i+':'+j
        allowTimes.push(_time)
    }
}
$("#datetimepicker").datetimepicker({
    format:'Y-m-d H:i',
    allowTimes:allowTimes
});
$("#datetimepicker1").datetimepicker({
    format:'Y-m-d H:i',
    allowTimes:allowTimes
});

$("#datetimepicker").focus(function(){
    $("#datetimepicker").datetimepicker('show') 
})

$("#datetimepicker1").focus(function(){
    $("#datetimepicker1").datetimepicker('show') 
})
</script> 