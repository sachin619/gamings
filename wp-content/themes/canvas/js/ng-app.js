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
    $scope.homeMatchListing = [];
    $scope.tradeTotal = [];
    sessionStorage.setItem('getCount', '');
    $http.get(domain + "home").then(function (response) {

        $scope.home = response.data;
       // $('.aboutUs').html(response.data.aboutUs[0]['content']);
       // $('.aboutTitle').html(response.data.aboutUs[0]['title']);
        $('.awardContent').html(response.data.leaderBoard['award']);

        jQuery.each(response.data.upcomingMatches.catPost, function (k, v) {
            // console.log(v);
            $scope.homeMatchListing.push(v);

        });

        if (response.data.leaderBoard['info'] == null) {
            $('.popupLeaderBoard').hide();
        }
    });

    getUrlParameter();
    var i = 1;

    $scope.loadMore = function (catName, getCount) {
        i++;
        sessionStorage.setItem('getCount', i);
        //console.log($.urlParam('category'));
        // console.log(getCount);
        var formInfo = {'categoryName': '', 'getCount': sessionStorage.getItem('getCount'), 'loadMoreMatch': 'true'};

        ngPost('home-match-listing', formInfo, $scope, $http, $templateCache, 'homeMatchListing');

    };
    $scope.tradeMatch = function (link, tid, points, uid, pointsTie, event) {
        angular.element(event.target).attr('disabled', 'disabled');

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
            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName', event);

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
                    responsive: {
                        0: {
                            items: 1,
                            nav: false
                        },
                        600: {
                            items: 3,
                            nav: false
                        }
                    }
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
    $('.searchMyBets').validate({
        rules: {
            fname: {minlength: 3, required: true},
            email: {required: true, email: true},
            mobile: {required: true, minlength: 10, maxlength: 10, number: true},
        },
        message: {
        }
    });
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
    $scope.downloadCsv = function () {
        $('.loaderDownload').show();
        formData = {};
        ngPost('download-csv', formData, $scope, $http, $templateCache, 'donwload');

    };
    formData = {'pagination': Pagination, 'type': 'myAccount'};
    ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    /**************************for userbets pagination*******************************************************/
    var getPageCount = 0;
    $(document).on('click', '.paginateNext', function () {
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        getPageCount++;
        if (getPageCount > 0) {
            $('.paginatePrev').show();
        }
        var getCount = getPageCount * 10;
        formData = {'pagination': Pagination, 'type': 'myAccountFilter', 'getCount': getCount, 'startDate': startDate, 'endDate': endDate};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccount');
    });

    /**************************** for userbets  pagination*****************************************/
    var getPageCountWin = 0;
    $(document).on('click', '.paginateNextWin', function () {
        getPageCountWin++;
        if (getPageCountWin > 0) {
            $('.paginatePrevWin').show();
        }
        formData = {'pagination': Pagination, 'type': 'myAccountFilterWin', 'getCount': getPageCountWin};
        ngPost('my-account', formData, $scope, $http, $templateCache, 'myAccountFilterWIn');
    });
    /****************************for pagination*****************************************/


    $scope.searchByDate = function (reset) {
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        if (startDate === '' && reset != 'yes') {
            $('.errorStartDate').show();
        }
        if (endDate === '' && reset != 'yes') {
            $('.errorEndDate').show();
        }
        $('.searchMyBets').valid({});
        if (!$('.searchMyBets').valid()) {
            return false;
        }
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
        }).success().error(console.log('error'));
    };

});

