<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\User;
use app\models\PostSearch;
use app\models\MapelPost;
use app\models\TblMapel;
use yii\data\ActiveDataProvider;
use app\components\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'remove-answer' => ['POST'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['Guru Admin'],
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['Guru'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {            
        if ($action->id == 'image-upload') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $mapelPost = MapelPost::find()->where(['mapel_id'=>$id])->all();
        $ids = [];
        foreach($mapelPost as $mapel_post)
        {
            if($mapel_post->post->post_as == 'Soal')
                $ids[] = $mapel_post->post_id;
        }
        $searchModel = new PostSearch();
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->searchIn($ids, $queryParams);

        return $this->render('index', [
            'mapel'       => $mapelPost,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$model_id)
    {
        $jawabans = Post::find()->where(['post_parent_id'=>$model_id,'post_as'=>'Jawaban']);
        $dataProvider = new ActiveDataProvider([
            'query' => $jawabans,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($model_id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Post();
        $mapel = TblMapel::findOne($id);
        if($mapel->guru_admin_id != Yii::$app->user->identity->guru_id)
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        $topik = $this->topik($id);

        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())){
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_date = strtotime(date("Y-m-d H:i:s"));
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save(false)) 
            {
                $CategoryPost = new MapelPost;
                $CategoryPost->mapel_id = $id;
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['view', 'id'=>$id, 'model_id' => $model->id,'post_as'=>$model->post_as]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'topik' => $topik,
            'mapel' => $mapel
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$model_id)
    {
        $model = $this->findModel($model_id);
        $mapel = TblMapel::findOne($id);
        $topik = $this->topik($id);

        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post())){
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save(false))
            {
                MapelPost::deleteAll(['post_id'=>$model->id]);

                $CategoryPost = new MapelPost;
                $CategoryPost->mapel_id = $id;
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['view', 'id' => $id, 'model_id'=>$model->id, 'post_as' => $model->post_as]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'topik' => $topik,
            'mapel' => $mapel
        ]);
    }

    public function actionAnswer($id)
    {
        $model = $this->findModel($id);
        $answer = new Post;

        if ($answer->load(Yii::$app->request->post())){
            $request = Yii::$app->request->post();
            $answer->post_excerpt = $this->strWordCut($answer->post_content,100);
            $answer->post_date = strtotime(date("Y-m-d H:i:s"));
            $answer->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($answer->save(false))
                return $this->redirect(['view', 'id'=>$model->mapelPost->mapel_id, 'model_id' => $model->id, 'post_as' => $model->post_as]);
        }

        return $this->render('answer', [
            'model' => $model,
            'answer' => $answer
        ]);
    }

    public function actionUpdateAnswer($id, $answer_id)
    {
        $model = $this->findModel($id);
        $answer = Post::findOne($answer_id);

        if ($answer->load(Yii::$app->request->post())){
            $request = Yii::$app->request->post();
            $answer->post_excerpt = $this->strWordCut($answer->post_content,100);
            $answer->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($answer->save(false))
                return $this->redirect(['view', 'id' => $model->mapelPost->mapel_id, 'model_id' => $model->id, 'post_as' => $model->post_as]);
        }

        return $this->render('update-answer', [
            'model' => $model,
            'answer' => $answer
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $post_as = $model->post_as;
        $mapel_id = $model->mapelPost->mapel_id;
        $model->delete();

        return $this->redirect(['index','id'=>$mapel_id,'PostSearch[post_as]'=>$post_as]);
    }

    public function actionRemoveAnswer($id)
    {
        $model = $this->findModel($id);
        $parent = $this->findModel($model->post_parent_id);
        $model->delete();

        return $this->redirect(['view','id'=>$parent->id,'post_as'=>$parent->post_as]);
    }

    public function actionToggleAnswer($id)
    {
        $model = $this->findModel($id);
        $all_answer = Post::find()->where(['post_parent_id'=>$model->post_parent_id])->all();
        foreach($all_answer as $answer)
        {
            $answer->post_status = 0;
            $answer->save(false);
        }
        $model->post_status = $model->post_status == 1 ? 0 : 1;
        $model->save(false);

        return $this->redirect(['view', 'model_id' => $model->post_parent_id, 'id'=>$model->mapelPost->mapel_id,'post_as'=>'Soal']);
    }

    public function actionImport()
    {
        if(isset($_FILES['file']))
        {
            $fileName = $_FILES['file']['tmp_name'];
            $data = \moonland\phpexcel\Excel::import($fileName);
            $data = $data[0];
            $mapel = TblMapel::findOne($_POST['id']);
            $ids = [];
            foreach($mapel->mapelPosts as $mapel_post)
                if($mapel_post->post->post_as == 'Materi')
                    $ids[] = $mapel_post->post_id;

            foreach($data as $d){
                $model = new Post();
                $model->post_author_id = Yii::$app->user->identity->guru_id;
                $model->post_parent_id = $ids[($d['Topik']-1)];
                $model->post_as = 'Soal';
                $model->post_title = $d['Judul'];
                $model->post_content = $d['Deskripsi'];
                $model->post_excerpt = $this->strWordCut($model->post_content,100);
                $model->post_date = strtotime(date("Y-m-d H:i:s"));
                $model->post_modified = strtotime(date("Y-m-d H:i:s"));
                if($model->save(false)) 
                {
                    $mapelPost = new MapelPost;
                    $mapelPost->mapel_id = $_POST['id'];
                    $mapelPost->post_id = $model->id;
                    $mapelPost->save();

                    $jawaban = new Post;
                    $jawaban->post_parent_id = $model->id;
                    $jawaban->post_as = 'Jawaban';
                    $jawaban->post_author_id = Yii::$app->user->identity->guru_id;
                    $jawaban->post_title = $d['Jawaban A'];
                    $jawaban->post_content = $d['Jawaban A'];
                    $jawaban->post_excerpt = $this->strWordCut($model->post_content,100);
                    $post_status = $d['Jawaban Benar'] === 'A' ? 1 : 0;
                    $jawaban->post_status = $post_status;
                    $jawaban->save(false);

                    $jawaban = new Post;
                    $jawaban->post_parent_id = $model->id;
                    $jawaban->post_as = 'Jawaban';
                    $jawaban->post_author_id = Yii::$app->user->identity->guru_id;
                    $jawaban->post_title = $d['Jawaban B'];
                    $jawaban->post_content = $d['Jawaban B'];
                    $jawaban->post_excerpt = $this->strWordCut($model->post_content,100);
                    $post_status = $d['Jawaban Benar'] === 'B' ? 1 : 0;
                    $jawaban->post_status = $post_status;
                    $jawaban->save(false);

                    $jawaban = new Post;
                    $jawaban->post_parent_id = $model->id;
                    $jawaban->post_as = 'Jawaban';
                    $jawaban->post_author_id = Yii::$app->user->identity->guru_id;
                    $jawaban->post_title = $d['Jawaban C'];
                    $jawaban->post_content = $d['Jawaban C'];
                    $jawaban->post_excerpt = $this->strWordCut($model->post_content,100);
                    $post_status = $d['Jawaban Benar'] === 'C' ? 1 : 0;
                    $jawaban->post_status = $post_status;
                    $jawaban->save(false);

                    $jawaban = new Post;
                    $jawaban->post_parent_id = $model->id;
                    $jawaban->post_as = 'Jawaban';
                    $jawaban->post_author_id = Yii::$app->user->identity->guru_id;
                    $jawaban->post_title = $d['Jawaban D'];
                    $jawaban->post_content = $d['Jawaban D'];
                    $jawaban->post_excerpt = $this->strWordCut($model->post_content,100);
                    $post_status = $d['Jawaban Benar'] === 'D' ? 1 : 0;
                    $jawaban->post_status = $post_status;
                    $jawaban->save(false);

                    $jawaban = new Post;
                    $jawaban->post_parent_id = $model->id;
                    $jawaban->post_as = 'Jawaban';
                    $jawaban->post_author_id = Yii::$app->user->identity->guru_id;
                    $jawaban->post_title = $d['Jawaban E'];
                    $jawaban->post_content = $d['Jawaban E'];
                    $jawaban->post_excerpt = $this->strWordCut($model->post_content,100);
                    $post_status = $d['Jawaban Benar'] === 'E' ? 1 : 0;
                    $jawaban->post_status = $post_status;
                    $jawaban->save(false);
                }
            }
            return $this->redirect(['index', 'id'=>$_POST['id'],'PostSearch[post_as]'=>'Soal']);
        }
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    function topik($id)
    {
        $topik = TblMapel::findOne($id);
        $ids = [];
        foreach($topik->mapelPosts as $mapel_post)
            if($mapel_post->post->post_as == 'Materi')
                $ids[] = $mapel_post->post_id;
        $mapel = Post::find()->where(['in','id',$ids])->orderBy(['post_order'=>SORT_ASC])->all();
        $_mapel = [];
        foreach($mapel as $key => $val)
        {
            $_mapel[] = [
                'id' => $val->id,
                'post_title' => ++$key.'. '.$val->post_title
            ];
        }
        return ArrayHelper::map($_mapel,'id','post_title');
    }

    function strWordCut($string,$length,$end='....')
    {
        $string = strip_tags($string);

        if (strlen($string) > $length) {

            // truncate string
            $stringCut = substr($string, 0, $length);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).$end;
        }
        return $string;
    }

    function actionImageUpload()
    {
        if(isset($_FILES['upload']['name']))
        {
            $file = $_FILES['upload']['tmp_name'];
            $file_name = $_FILES['upload']['name'];
            $file_name_array = explode(".", $file_name);
            $extension = end($file_name_array);
            $new_image_name = rand() . '.' . $extension;
            // chmod('uploads', 0777);
            $allowed_extension = array("jpg", "gif", "png");
            if(in_array($extension, $allowed_extension))
            {
                move_uploaded_file($file, 'uploads/' . $new_image_name);
                $function_number = $_GET['CKEditorFuncNum'];
                $post = new Post;
                $post->post_content = 'uploads/' . $new_image_name;
                $post->post_author_id = Yii::$app->user->identity->guru_id;
                $post->post_as = 'Gambar';
                $post->post_type = 'Media';
                $post->save(false);
                $url = Url::to(['uploads/' . $new_image_name]);
                $message = '';
                echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
            }
        }
    }
}
