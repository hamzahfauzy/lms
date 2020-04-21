<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\MapelPost;
use app\models\TblMapel;
use app\models\Post;
use app\models\PostMeta;
use app\models\Tugas;
use app\models\VwJadwal;
use app\models\VwKelas;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','logout'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    function toHari($i)
    {
        $hari = [
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jum'at",
            "Sabtu"
        ];

        return $hari[$i];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $jadwal = VwJadwal::find()->where(['guru_id'=>Yii::$app->user->identity->guru_id])->all();
        return $this->render('index',[
            'jadwal' => $jadwal,
            'adminMapel' => Yii::$app->user->identity->adminMapel,
            'toHari' => function($i){
                return $this->toHari($i);
            }
        ]);
    }

    public function actionJadwal()
    {
        $jadwal = VwJadwal::find()->where(['guru_id'=>Yii::$app->user->identity->guru_id])->all();
        return $this->render('jadwal',[
            'jadwal' => $jadwal,
            'toHari' => function($i){
                return $this->toHari($i);
            }
        ]);
    }

    public function actionViewJadwal($id)
    {
        $jadwal = VwJadwal::find()->where(['jadwal_id'=>$id,'guru_id'=>Yii::$app->user->identity->guru_id])->one();
        $additionalModel = [];
        if(isset($_GET['page']))
        {
            if($_GET['page'] == 'tugas')
            {   
                $additionalModel = Post::find()->where(['post_excerpt'=>$jadwal->jadwal_id])->all();
            }
            else if($_GET['page'] == 'update-tugas')
            {
                $mapelPost = MapelPost::find()->where(['mapel_id'=>$jadwal->mapel_id])->all();
                $ids = [];
                foreach($mapelPost as $mapel_post)
                    if($mapel_post->post->post_as == 'Materi')
                        $ids[] = $mapel_post->post_id;
                
                $additionalModel = Post::find()->where(['in','id',$ids])->all();
                $additionalModel = ['model'=>Post::findOne($_GET['model_id']),'topik'=>$additionalModel];
            }
            else if($_GET['page'] == 'create-tugas')
            {
                $mapelPost = MapelPost::find()->where(['mapel_id'=>$jadwal->mapel_id])->all();
                $ids = [];
                foreach($mapelPost as $mapel_post)
                    if($mapel_post->post->post_as == 'Materi')
                        $ids[] = $mapel_post->post_id;
                
                $additionalModel = Post::find()->where(['in','id',$ids])->all();
            }
        }
        else
        {
            $additionalModel = VwKelas::find()->where([
                'tahun_akademik' => $jadwal->tahun_akademik,
                'kelas' => $jadwal->kelas,
                'mapel_id' => $jadwal->mapel_id,
            ])->all();
        }
        return $this->render('view-jadwal',[
            'jadwal' => $jadwal,
            'additionalModel' => $additionalModel,
            'toHari' => function($i){
                return $this->toHari($i);
            }
        ]);
    }

    public function actionCreateTugas()
    {
        $post = new Post;
        $post->post_title = $_POST['post_title'];
        $post->post_content = $_POST['post_content'];
        $post->post_author_id = Yii::$app->user->identity->guru_id;
        $post->post_parent_id = $_POST['category'];
        $post->post_excerpt = $_POST['jadwal_id'];
        $post->post_as = 'Tugas';
        $post->post_type = 'Post';
        if($post->save(false))
        {
            foreach($_POST['meta'] as $key => $value)
            {
                $postMeta = new PostMeta;
                $postMeta->post_id = $post->id;
                $postMeta->meta_key = $key;
                $postMeta->meta_value = $value;
                $postMeta->save();
            }
            return $this->redirect(['site/view-jadwal','id'=>$_POST['jadwal_id'],'page'=>'tugas']);
        }

    }

    public function actionMapel()
    {
        $mapel = Yii::$app->user->identity->adminMapel;
        return $this->render('mapel',[
            'adminMapel' => $mapel,
            
        ]);
    }

    public function actionTugas($id, $materi_id, $jadwal_id)
    {
        $mapel = TblMapel::findOne($id);
        $materi = Post::findOne($materi_id);
        $jadwal = VwJadwal::find()->where(['jadwal_id'=>$jadwal_id])->one();
        $model = Tugas::find()->where(['jadwal_id'=>$jadwal_id,'materi_id'=>$materi_id])->all();

        return $this->render('tugas', [
            'model' => $model,
            'mapel' => $mapel,
            'materi' => $materi,
            'jadwal' => $jadwal,
            'id'     => $id,
        ]);
    }

    public function actionAddTugas($id, $materi_id, $jadwal_id)
    {
        
        $mapel = TblMapel::findOne($id);
        $jadwal = VwJadwal::find()->where(['jadwal_id'=>$jadwal_id])->one();
        $tugas = Post::findOne($materi_id);
        $materi = Post::findOne($tugas->post_parent_id);
        $tugas = Tugas::find()->where(['materi_id'=>$materi_id,'jadwal_id'=>$jadwal_id])->all();
        $ids = [];
        foreach($tugas as $t)
            $ids[] = $t->soal_id;
        $soal = Post::find()->where(['post_parent_id'=>$materi->id,'post_as'=>'Soal'])->andWhere(['not in','id',$ids])->all();
        if (Yii::$app->request->post()){
            foreach($_POST['soal'] as $soal)
            {
                $model = new Tugas;
                $model->materi_id = $materi_id;
                $model->jadwal_id = $jadwal_id;
                $model->soal_id   = $soal;
                $model->save();
            }
            return $this->redirect(['tugas','id'=>$id,'materi_id'=>$materi_id,'jadwal_id'=>$jadwal_id]);
        }

        return $this->render('add-tugas', [
            'soal' => $soal,
            'mapel' => $mapel,
            'materi' => $materi,
            'materi_id' => $materi_id,
            'jadwal' => $jadwal,
            'id'     => $id,
        ]);

    }

    public function actionUpdateTugas()
    {
        if(isset($_POST['post_title']))
        {
            $id = $_POST['id'];
            $post = Post::findOne($id);
            $post->post_title = $_POST['post_title'];
            $post->post_content = $_POST['post_content'];
            $post->post_author_id = Yii::$app->user->identity->guru_id;
            $post->post_parent_id = $_POST['category'];
            $post->post_excerpt = $_POST['jadwal_id'];
            $post->post_as = 'Tugas';
            $post->post_type = 'Post';
            if($post->save(false))
            {
                postMeta::deleteAll(['post_id'=>$id]);
                foreach($_POST['meta'] as $key => $value)
                {
                    $postMeta = new PostMeta;
                    $postMeta->post_id = $post->id;
                    $postMeta->meta_key = $key;
                    $postMeta->meta_value = $value;
                    $postMeta->save();
                }
                return $this->redirect(['site/view-jadwal','id'=>$_POST['jadwal_id'],'page'=>'tugas']);
            }
        }
    }

    public function actionRemoveTugas($id,$jadwal_id)
    {
        Post::findOne($id)->delete();
        return $this->redirect(['view-jadwal','id'=>$jadwal_id,'page'=>'tugas']);
    }

    public function actionDeleteTugas($id)
    {
        $tugas = Tugas::findOne($id);
        $materi = $tugas->materi;
        $jadwal_id = $tugas->jadwal_id;
        $tugas->delete();
        return $this->redirect(['tugas','id'=>$materi->parent->mapelPost->mapel_id,'materi_id'=>$tugas->materi_id,'jadwal_id'=>$jadwal_id]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->renderPartial('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionGallery()
    {
        $gallery = Post::find()->where(['post_type'=>'Media','post_author_id'=>Yii::$app->user->identity->guru_id])->all();
        return $this->render('gallery',[
            'gallery' => $gallery
        ]);
    }

    function actionUpload()
    {
        if(isset($_FILES['file']['name']))
        {
            $file = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = rand() . '.' . $extension;
            // chmod('uploads', 0777);
            $allowed_extension = array("jpg", 'jpeg', "gif", "png", "pdf");
            if(in_array($extension, $allowed_extension))
            {
                if(move_uploaded_file($file, 'uploads/' . $new_image_name))
                {
                    $post = new Post;
                    $post->post_title = $file_name;
                    $post->post_content = 'uploads/' . $new_image_name;
                    $post->post_author_id = Yii::$app->user->identity->guru_id;
                    if(in_array($extension, array("jpg", 'jpeg', "gif", "png")))
                    $post->post_as = 'Gambar';
                    else
                    $post->post_as = 'Document';
                    $post->post_type = 'Media';
                    $post->save(false);
                    $message = "success";
                }
                else $message = "warning";
                Yii::$app->session->setFlash('status', $message);
                return Yii::$app->getResponse()->redirect(['site/gallery']);
                // return $this->redirect(['site/gallery','msg'=>$message]);
            }
        }
    }

    public function actionDeleteFile($id)
    {
        $model = Post::findOne($id);
        if(file_exists($model->post_content))
            unlink($model->post_content);
        $model->delete();
        return $this->redirect(['site/gallery']);
    }
}
