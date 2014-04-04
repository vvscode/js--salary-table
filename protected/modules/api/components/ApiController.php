<?php
class ApiController extends Controller
{
    protected $modelName = 'Must be overrided';

    protected $propertiesErrors = array();

    public $defaultAction = 'list';

    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@')
            ),
            array('deny'),
        );
    }

    public function actionList()
    {
        try {
            $models = CActiveRecord::model($this->modelName)->findAll();
        } catch (Exception $e) {
            $this->_sendResponse(501, sprintf('Error: Mode list is not implemented for model %s %s', $this->modelName, $e));
            Yii::app()->end();
        }

        $rows = array();
        if (!empty($models)) {
            foreach ($models as $model) {
                $rows[] = $model->attributes;
            }
        }
        $this->_sendResponse(200, CJSON::encode($rows));
    }

    public function actionView($id = NULL)
    {
        if (!$id)
            $this->_sendResponse(500, 'Error: Parameter id is missing');

        $model = CActiveRecord::model($this->modelName)->findByPk($id);

        if (is_null($model))
            $this->_sendResponse(404, 'No Item found with id ' . $id);
        else
            $this->_sendResponse(200, CJSON::encode($model));
    }

    public function actionCreate()
    {
        try {
            $model = new $this->modelName;
        } catch (Exception $e) {
            $this->_sendResponse(501, sprintf('Mode create is not implemented for model %s', $this->modelName));
        }

        $this->setModelAttributes($model, $this->getBodyVars());
        $this->beforeSaveModel($model, 'CREATE');
        $this->saveModel($model);
    }

    public function actionUpdate($id = NULL)
    {
        $model = CActiveRecord::model($this->modelName)->findByPk($id);

        if ($model === null) {
            $this->_sendResponse(400, sprintf("Error: Didn't find any model %s with ID %s.", $this->modelName, $id));
        }

        $this->setModelAttributes($model, $this->getBodyVars());
        $this->beforeSaveModel($model, 'UPDATE');
        $this->saveModel($model);
    }

    public function actionDelete($id = NULL)
    {
        $model = CActiveRecord::model($this->modelName)->findByPk($id);

        if ($model === null) {
            $this->_sendResponse(400, sprintf("Error: Didn't find any model %s with ID %s.", $this->modelName, $id));
        }

        $num = $model->delete();
        if ($num > 0) {
            $this->_sendResponse(200, $num); //this is the only way to work with backbone
        } else {
            $this->_sendResponse(500, sprintf("Error: Couldn't delete model %s with ID %s.", $this->modelName, $id));
        }
    }

    protected function beforeSaveModel($model, $mode = 'NEW'){
        return $model;
    }

    protected function beforeAction($event)
    {
        $beforeActionName = 'before' . ucfirst($event->getId());
        if (method_exists($this, $beforeActionName)) {
            return $this->$beforeActionName();
        } else {
            return true;
        }
    }

    protected function setModelAttributes($model, $attr)
    {
        $this->propertiesErrors = array();
        foreach ($attr as $var => $value) {
            if ($model->hasAttribute($var)) {
                $model->$var = $value;
            } elseif ($model->canSetProperty($var)) {
                $model->$var = $value;
            } else {
                $this->propertiesErrors[$var] = sprintf('Parameter %s is not allowed for model %s', $var, $this->modelName);
            }
        }
        return $model;
    }

    protected function getBodyVars()
    {
        $post_vars = array();
        $json = file_get_contents('php://input');
        try {
            $post_vars = CJSON::decode($json, true); //true means use associative array
        } catch (Exception $e) {
            if (defined('YII_DEBUG') && YII_DEBUG == true) {
                echo "Error on parsing input body\n";
                echo $e->getCode() . '  ' . $e->getMessage() . "\n";
                print_r($e);
            }
        }
        return $post_vars;
    }

    protected function saveModel($model)
    {
        if (empty($this->propertiesErrors)) {
            if ($model->save()) {
                $this->_sendResponse(200, CJSON::encode($model));
            }
        } else {
            $resp = array();
            $resp['msg'] = sprintf("Error processing '%s'", $this->modelName);
            $resp['errors'] = $this->propertiesErrors;

            $this->_sendResponse(500, CJSON::encode($resp));
        }

        if(!empty($model->errors)){
            $resp = array();
            $resp['msg'] = sprintf("Error processing '%s'", $this->modelName);
            $resp['errors'] = $this->propertiesErrors;
            foreach ($model->errors as $attribute => $attr_errors) {
                $resp['errors'][$attribute] = $attr_errors[0];
            }

            $this->_sendResponse(500, CJSON::encode($resp));
        }
    }

    protected function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
    {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        header($status_header);
        header('Content-type: ' . $content_type);
        if ($body != '') {
            echo $body;
        } else {
            $message = '';
            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }
            // servers don't always have a signature turned on
            // (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templated in a real-world solution
            $body = '<!DOCTYPE html><html><body>
            <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
            <p>' . $message . '</p>
            <address>' . $signature . '</address>
            </body></html>';

            echo $body;
        }
        Yii::app()->end();
    }

    protected function _getStatusCodeMessage($status)
    {
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}