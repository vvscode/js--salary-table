salaryTableApp.controller('WorkersListCtrl',['$scope', 'Workers', '$q', '$log', '$timeout', function($scope, Workers, $q, $log, $timeout) {
    $scope.data = {};
    $scope.form = {data:{}};
    $scope.func = {};
    $scope.messages = {};
    $scope.filter = {};
    $scope.data.workers = Workers;
    $scope.data.showForm = false;
    $scope.data.workers.list = Workers.getList();
    $scope.data.workers.filteredList = [];

    $scope.messagesTimeout;
    $scope.$watch(function(){
        return $scope.messages;
    }, function(){
        if($scope.messagesTimeout && $scope.messagesTimeout.cancel){
            $scope.messagesTimeout.cancel();
        }

        $scope.messagesTimeout = $timeout(function(){
            $scope.func.clearMessages();
        }, 2000);

    }, true);



    $scope.form.submit = function(){
        var opt = {};
        angular.forEach($scope.form.data, function(val, key){
           opt[key] = val;
        });

        Workers.create(opt, function(){
            $scope.form.closeForm();
        }, function(data){
            $scope.func.processError(data);
        });
    }

    $scope.form.closeForm = function(){
        $scope.form.data = {};
        delete($scope.data.showForm);
        $scope.func.clearMessages();
    }

    $scope.func.add = function(){
        $scope.form.data = {};
        $scope.data.showForm = true;
    }

    $scope.func.delete = function(id){
        Workers.delete({ id: id });
        $scope.form.closeForm();
    }

    $scope.func.edit = function(user){
        $scope.form.userId = user.id;
        $scope.form.userLogin = user.login;
        $scope.form.userPass = user.hash;
        $scope.data.showForm = true;
    }

    $scope.func.onBeforeSave = function(newVal, fieldName, user){
        var d = $q.defer();

        var data = {id: user.id};
        data[fieldName] = newVal;

        if(user[fieldName] == newVal){
            d.resolve();
            return;
        }

        Workers.update(
            data,
            function(){
                $scope.messages.success = "Данные сохранены";
                d.resolve();
            },
            function(data){
                console.log('Error on user update', data);
                var globalErrorMsg = data.msg || 'Ошибка обработки поля "' + fieldName + '"';
                var localErrorMsg = data.errors ? data.errors[fieldName] : 'Error';

                $scope.messages.err = globalErrorMsg;
                d.reject(localErrorMsg);
            }
        );

        return d.promise;
    }

    $scope.func.clearMessages = function(){
        $scope.messages = {};
    }

    $scope.func.onHideXEdit = function(){
        //$scope.func.clearMessages();
    }

    $scope.func.processError = function(data){
        if(data.errors){
            $scope.messages.listOfErrors = [];
            var err = data.msg || 'Ошибка обработки данных';
            angular.forEach(data.errors, function(val, key, list){
                $scope.messages.listOfErrors.push(val);
            });
            $scope.messages.err = err;
        }
    }
}]);