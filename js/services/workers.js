services.factory('Workers', ['$http', '$q', function ($http, $q) {
        var apiPrefix = typeof API_PREFIX == 'undefined' ? '' : API_PREFIX;

    var checkWorkerFields = function(data){
        var opt = angular.copy(data);
        delete opt.salary_comment;
        delete opt.salary;

        return opt;
    }

        var workers = {};

        workers.getList = function( okFunc, errFunc){
            workers.list = [];
            $http.get(apiPrefix + 'api/workers')
                .success(function(data){
                    angular.forEach(data, function(val, key){
                        val._internal_employee_num = ("00000" + val.employee_num).substr(-4);
                    });

					angular.forEach(data, function(obj){
						 angular.forEach(obj, function(val, key, item){
							if(!val) { 
							   obj[key] = ""; 
							}
						});
					});

                    if(typeof okFunc == 'function')
                        okFunc(data);
                    workers.list = data;
                }).error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
            return workers;
        };

        workers.create = function(data, okFunc, errFunc){
            //$http.put(apiPrefix + 'api/workers/create', data)
            // TODO: check apache configuration to allow PUT and DELETE req
            $http.post(apiPrefix + 'api/workers/create', checkWorkerFields(data))
                .success(function(data){
                    if(typeof okFunc == 'function')
                        okFunc(data);
                    workers.getList();
                }).error(function(data){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        workers.update = function(data,  okFunc, errFunc){
            $http.post(apiPrefix + 'api/workers/update/' + data.id, checkWorkerFields(data))
                .success(function(data){
                    if(typeof okFunc == 'function')
                        okFunc.apply(null, arguments);
                })
                .error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        workers.delete = function(data,  okFunc, errFunc){
            //$http.delete(apiPrefix + 'api/workers/delete/' + data.id, data)
            // TODO: check apache configuration to allow PUT and DELETE req
            $http.post(apiPrefix + 'api/workers/delete/' + data.id, data)
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc.apply(null, arguments);
                })
                .error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        workers.get = function(id, okFunc, errFunc){
            var defer = $q.defer();
            defer.data = {};
            $http.get(apiPrefix + 'api/workers/view/' + id)
                .success(function(data){
                    if(typeof okFunc == 'function')
                        okFunc(data);
                    defer.promise.data = data;
                    defer.resolve(data);
                }).error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                    defer.reject(arguments);
                });
            return defer.promise;
        }

        return workers;
    }]);