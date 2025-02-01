<?php

namespace api\components;

/**
 * Component ApiResponse
 */
class ApiResponse extends \yii\web\Response
{
    /**
     * @inheritDoc
     *
     * @return void|mixed
     */
    public function send()
    {
        if ($this->isSent) {
            return;
        }

        if ($this->getStatusCode() === 424) {

            $data = null;
            $errors = [];
            if (isset($this->data["errors"])) {
                $errors = $this->data["errors"];
                unset($this->data["errors"]);
            }
            if (isset($this->data["data"])) {
                $data = $this->data["data"];
                unset($this->data["data"]);
            }

            $this->setStatusCode(200);
            $this->data = ["status" => "failed", "errors" => $errors, "data" => $data];

        } elseif ($this->getStatusCode() === 200) {

            $this->data = ["status" => "success", "data" => isset($this->data) ? $this->data : null];

        } else if ($this->getStatusCode() !== 200) {

            $message = "";
            if (isset($this->data["message"])) {
                $message = $this->getStatusCode() . ": " . $this->data["message"];
            }

            $this->setStatusCode(200);
            $this->data = ["status" => "error", "message" => $message];
        }

        parent::send();
    }
}