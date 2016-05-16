/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var domain = "http://localhost/gamings/api?action=";
var base_url = "http://localhost/gamings/";

var loaderLocation = base_url + "/wp-content/themes/canvas/images/pageload1.gif";
var app = angular.module('gaming', ['simplePagination']);
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

app.controller('myAccount', function ($scope, Pagination, $http, $templateCache) {
    formData = {'pagination': Pagination, 'type': 'myAccount'};
    ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    $scope.searchByDate = function () {
        console.log($('.startDate').val());
        console.log($('.endDate').val());
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        formData = {'pagination': Pagination, 'type': 'myAccount', 'startDate': startDate, 'endDate': endDate};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    };
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
    $(".loaderForgot").hide();
    $('.forgotPassword-success').hide();
    $('.forgotPassword-error').hide();
    $scope.loadImg = base_url + "/wp-content/themes/canvas/images/pageload1.gif";
    $scope.forgotPassword = function () {
        $(".loaderForgot").show();
        formData = $('#user_login').val();
        var baseUrl = domain + 'forgot-password';
        ngPostForgotPassword(baseUrl, formData, $scope, $http, $templateCache, 'getDetails');
    };


    formData = {};
    ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
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
        $('.loader').show();
        $('.alert').hide();
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
    slugCopy = slug;
    var formData = {
        'postId': slug
    };
    $scope.tradeMatch = function (link, tid, points, uid) {
        if (uid != null) {  //for login redirect
            var slug = link.split("/");
            slug = slug[slug.length - 2];
            var formDataNew = {
                'mid': tid,
                'pts': points,
                'slug': slug,
                'mainSlug': slugCopy,
                'type': 'tournamentsMatches'
            };
            //console.log(slugCopy);

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
                'slug': slug,
                'type': 'tournaments'

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
                'slug': slug,
                'type': 'matches'
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
        var formInfo = {'categoryName': $.urlParam('category'), 'getCount': getCount, 'loadMore': 'true'};
        ngPost('listing-tournaments', formInfo, $scope, $http, $templateCache, 'getDetails');

    };
});

app.controller('listingMatch', function ($http, $scope, $templateCache) {

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

    $scope.tradeMatch = function (link, tid, points, uid) {

        var slug = link.split("/");
        slug = slug[slug.length - 2];
        var formDataNew = {
            'mid': tid,
            'pts': points,
            'slug': slug,
            'mainSlug': $.urlParam('category'),
            'type': 'matchesList',
            'catType': sessionStorage.getItem('type')
        };
        console.log(sessionStorage.getItem('type'));
        tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName');
    }; //for login redirect
    //console.log( $.urlParam('category'));
    ngPost('listing-matches', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (type, $index) {
        //console.log($.urlParam('category'));
        //console.log(type);
        $scope.selectedIndex = $index;
        $('.hide-loadMore').show();
        $scope.getCat = type;
        sessionStorage.setItem('type', type);
        var formInfo = {'categoryName': $.urlParam('category'), 'type': type};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getDetails');
    };
    $scope.loadMore = function (catName, getCount) {
        //console.log($.urlParam('category'));
        // console.log(getCount);
        var formInfo = {'categoryName': $.urlParam('category'), 'getCount': getCount, 'loadMore': 'true'};
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
                $('.loader').hide();

                //for pagination of matches
                if (typeof formData['loadMore'] !== 'undefined')
                    var getCountResult = response['catPost'].length;
                var getPaginateCount = formData['getCount'];
                if (getPaginateCount > getCountResult) {
                    $('.hide-loadMore').hide();
                }
                //for pagination of matches
                if (typeof response['userBets'] !== 'undefined' && formData['type'] === 'myAccount') {
                    var Pagination = formData['pagination'];
                    $scope.posts = response['userBets'];
                    $scope.winList = response['winLoss'];
                    $scope.pagination = Pagination.getNew(10);
                    $scope.paginationWin = Pagination.getNew(10);

                    $scope.pagination.numPages = Math.ceil($scope.posts.length / $scope.pagination.perPage);
                    $scope.paginationWin.numPages = Math.ceil($scope.winList.length / $scope.paginationWin.perPage);

                }
                if (typeName == 'login') {
                    $('.loader').hide();
                    $('.alert').show();
                }
                ;
                $.urlParam = function (name) {
                    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                    if (results == null) {
                        return null;
                    }
                    else {
                        return results[1] || 0;
                    }
                };
                if (response['msg'] === "success_login") {
                    if ($.urlParam('url') == null) {
                        $('.alert').hide();
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
        if (formData['type'] === 'tournaments') {
            var formDataReload = {'postId': formData['slug']};
            ngPost('tournaments-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');
        }
        else if (formData['type'] === 'matches') {
            var formDataReload = {'postId': formData['slug']};
            ngPost('matches-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');
        }
        else if (formData['type'] === 'matchesList') {
            var formDataReload = {'categoryName': formData['mainSlug'], 'type': formData['catType']};
            console.log(formDataReload);
            ngPost('listing-matches', formDataReload, $scope, $http, $templateCache, 'getDetails');
        }
        else if (formData['type'] === 'tournamentsMatches') {
            var formDataReload = {'postId': formData['mainSlug']};
            ngPost('tournaments-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');

        }
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

function hideDiv() {
    $(document).ready(function () {
        console.log($('.demo').html());

    });
}

app.controller('contactCtrl', function ($scope, $http, $templateCache) {
    $('.loader').hide();
    $('#template-contactform').validate({
        rules: {
            fname: {minlength: 5, required: true},
            email: {required: true, email: true},
            phone: {required: true, minlength: 10, maxlength: 10, number: true},
            message: {required: true, minlength: 10}

        },
        messages: {fname: "Minimum length should be 5",
            email: "Not a valid Email Id",
            phone: "Enter a valid mobile number",
            message: "Minimum length should be 10"
        }
    });
    $scope.loadImg = base_url + "/wp-content/themes/canvas/images/pageload1.gif";
    $scope.contacForm = function () {

        $('#template-contactform').valid();
        if (!$('#template-contactform').valid()) {
            return false;
        }
        $('.loader').show();
        var formData = $('#template-contactform').serialize();
        ngPost('contact-us', formData, $scope, $http, $templateCache, 'errorReg');
    };
});


function ngPostForgotPassword(url, formData, $scope, $http, $templateCache, errorBlock) {
    $http({
        method: "POST",
        url: url,
        data: $.param({'user_login': formData}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        cache: $templateCache
    }).success(function (response) {
        $(".loaderForgot").hide();
        $scope[errorBlock] = response;
        if (response === "Yes") {
            $('.forgotPassword-success').show();
            $('.forgotPassword-error').hide();

            var url = base_url + 'wp-login.php?action=lostpassword';
            ngPostForgotPassword(url, formData, $scope, $http, $templateCache, 'getDetails');
        } else if (response === "No") {
            $('.forgotPassword-success').hide();
            $('.forgotPassword-error').show();
            console.log('No');
        }
    }).error(function (response) {
        $scope[errorBlock] = response;
    });
}


app.controller('forgotPasswordCtrl', function ($scope, $http, $templateCache) {

    $scope.loaderSrc = loaderLocation;
    $('.loader').hide();
    getUrlParameter();
    $scope.resetPassword = function () {        
        $('#forgotPassword').validate({
            rules:{
                password:{minlength:5}
            },
            messages:{
                password:"Minimum lenght should be 5"
            }
        });
        if (!$('#forgotPassword').valid()) {
            return false;
        }
        $('.loader').show();
        var formInfo = {'newPassword': $scope.password, 'key': $.urlParam('key'), 'login': $.urlParam('login')};
        ngPost('forgot-password-reset', formInfo, $scope, $http, $templateCache, 'errorReg');
    };
});

function getUrlParameter() {
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        }
        else {
            return results[1] || 0;
        }
    };
}