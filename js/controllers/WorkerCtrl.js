salaryTableApp.controller('WorkerCtrl',
    [
        '$scope', 'Workers', 'Salary',  '$q', '$location', '$log',
        function($scope, Workers, Salary, $q, $location, $log) {
            $scope.userId = $location.search().id;
            if($scope.userId == 'new'){
                $scope.userId = null;
            }
            $scope.errorMsg = "";
            $scope.form = {};
            $scope.func = {};
            $scope.messages = {};
            $scope.salaries = {};
            $scope.userName = salaryTableApp.userName;

            var d = new Date;
            var m = d.getMonth() + 1;
            $scope.currentDate = [
                d.getFullYear(),
                m < 10? "0" + m: m,
                d.getDate()
            ].join('-');

            $scope.salaryForm = { data: { date: $scope.currentDate}};

            $scope.user = {};



            var updateUserInfo = function(){
                if($scope.userId){
                    $scope.user = Workers.get(
                        $scope.userId,
                        function(data){
                            $log.info('Get user info', data);
                            $scope.form.data = angular.copy(data);
                            $scope.func.clearError();
                        },
                        function(data){
                            $log.error('error on get user info', arguments);
                            $scope.func.processError('Error on get user info', data);
                        }
                    );

                    $scope.salaries = Salary.get(
                        $scope.userId,
                        function(){
                            $log.info('get user salaries', arguments);
                        },
                        function(){
                            $log.error('Error get user salaries', arguments);
                        }
                    );
                }
            }

            updateUserInfo();

            $scope.func.clearError = function(){
                $scope.messages = {};
            }

            $scope.func.setActiveSalary = function(sal, $event){
                if($event && $event.preventDefault){
                    $event.preventDefault();
                }

                Salary.setActive(sal,
                    function(){
                        $scope.user.data.salary = sal.amount;
                        $scope.form.data.salary = sal.amount;
                        $log.info('Активная ЗП изменена',arguments);
                    },
                    function(){
                        $log.error('Ошибка смены активной зп',arguments);
                    });

                return false;
            }


            $scope.func.deleteSalary = function(sal, $event){
                if($event && $event.preventDefault){
                    $event.preventDefault();
                }
                if(confirm("Вы уверены, что хотите удалить эту запись?")){
                    Salary.delete(sal);
                }
            }

            $scope.func.deleteWorker = function(id, $event){
                if($event && $event.preventDefault){
                    $event.preventDefault();
                }
                if(confirm("Вы уверены, что хотите удалить этого пользователя?")){
                    Workers.delete(
                        {id: id},
                        function(){
                            window.location.href =  'workers';
                        },
                        function(data){
                            $log.error('Error on delete worker', arguments);
                        }
                    );
                }
            }

            $scope.func.processError = function(text, data){
                if(data.errors){
                    $scope.messages.listOfErrors = [];
                    angular.forEach(data.errors, function(val, key, list){
                        $scope.messages.listOfErrors.push(val);
                    });
                }
                var err = text || data.msg || 'Error on data processing';
                $scope.messages.err = err;
            }

            $scope.form.isDataChanged = function(){
                return !angular.equals($scope.form.data, $scope.user.data);
            }

            $scope.form.resetForm = function($event){
                $scope.form.data = angular.copy($scope.user.data);
                $event.preventDefault();
                $scope.func.clearError();
            }

            $scope.form.submit = function(){
                var opt = {};
                angular.forEach($scope.form.data, function(val, key){
                    opt[key] = val;
                });

                if(opt.id){
                    Workers.update(opt, function(data){
                        $scope.func.clearError();
                        $scope.user.data = data;
                    }, function(data){
                        $scope.func.processError('', data);
                    });
                } else {
                    var salary = parseInt(opt.salary);

                    Workers.create(opt, function(data){
                        $scope.func.clearError();
                        $scope.form.data = $scope.user.data = data;
                        $scope.userId = data.id;
                        window.location.hash = "#/?id=" + data.id;

                        // If salary set on creation user - add item to salaries table
                        if(salary){
                            $scope.salaryForm.data = {
                                amount: salary,
                                date: $scope.form.data.date_of_employment || $scope.currentDate,
                                comment: $scope.salaryForm.data.comment || '--'
                            }
                            $scope.salaryForm.submit();
                        }

                    }, function(data){
                        $scope.func.processError('', data);
                    });
                }
            }

            $scope.salaryForm.submit = function(){
                var opt = {};
                angular.forEach($scope.salaryForm.data, function(val, key){
                    opt[key] = val;
                });

                opt.worker_id = $scope.userId;

                Salary.create(
                    opt,
                    function(){
                        updateUserInfo();
                        $scope.salaryForm.data = { date: $scope.currentDate};
                        $scope.func.clearError();
                    }, function(){
                        $log.error('Error on adding salary', arguments);
                        $scope.func.processError('Error on adding salary', arguments);
                    }
                )

            }
        }
    ]
);