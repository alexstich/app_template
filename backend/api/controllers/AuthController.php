<?php

namespace api\controllers;

use Yii;
use api\models\users\forms\LoginForm;
use api\models\users\forms\SignupForm;
use yii\web\UnauthorizedHttpException;
use yii\filters\VerbFilter;
use api\components\BearerAuth;
use api\components\ApiController;
use api\models\users\User;

/**
 * AuthController implements actions for User model.
 */
class AuthController extends ApiController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            'class' => BearerAuth::class,
            'only' => ['logout'],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'login' => ['post'],
                'register' => ['post'],
                'logout' => ['post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Login user
     * @return array
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUser();
        }

        return $this->prepareErrorsResponse($model->getFirstErrors());
    }

    /**
     * Register new user
     * @return array
     */
    public function actionRegister()
    {
        $model = new SignupForm();

        $payload = Yii::$app->request->post();
        $loaded = $model->load($payload, '');
        
        if ($loaded && $user = $model->signup()) {
            return $user;
        }

        if (!$loaded) {
            return $this->prepareErrorsResponse(["Failed to load payload"]);
        }

        return $this->prepareErrorsResponse($model->getFirstErrors());
    }

    /**
     * Logout user
     * @return array
     */
    public function actionLogout()
    {
        if (Yii::$app->user->logout()) {
            return ['success' => true];
        }

        throw new UnauthorizedHttpException('Failed to logout');
    }
} 