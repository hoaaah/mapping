<?php

namespace app\controllers;

use Yii;
use app\models\RefKegiatan;
use app\models\RefKegiatanLama;
use app\models\RefKegiatanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * KegiatanController implements the CRUD actions for RefKegiatan model.
 */
class KegiatanController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all RefKegiatan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefKegiatanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 100;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            (array) $selections = $post['selection'];
            (int) $kdUbah = $post[$searchModel->formName()]['kd_ubah'];
            $id_lama = $post[$searchModel->formName()]['id_lama'];
            foreach ($selections as $key => $value) {
                $model = $this->findModel($value);
                $model->kd_ubah = $kdUbah;
                if ($id_lama) $model->id_lama = $id_lama;
                $model->save();
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
