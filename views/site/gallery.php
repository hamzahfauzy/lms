<?php

/* @var $this yii\web\View */
use yii\helpers\Url;


$this->title = 'File Manager';
$this->params['breadcrumbs'][] = 'File Manager';
?>
<div class="site-index">

    <div class="body-content" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
        <a href="javascript:void(0)" class="btn btn-primary" onclick="file.click()"><i class="fas fa-cloud-upload-alt"></i> Upload File</a>
        <form method="post" action="<?= Url::to(['site/upload']) ?>" id="form" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <input type="file" name="file" id="file" style="display:none" accept=".jpg, .jpeg, .gif, .png, .pdf" onchange="if(confirm('apakah anda yakin akan mengupload file ini ?')) form.submit()">
        </form>
        <?php if(Yii::$app->session->hasFlash('status')): $msg = Yii::$app->session->getFlash('status');?>
            <p></p>
            <div class="alert alert-<?=$msg?>">
                Upload <?= $msg == 'success' ? 'Berhasil' : 'Gagal' ?>
            </div>
        <?php endif; ?>
        <p></p>
        <?php if(empty($gallery)){ echo "<center><i>Tidak ada data</i></center>"; } ?>
        <div class="row text-center text-lg-left">
            <?php foreach($gallery as $g){ ?>
            <div class="col-md-4 col-6">
                <a href="<?= Url::to([$g->post_content]) ?>">
                <?php if($g->post_as == 'Gambar'){ ?>
                <img class="img-fluid img-thumbnail d-block" style="height:250px;width:100%;object-fit:cover;" src="<?= Url::to([$g->post_content]) ?>" alt="">
                <?php }else{ ?>
                <img class="img-fluid img-thumbnail d-block" style="height:250px;width:100%;object-fit:cover;" src="<?= Url::base(true) ?>/img/pdf-icon.png" alt="">
                <?php } ?>
                </a>
                <center>
                <a href="<?= Url::to([$g->post_content]) ?>"><?= $g->post_title ? $g->post_title : str_replace('uploads/','',$g->post_content) ?></a><br>
                <button class="btn btn-success" onclick="copyText('<?= Url::base(true) ?>/<?=$g->post_content?>', this)">Salin Link</button>
                <a href="<?= Url::to([$g->post_content]) ?>" class="btn btn-warning"><i class="fas fa-cloud-download-alt"></i></a>
                <a href="<?= Url::to(['delete-file','id'=>$g->id]) ?>" data-method="post" data-confirm="apakah anda yakin akan menghapus file ini ?" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                </center>
                <div class="mb-4"></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
function copyText(str, btn) {
    var el = document.createElement('textarea');
   // Set value (string to be copied)
   el.value = str;
   // Set non-editable to avoid focus and move outside of view
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   // Select text inside element
   el.select();
   // Copy text to clipboard
   document.execCommand('copy');
   // Remove temporary element
   document.body.removeChild(el);

   btn.innerHTML = "Tersalin"
   setTimeout(()=>{
       btn.innerHTML = "Salin Link"
   },2000)
}
</script>