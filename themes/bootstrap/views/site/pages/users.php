<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/controllers/UsersListCtrl.js?002b', CClientScript::POS_HEAD);
$this->pageTitle = 'Список пользоателей';
?>
<div class="page" ng-controller="UsersListCtrl">
    <div ng-if="messages.err" class="alert alert-error">
        {{ messages.err }}
        <ul>
            <li ng-repeat="error in messages.listOfErrors">{{ error }}</li>
        </ul>
    </div>
    <h1>Список пользователей</h1>
    <div>
        <div class="user-list">
            <div>
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th class="column-id">ID</th>
                        <th class="column-login">Логин</th>
                        <th class="column-tools"><a href="#" class="btn btn-success" ng-click="func.add()"><i
                                    class="icon-plus icon-white"></i></a></th>
                    </tr>
                    <tr ng-repeat="user in data.users.list">
                        <td class="column-id">{{user.id}}</td>
                        <td class="column-login">
                            <div d
                                 editable-text="user.login"
                                 onbeforesave="func.onBeforeSave($data, 'login', user)"
                                 onhide="func.onHideXEdit()">
                                {{user.login}}
                            </div>
                        </td>
                        <td class="column-tools">
                            <a ng-if="user.login != userName" class="btn btn-inverse" href="#"
                               ng-click="func.delete(user.id)">
                                <i class="icon-trash icon-white"></i>
                            </a>
                            <a  class="btn btn-inverse" href="#"
                               ng-click="func.edit(user)">
                                <i class="icon-pencil icon-white"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="user-form" ng-if="data.showForm">
        <form class="form-inline" ng-submit="form.submit()">
            <table class="table">
                <tr>
                    <td>
                        <span class="badge badge-success" ng-if="!form.userId">Новый</span>
                        <span class="badge badge-info" ng-if="form.userId">{{form.userId}}</span>
                        <input type="hidden" name="id" ng-model="form.userId">
                    </td>
                    <td>
                        <label for="login">Логин:</label>
                        <input type="text" ng-disabled="form.userId" ng-model="form.userLogin" autofocus/>
                    </td>
                    <td>
                        <label for="pass">Пароль:</label>
                        <input type="password" ng-model="form.userPass"/>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary" href="#">
                            <i class="icon-ok icon-white"></i>Сохранить
                        </button>
                        <a ng-click="form.closeForm()" class="btn" href="#">
                            <i class="icon-remove"></i>Отменить</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>