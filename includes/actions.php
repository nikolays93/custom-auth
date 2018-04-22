<?php
/*
add_action('register_form', function() {
    $phone = '';
    if( !empty($_POST['user_phone']) )
        $phone = esc_attr( wp_unslash( $user_phone ) );
    ?>
    <p>
        <label for="user_phone"><?php _e('Phone number') ?><br />
        <input type="text" name="user_phone" id="user_phone" class="input" value="<?php echo $phone;?>" size="15" /></label>
    </p>
    <?php
});
*/
add_action('register_form', function() { ?>
    <p id="reg_passmail"><?php _e( 'Registration confirmation will be emailed to you.' ); ?></p>
<?php
}, 99);
