<form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( network_site_url( LOSTPWDPAGE, 'login_post' ) ); ?>" method="post">
    <p>
        <label for="user_login" ><?php _e( 'Username or Email Address' ); ?><br />
        <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" /></label>
    </p>
    <?php
    /**
     * Fires inside the lostpassword form tags, before the hidden fields.
     *
     * @since 2.1.0
     */
    do_action( 'lostpassword_form' ); ?>
    <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Get New Password'); ?>" /></p>
</form>

<p id="nav">
    <a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e('Log in') ?></a>
    <?php
    if ( get_option( 'users_can_register' ) ) :
        $registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

        echo esc_html( $login_link_separator );

        /** This filter is documented in wp-includes/general-template.php */
        echo apply_filters( 'register', $registration_url );
    endif;
    ?>
</p>
