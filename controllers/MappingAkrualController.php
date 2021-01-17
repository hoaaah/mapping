<?php

namespace app\controllers;

use app\models\ModulesFactory;
use app\models\RefAkrual5;
use Yii;
use app\models\RefAkrualRek;
use app\models\RefAkrualRekSearch;
use app\models\RefRek5;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Response;
use app\models\RefRek5Search;
use yii\helpers\ArrayHelper;

/**
 * MappingAkrualController implements the CRUD actions for RefAkrualRek model.
 */
class MappingAkrualController extends Controller
{

    private $_menu;
    private $_tahun;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionRekAkrualList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {

            $query = Yii::$app->db->createCommand("
                SELECT * FROM
                (
                    SELECT
                    CONCAT(kd_akrual_1, '.', kd_akrual_2, '.', kd_akrual_3, '.', kd_akrual_4, '.', kd_akrual_5) AS id, 
                    CONCAT(kd_akrual_1, '.', kd_akrual_2, '.', kd_akrual_3, '.', kd_akrual_4, '.', kd_akrual_5, ' ', nm_akrual_5) AS text
                    FROM ref_akrual_5
                ) a 
                WHERE text LIKE :q
            ", [':q' => "%{$q}%"]);
            $data = $query->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            list($kd_akrual_1, $kd_akrual_2, $kd_akrual_3, $kd_akrual_4, $kd_akrual_5) = explode('.', $id);
            $out['results'] = ['id' => $id, 'text' => RefAkrual5::findOne(['kd_akrual_1' => $kd_akrual_1, 'kd_akrual_2' => $kd_akrual_2, 'kd_akrual_3' => $kd_akrual_3, 'kd_akrual_4' => $kd_akrual_4, 'kd_akrual_5' => $kd_akrual_5])->nm_akrual_5];
        }
        return $out;
    }

