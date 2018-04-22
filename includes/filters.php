<?php

add_filter('login_url', function() {

    return LOGINPAGE;
}, 10, 1);

add_filter('register_url', function() {

    return REGISTERPAGE;
}, 10, 1);

add_filter('lostpassword_url', function() {

    return LOSTPWDPAGE;
}, 10, 1);
