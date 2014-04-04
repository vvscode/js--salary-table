services.factory('Users', ['$http', function ($http) {
        var apiPrefix = typeof API_PREFIX == 'undefined' ? '' : API_PREFIX;

        var users = {};
        users.get = function( okFunc, errFunc){
            users.list = [];
            $http.get(apiPrefix + 'api/users')
                .success(function(data){
                    if(typeof okFunc == 'function')
                        okFunc(data);
                    users.list = data;
                }).error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
            return users;
        };

        users.create = function(data, okFunc, errFunc){
            $http.post(apiPrefix + 'api/users/create', data)
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc();
                    users.get();
                }).error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        users.update = function(data,  okFunc, errFunc){
            $http.post(apiPrefix + 'api/users/update/' + data.id, data)
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc();
                    users.get();
                })
                .error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        users.delete = function(data,  okFunc, errFunc){
            $http.post(apiPrefix + 'api/users/delete/' + data.id, data)
                .success(function(){
                    if(typeof okFunc == 'function')
                        okFunc();
                    users.get();
                })
                .error(function(){
                    if(typeof errFunc == 'function')
                        errFunc.apply(null, arguments);
                });
        };

        return users;
    }]);