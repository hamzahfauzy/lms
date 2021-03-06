<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use app\models\PostMeta;
use app\models\MapelPost;
use app\models\TblElMapel;
use app\models\TblMapel;
use yii\data\ActiveDataProvider;
use app\components\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class MateriController extends \yii\web\Controller
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
                        'actions' => ['index','view','open'],
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

    public function actionIndex($id)
    {
        $mapel = TblMapel::findOne($id);
        $ids = [];
        foreach($mapel->mapelPosts as $mapel_post)
            if($mapel_post->post->post_as == 'Materi')
                $ids[] = $mapel_post->post_id;

        $query = Post::find()->where(['in','id',$ids])->orderby(['post_order'=>SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'mapel'        => $mapel,
            'mapel_id'     => $id,
            'is_admin'     => $mapel->guru_admin_id == Yii::$app->user->identity->guru_id
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $mapel_id)
    {
        if(isset($_GET['mode']) && $_GET['mode'] == 'ajax')
        {
            $model = Post::find()->where(['post_parent_id'=>$id,'post_as'=>'Sub Materi'])->orderBy(['post_order'=>SORT_ASC])->asArray()->all();
            return json_encode($model);
        }
        $jawabans = Post::find()->where(['post_parent_id'=>$id,'post_as'=>'Sub Materi']);
        $dataProvider = new ActiveDataProvider([
            'query' => $jawabans,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'mapel_id' => $mapel_id,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionOpen($id,$sub_materi=0)
    {
        // $mapel = TblMapel::findOne($id);
        $materi = Post::findOne($id);
        $ids = [];
        $all = $materi->getSubPosts()->where(['post_as'=>'Sub Materi'])->orderBy(['post_order'=>SORT_ASC])->all();
        foreach($all as $sub_post)
            $ids[] = $sub_post->id;

        $model = [];
        $index = $sub_materi-1;
        $next  = isset($ids[$sub_materi]) ? Post::findOne($ids[$sub_materi]) : 0;
        $prev  = isset($ids[$index-1]) ? Post::findOne($ids[$index-1]) : 0;
        if(isset($ids[$index]))
            $model = Post::findOne($ids[$index]);
        
        return $this->render('open', [
            'all'   => $all,
            'model' => $model,
            'sub_materi' => $sub_materi,
            'next' => $next,
            'prev' => $prev,
            'mapel' => $materi->mapelPost->mapel
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionEdit($id)
    {
        $mapel = TblMapel::findOne($id);
        if($mapel->guru_admin_id != Yii::$app->user->identity->guru_id)
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

        $model = TblElMapel::findOne($id);
        if(!$model)
            $model = new TblElMapel;

        $model->mapel_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $id]);
        }

        return $this->render('edit', [
            'model' => $model,
        ]);

    }

    public function actionCreate($mapel_id)
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post();
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_date = strtotime(date("Y-m-d H:i:s"));
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save()) 
            {
                $CategoryPost = new MapelPost;
                $CategoryPost->mapel_id = $request['category'];
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['index', 'id' => $mapel_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'mapel_id' => $mapel_id
        ]);
    }

    public function actionCreateSubMateri($materi_id, $mapel_id)
    {
        $materi = Post::findOne($materi_id);
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post();
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_date = strtotime(date("Y-m-d H:i:s"));
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save()) 
            {
                $CategoryPost = new MapelPost;
                $CategoryPost->mapel_id = $request['category'];
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['index', 'id'=>$mapel_id]);
            }
        }

        return $this->render('create_sub_materi', [
            'model' => $model,
            'mapel_id' => $mapel_id,
            'materi_id' => $materi_id,
            'materi' => $materi,
        ]);
    }

    public function actionUpdateSubMateri($id, $materi_id, $mapel_id)
    {
        $materi = Post::findOne($materi_id);
        $model = Post::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $request = Yii::$app->request->post();
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_date = strtotime(date("Y-m-d H:i:s"));
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save()) 
            {
                $CategoryPost = new MapelPost;
                $CategoryPost->mapel_id = $request['category'];
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['index', 'id'=>$mapel_id]);
            }
        }

        return $this->render('update_sub_materi', [
            'model' => $model,
            'mapel_id' => $mapel_id,
            'materi_id' => $materi_id,
            'materi' => $materi,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $mapel_id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            $request = Yii::$app->request->post();
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save())
                return $this->redirect(['index', 'id' => $mapel_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'mapel_id' => $mapel_id
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $mapel_id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index','id'=>$mapel_id]);
    }

    public function actionRemoveSubMateri($id, $mapel_id)
    {
        $model = $this->findModel($id);
        $materi_id = $model->post_parent_id;
        $model->delete();
        return $this->redirect(['index', 'id'=>$mapel_id]);
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

    function mapel()
    {
        $mapel = Category::find()->all();
        return ArrayHelper::map($mapel,'id','name');
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
