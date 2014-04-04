salaryTableApp.controller('UsersListCtrl',['$scope', 'Users', '$q', function($scope, Users, $q) {
    $scope.data = {};
    $scope.form = {};
    $scope.func = {};
    $scope.messages = {};
    $scope.data.users = Users;
    $scope.data.showForm = false;
    $scope.data.usersList = Users.get();
    $scope.userName = salaryTableApp.userName;

    $scope.form.submit = function(){
        if(!$scope.form.userId){
            Users.create({
                login: $scope.form.userLogin,
                pass: $scope.form.userPass
            }, function(){
                $scope.form.closeForm();
            }, function(data){
                $scope.func.processError(data);
            });
        } else {
            var opt = {login: $scope.form.userLogin, id: $scope.form.userId};
            if($scope.form.userPass)
                opt.pass = $scope.form.userPass;

            Users.update(opt, function(){
                $scope.form.closeForm();
            }, function(data){
                $scope.func.processError(data);
            });
        }
    }

    $scope.form.closeForm = function(){
        $scope.form.userId = null;
        $scope.form.userLogin = "";
        $scope.form.userPass = "";
        delete($scope.data.showForm);
        $scope.func.clearMessages();
    }

    $scope.func.add = function(){
        $scope.form.userId = null;
        $scope.form.userLogin = "";
        $scope.form.userPass = "";
        $scope.data.showForm = true;
    }

    $scope.func.delete = function(id){
        Users.delete({ id: id });
        $scope.form.closeForm();
    }

    $scope.func.edit = function(user){
        $scope.form.userId = user.id;
        $scope.form.userLogin = user.login;
        $scope.form.userPass = '';
        $scope.data.showForm = true;
    }

    $scope.func.onBeforeSave = function(newVal, fieldName, user){
        console.log('$scope.func.onBeforeSave', arguments);
        var d = $q.defer();

        var data = {id: user.id};
        data[fieldName] = newVal;


        Users.update(
            data,
            function(){
                d.resolve();
            },
            function(data){
                console.log('Error on user update', data);
                var globalErrorMsg = data.msg || 'Error on processins "' + fieldName + '" field';
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
        $scope.func.clearMessages();
    }

    $scope.func.processError = function(data){
        if(data.errors){
            $scope.messages.listOfErrors = [];
            var err = data.msg || 'Error on data processing';
            angular.forEach(data.errors, function(val, key, list){
                $scope.messages.listOfErrors.push(val);
            });
            $scope.messages.err = err;
        }
    }
}]);