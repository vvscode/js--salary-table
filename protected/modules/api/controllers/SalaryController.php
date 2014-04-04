<?php

class SalaryController extends ApiController
{
    protected $modelName = 'Salary';

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
                'actions' => array('list', 'create', 'view', 'active', 'delete'),
            ),
            array('deny'),
        );
    }

    public function actionList($uid)
    {
        try {
            $models = CActiveRecord::model($this->modelName)->findAllByAttributes(
                array(
                    'worker_id' => $uid,
                    'deleted' => 0
                )
            );
        } catch (Exception $e) {
            $this->_sendResponse(501, sprintf(
                'Error: Mode list is not implemented for model <b>%s</b><br /><i>%s</i>',
                $this->modelName, $e));
            Yii::app()->end();
        }

        $rows = array();
        if (!empty($models)) {
            foreach ($models as $model){
                $rows[] = $model->attributes;
            }
        }
        $this->_sendResponse(200, CJSON::encode($rows));
    }

    protected function beforeSaveModel($model, $mode = 'NEW'){
        if($mode == 'CREATE'){
            // if new date not less then current active
            if( strtotime($model->date) >= strtotime($model->worker->attributes['salary_date'])){
                $model->setAttribute('creator_id', Yii::app()->user->id);
                $model->setAttribute('is_active', true);
            }
        }
        return $model;
    }

    public function actionActive(){
        $post = $this->getBodyVars();
        $resp = array();

        if(!isset($post['id'])){
            $resp['msg'] = 'Invalid action invoke';
            $this->_sendResponse(500, CJSON::encode($resp));
        }

        $model = CActiveRecord::model($this->modelName)->findByAttributes(
            array('id' => $post['id'], 'deleted' => 0)
        );

        if (is_null($model))
            $this->_sendResponse(404, 'No Item found with id ' . $post['id']);

        $model->is_active = true;
        $this->saveModel($model);
    }


}