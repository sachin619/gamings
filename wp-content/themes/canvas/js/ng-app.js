/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var domain = "http://localhost/gamings/api?action=";
var base_url = "http://localhost/gamings/";




var app = angular.module('gaming', []);
app.controller('homeCtrl', function ($scope, $http) {
    $http.get(domain + "home").then(function (response) {
        $scope.home = response.data;
    });
}).directive("owlCarousel", function () {
    return {
        restrict: 'E',
        transclude: false,
        link: function (scope) {
            scope.initCarousel = function (element) {
                // provide any default options you want
                var defaultOptions = {
                };
                var customOptions = scope.$eval($(element).attr('data-options'));
                // combine the two options objects
                for (var key in customOptions) {
                    defaultOptions[key] = customOptions[key];
                }
                // init carousel
                $(element).owlCarousel(defaultOptions);
            };
        }
    };
})
        .directive('owlCarouselItem', [function () {
                return {
                    restrict: 'A',
                    transclude: false,
                    link: function (scope, element) {
                        // wait for the last item in the ng-repeat then call init
                        if (scope.$last) {
                            scope.initCarousel(element.parent());
                        }
                    }
                };
            }]);

app.controller('myAccount', function ($scope, $http, $templateCache) {
    formData = {};
    ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    $scope.userUpdate = function () {
        $('.loader').show();
        var password = $('#password').val();
        var fname = $('#fname').val();
        var lname = $('#lname').val();
        var uname = $('#uname').val();
        var email = $('#email').val();
        var phone = $('#mobile').val();


        var userInfo = {pass: password, fname: fname, lname: lname, uname: uname, email: email, phone: phone};
        tourDetails('update-user-info', userInfo, $scope, $http, $templateCache, 'getUserInfo');
        //for image upload
        var file_data = $('#img').prop('files')[0];
        var form_data = new FormData();
        form_data.append('file', file_data);
        console.log(form_data);

        //alert(form_data);                             
        $.ajax({
            url: domain + 'upload-img', // point to server-side PHP script 
            dataType: 'text', // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            success: function (php_script_response) {
                console.log(php_script_response);// display response from the PHP script, if any
            }
        });

    };
    $scope.updatePassword = function () {
        $('.loader').show();
        var oldPassword = $('#oldPassword').val();
        var newPassword = $('#newPassword').val();
        var userInfo = {oldPass: oldPassword, newPassword: newPassword};
        tourDetails('password-update', userInfo, $scope, $http, $templateCache, 'udpatePassword');
    };

    $scope.uploadFile = function (files) {
        console.log(files);

        var fd = new FormData();
        //Take the first selected file
        fd.append("file", files[0]);
        var uploadUrl = "http://localhost/practice/";
        $http.post(uploadUrl, fd, {
            withCredentials: true,
            headers: {'Content-Type': undefined},
            transformRequest: angular.identity
        }).success(console.log('success')).error(console.log('error'));
    };

});

app.controller('signupCtrl', function ($scope, $http, $templateCache) {
    $scope.signUp = function () {
        var formData = {
            'user_login': document.registerForm.username.value,
            'first_name': document.registerForm.fName.value,
            'last_name': document.registerForm.lName.value,
            'user_email': document.registerForm.email.value,
            'user_pass': document.registerForm.password.value,
            'phone': document.registerForm.phone.value
        };
        ngPost('registration', formData, $scope, $http, $templateCache, 'errorReg');
    };
    $scope.signIn = function () {
        var formData = {
            'userName': document.loginForm.username.value,
            'password': document.loginForm.password.value
        };
        ngPost('login', formData, $scope, $http, $templateCache, 'errorLog');
    };
});

