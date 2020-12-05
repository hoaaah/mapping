<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\KegiatanForm;
use app\models\RefBidang;
use app\models\RefKegiatanLama;
use app\models\RefRek5;
use app\models\RefRek5Lama;
use League\Flysystem\AdapterInterface;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCekKegiatan($kd_urusan = null, $kd_bidang = null, $kd_prog = null, $kd_keg = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $kegiatan = RefKegiatanLama::find()->where("kd_urusan LIKE :kd_urusan AND kd_bidang LIKE :kd_bidang AND kd_prog LIKE :kd_prog AND kd_keg LIKE :kd_keg", [
            ':kd_urusan' => $kd_urusan ?? '%',
            ':kd_bidang' => $kd_bidang ?? '%',
            ':kd_prog' => $kd_prog ?? '%',
            ':kd_keg' => $kd_keg ?? '%',
        ])->all();
        if (!$kegiatan) throw new NotFoundHttpException();

        return $kegiatan;
    }

    public function actionCekRekening($kd_rek_1 = null, $kd_rek_2 = null, $kd_rek_3 = null, $kd_rek_4 = null, $kd_rek_5 = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rekening = RefRek5Lama::find()->where("kd_rek_1 LIKE :kd_rek_1 AND kd_rek_2 LIKE :kd_rek_2 AND kd_rek_3 LIKE :kd_rek_3 AND kd_rek_4 LIKE :kd_rek_4 AND kd_rek_5 LIKE :kd_rek_5", [
            ':kd_rek_1' => $kd_rek_1 ?? '%',
            ':kd_rek_2' => $kd_rek_2 ?? '%',
            ':kd_rek_3' => $kd_rek_3 ?? '%',
            ':kd_rek_4' => $kd_rek_4 ?? '%',
            ':kd_rek_5' => $kd_rek_5 ?? '%',
        ])->all();
        if (!$rekening) throw new NotFoundHttpException();

        return $rekening;
    }

    public function actionUnggahKegiatan()
    {
        $model = new KegiatanForm();

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();
            // return var_dump($image);

            if ($image !== false) {
                Yii::$app->awss3Fs->put($model->pathToFile.$model->file, fopen($image->tempName,'r+'), [
                    'visibility' => AdapterInterface::VISIBILITY_PUBLIC,
                ]);
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 1,
                'message' => 'Upload Success, please wait for a moment.',
                'redirect' => 1,
                'method' => 'POST',
                'redirect' => Url::to(['result-kegiatan', 'id' => $model->file], true)
            ];
            // return $this->redirect(['view', 'id'=>$model->id]);
        }

        return $this->render("kegiatan", ['model' => $model]);
    }

    public function actionResultKegiatan($id){
        
        $model = new KegiatanForm(); 
        $model->find($id);

        $fileNameArray = explode('.', $id);
        $fileExtension = end($fileNameArray);
        $tmpfname = tempnam(sys_get_temp_dir(),  'data');
        $handle = fopen($tmpfname, 'w');
        fwrite($handle, @file_get_contents($model->getImageUrl()));
        fclose($handle);
        $inputFileName = $tmpfname;
        $inputFileType = ucwords($fileExtension);

        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $headings = array_shift($sheetData);
        
        array_walk(
            $sheetData,
            function(&$row) use($headings) {
              $row = array_combine($headings, $row);
            }
        );

        $i = 0;
        /**
         * format array
         * ['kd_urusan' => 1, 'kd_bidang' => 1, 'kd_prog' => 1, 'kd_keg' => 1, 'ket_kegiatan' => 'Keterangan', 'ket' => 'diubah/tambahan']
         */
        $duplicateData = 0;
        $imported = 0;
        $saldoAkhir = 0;
        $dataArray = [];
        foreach($sheetData as $data){
            foreach ($data as $key => $value) {
                // str_replace(' ', '', strtolower($key))
                if(str_replace(' ', '', strtolower($key)) == 'kd_urusan') $kd_urusan = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_bidang') $kd_bidang = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_prog') $kd_prog = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_keg') $kd_keg = $value;
                if(str_replace(' ', '', strtolower($key)) == 'ket_kegiatan') $ket_kegiatan = $value;
            }
            // find duplicate first
            $kegiatanLamaExist = RefKegiatanLama::findOne(['kd_urusan' => $kd_urusan, 'kd_bidang' => $kd_bidang, 'kd_prog' => $kd_prog, 'kd_keg' => $kd_keg]);
            if($kegiatanLamaExist){
                if($kegiatanLamaExist->ket_kegiatan !== $ket_kegiatan) $dataArray[] = ['kd_urusan' => $kd_urusan, 'kd_bidang' => $kd_bidang, 'kd_prog' => $kd_prog, 'kd_keg' => $kd_keg, 'ket_kegiatan' => $ket_kegiatan, 'ket' => 'diubah dari keterangan lama "' . $kegiatanLamaExist->ket_kegiatan .'"'];
            }
            if(!$kegiatanLamaExist){
                $dataArray[] = ['kd_urusan' => $kd_urusan, 'kd_bidang' => $kd_bidang, 'kd_prog' => $kd_prog, 'kd_keg' => $kd_keg, 'ket_kegiatan' => $ket_kegiatan, 'ket' => 'Tambahan'];
            }
            $i++;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $dataArray,
            'pagination' => [
                'pageSize' => 0,
            ],
            'sort' => [
                'attributes' => ['kd_urusan', 'kd_bidang', 'kd_prog', 'kd_keg', 'ket_kegiatan', 'ket'],
            ],
        ]);

        // return var_dump($dataArray);

        return $this->renderAjax("result-kegiatan", ['dataProvider' => $dataProvider]);

        if(Yii::$app->params['useS3FileSystem'] == 'enable') unlink($tmpfname);

    }

    public function actionUnggahRekening()
    {
        $model = new KegiatanForm();

        if ($model->load(Yii::$app->request->post())) {
            // process uploaded image file instance
            $image = $model->uploadImage();
            // return var_dump($image);

            if ($image !== false) {
                Yii::$app->awss3Fs->put($model->pathToFile.$model->file, fopen($image->tempName,'r+'), [
                    'visibility' => AdapterInterface::VISIBILITY_PUBLIC,
                ]);
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'status' => 1,
                'message' => 'Upload Success, please wait for a moment.',
                'redirect' => 1,
                'method' => 'POST',
                'redirect' => Url::to(['result-rekening', 'id' => $model->file], true)
            ];
            // return $this->redirect(['view', 'id'=>$model->id]);
        }

        return $this->render("kegiatan", ['model' => $model]);
    }

    public function actionResultRekening($id){
        
        $model = new KegiatanForm(); 
        $model->find($id);

        $fileNameArray = explode('.', $id);
        $fileExtension = end($fileNameArray);
        $tmpfname = tempnam(sys_get_temp_dir(),  'data');
        $handle = fopen($tmpfname, 'w');
        fwrite($handle, @file_get_contents($model->getImageUrl()));
        fclose($handle);
        $inputFileName = $tmpfname;
        $inputFileType = ucwords($fileExtension);

        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $headings = array_shift($sheetData);
        
        array_walk(
            $sheetData,
            function(&$row) use($headings) {
              $row = array_combine($headings, $row);
            }
        );

        $i = 0;
        /**
         * format array
         * ['kd_urusan' => 1, 'kd_bidang' => 1, 'kd_prog' => 1, 'kd_keg' => 1, 'ket_kegiatan' => 'Keterangan', 'ket' => 'diubah/tambahan']
         */
        $duplicateData = 0;
        $imported = 0;
        $saldoAkhir = 0;
        $dataArray = [];
        foreach($sheetData as $data){
            foreach ($data as $key => $value) {
                // str_replace(' ', '', strtolower($key))
                if(str_replace(' ', '', strtolower($key)) == 'kd_rek_1') $kd_rek_1 = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_rek_2') $kd_rek_2 = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_rek_3') $kd_rek_3 = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_rek_4') $kd_rek_4 = $value;
                if(str_replace(' ', '', strtolower($key)) == 'kd_rek_5') $kd_rek_5 = $value;
                if(str_replace(' ', '', strtolower($key)) == 'nm_rek_5') $nm_rek_5 = $value;
            }
            // find duplicate first
            $rekeningLamaExist = RefRek5Lama::findOne(['kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5]);
            if($rekeningLamaExist){
                if($rekeningLamaExist->nm_rek_5 !== $nm_rek_5) $dataArray[] = ['kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5, 'nm_rek_5' => $nm_rek_5, 'ket' => 'diubah dari keterangan lama "' . $rekeningLamaExist->nm_rek_5 .'"'];
            }
            if(!$rekeningLamaExist){
                $dataArray[] = ['kd_rek_1' => $kd_rek_1, 'kd_rek_2' => $kd_rek_2, 'kd_rek_3' => $kd_rek_3, 'kd_rek_4' => $kd_rek_4, 'kd_rek_5' => $kd_rek_5, 'nm_rek_5' => $nm_rek_5, 'ket' => 'Tambahan'];
            }
            $i++;
        }

        $dataProvider = new ArrayDataProvider([
            'allModels' => $dataArray,
            'pagination' => [
                'pageSize' => 0,
            ],
            'sort' => [
                'attributes' => ['kd_rek_1', 'kd_rek_2', 'kd_rek_3', 'kd_rek_4', 'kd_rek_5', 'nm_rek_5', 'ket'],
            ],
        ]);

        // return var_dump($dataArray);

        return $this->renderAjax("result-rekening", ['dataProvider' => $dataProvider]);

        if(Yii::$app->params['useS3FileSystem'] == 'enable') unlink($tmpfname);

    }

    public function actionBidang()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $bidang = RefBidang::find()->select(['kd_bidang AS id', 'nm_bidang AS name'])->where(['kd_urusan' => $cat_id])->asArray()->all();
                $out = $bidang;
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                return Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected' => '']);
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
        return $this->render('login', [
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
}
