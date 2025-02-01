<?php

namespace api\components;

use yii\rest\Controller;

/**
 * Class ApiController
 * @package api\components
 */
class ApiController extends Controller
{
     /**
     * Return prepared failed response in format [<errors> => [<string>, ...]].
     *
     * Set status HTTP - 424 Method failure - for right processing by Response component.
     *
     * $validationErrors must be given like Model::getErrors() response.
     *
     * $data can be one dimensional array or string or integer.
     *
     * @param array|null $validationErrors  Array of validation errors in [<attribute> => [<error>, ...], ...]  format
     * @param mixed $data                   Some data for special requests
     *
     * @return mixed
     */
    protected function prepareErrorsResponse(array $validationErrors = null, $data = null)
    {
        $response = [];

        \Yii::$app->response->setStatusCode(424);

        if (!empty($validationErrors)) {
            foreach ($validationErrors as $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        if (is_string($error) || is_integer($error)) {
                            $response["errors"][] = $error;
                        }
                    }
                } elseif (is_string($errors) || is_integer($errors)) {
                    $response["errors"][] = $errors;
                }
            }
        }

        if (!empty($data)) {
            $response["data"] = $data;
        }

        return $response;
    }
}