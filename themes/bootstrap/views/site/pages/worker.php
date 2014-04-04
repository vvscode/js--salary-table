<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/controllers/WorkerCtrl.js?001b', CClientScript::POS_HEAD);
$this->pageTitle = 'Страница работника';
?>
<div class="page container" ng-controller="WorkerCtrl">
    <div ng-if="messages.err" class="alert alert-error">
        {{ messages.err }}
        <ul>
            <li ng-repeat="error in messages.listOfErrors">{{ error }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="span5">
     <div class="user-info">
                <h2>Информация о работнике</h2>
                <form class="form-inline worker-form" ng-submit="form.submit()">
                    <input type="hidden" name="id" ng-model="form.data.id" value="{{ form.data.id }}">
                    <div class="form-row">
                        <label for="employee_num">Табельный №:</label>
                        <input name="employee_num" type="text" ng-model="form.data.employee_num"/>
                    </div>
                    <div class="form-row">
                        <label for="nick">Ник:</label>
                        <input name="nick" type="text" ng-model="form.data.nick"/>
                    </div>
                    <div class="form-row">
                        <label for="name">Ф.И.О.:</label>
                        <input name="name" type="text" ng-model="form.data.name"/></div>
                    <div class="form-row">
                        <label for="birthday">День рождения:</label>
                        <input name="birthday" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" placeholder="0000-00-00" ng-model="form.data.birthday"/>
                    </div>
                    <div class="form-row">
                        <label for="date_of_employment">Дата приема на работу:</label>
                        <input name="date_of_employment" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" placeholder="0000-00-00" ng-model="form.data.date_of_employment"/>
                    </div>
                    <div class="form-row">
                        <label for="date_of_contract">Дата окончания контракта:</label>
                        <input name="date_of_contract" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" placeholder="0000-00-00" ng-model="form.data.date_of_contract"/>
                    </div>
                    <div class="form-row">
                        <label for="phone">Телефон:</label>
                        <input name="phone" type="text" ng-model="form.data.phone"/>
                    </div>
                    <div class="form-row">
                        <label for="project_name">Проект:</label>
                        <input name="project_name" type="text" ng-model="form.data.project_name"/>
                    </div>
                    <div class="form-row">
                        <label for="chief">Ник руководителя:</label>
                        <input name="chief" type="text" ng-model="form.data.chief"/>
                    </div>
                    <div class="form-row">
                        <label for="salary">Зарплата:</label>
                        <input name="salary" type="text" ng-disabled="user.data.id" ng-model="form.data.salary"/>
                    </div>
                    <div class="form-row" ng-if="!user.data.id" >
                        <label for="salary">Комментарий:</label>
                        <textarea name="salary" type="text" ng-model="salaryForm.data.comment"></textarea>
                    </div>
                    <div class="form-row button-row" ng-show="form.isDataChanged()">
                        <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i>Сохранить</button>
                        <a href="#" ng-click="form.resetForm($event)" class="btn btn-primary"><i class="icon-ok icon-white"></i>Сбросить</a>
                    </div>
                </form>
                 <div class="form-row button-row" ng-if="form.data.id">
                     <a href="#" class="btn" ng-click="func.deleteWorker(form.data.id, $event);"><i class="icon-remove-sign"></i>Удалить пользователя</a>
                 </div>
            </div>
        </div>
        <div class="span7">
            <div class="user-salaries"  ng-if="user.data.id" >
                <div class="salaries-list">
                    <h2>История изменения зарплат</h2>
                    <form class="form-inline salary-form" ng-submit="salaryForm.submit()">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th class="column-id">ID</th>
                            <th class="column-creator">Создал</th>
                            <th class="column-amount">Сумма</th>
                            <th class="column-date">Дата</th>
                            <th class="column-comment">Комментарий</th>
                            <th class="column-isactive">Активна</th>
                            <th class="column-tools"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr  ng-if="!salaries.list || !salaries.list.length">
                            <td colspan="7">Нет данных</td>
                        </tr>
                        <tr ng-repeat="salary in salaries.list | orderBy: 'date'">
                            <td class="column-id">{{ salary.id }}</td>
                            <td class="column-creator">{{ salary.creator }}</td>
                            <td class="column-amount">{{ salary.amount }}</td>
                            <td class="column-date">{{ salary.date }}</td>
                            <td class="column-comment">{{ salary.comment }}</td>
                            <td class="column-isactive">
                                <input type="checkbox" ng-click="func.setActiveSalary(salary, $event)" ng-checked="salary.is_active == 1" />
                            </td>
                            <td class="column-tools">
                                <a class="btn" ng-click="func.deleteSalary(salary, $event)" href="#" ng-if="salary.is_active != 1">
                                    <i class="icon-trash"></i></a>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class="column-id"><div></div></td>
                            <td class="column-creator">{{ userName }}</td>
                            <td class="column-amount"><div><input required="required"  name="amount" type="text" ng-model="salaryForm.data.amount"/></div></td>
                            <td class="column-date">
                                <div><input required="required"  name="date" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" placeholder="0000-00-00" ng-model="salaryForm.data.date"/></div>
                            </td>
                            <td class="column-comment"><div><textarea required="required"  name="comment" type="text" ng-model="salaryForm.data.comment"></textarea></div></td>
                            <td class="column-isactive"><div></div></td>
                            <td class="column-tools"><button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i></button></td>
                        </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>