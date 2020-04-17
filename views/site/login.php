<?php
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* (C) Copyright 2019 Heru Arief Wijaya (http://belajararief.com/) untuk Indonesia.*/

app\assets\AppAsset::register($this);
hoaaah\sbadmin2\assets\SbAdmin2Asset::register($this);

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@bower/startbootstrap-sb-admin-2');
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="bg-gradient-primary">
<?php $this->beginBody() ?>
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background-image:url(/assets/login-bg.jpg)"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                  </div>
                  <?php $form = ActiveForm::begin(['id' => 'login-form','options'=>['class'=>'user']]); ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Masukkan Username...','class'=>'form-control form-control-user'])->label(false) ?>

                    <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Masukkan Kata Sandi...','class'=>'form-control form-control-user'])->label(false) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fas fa-sign-in-alt"></i> Masuk', ['class' => 'btn btn-primary btn-user btn-block', 'name' => 'login-button']) ?>
                    </div>

                  <?php ActiveForm::end(); ?>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>