app.controller('tourDetails', function ($scope, $http, $templateCache) {
    var slug = document.location.pathname.split("/");
    slug = slug[slug.length - 2];
    var formData = {
        'postId': slug
    };
    $scope.tradeMatch = function (link, tid, points, uid) {
        if (uid != null) {  //for login redirect
            var slug = link.split("/");
            slug = slug[slug.length - 2];
            console.log(tid);
            console.log(points);
            console.log(slug);
            var formDataNew = {
                'mid': tid,
                'pts': points,
                'slug': slug

            };
            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName');
        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";
        }
    }; //for login redirect
    ngPost('tournaments-detail', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.trade = function (tid, teamId, pts, uid) {
        if (uid != null) {
            var formData = {
                'tid': tid,
                'team_id': teamId,
                'pts': pts,
                'slug': slug

            };
            tourDetails('trade', formData, $scope, $http, $templateCache, 'blockName');

        } else {
            sessionStorage.setItem("url", document.URL);
            window.location = base_url + "register?url=redirect";

        }

    };

    $scope.getTrade = function (teamId) {
        console.log(teamId);
    };


});


app.controller('matchesDetails', function ($scope, $http, $templateCache) {
    var slug = document.location.pathname.split("/");
    slug = slug[slug.length - 2];
    var formData = {
        'postId': slug
    };
    ngPost('matches-detail', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.trade = function (link, tid, teamId, pts, uid) {
        if (uid != null) {
            var slug = link.split("/");
            slug = slug[slug.length - 2];
            console.log(tid);
            console.log(pts);
            console.log(slug);
            pointsTeamId = {};
            pointsTeamId[teamId] = pts;
            var formData = {
                'mid': tid,
                'pts': pointsTeamId,
                'slug': slug

            };
            tourDetails('multi-trade-match', formData, $scope, $http, $templateCache, 'blockName');
        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";

        }
    };

    $scope.getTrade = function (teamId) {
        console.log(teamId);
    };


});

app.controller('listingTour', function ($http, $scope, $templateCache) {
    $scope.selectedIndex = 'home';
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        }
        else {
            return results[1] || 0;
        }
    };
    if ($.urlParam('category') !== '') {
        var formData = {'categoryName': $.urlParam('category')};
    }
    else {
        var formData = {};
    }
    ngPost('listing-tournaments', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.selectedIndex = 'home';
    $scope.filter = function (catName, index) {
        $scope.selectedIndex = index;
        console.log(index);
        $('.hide-loadMore').show();
        $scope.getCat = catName;
        var formInfo = {'categoryName': catName};
        ngPost('listing-tournaments', formInfo, $scope, $http, $templateCache, 'getDetails');
    };
    $scope.loadMore = function (catName, getCount) {
        //console.log(getCount);
        var formInfo = {'categoryName': catName, 'getCount': getCount};
        ngPost('listing-tournaments', formInfo, $scope, $http, $templateCache, 'getDetails');
        if ($scope.j > getCount)
            $('.hide-loadMore').hide();
    };
});

app.controller('listingMatch', function ($http, $scope, $templateCache) {
    $scope.selectedIndex = 'home';
    var formData = {};
    ngPost('listing-matches', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (catName, $index) {
        $scope.selectedIndex = $index;
        $('.hide-loadMore').show();
        $scope.getCat = catName;
        var formInfo = {'categoryName': catName};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getDetails');
    };
    $scope.loadMore = function (catName, getCount) {
        var formInfo = {'categoryName': catName, 'getCount': getCount};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getDetails');
        if ($scope.j > getCount)
            $('.hide-loadMore').hide();
    };
});

function ngPost(typeName, formData, $scope, $http, $templateCache, errorBlock) {
    $http({
        method: 'POST',
        url: domain + typeName,
        data: $.param({'data': formData}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        cache: $templateCache
    }).
            success(function (response) {
                $.urlParam = function (name) {
                    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    if (results == null) {
                        return null;
                    }
                    else {
                        return results[1] || 0;
                    }
                };
                if (response === "success_login") {
                    if ($.urlParam('url') == null) {
                        window.location.href = base_url + 'my-account/';
                    } else {
                        window.location.href = sessionStorage.getItem("url");
                        ;
                    }
                } else {
                    $scope[errorBlock] = response;
  
                }
                ;
            }).
            error(function (response) {
                $scope[errorBlock] = response || "Request failed";
            });
}

function tourDetails(typeName, formData, $scope, $http, $templateCache, msgBlock) {
    $http({
        url: domain + typeName,
        method: "POST",
        data: $.param({'data': formData}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        cache: $templateCache
    }).then(function (response) {
        $('.loader').hide();
        swal({
            title: response.data
        });
    });
}

$(document).on('click', 'body', function () {
//    $('.sweet-alert').remove();
//        $('.sweet-overlay').remove();

});

function hideDiv(){
    $(document).ready(function(){
           console.log($('.demo').html());  

    });
}
