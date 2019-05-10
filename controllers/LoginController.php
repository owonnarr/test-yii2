<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\helpers\AuthHelper;
use Yii;

/**
 * @property AuthHelper $authHelper
 */
class LoginController extends \yii\web\Controller
{
    private $authHelper;

    public function beforeAction($action)
    {
        $this->authHelper = new AuthHelper();

        if ($action->id === 'auth') {
            $this->authHelper->incrementAttempts();
        };

        if (Yii::$app->session->has('username')) {
            return $this->redirect(['profile/index']);
        }


        return parent::beforeAction($action);
    }

    /**
     * show login page
     * @return string
     */
    public function actionIndex()
    {
        $model = new LoginForm();

        if ($this->authHelper->getAttemptCount() > AuthHelper::COUNT_ATTEMPT) {
            $this->authHelper->temporarilyBlock();
            $timeToUnlock = $this->authHelper->getTimeToUnlock();
            return $this->render('index', [
                'model' => $model,
                'time' => $timeToUnlock,
                'blocked' => true
            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'blocked' => false
        ]);
    }

    /**
     *
     * @return \yii\web\Response
     */
    public function actionAuth()
    {
        $model = new LoginForm();

        if (!$model->load(Yii::$app->request->post()) || !$model->validate()) {
            Yii::$app->session->setFlash('error', 'Неправильные логин или пароль');
            return $this->redirect(['index']);
        }

        Yii::$app->session->set('username', $model->username);

        return $this->redirect(['profile/index']);
    }

    /**
     * logout user
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->session->destroy();
        return $this->redirect(['index']);
    }
}
