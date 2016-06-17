/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var domain = "http://localhost/gamings/api/?action=";

var base_url = "http://localhost/gamings/";

var loaderLocation = base_url + "/wp-content/themes/canvas/images/pageload1.gif";
var app = angular.module('gaming', ['simplePagination']);

app.controller('homeCtrl', function ($scope, $http, $templateCache) {
    sessionStorage.setItem('getCount', '');
    $http.get(domain + "home").then(function (response) {
        $scope.home = response.data;
        $('.awardContent').html(response.data.leaderBoard['award']);
        $scope.homeMatchListing = response.data;
    });
//    $http.get(domain + "home-match-listing").then(function (response) {
//        $scope.homeMatchListing = response.data;
//    });
    getUrlParameter();

    $scope.loadMore = function (catName, getCount) {
        console.log(getCount);
        sessionStorage.setItem('getCount', getCount);
        //console.log($.urlParam('category'));
        // console.log(getCount);
        var formInfo = {'categoryName': '', 'getCount': sessionStorage.getItem('getCount'), 'loadMoreMatch': 'true'};
        ngPost('home-match-listing', formInfo, $scope, $http, $templateCache, 'homeMatchListing');

    };
    $scope.tradeMatch = function (link, tid, points, uid, pointsTie) {

        if (uid != null) {
            var slug = link.split("/");
            slug = slug[slug.length - 2];
            var formDataNew = {
                'mid': tid,
                'pts': points,
                'slug': slug,
                'tie': pointsTie,
                'mainSlug': $.urlParam('category'),
                'type': 'popularMatches',
                'catType': sessionStorage.getItem('type')
            };
            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName');

        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";
        }
    }; //for login redirect
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
    $('.userInfoForm').validate({
        rules: {
            fname: {minlength: 3, required: true},
            email: {required: true, email: true},
            mobile: {required: true, minlength: 10, maxlength: 10, number: true},
        },
        messages: {
            fname: "Minimum length should be 3",
            email: "Not a valid Email Id",
            phone: "Enter a valid mobile number",
        }
    });

    formData = {'pagination': Pagination, 'type': 'myAccount'};
    ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    var getPageCount = 0;

    if (getPageCount <= 0) {  //hide prev button
        $('.paginatePrev').hide();
    }                          //hide prev button
    $(document).on('click', '.paginateNext', function () {
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        getPageCount++;
        if (getPageCount > 0) {
            $('.paginatePrev').show();
        }
        var getCount = getPageCount * 10;
        formData = {'pagination': Pagination, 'type': 'myAccount', 'getCount': getCount, 'startDate': startDate, 'endDate': endDate};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    });

    $(document).on('click', '.paginatePrev', function () {
        getPageCount--;
        var getCount = getPageCount * 10;
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        formData = {'pagination': Pagination, 'type': 'myAccount', 'getCount': getCount, 'startDate': startDate, 'endDate': endDate};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
        if (getPageCount == 0) {
            $('.paginatePrev').hide();
        } else {
            $('.paginateNext').show();
        }
    });

    $(document).on('click', '.paginateDiffusionNext', function () {
        var getCountDiffusion = getPageCount * 10;
        formData = {'pagination': Pagination, 'type': 'myAccount', 'getCountDiffusion': getCountDiffusion};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    });
    $scope.searchByDate = function (reset) {
        getPageCount = 0;
        $('.paginatePrev').hide();
        $('.paginateNext').show();
        if (reset == 'yes') {
            $('.startDate').val('');
            $('.endDate').val('');
        }
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        formData = {'pagination': Pagination, 'type': 'myAccount', 'startDate': startDate, 'endDate': endDate, 'reset': reset};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    };


    $scope.userUpdate = function () {
        $('.userInfoForm').valid();
        if (!$('.userInfoForm').valid()) {
            return false;
        }
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
        $('.loaderRegister').show();
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
    $scope.tradeMatch = function (link, tid, points, uid, pointsTie) {

        if (uid != null) {
            var slug = link.split("/");
            slug = slug[slug.length - 2];
            var formDataNew = {
                'mid': tid,
                'pts': points,
                'slug': slug,
                'tie': pointsTie,
                'mainSlug': $.urlParam('category'),
                'mainSlugTour': slugCopy,
                'type': 'tournamentMatcheList',
                'catType': sessionStorage.getItem('type')
            };
            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName');
        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";
        }
    };
    ngPost('tournaments-detail', formData, $scope, $http, $templateCache, 'getDetails');
    var formDataMatch = {'tourId': slug, 'type': 'upcomming'};
    ngPost('listing-matches', formDataMatch, $scope, $http, $templateCache, 'getMatchDetails');
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


    $scope.filter = function (type, $index) {
        //console.log($.urlParam('category'));
        //console.log(type);
        if (type === "daysBefore" || type === "ongoing") {
            $scope.hideTrade = "none";
        } else {
            $scope.hideTrade = "block";
        }

        if (type === "daysBefore" || type === "ongoing") {
            $scope.hideDefault = "block";
        } else {
            $scope.hideDefault = "none";
        }
        ;
        $scope.selectedIndex = $index;
        $('.hide-loadMore').show();
        $scope.getCat = type;
        sessionStorage.setItem('type', type);
        var formInfo = {'categoryName': $.urlParam('category'), 'type': type, 'tourId': slug};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getMatchDetails');
    };
    $scope.getTrade = function (teamId) {
        console.log(teamId);
    };

    $scope.loadMore = function (catName, getCount) {
        var type = "";
        console.log(sessionStorage.getItem('type'));
        if (sessionStorage.getItem('type') != '' && sessionStorage.getItem('type') != null) {
            type = sessionStorage.getItem('type');
        } else {
            type = 'upcomming';
        }
        //console.log($.urlParam('category'));
        // console.log(getCount);
        sessionStorage.setItem('getCount', getCount);
        var formInfo = {'categoryName': $.urlParam('category'), 'tourId': slug, 'type': type, 'getCount': getCount, 'loadMore': 'true'};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getMatchDetails');
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
    sessionStorage.setItem('getCount', '');
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
    $scope.categoryName = $.urlParam('category');

    if ($.urlParam('category') !== '') {
        var formData = {'categoryName': $.urlParam('category')};
    }
    else {
        var formData = {};
    }

    $scope.tradeMatch = function (link, tid, points, uid, pointsTie) {
        //  $scope.pointsTie="";
        if (uid != null) {
            var slug = link.split("/");
            slug = slug[slug.length - 2];
            var formDataNew = {
                'mid': tid,
                'pts': points,
                'tie': pointsTie,
                'slug': slug,
                'mainSlug': $.urlParam('category'),
                'type': 'matchesList',
                'catType': sessionStorage.getItem('type')
            };
            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName');
        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";
        }
    }; //for login redirect
    //console.log( $.urlParam('category'));
    ngPost('listing-matches', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (type, $index) {
        //console.log($.urlParam('category'));
        //console.log(type);
        if (type === "daysBefore" || type === "ongoing") {
            $scope.hideTrade = "none";
        } else {
            $scope.hideTrade = "block";
        }

        if (type === "daysBefore" || type === "ongoing") {
            $scope.hideDefault = "block";
        } else {
            $scope.hideDefault = "none";
        }
        ;
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
        sessionStorage.setItem('getCount', getCount);
        var formInfo = {'categoryName': $.urlParam('category'), 'getCount': getCount, 'loadMore': 'true'};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getDetails');
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
                if (typeName == 'home-match-listing') {
                    $scope[errorBlock] = response;

                }

                if (typeName == 'listing-matches') {
                    $('.updateUserKit').html(response['userTotalPts']);
                }
                if (typeName == 'tournaments-detail') {
                    $('.updateUserKit').html(response['userTotalPts']);

                }
                if (typeName == 'my-account') {
                    $scope.posts = response['userBets'];
                    if (response['userBets'].length == 0) {
                        $('.paginateNext').hide();
                    }
                    angular.element(document).ready(function () {
                        $('.toolMsg a').attr('data-original-title', "These points will be credited to your 'Cleared Points' after " + response['bufferDay'] + " days of winning Tournament/Match result");

                    });

                }

                $('.loader').hide();
                //for pagination of matches
                if (typeof formData['loadMore'] !== 'undefined')
                    var getCountResult = response['catPost'].length;
                var getPaginateCount = formData['getCount'];
                if (getPaginateCount > getCountResult) {
                    $('.hide-loadMore').hide();
                }
                if (typeof formData['loadMoreMatch'] !== 'undefined')
                    var getCountResult = response['upcomingMatches']['catPost'].length;
                var getPaginateCount = formData['getCount'];
                if (getPaginateCount > getCountResult) {
                    $('.hide-loadMore').hide();
                }

                //for pagination of matches
                if (typeof response['winLoss'] !== 'undefined' && formData['type'] === 'myAccount') {
                    var Pagination = formData['pagination'];
                    $scope.winList = response['winLoss'];
                    $scope.paginationWin = Pagination.getNew(10);
                    $scope.paginationWin.numPages = Math.ceil($scope.winList.length / $scope.paginationWin.perPage);

                }
                if (typeName == 'login') {
                    $('.loader').hide();
                    $('.alert').show();
                }
                if (typeName == 'contact-us') {
                    $('.col-ch').show();
                }
                if (typeName == 'registration') {
                    $('.loaderRegister ').hide();
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


        if (formData['type'] === 'popularMatches') {

            $http.get(domain + "home-match-listing&data[getCount]=" + sessionStorage.getItem('getCount')).then(function (response) {
                $scope.homeMatchListing = response.data;
                $('.updateUserKit').html(response.data['upcomingMatches']['userTotalPts']);
            });
            $scope.pointsTie = '';


        }
        if (formData['type'] === 'tournaments') {
            var formDataReload = {'postId': formData['slug']};
            ngPost('tournaments-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');
        }
        else if (formData['type'] === 'matches') {
            var formDataReload = {'postId': formData['slug']};
            ngPost('matches-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');
        }
        else if (formData['type'] === 'matchesList') {
            $scope.pointsTie = "";
            var formDataReload = {'categoryName': formData['mainSlug'], 'type': formData['catType'], 'getCount': sessionStorage.getItem('getCount')};
            //console.log(formDataReload);
            ngPost('listing-matches', formDataReload, $scope, $http, $templateCache, 'getDetails');
        }
        else if (formData['type'] === 'tournamentMatcheList') {
            $scope.pointsTieM = "";
            var formDataReload = {'categoryName': formData['mainSlug'], 'type': 'upcomming', 'tourId': formData['mainSlugTour'], 'getCount': sessionStorage.getItem('getCount')};
            console.log(formDataReload);
            ngPost('listing-matches', formDataReload, $scope, $http, $templateCache, 'getMatchDetails');
        }
        else if (formData['type'] === 'tournamentsMatches') {
            var formDataReload = {'postId': formData['mainSlug']};
            ngPost('tournaments-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');

        }
        $('.loader').hide();

        if (typeName === 'password-update') {
            if (response['data'] == "Password changed successfully") {
                console.log("hello");
                swal({
                    title: response.data
                });
                window.location = domain + "logout";
            }
            else if (response['data'] == "Old Password doesn't Match") {
                swal({
                    title: response.data
                });
            }
        } else {
            swal({
                title: response.data
            });
        }
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
            fname: {minlength: 3, required: true},
            email: {required: true, email: true},
            phone: {required: true, minlength: 10, maxlength: 10, number: true},
            message: {required: true, minlength: 10}

        },
        messages: {fname: "Minimum length should be 3",
            email: "Not a valid Email Id",
            phone: "Enter a valid mobile number",
            message: "Minimum length should be 10"
        }
    });
    $scope.loadImg = base_url + "/wp-content/themes/canvas/images/pageload1.gif";
    $scope.contacForm = function () {
        $('.col-ch').hide();
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
            rules: {
                password: {minlength: 3}
            },
            messages: {
                password: "Minimum lenght should be 3"
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

app.controller('leaderBoardCtrl', function ($scope, $http, $templateCache) {
    var formInfo = {};
    ngPost('leader-board', formInfo, $scope, $http, $templateCache, 'userDetails');

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