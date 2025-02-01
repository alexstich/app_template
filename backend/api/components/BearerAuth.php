<?php

namespace api\components;

use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;

class BearerAuth extends HttpBearerAuth
{
    /**
     * @inheritdoc
     */
    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
    }
} 