app.controller('signupCtrl', function ($scope, $http, $templateCache) {
    $('#register-form').validate({
        rules: {
            fName: {minlength: 3, required: true},
            email: {required: true, email: true},
            phone: {required: true, minlength: 10, maxlength: 10, number: true},
            message: {required: true, minlength: 10},
            username: {minlength: 5},
            password: {
                required: true,
                minlength: 5
            },
            confirmPassword: {
                equalTo: "#register-form-password"
            }

        },
        messages: {fname: "Minimum length should be 3",
            email: "Not a valid Email Id",
            phone: "Enter a valid mobile number",
            message: "Minimum length should be 10",
            username: 'Minimum length should be 5',
            confirmPassword: {equalTo: 'Password does not match'},
        }
    });


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
        $('#register-form').valid();
        if (!$('#register-form').valid()) {
            return false;
        }
        ;

        $('.loaderRegister').show();
        var formData = {
            'user_login': document.registerForm.username.value,
            'first_name': document.registerForm.fName.value,
            'last_name': document.registerForm.lName.value,
            'user_email': document.registerForm.email.value,
            'user_pass': document.registerForm.password.value,
            'phone': document.registerForm.phone.value,
            'dob': document.registerForm.dob.value,
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
    $scope.category = 'popular';
    var slug = document.location.pathname.split("/");
    $scope.homeMatchListing = [];
    slug = slug[slug.length - 2];
    slugCopy = slug;
    var formData = {
        'postId': slug
    };
    $scope.tradeMatch = function (link, tid, points, uid, pointsTie, event) {
        angular.element(event.target).attr('disabled', 'disabled');
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
                'type': 'matchesList',
            };
            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName', event);
        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";
        }
    };
    ngPost('tournaments-detail', formData, $scope, $http, $templateCache, 'getDetails');
    var formDataMatch = {'tourId': slug, 'type': 'upcomming'};
    ngPost('listing-matches', formDataMatch, $scope, $http, $templateCache, 'getMatchDetails');
    $scope.trade = function (tid, teamId, pts, uid, event) {
        var getPremium = parseFloat($('.premiumPoints').html());

        if (getPremium > 1 && pts > 0 && uid != null) {

            swal({
                title: 'Confirm',
                text: "Current Trade Premium value is" + getPremium + ". To Trade for " + pts + " Points, you will need to contribute " + Math.round(pts * getPremium) + " Points (" + pts + "*" + getPremium + "=" + pts * getPremium + "; rounded to " + Math.round(pts * getPremium) + "). Please confirm. ",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
                closeOnConfirm: false
            }, function () {
                angular.element(event.target).attr('disabled', 'disabled');


                var formData = {
                    'tid': tid,
                    'team_id': teamId,
                    'pts': pts,
                    'slug': slug,
                    'type': 'tournaments',
                };
                tourDetails('trade', formData, $scope, $http, $templateCache, 'blockName', event);


            });

        } else if (uid != null) {
            var formData = {
                'tid': tid,
                'team_id': teamId,
                'pts': pts,
                'slug': slug,
                'type': 'tournaments',
            };
            tourDetails('trade', formData, $scope, $http, $templateCache, 'blockName', event);
        } else {
            sessionStorage.setItem("url", document.URL);
            window.location = base_url + "register?url=redirect";
        }


    };


    $scope.filter = function (type, $index) {
        $scope.category = type;
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
        var formInfo = {'categoryName': $.urlParam('category'), 'type': type, 'tourId': slug, 'filter': 'yes'};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getMatchDetails');
    };
    $scope.getTrade = function (teamId) {

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

    };


});

app.controller('listingTour', function ($http, $scope, $templateCache) {
    $scope.selectedIndex = 'home';
    $scope.tourListing = [];
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return results[1] || 0;
        }
    };
    if ($.urlParam('category') !== '') {
        var formData = {'categoryName': $.urlParam('category')};
    } else {
        var formData = {};
    }
    ngPost('listing-tournaments', formData, $scope, $http, $templateCache, 'getDetails');

//    $scope.selectedIndex = 'home';
//    $scope.filter = function (catName, index) {
//        $scope.selectedIndex = index;
//        console.log(index);
//        $('.hide-loadMore').show();
//        $scope.getCat = catName;
//        var formInfo = {'categoryName': catName};
//        ngPost('listing-tournaments', formInfo, $scope, $http, $templateCache, 'getDetails');
//    };
    var getPageCount = 1;
    $scope.loadMore = function (catName, getCount) {
        getPageCount++;
        //console.log(getCount);
        var formInfo = {'categoryName': $.urlParam('category'), 'getCount': getPageCount};
        ngPost('listing-tournaments', formInfo, $scope, $http, $templateCache, 'getDetails');

    };
});

