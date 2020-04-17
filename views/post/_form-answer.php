<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<script src="https://cdn.ckeditor.com/4.14.0/standard-all/ckeditor.js"></script>
<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($answer, 'post_as')->hiddenInput(['value' => 'Jawaban'])->label(false) ?>
    <?= $form->field($answer, 'post_author_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
    <?= $form->field($answer, 'post_parent_id')->hiddenInput(['value' => $model->id])->label(false) ?>
    <?= $form->field($answer, 'post_type')->hiddenInput(['value' => 'post'])->label(false) ?>
    <?= $form->field($answer, 'post_status')->hiddenInput(['value' => 0])->label(false) ?>
    <?= $form->field($answer, 'post_title')->hiddenInput(['value' => 'Jawaban'])->label(false) ?>

    <?= $form->field($answer, 'post_content')->textarea(['id' => 'editor1'])->label("Jawaban") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    CKEDITOR.replace('editor1', {
      extraPlugins: 'embed,autoembed,image2',
      height: 250,

      // Load the default contents.css file plus customizations for this sample.
      contentsCss: [
        'http://cdn.ckeditor.com/4.14.0/full-all/contents.css',
        'https://ckeditor.com/docs/vendors/4.14.0/ckeditor/assets/css/widgetstyles.css'
      ],
      // Setup content provider. See https://ckeditor.com/docs/ckeditor4/latest/features/media_embed
      embed_provider: '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',

      // Configure the Enhanced Image plugin to use classes instead of styles and to disable the
      // resizer (because image size is controlled by widget styles or the image takes maximum
      // 100% of the editor width).
      image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
      image2_disableResizer: true
    });
    
</script>
