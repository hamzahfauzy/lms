<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Assign Guru';
$this->params['breadcrumbs'][] = ['label' => 'Mata Pelajaran', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view','id'=>$model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">
    
    <div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($category_user, 'category_id')->hiddenInput(['value' => $model->id])->label(false) ?>
    <?= $form->field($category_user, 'user_id')->dropDownList($all_guru,['prompt'=>'- Pilih Guru -']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>

</div>