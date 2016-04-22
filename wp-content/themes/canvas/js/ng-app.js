/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var domain = "http://localhost:1234/gamings/api?action=";
var base_url = "http://localhost:1234/gamings/";




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

    ngPost('tournaments-detail', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.trade = function (tid, teamId, pts) {
        var formData = {
            'tid': tid,
            'team_id': teamId,
            'pts': pts,
            'slug': slug

        };
        tourDetails('trade', formData, $scope, $http, $templateCache, 'blockName');

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
    $scope.trade = function (tid, teamId, pts) {
        var formData = {
            'mid': tid,
            'team_id': teamId,
            'pts': pts

        };
        tourDetails('trade', formData, $scope, $http, $templateCache, 'blockName');

    };

    $scope.getTrade = function (teamId) {
        console.log(teamId);
    };


});

app.controller('listingTour', function ($http, $scope, $templateCache) {
    var formData = {};
    ngPost('listing-tournaments', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (catName) {
        $('.pf-media').show();
            if (catName === 'All')
                $('.pf-media').show();
            else
                $('.pf-media').not('.pf-' + catName).hide();
    };
});

app.controller('listingMatch', function ($http, $scope, $templateCache) {
    var formData = {};
    ngPost('listing-matches', formData, $scope, $http, $templateCache, 'getDetails');
    $scope.filter = function (catName) {
        $('.pf-media').show();
            if (catName === 'All')
                $('.pf-media').show();
            else
                $('.pf-media').not('.pf-' + catName).hide();
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
                if (response === "success_login") {
                    window.location.href = base_url + 'my-account/';
                } else {
                    $scope[errorBlock] = response;
                    angular.element(document).ready(function () {

                        console.log($('.stage').length);
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
        alert(response.data);
    });
}


