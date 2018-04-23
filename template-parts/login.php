<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( LOGINPAGE, 'login_post' ) ); ?>" method="post">
    <p>
        <label for="user_login"><?php echo apply_filters('user_login_label', __( 'Username or Email Address' )); ?><br />
        <input type="text" name="log" id="user_login"<?php echo $aria_describedby_error; ?> class="input" value="<?php echo esc_attr( $user_login ); ?>" size="20" /></label>
    </p>
    <p>
        <label for="user_pass"><?php echo apply_filters('user_pass_label', __( 'Password' ) ); ?><br />
        <input type="password" name="pwd" id="user_pass"<?php echo $aria_describedby_error; ?> class="input" value="" size="20" /></label>
    </p>
    <?php
    /**
     * Fires following the 'Password' field in the login form.
     *
     * @since 2.1.0
     */
    do_action( 'login_form' );
    ?>
    <p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever" <?php checked( $rememberme ); ?> /> <?php esc_html_e( 'Remember Me' ); ?></label></p>
    <p class="submit">
        <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Log In'); ?>" />
<?php   if ( $interim_login ) { ?>
        <input type="hidden" name="interim-login" value="1" />
<?php   } else { ?>
        <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>" />
<?php   } ?>
<?php   if ( $customize_login ) : ?>
        <input type="hidden" name="customize-login" value="1" />
<?php   endif; ?>
        <input type="hidden" name="testcookie" value="1" />
    </p>
</form>

<?php if ( ! $interim_login ) { ?>
<p id="nav">
<?php if ( ! isset( $_GET['checkemail'] ) || ! in_array( $_GET['checkemail'], array( 'confirm', 'newpass' ) ) ) :
    if ( get_option( 'users_can_register' ) ) :
        $registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

        /** This filter is documented in wp-includes/general-template.php */
        echo apply_filters( 'register', $registration_url );

        echo esc_html( $login_link_separator );
    endif;
    ?>
    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?' ); ?></a>
<?php endif; ?>
</p>
<?php } ?>

<script type="text/javascript">
function wp_attempt_focus(){
setTimeout( function(){ try{
<?php if ( $user_login ) { ?>
d = document.getElementById('user_pass');
d.value = '';
<?php } else { ?>
d = document.getElementById('user_login');
<?php if ( 'invalid_username' == $errors->get_error_code() ) { ?>
if( d.value != '' )
d.value = '';
<?php
}
}?>
d.focus();
d.select();
} catch(e){}
}, 200);
}

<?php
/**
 * Filters whether to print the call to `wp_attempt_focus()` on the login screen.
 *
 * @since 4.8.0
 *
 * @param bool $print Whether to print the function call. Default true.
 */
if ( apply_filters( 'enable_login_autofocus', true ) && ! $error ) { ?>
wp_attempt_focus();
<?php } ?>
if(typeof wpOnload=='function')wpOnload();
<?php if ( $interim_login ) { ?>
(function(){
try {
    var i, links = document.getElementsByTagName('a');
    for ( i in links ) {
        if ( links[i].href )
            links[i].target = '_blank';
    }
} catch(e){}
}());
<?php } ?>
</script>
