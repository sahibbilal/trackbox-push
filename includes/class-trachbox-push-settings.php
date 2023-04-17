<?php

function track_box_push_settings_init() {

    register_setting( 'track_box_push', 'track_box_push_options' );
    register_setting( 'track_box_push_settings', 'track_box_push_settings' );

    max_section_design();
    max_fields_design();

}

add_action( 'admin_init', 'track_box_push_settings_init' );

function max_section_design(){

    add_settings_section(
        'track_box_push_design_styling',
        __( 'Required Parameters', 'track_box_push' ), 'track_box_push_section_styling_data',
        'track_box_push'
    );

}

function track_box_push_section_styling_data( $args ) {
    ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>">
        <?php esc_html_e( '', 'track_box_push' ); ?>
    </p>
    <?php
}

function track_box_push_options_page() {

    add_menu_page(
        'Trackbox Push',
        'Trackbox Push',
        'manage_options',
        'track_box_push',
        'track_box_push_html',
        'dashicons-analytics'
    );

}

add_action( 'admin_menu', 'track_box_push_options_page' );

function track_box_push_html() {

    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    if ( isset( $_GET['settings-updated'] ) ) {
        add_settings_error( 'track_box_push_messages', 'track_box_push_message', __( 'Settings Saved', 'track_box_push' ), 'updated' );
    }
    settings_errors( 'track_box_push_messages' );

    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <div class="tab-content">
            <?php
            max_design_tab();
            ?>
        </div>
    <?php
}

function max_design_tab(){
    ?>
    <form action="options.php" method="post">
        <?php
        settings_fields( 'track_box_push' );
        do_settings_sections( 'track_box_push' );
        submit_button( 'Save Settings' );
        ?>
    </form>
    <?php
}

