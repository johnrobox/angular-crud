
<html ng-app="myApp">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    </head>
    <body ng-controller="myController">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <button ng-click="addEmployeeModal()" class="btn btn-primary">Add Employee</button>
                </div>
                <div class="col-sm-10"></div>
            </div>
            
            <input type="text" class="form-control" id="employee" placeholder="Search employe here" ng-model="searchString">
            
            <div style="color:green">{{ okay }}</div>
            
            <table class="table table-bordered">
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                <tr ng-repeat="employee in employees  | searchFor:searchString">
                    <td>{{ employee.firstname }}</td>
                    <td>{{ employee.lastname }}</td>
                    <td>{{ employee.address }}</td>
                    <td>
                        <button class="btn btn-primary" ng-click="editEmployee(employee.id)">Edit</button>
                        <button class="btn btn-danger" ng-click="deleteEmployee(employee.id)">Delete</button>
                    </td>
                </tr>
            </table>
        </div>
        
        <div id="addEmployee" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Add Employee
                    </div>
                    <div class="modal-body">
                        <div style="color:red">{{ addError }}</div>
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" ng-model="firstname" class="form-control" id="firstname"/>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" ng-model="lastname" class="form-control" id="lastname"/>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" ng-model="address" class="form-control" id="address"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" ng-click="addEmployeeAddButton()">Add</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">Edit Employee</div>
                    <div class="modal-body">
                        <div style="color: red">{{ upError }}</div>
                        <div class="form-group">
                            <label for="firstnameEdit">Firstname</label>
                            <input type="text" ng-model="eFirstname" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="lastnameEdit">Lastname</label>
                            <input type="text" ng-model="eLastname" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label for="addressEdit">Address</label>
                            <input type="text" ng-model="eAddress" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" ng-click="submitEdit()">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        Delete this item ?
                    </div>
                    <div class="modal-body">
                        {{ delError }}
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" ng-click="deleteConfirm()">Yes</button>
                        <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            var app = angular.module('myApp', []);
            app.controller('myController', function($scope, $http){
                
                viewAllEmployee($scope, $http);
                
                $scope.addEmployeeModal = function(){
                    $('#addEmployee').modal('show');
                    $scope.addEmployeeAddButton = function() {
                        var employee = {
                            firstname : $scope.firstname, 
                            lastname : $scope.lastname,
                            address : $scope.address
                        };
                        
                        $http.post('http://practice.com/crud-practise/add.php', employee)
                                .success(function(data){
                                    if (!data.valid) {
                                        $scope.addError = data.message;
                                    } else {
                                        $scope.okay = data.message;
                                        $("#addEmployee").modal('hide');
                                        viewAllEmployee($scope, $http);
                                    }
                                })
                                .error(function(data) {
                                    
                                });
                    }
                }
                
                $scope.editEmployee = function(id) {
                    $('#editModal').modal('show');
                    angular.forEach($scope.employees, function(obj){
                        if (obj.id == id) {
                            $scope.eFirstname = obj.firstname;
                            $scope.eLastname = obj.lastname;
                            $scope.eAddress = obj.address;
                        }
                    });
                    
                    $scope.submitEdit = function(){
                        var upData = {
                            id : id,
                            firstname : $scope.eFirstname,
                            lastname : $scope.eLastname,
                            address : $scope.eAddress
                        }
                        $http.post('http://practice.com/crud-practise/update.php', upData)
                                .success(function(data){
                                    if (!data.valid){
                                        $scope.upError = data.message;
                                    } else {
                                        viewAllEmployee($scope, $http);
                                        $scope.okay = data.message;
                                        $('#editModal').modal('hide');
                                    }
                                })
                                .error(function(){
                                    
                                })
                    }
                }
                
                $scope.deleteEmployee = function(id) {
                    $('#deleteModal').modal('show');
                    $scope.deleteConfirm = function(){
                        var dData = {id : id};
                        $http.post('http://practice.com/crud-practise/delete.php', dData)
                                .success(function(data){
                                    if (!data.valid) {
                                        $scope.delError = data.message;
                                    } else {
                                        viewAllEmployee($scope, $http);
                                        $scope.okay = data.message;
                                        $('#deleteModal').modal('hide');
                                    }
                                })
                                .error(function(data){

                                })
                        
                    }
                }
                
            });
            
            function viewAllEmployee($scope, $http) {
                $http.get('http://practice.com/crud-practise/all.php')
                        .success(function(data){
                            $scope.employees = data;
                        })
                        .error(function(){})
            }
            
            app.filter('searchFor', function(){
                return function(arr, searchString){
                    if(!searchString){
                            return arr;
                    }
                    var result = [];
                    searchString = searchString.toLowerCase();
                    angular.forEach(arr, function(item){
                            if(item.firstname.toLowerCase().indexOf(searchString) !== -1){
                                    result.push(item);
                            }
                    });
                    return result;
                };
            });
        </script>
    </body>
</html>