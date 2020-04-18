<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\TblMapel;
use app\models\TblMapelSearch;
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
                        'actions' => ['index','view'],
                        'allow' => true,
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
        $searchModel = new TblMapelSearch;
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['TblMapelSearch']['guru_admin_id'] = Yii::$app->user->identity->guru_id;
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

    protected function findModel($id)
    {
        if (($model = TblMapel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
