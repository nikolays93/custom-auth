<?php

namespace NikolayS93\Auth;

add_filter('login_url', function() { return LOGINPAGE; }, 10, 1);
add_filter('register_url', function() { return REGISTERPAGE; }, 10, 1);
add_filter('lostpassword_url', function() { return LOSTPWDPAGE; }, 10, 1);

add_action('init', function(){
    $login_url = apply_filters( 'wp-login-file',
        'wp-content/plugins/' . DOMAIN . '/wp-login.php' );

  add_rewrite_rule( ltrim(LOGINPAGE, '/') . '/?$', $login_url );
  add_rewrite_rule( ltrim(REGISTERPAGE, '/') . '/?$', $login_url . '?action=register' );
  add_rewrite_rule( ltrim(LOSTPWDPAGE, '/') . '/?$', $login_url . '?action=lostpassword' );
});

/**
* Логотип на форме входа
*/
add_action('login_header', __NAMESPACE__ . '\login_header_logo_css');
function login_header_logo_css() {
    if( $logo_id = get_theme_mod( 'custom_logo' ) ) {
        $logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
?>
<style type="text/css">
    body.login {
        background:;
    }
    #login.left {
        width: 1200px;
    }
    #login.left h1,
    #login.left #loginform,
    #login.left #nav,
    #login.left #backtoblog {
        display: block;
        width: 320px;
        padding-left: 24px;
        padding-right: 24px;
    }
    #login.right h1,
    #login.right #loginform,
    #login.right #nav,
    #login.right #backtoblog {
        margin-left: auto;
    }
    #login h1 a {
        background: url('<?=$logo_src[0];?>') center no-repeat;
        background-size: contain;
        width: <?=$logo_src[1];?>px;
        max-width: 100%;
    }
</style>
<?php
    }
}

add_filter( 'login_headerurl', 'home_url', 10, 0 );