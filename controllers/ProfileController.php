<?php

namespace app\controllers;

use Yii;

class ProfileController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (!Yii::$app->session->has('username')) {
            return $this->redirect(['login/index']);
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $username = Yii::$app->session->get('username');

        return $this->render('index', [
            'username' => $username
        ]);
    }

}
