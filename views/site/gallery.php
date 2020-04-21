<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Gallery';
?>
<div class="site-index">

    <div class="body-content" style="background-color:#FFF !important;box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15)!important;padding:15px;">
        <a href="javascript:void(0)" class="btn btn-primary" onclick="file.click()">Upload Gambar</a>
        <form method="post" action="<?= Url::to(['site/upload']) ?>" id="form" enctype="multipart/form-data">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <input type="file" name="file" id="file" style="display:none" accept=".jpg, .jpeg, .gif" onchange="if(confirm('apakah anda yakin akan mengupload gambar ini ?')) form.submit()">
        </form>
        <p></p>
        <div class="row text-center text-lg-left">
            <?php foreach($gallery as $g){ ?>
            <div class="col-md-4 col-6">
                <img class="img-fluid img-thumbnail d-block" style="height:250px;width:100%;object-fit:cover;" src="<?= Url::to([$g->post_content]) ?>" alt="">
                <center>
                <a href="<?= Url::to([$g->post_content]) ?>"><?= $g->post_content ?></a>
                <br><button class="btn btn-success" onclick="copyText('<?= Url::base(true) ?>/<?=$g->post_content?>', this)">Salin Link</button>
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