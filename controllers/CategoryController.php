<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Category;
use app\models\CategorySearch;
use app\models\CategoryUser;
use app\models\CategoryUserSearch;
use app\components\AccessRule;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                        'roles' => ['Super Admin'],
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                        'roles' => ['Guru','Guru Admin'],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $mapels = [];
        
        $searchModel = new CategorySearch;
        $queryParams = Yii::$app->request->queryParams;
        if(Yii::$app->user->identity->level != 'Super Admin')
        {
            $searchModel = new CategoryUserSearch;
            $queryParams['CategoryUserSearch']['user_id'] = Yii::$app->user->identity->id;
        }
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->pagination = ['pageSize' => 10];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $categoryUser = CategoryUser::find()->where(['category_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $categoryUser,
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAssign($id)
    {
        $model = $this->findModel($id);
        $category_user = new CategoryUser;
        $all_guru = User::find()->where(['LIKE','level','Guru'])->all();
        $all_guru = ArrayHelper::map($all_guru,'id','username');

        if ($category_user->load(Yii::$app->request->post()) && $category_user->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('assign', [
            'model' => $model,
            'category_user' => $category_user,
            'all_guru' => $all_guru
        ]);
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRemoveAssign($id, $cat_user)
    {
        CategoryUser::findOne($cat_user)->delete();

        return $this->redirect(['view','id'=>$id]);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