app.controller('listingMatch', function ($http, $scope, $templateCache) {
    sessionStorage.setItem('getCount', '');
    $scope.category = 'popular';
    $scope.selectedIndex = 'home';
    $scope.homeMatchListing = [];
    var countLoad = 1;
    $.urlParam = function (name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results == null) {
            return null;
        } else {
            return results[1] || 0;
        }
    };
    $scope.categoryName = $.urlParam('category');

    if ($.urlParam('category') !== '') {
        var formData = {'categoryName': $.urlParam('category')};
    } else {
        var formData = {};
    }

    $scope.tradeMatch = function (link, tid, points, uid, pointsTie, event) {

        angular.element(event.target).attr('disabled', 'disabled');
        console.log(points);
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

            tourDetails('multi-trade-match', formDataNew, $scope, $http, $templateCache, 'blockName', event, points);

        } else {
            sessionStorage.setItem('url', document.URL);
            window.location = base_url + "register?url=redirect";
        }
    }; //for login redirect
    //console.log( $.urlParam('category'));
    ngPost('listing-matches', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (type, $index) {
        $scope.category = type;
        countLoad = 1;
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
        var formInfo = {'categoryName': $.urlParam('category'), 'type': type, 'filter': 'yes'};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getDetails');
    };

    $scope.loadMore = function (catName, getCount) {

        countLoad++;
        //console.log($.urlParam('category'));
        // console.log(getCount);

        sessionStorage.setItem('getCount', countLoad);
        var formInfo = {'categoryName': $.urlParam('category'), 'getCount': countLoad, 'type': sessionStorage.getItem('type'), 'loadMore': 'true'};
        ngPost('listing-matches', formInfo, $scope, $http, $templateCache, 'getDetails');
    };
});

