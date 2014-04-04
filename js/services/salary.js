services.factory('Salary', ['$http', function ($http) {
        var apiPrefix = typeof API_PREFIX == 'undefined' ? '' : API_PREFIX;

        function setActiveSalary(sal){
            sal.is_active = true;
            angular.forEach(salary.list, function(salItem, key, salList){
                if(sal.worker_id == salItem.worker_id && sal.id != salItem.id){
                    salItem.is_active = false;
                }
            });
        }

        var salary = {};
        salary.get = function(id, okFunc, errFunc){
            salary.list = [];
            $http.get(apiPrefix + 'api/salary/list/uid/' + id)
                .success(function(data){
                    if(typeof okFunc == 'function')
                        okFunc(data);
                    salary.list = data;
                }).error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
            return salary;
        };

        salary.create = function(data, okFunc, errFunc){
            var userId = data.worker_id;
            //$http.put(apiPrefix + 'api/salary/create', data)
            // TODO: check apache configuration to allow PUT and DELETE req
            $http.post(apiPrefix + 'api/salary/create', data)
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc();
                    salary.get(userId);
                }).error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        salary.update = function(data,  okFunc, errFunc){
            errFunc({msg: 'No implementation for updating  salaries'});
        };

        salary.delete = function(data,  okFunc, errFunc){
            errFunc({msg: 'No implementation for deleting salaries'});
        };

        salary.setActive = function(sal, okFunc, errFunc){
            var data = {id: sal.id};
            $http.post(apiPrefix + 'api/salary/active', data)
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc.apply(null, arguments);

                    setActiveSalary(sal);
                }). error(function(){
                        if(typeof errFunc == 'function')
                            errFunc.apply(null, arguments);
                });
        }

        salary.delete = function(data, okFunc, errFunc){
            $http.post(apiPrefix + 'api/salary/delete/' + data.id, {})
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc();
                    salary.get(data.worker_id);
                })
                .error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        }

        return salary;
    }]);