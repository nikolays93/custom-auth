<form name="resetpassform" id="resetpassform" action="<?php echo esc_url( network_site_url( LOGINPAGE . '?action=resetpass', 'login_post' ) ); ?>" method="post" autocomplete="off">
    <input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off" />

    <div class="user-pass1-wrap">
        <p>
            <label for="pass1"><?php _e( 'New password' ) ?></label>
        </p>

        <div class="wp-pwd">
            <div class="password-input-wrapper">
                <input type="password" data-reveal="1" data-pw="<?php echo esc_attr( wp_generate_password( 16 ) ); ?>" name="pass1" id="pass1" class="input password-input" size="24" value="" autocomplete="off" aria-describedby="pass-strength-result" />
                <span class="button button-secondary wp-hide-pw hide-if-no-js">
                    <span class="dashicons dashicons-hidden"></span>
                </span>
            </div>
            <div id="pass-strength-result" class="hide-if-no-js" aria-live="polite"><?php _e( 'Strength indicator' ); ?></div>
        </div>
        <div class="pw-weak">
            <label>
                <input type="checkbox" name="pw_weak" class="pw-checkbox" />
                <?php _e( 'Confirm use of weak password' ); ?>
            </label>
        </div>
    </div>

    <p class="user-pass2-wrap">
        <label for="pass2"><?php _e( 'Confirm new password' ) ?></label><br />
        <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
    </p>

    <p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
    <br class="clear" />

    <?php
    /**
     * Fires following the 'Strength indicator' meter in the user password reset form.
     *
     * @since 3.9.0
     *
     * @param WP_User $user User object of the user whose password is being reset.
     */
    do_action( 'resetpass_form', $user );
    ?>
    <input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>" />
    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Reset Password'); ?>" /></p>
</form>

<p id="nav">
    <a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e( 'Log in' ); ?></a>
    <?php
    if ( get_option( 'users_can_register' ) ) :
        $registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

        echo esc_html( $login_link_separator );

        /** This filter is documented in wp-includes/general-template.php */
        echo apply_filters( 'register', $registration_url );
    endif;
    ?>
</p>