function ngPost(typeName, formData, $scope, $http, $templateCache, errorBlock, event) {

    $http({
        method: 'POST',
        url: domain + typeName,
        data: $.param({'data': formData}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        cache: $templateCache
    }).
            success(function (response) {
                if (typeName == 'home-match-listing') {
                    jQuery.each(response.upcomingMatches.catPost, function (k, v) {
                        // console.log(v);
                        $scope.homeMatchListing.push(v);
                    })
                }
                if (typeName == 'listing-tournaments') {

                    if (response.catPost.length < 6) {
                        $('.hide-loadMore').hide();
                    }
                    jQuery.each(response.catPost, function (k, v) {
                        $scope.tourListing.push(v);
                    });
                }

                if (typeName == 'listing-matches' && formData['filter'] != 'yes') {

                    $('.updateUserKit').html(response['userTotalPts']);
                    jQuery.each(response.catPost, function (k, v) {
                        // console.log(v);
                        $scope.homeMatchListing.push(v);

                    });
                }
                if (formData['filter'] == 'yes') {
                    $scope.homeMatchListing = [];
                    $('.updateUserKit').html(response['userTotalPts']);
                    jQuery.each(response.catPost, function (k, v) {
                        // console.log(v);
                        $scope.homeMatchListing.push(v);

                    });
                }

                if (typeName == 'tournaments-detail') {
                    $('.updateUserKit').html(response['userTotalPts']);
                }
                if (typeName == 'download-csv') {
                    window.location = response.url;
                    $(document).ready(function () {
                        $('.loaderDownload').hide();
                    });
                }
                if (typeName == 'my-account' && formData['type'] == 'myAccountFilter') {
                    jQuery.each(response['userBets'], function (k, v) {    // # user bets loadmore
                        $scope.posts.push(v);
                    });

                    if (response['userBets'].length == 0) {
                        $('.paginateNext').hide();
                    }                                                        // # user bets loadmore
                }
                if (typeName == 'my-account' && formData['type'] != 'myAccountFilter' && formData['type'] !== 'myAccountFilterWin') {
                    $scope.posts = [];                                 // # user bets loadmore
                    jQuery.each(response['userBets'], function (k, v) {
                        $scope.posts.push(v);
                    });                                                 // # user bets loadmore
                    //$scope.posts = response['userBets'];
                    $scope.winList = [];                                 // # user win loadmore
                    jQuery.each(response['winLoss'], function (k, v) {
                        $scope.winList.push(v);
                    });                                                 // # user win loadmore

                }
                //for pagination of matches
                if (formData['type'] === 'myAccountFilterWin') {
                    jQuery.each(response['winLoss'], function (k, v) {
                        $scope.winList.push(v);
                    });
                    if (response['winLoss'].length == 0) {
                        $('.paginateNextWin').hide();
                    }                                                  // # user win loadmore
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


                if (typeName == 'login') {
                    $('.loader').hide();
                    $('.alert').show();
                }
                if (typeName == 'contact-us') {
                    angular.element(event.target).removeAttr('disabled');
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
                    } else {
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
                    if (typeName != 'home-match-listing' && (typeName != 'listing-matches' && formData['filter'] != 'yes') && typeName != 'listing-tournaments' && formData['type'] != 'myAccountFilter' && formData['type'] != 'myAccountFilterWin' && typeName != 'download-csv') {
                        $('.toolMsg').attr('data-original-title', "These points will be credited to your 'Cleared Points' after " + response['bufferDay'] + " days of winning Tournament/Match result");

                        $scope[errorBlock] = response;
                    }

                }
                ;
            }).
            error(function (response) {
                $scope[errorBlock] = response || "Request failed";
            });
}

function tourDetails(typeName, formData, $scope, $http, $templateCache, msgBlock, event, points) {

    $http({
        url: domain + typeName,
        method: "POST",
        data: $.param({'data': formData}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        cache: $templateCache
    }).then(function (response) {

        if (formData['type'] === 'popularMatches') {
            $('.updateUserKit').html(response.data.userTotalPts);
            $("." + formData['mid'] + "-" + 'totalMid').html(response.data.totalMid);
            angular.element(event.target).removeAttr('disabled');
            jQuery.each(response.data.mytradedPoints, function (k, v) {
                if (v > 0)
                    $("." + formData['mid'] + "-" + k).html("You've traded " + v + " pts.");
            });
            $scope.points = "";
            $scope.pointsTie = '';
            // $('.trade').val('');
        }

        if (formData['type'] === 'tournaments') {
            $scope.pointsTie = "";
            angular.element(event.target).removeAttr('disabled');
            var formDataReload = {'postId': formData['slug']};
            ngPost('tournaments-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');
        } else if (formData['type'] === 'matches') {

            var formDataReload = {'postId': formData['slug']};
            ngPost('matches-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');
        } else if (formData['type'] === 'matchesList') {
            $scope.points = "";
            $scope.pointsTie = "";
            angular.element(event.target).removeAttr('disabled');
            $('.updateUserKit').html(response.data.userTotalPts);
            $("." + formData['mid'] + "-" + 'totalMid').html(response.data.totalMid);
            jQuery.each(response.data.mytradedPoints, function (k, v) {
                if (v > 0)
                    $("." + formData['mid'] + "-" + k).html("You've traded " + v + " pts.");
            });
        } else if (formData['type'] === 'tournamentMatcheList') {
            $scope.points = "";
            $("." + formData['mid'] + "-" + 'totalMid').html(response.data.totalMid);
            angular.element(event.target).removeAttr('disabled');
            $('.updateUserKit').html(response.data.userTotalPts);
            $scope.pointsTieM = "";
        } else if (formData['type'] === 'tournamentsMatches') { //not used need to check
            var formDataReload = {'postId': formData['mainSlug']};
            ngPost('tournaments-detail', formDataReload, $scope, $http, $templateCache, 'getDetails');

        }
        $('.loader').hide();

        if (typeName === 'password-update') {
            if (response['data'] == "Password changed successfully") {

                swal({
                    html: true,
                    title: response.data
                });
                window.location = domain + "logout";
            } else if (response['data'] == "Old Password doesn't Match") {
                swal({
                    html: true,
                    title: response.data
                });
            }
        } else {
            swal({
                html: true,
                title: response.data.msg
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
    $scope.contacForm = function (event) {

        $('.col-ch').hide();
        $('#template-contactform').valid();
        if (!$('#template-contactform').valid()) {
            return false;
        }
        $('.loader').show();
        angular.element(event.target).attr('disabled', 'disabled');
        var formData = $('#template-contactform').serialize();
        ngPost('contact-us', formData, $scope, $http, $templateCache, 'errorReg', event);
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
        } else {
            return results[1] || 0;
        }
    };
}