<?php

class UsersController extends ApiController
{
    protected $modelName = 'User';

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