    /**
     * Lists all RefAkrualRek models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RefRek5Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 50;

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            // return var_dump($post);
            (array) $selections = $post['selection'];
            $kodeAkrual = $post[$searchModel->formName()]['kode_akrual'];
            list($kd_akrual_1, $kd_akrual_2, $kd_akrual_3, $kd_akrual_4, $kd_akrual_5) = explode('.', $kodeAkrual);
            // $kdUjung = $post[$searchModel->formName()]['kd_ujung'];
            // $id_lama = $post[$searchModel->formName()]['id_lama'];
            foreach ($selections as $key => $value) {
                $refRek5 = RefRek5::findOne(['id' => $value]);
                $refAkrualRek = RefAkrualRek::findOne([
                    'kd_rek_1' => $refRek5->kd_rek_1,
                    'kd_rek_2' => $refRek5->kd_rek_2,
                    'kd_rek_3' => $refRek5->kd_rek_3,
                    'kd_rek_4' => $refRek5->kd_rek_4,
                    'kd_rek_5' => $refRek5->kd_rek_5
                ]);
                if (!$refAkrualRek) $refAkrualRek = new RefAkrualRek([
                    'kd_rek_1' => $refRek5->kd_rek_1,
                    'kd_rek_2' => $refRek5->kd_rek_2,
                    'kd_rek_3' => $refRek5->kd_rek_3,
                    'kd_rek_4' => $refRek5->kd_rek_4,
                    'kd_rek_5' => $refRek5->kd_rek_5
                ]);
                $refAkrualRek->setAttributes([
                    'kd_akrual_1' => $kd_akrual_1,
                    'kd_akrual_2' => $kd_akrual_2,
                    'kd_akrual_3' => $kd_akrual_3,
                    'kd_akrual_4' => $kd_akrual_4,
                    'kd_akrual_5' => $kd_akrual_5
                ]);
                $refAkrualRek->save(false);
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tahun' => $this->_tahun,
        ]);
    }

    /**
     * Displays a single RefAkrualRek model.
     * @param integer $kd_rek_1
     * @param integer $kd_rek_2
     * @param integer $kd_rek_3
     * @param integer $kd_rek_4
     * @param integer $kd_rek_5
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = $this->findModel($id);

        $return = $this->{$render}('view', [
            'model' => $model,
        ]);

        if ($request->isAjax) return [
            'title' => "RefAkrualRek #" . $model->kd_rek_1,
            'content' => $return,
            'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"])
        ];

        return $return;
    }

    /**
     * Creates a new RefAkrualRek model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $render = 'render';

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $model = new RefAkrualRek();

        $return = $this->{$render}('_form', [
            'model' => $model,
        ]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return 1;
            } else {
                $return = "";
                if ($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        }
        if ($request->isAjax) return [
            'title' => "Tambah Data",
            'content' => $return,
            'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"])
        ];
        return $return;
    }

    /**
     * Updates an existing RefAkrualRek model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $kd_rek_1
     * @param integer $kd_rek_2
     * @param integer $kd_rek_3
     * @param integer $kd_rek_4
     * @param integer $kd_rek_5
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $render = 'render';

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $render = 'renderAjax';
        }

        $queryRefAkrual5 = RefAkrual5::find()
            ->where('1 = 0')
            ->all();
        $refAkrual5ArrayList = ArrayHelper::map($queryRefAkrual5, 'rek5Code', 'rek5TextWithCode');

        $refRek5 = RefRek5::findOne(['id' => $id]);
        $kd_rek_1 = $refRek5->kd_rek_1;
        $kd_rek_2 = $refRek5->kd_rek_2;
        $kd_rek_3 = $refRek5->kd_rek_3;
        $kd_rek_4 = $refRek5->kd_rek_4;
        $kd_rek_5 = $refRek5->kd_rek_5;

        $rekAkrual1 = $rekAkrual2 = $rekAkrual3 = '%';

        if (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.6') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 3;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2) == '6.1') {
            $rekAkrual1 = 7;
            $rekAkrual2 = 1;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2) == '6.2') {
            $rekAkrual1 = 7;
            $rekAkrual2 = 2;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.7') {
            $rekAkrual1 = 6;
            $rekAkrual2 = 1;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.8') {
            $rekAkrual1 = 6;
            $rekAkrual2 = 2;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.2') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 1;
            $rekAkrual3 = 3;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.3') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 1;
            $rekAkrual3 = 4;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.4') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 1;
            $rekAkrual3 = 5;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.1.5') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 1;
            $rekAkrual3 = 3;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.2.1') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 1;
            $rekAkrual3 = 2;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.2.2') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 2;
            $rekAkrual3 = 1;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.2.3') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 2;
            $rekAkrual3 = 2;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.2.4') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 2;
            $rekAkrual3 = 3;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.2.5') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 2;
            $rekAkrual3 = 4;
        } elseif (($kd_rek_1 . '.' . $kd_rek_2 . '.' . $kd_rek_3) == '5.2.6') {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = 2;
            $rekAkrual3 = 5;
        } else {
            $rekAkrual1 = $kd_rek_1;
            $rekAkrual2 = $kd_rek_2;
        }

        $refAkrualQuery = Yii::$app->db->createCommand("
            SELECT
            a.kd_akrual_1, a.kd_akrual_2, a.kd_akrual_3, a.kd_akrual_4, a.kd_akrual_5,
            CONCAT(a.kd_akrual_1, '.', a.kd_akrual_2, '.', a.kd_akrual_3, '.', a.kd_akrual_4, '.', a.kd_akrual_5) AS rek5Code,
            CONCAT(a.kd_akrual_1, '.', a.kd_akrual_2, '.', a.kd_akrual_3, '.', a.kd_akrual_4, '.', a.kd_akrual_5, ' ', b.nm_akrual_4, ' - ', a.nm_akrual_5) AS rek5TextWithCode
            FROM ref_akrual_5 a
            LEFT JOIN ref_akrual_4 b ON 
            a.kd_akrual_1 = b.kd_akrual_1 AND
            a.kd_akrual_2 = b.kd_akrual_2 AND
            a.kd_akrual_3 = b.kd_akrual_3 AND
            a.kd_akrual_4 = b.kd_akrual_4
            WHERE a.kd_akrual_1 LIKE :rekAkrual1
            AND a.kd_akrual_2 LIKE :rekAkrual2
            AND a.kd_akrual_3 LIKE :rekAkrual3
        ", [
            ':rekAkrual1' => $rekAkrual1,
            ':rekAkrual2' => $rekAkrual2,
            ':rekAkrual3' => $rekAkrual3
        ])->queryAll();
        $refAkrualList = ArrayHelper::map($refAkrualQuery, 'rek5Code', 'rek5TextWithCode');

        $model = RefAkrualRek::findOne(['kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5]);
        if (!$model) $model = new RefAkrualRek(['kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5]);

        $return = $this->{$render}('_form', [
            'model' => $model,
            'refAkrual5ArrayList' => $refAkrual5ArrayList,
            'refAkrualList' => $refAkrualList
        ]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return 1;
            } else {
                $return = "";
                if ($model->errors) $return .= $this->setErrorMessage($model->errors);
                return $return;
            }
        }
        if ($request->isAjax) return [
            'title' => "Mapping #",
            'content' => $return,
            'footer' => Html::button('Close', ['class' => 'btn btn-secondary float-left', 'data-dismiss' => "modal"])
        ];
        return $return;
    }

    public function actionRekeningAkrual($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = RefAkrual5::find()->where("nm_akrual_5 LIKE '%:q%'", [':q' => $q])->all();
            $data = ArrayHelper::map($query, 'rek5Code', 'rek5TextWithCode');
            // $query = new Query;
            // $query->select('id, name AS text')
            //     ->from('city')
            //     ->where(['like', 'name', $q])
            //     ->limit(20);
            // $command = $query->createCommand();
            // $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => RefAkrual5::find($id)->name];
        }
        return $out;
    }

    /** 
     * when errors happened at actionCreate or actionUpdate
     * this function will return every error 
     */
    protected function setErrorMessage($errors)
    {
        $return = "";
        foreach ($errors as $key => $data) {
            $return .= $key . ": " . $data['0'] . '<br>';
        }
        return $return;
    }

    // /**
    //  * Deletes an existing RefAkrualRek model.
    //  * If deletion is successful, the browser will be redirected to the 'index' page.
    //  * @param integer $kd_rek_1
    //  * @param integer $kd_rek_2
    //  * @param integer $kd_rek_3
    //  * @param integer $kd_rek_4
    //  * @param integer $kd_rek_5
    //  * @return mixed
    //  */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(Yii::$app->request->referrer);
    // }

    /**
     * Finds the RefAkrualRek model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $kd_rek_1
     * @param integer $kd_rek_2
     * @param integer $kd_rek_3
     * @param integer $kd_rek_4
     * @param integer $kd_rek_5
     * @return RefAkrualRek the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $refRek5 = RefRek5::findOne(['id' => $id]);
        $kd_rek_1 = $refRek5->kd_rek_1;
        $kd_rek_2 = $refRek5->kd_rek_2;
        $kd_rek_3 = $refRek5->kd_rek_3;
        $kd_rek_4 = $refRek5->kd_rek_4;
        $kd_rek_5 = $refRek5->kd_rek_5;
        if (($model = RefAkrualRek::findOne(['kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
