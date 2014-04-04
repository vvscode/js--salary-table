<?php

class WorkersController extends ApiController
{
    protected $modelName = 'Worker';

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
                'actions' => array('list', 'create', 'view', 'update', 'delete'),
            ),
            array('deny'),
        );
    }
}