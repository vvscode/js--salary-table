<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/controllers/WorkersListCtrl.js?002b', CClientScript::POS_HEAD);
$this->pageTitle = 'Список работников';

?>

<div class="page" ng-controller="WorkersListCtrl">
    <div class="messages">
        <div ng-if="messages.err" class="alert alert-error">
            {{ messages.err }}
            <ul>
                <li ng-repeat="error in messages.listOfErrors">{{ error }}</li>
            </ul>
        </div>
        <div ng-if="messages.success" class="alert alert-success">
            {{ messages.success }}
        </div>
    </div>
    <h1>Список сотрудников</h1>


    <div>
        <div class="worker-list">
            <div class="table-head">
                <table class="table table-hover table-bordered table-striped table-header">
                    <thead>
                    <tr>
                        <th class="column-num">№</th>
                        <th class="column-nick">Ник</th>
                        <th class="column-name">Ф.И.О.</th>
                        <th class="column-birthday">Дата<br />рождения</th>
                        <th class="column-employment-date">Дата<br />принятия на работу</th>
                        <th class="column-contract-date">Дата<br />окончания контракта</th>
                        <th class="column-phone">Телефон</th>
                        <th class="column-project">Проект</th>
                        <th class="column-chief">Ник руководителя</th>
                        <th class="column-salary">Зарплата</th>
                        <th class="column-comment">Комментарий</th>
                        <th class="column-tools"><div></div></th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr ng-class="!!data.workers.list.length? '': 'empty-list'">
                            <td class="column-num"><div><input ng-model="filter.num" type="text" /></div></td>
                            <td class="column-nick"><div><input ng-model="filter.nick" type="text" /></div></td>
                            <td class="column-name"><div><input ng-model="filter.name" type="text" /></div></td>
                            <td class="column-birthday"><div><input ng-model="filter.birthday" type="text" /></div></td>
                            <td class="column-employment-date"><div><input ng-model="filter.employmentDay" type="text" /></div></td>
                            <td class="column-contract-date"><div><input ng-model="filter.contractDay" type="text" /></div></td>
                            <td class="column-phone"><div><input ng-model="filter.phone" type="text" /></div></td>
                            <td class="column-project"><div><input ng-model="filter.project" type="text" /></div></td>
                            <td class="column-chief"><div><input ng-model="filter.chief" type="text" /></div></td>
                            <td class="column-salary"><div><input ng-model="filter.salary" type="text" /></div></td>
                            <td class="column-comment"><div><input ng-model="filter.comment" type="text" /></div></td>
                            <td class="column-tools"><div></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div ng-if="data.workers.list.length" class="table-body">
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="column-num"></th>
                        <th class="column-nick"></th>
                        <th class="column-name"></th>
                        <th class="column-birthday"></th>
                        <th class="column-employment-date"></th>
                        <th class="column-contract-date"></th>
                        <th class="column-phone"></th>
                        <th class="column-project"></th>
                        <th class="column-chief"></th>
                        <th class="column-salary"></th>
                        <th class="column-comment"></th>
                        <th class="column-tools"><a href="#" class="btn btn-success" ng-click="func.add()"><i
                                    class="icon-plus icon-white"></i></a></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="worker in data.workers.list | filter: {
                            employee_num: filter.num,
                            nick: filter.nick,
                            name: filter.name,
                            birthday: filter.birthday,
                            date_of_contract:filter.contractDay,
                            date_of_employment:filter.employmentDay,
                            phone: filter.phone,
                            project_name:
                            filter.project,
                            chief:filter.chief,
                            salary: filter.salary,
                            salary_comment: filter.comment
                            } | orderBy:'_internal_employee_num'">
                        <td class="column-num">
                            <div editable-text="worker.employee_num" onbeforesave="func.onBeforeSave($data, 'employee_num', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.employee_num || "---"}}
                            </div></td>
                        <td class="column-nick">
                            <div editable-text="worker.nick" onbeforesave="func.onBeforeSave($data, 'nick', worker)"
                                 onhide="func.onHideXEdit()" blur="submit"
                                >
                                {{worker.nick || "---"}}
                            </div>
                        </td>
                        <td class="column-name">
                            <div editable-text="worker.name" onbeforesave="func.onBeforeSave($data, 'name', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.name || "---"}}
                            </div>
                        </td>
                        <td class="column-birthday">
                            <div editable-text="worker.birthday"
                                 e-pattern="\d{4}-\d{1,2}-\d{1,2}"
                                 e-placeholder="0000-00-00"
                                 onbeforesave="func.onBeforeSave($data, 'birthday', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.birthday || "---"}}
                            </div>
                        </td>
                        <td class="column-employment-date">
                            <div editable-text="worker.date_of_employment"
                                 e-pattern="\d{4}-\d{1,2}-\d{1,2}"
                                 e-placeholder="0000-00-00"
                                 onbeforesave="func.onBeforeSave($data, 'date_of_contract', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.date_of_employment || "---"}}
                            </div>
                        </td>
                        <td class="column-contract-date">
                            <div editable-text="worker.date_of_contract"
                                 e-pattern="\d{4}-\d{1,2}-\d{1,2}"
                                 e-placeholder="0000-00-00"
                                 onbeforesave="func.onBeforeSave($data, 'date_of_contract', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.date_of_contract || "---"}}
                            </div>
                        </td>
                        <td class="column-phone">
                            <div editable-text="worker.phone" onbeforesave="func.onBeforeSave($data, 'phone', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.phone || "---"}}
                            </div>
                        </td>
                        <td class="column-project">
                            <div editable-text="worker.project_name"
                                 onbeforesave="func.onBeforeSave($data, 'project_name', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.project_name || "---"}}
                            </div>
                        </td>
                        <td class="column-chief">
                            <div editable-text="worker.chief" onbeforesave="func.onBeforeSave($data, 'chief', worker)"
                                 onhide="func.onHideXEdit()" blur="submit">
                                {{worker.chief || "---"}}
                            </div>
                        </td>
                        <td class="column-salary"><a
                                href="<?php echo $this->createUrl('site/page', array('view' => 'worker')); ?>#/?id={{ worker.id }}">{{worker.salary}}</a>
                        </td>
                        <td class="column-comment">
                            <a
                                href="<?php echo $this->createUrl('site/page', array('view' => 'worker')); ?>#/?id={{ worker.id }}">{{ worker.salary_comment }}</a>
                        </td>
                        <td class="column-tools">
                            <div>
                                <a class="btn" title="История" href="<?php echo $this->createUrl('site/page', array('view' => 'worker')); ?>#/?id={{ worker.id }}"><i class="icon-time"></i></a>
                            </div>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
            <div ng-if="!data.workers.list.length" class="table-body-nodata">
                Нет данных
            </div>
        </div>
        <div class="commands-row">
            <a href="<?php echo $this->createUrl('site/page', array('view' => 'worker')); ?>#/?id=new" class="btn btn-success"<i                    class="icon-plus icon-white"></i>Добавить нового</a>
        </div>
    </div>

</div>
