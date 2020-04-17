<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\User;
use app\models\PostSearch;
use app\models\Category;
use app\models\CategoryPost;
use app\models\CategoryUser;
use yii\data\ActiveDataProvider;
use app\components\AccessRule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
                        'roles' => ['Super Admin','Guru Admin'],
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

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $queryParams = Yii::$app->request->queryParams;
        if(Yii::$app->user->identity->level == 'Super Admin')
            $dataProvider = $searchModel->search($queryParams);
        if(Yii::$app->user->identity->level == 'Guru Admin')
        {
            $queryParams['PostSearch']['post_author_id'] = Yii::$app->user->identity->id;
            $dataProvider = $searchModel->search($queryParams);
        }
        if(Yii::$app->user->identity->level == 'Guru')
        {
            // get guru admin
            $guruMapel = CategoryUser::find()->where(['user_id'=>Yii::$app->user->identity->id])->all();
            $ids = [];
            foreach($guruMapel as $gm)
            {
                // get all mapel
                $CategoryPost = CategoryPost::find()->where(['category_id'=>$gm->category_id])->all();
                foreach($CategoryPost as $category)
                {
                    if($category->post->post_as == 'Soal')
                        $ids[] = $category->post->id;
                }
            }
            $dataProvider = $searchModel->searchIn($ids);
        }

        return $this->render('index', [
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
    public function actionView($id)
    {
        $jawabans = Post::find()->where(['post_parent_id'=>$id,'post_as'=>'Jawaban']);
        $dataProvider = new ActiveDataProvider([
            'query' => $jawabans,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $mapel = $this->mapel();

        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && !empty($request['category'])){
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_date = strtotime(date("Y-m-d H:i:s"));
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save(false)) 
            {
                $CategoryPost = new CategoryPost;
                $CategoryPost->category_id = $request['category'];
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['view', 'id' => $model->id,'post_as'=>$model->post_as]);
            }
        }

        return $this->render('create', [
            'model' => $model,
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $mapel = $this->mapel();

        $request = Yii::$app->request->post();
        if ($model->load(Yii::$app->request->post()) && !empty($request['category'])){
            $model->post_excerpt = $this->strWordCut($model->post_content,100);
            $model->post_modified = strtotime(date("Y-m-d H:i:s"));
            if($model->save(false))
            {
                CategoryPost::deleteAll(['post_id'=>$model->id]);

                $CategoryPost = new CategoryPost;
                $CategoryPost->category_id = $request['category'];
                $CategoryPost->post_id = $model->id;
                $CategoryPost->save();
                return $this->redirect(['view', 'id' => $model->id, 'post_as' => $model->post_as]);
            }
        }

        return $this->render('update', [
            'model' => $model,
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
                return $this->redirect(['view', 'id' => $model->id, 'post_as' => $model->post_as]);
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
                return $this->redirect(['view', 'id' => $model->id, 'post_as' => $model->post_as]);
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
        $model->delete();

        return $this->redirect(['index','PostSearch[post_as]'=>$post_as]);
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

        return $this->redirect(['view','id'=>$model->post_parent_id,'post_as'=>'Soal']);
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
        if(Yii::$app->user->identity->level != 'Super Admin')
        {
            $categoryUser = CategoryUser::find()->where(['user_id'=>Yii::$app->user->identity->id])->all();
            $ids = [];
            foreach($categoryUser as $category)
                $ids[] = $category->category_id;
            
            $mapel = Category::find()->where(['in','id',$ids])->all();
        }
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
}