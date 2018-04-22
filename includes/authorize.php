<?php

/**
 * @todo:  sanitize phone number
 */
add_filter('sanitize_number', 'sanitize_text_field', 5, 1);
// add_filter('sanitize_number', 'plain_number_filter', 10, 1);
// function plain_number_filter($phonenumber){
//   $plain_number = preg_replace("/^\+7/", "8", $phonenumber);
//   $plain_number = preg_replace("/[a-z\W]/ui", "", $plain_number);

//   return $plain_number;
// }

// add_action('woocommerce_checkout_process', 'is_phone');
// function is_phone() {
//   $billing_phone = sanitize_text_field( $_POST['billing_phone'] );
//   // your function's body above, and if error, call this wc_add_notice
//   // wc_add_notice( __( 'Your phone number is wrong.' ), 'error' );
// }

/**
 * Authenticates a user using the woocommerce billing phone number and password.
 *
 * @since 4.5.0
 *
 * @based on wp_authenticate_email_password from wp-includes/user.php.
 * @param WP_User|WP_Error|null $user     WP_User or WP_Error object if a previous
 *                                        callback failed authentication.
 * @param string                $phone    Phone number for authentication.
 * @param string                $password Password for authentication.
 * @return WP_User|WP_Error WP_User on success, WP_Error on failure.
 */
add_filter( 'authenticate', 'wp_authenticate_phone_password', 25, 3 );
function wp_authenticate_phone_password( $user, $phone, $password ) {
    if ( is_wp_error( $user ) || !is_a($user, 'WP_User') ) {
        return $user;
    }

    $phonenumber = apply_filters( 'sanitize_number', $phone );

    /** Check empty */
    $len = strlen($phonenumber);
    if ( $len < 5 || $len > 15 ) {
        // Uses 'empty_username' for back-compat with wp_signon()
        return new WP_Error( 'invalid_phonenumber',
            __( '<strong>ERROR</strong>: The phone number field is incorrect.') );
    }

    // get user by phonenumber
    $users = get_users( array(
        'meta_key' => 'billing_phone',
        'meta_value' => $phonenumber,
    ) );

    // first finded user
    reset( $users );
    $user = current( $users );

    if ( is_wp_error( $user ) || !$user ) {
        return new WP_Error( 'invalid_email',
            __( '<strong>ERROR</strong>: Invalid nickname, email or phone number.' ) .
            ' <a href="' . wp_lostpassword_url() . '">' .
            __( 'Lost your password?' ) .
            '</a>'
        );
    }

    /** This filter is documented in wp-includes/user.php */
    $user = apply_filters( 'wp_authenticate_user', $user, $password );

    if ( is_wp_error( $user ) ) {
        return $user;
    }

    if ( !wp_check_password( $password, $user->user_pass, $user->ID ) ) {
        return new WP_Error( 'incorrect_password',
            sprintf(
                /* translators: %s: phone number */
                __( '<strong>ERROR</strong>: The password you entered for the phone number or email address %s is incorrect.' ),
                '<strong>' . $phonenumber . '</strong>'
            ) .
            ' <a href="' . wp_lostpassword_url() . '">' .
            __( 'Lost your password?' ) .
            '</a>'
        );
    }

    return $user;
}

add_action( 'user_register', 'user_register_phonenumber', 10, 1 );
add_action( 'register_new_user', 'user_register_phonenumber', 10, 1 );
function user_register_phonenumber( $user_id ) {

    file_put_contents(__DIR__ . '/deb.log', print_r($_POST, 1));
    if ( isset( $_POST['user_phone'] ) )
        update_user_meta($user_id, 'billing_phone', $_POST['user_phone']);
}
