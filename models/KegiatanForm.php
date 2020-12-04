<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * ContactForm is the model behind the contact form.
 */
class KegiatanForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    public $image;
    public $uploadPath;
    public $uploadUrl;
    public $basePathToFile;
    public $file;
    public $filename;

    public function init() {
        parent::init();
        $this->basePathToFile = 'mapping/';
        $this->uploadPath = Yii::getAlias('@webroot'). '/uploads/'.$this->basePathToFile;
        $this->uploadUrl = Yii::$app->urlManager->baseUrl .'/uploads/'.$this->basePathToFile;
    }    

    public function find($id)
    {
        $this->file = $id;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            // [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            // ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],

            // [['tahun', 'tabel_id'], 'required'],
            [['image'], 'safe'],
            [['image'], 'file', 'extensions'=>'csv'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
            'image' => 'File CSV'
        ];
    }


    /**
     * pathToFile are used when useS3FS enable
     */
    public function getPathToFile()
    {
        return $this->setPathToFile();
    }

    public function setPathToFile()
    {
        return $this->basePathToFile;
    }

    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        $file = @fopen($this->getImageUrl(), 'r');
        return isset($this->file) ? $file : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        if($this->file) return env('S3_BASE_URL'). '/' . $this->pathToFile  . $this->file;
    }

    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->filename = $image->name;
        $fileName = explode(".", $image->name);
        $ext = end($fileName);

        // generate a unique file name
        $this->file = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }

    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        Yii::$app->awss3Fs->delete($this->pathToFile .$this->file);
       
        // if deletion successful, reset your file attributes
        $this->file = null;
        $this->filename = null;
        $this->save();

        return true;
    }   
}
