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
        if (uid != null) {
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
            sessionStorage.setItem('url',document.URL);
            window.location = base_url + "register?url=redirect";
        }
    };
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
            sessionStorage.setItem('url',document.URL);
            window.location = base_url + "register?url=redirect";

        }
    };

    $scope.getTrade = function (teamId) {
        console.log(teamId);
    };


});

app.controller('listingTour', function ($http, $scope, $templateCache) {
    var formData = {};
    ngPost('listing-tournaments', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (catName) {
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
    var formData = {};
    ngPost('listing-matches', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (catName) {
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
                }
                if (response === "success_login") {
                    if ($.urlParam('url') == null) {
                        window.location.href = base_url + 'my-account/';
                    } else {
                        window.location.href =  sessionStorage.getItem("url");;
                    }
                } else {
                    $scope[errorBlock] = response;
                    angular.element(document).ready(function () {
                        console.log(response);
                        if ($('.blockTrade').length === 1) {
                            $('.blockTrade').replaceWith("<td colspan='2'>Winner </td>");
                            $('.blockAction').replaceWith("");
                        }
                    });
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

        swal({
            title: response.data
        });
    });
}


