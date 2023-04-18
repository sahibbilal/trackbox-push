<?php

function max_fields_design(){
    $options = get_option( 'track_box_push_options' );
//    update_option( 'track_box_push_options', '');
    add_settings_field(
        'track_box_push_apiKey',
        __( 'API Key', 'track_box_push' ),
        'track_box_push_track_box_push_apiKey',
        'track_box_push',
        'track_box_push_design_styling',
        array(
            'label_for'         => 'track_box_push_apiKey',
            'class'             => 'track_box_push_row',
            'track_box_push_custom_data' => 'custom',
        )
    );
    if(!empty($options['custom'])) {
        foreach ($options['custom'] as $key => $single) {
            add_settings_field(
                'track_box_push_details' . $key,
                __('Account Details '.$key, 'track_box_push'),
                'track_box_push_details_cb',
                'track_box_push',
                'track_box_push_design_styling',
                array(
                    'key' => $key,
                    'details' => $single,
                    'label_for' => 'track_box_push_details' . $key,
                    'class' => 'track_box_push_custom',
                    'track_box_push_custom_data' => 'custom',
                )
            );
        }
    }
    add_settings_field(
        'track_box_push_add',
        __( 'Further Details', 'track_box_push' ),
        'track_box_push_track_box_push_add_cb',
        'track_box_push',
        'track_box_push_design_styling',
        array(
        )
    );
}
function track_box_push_track_box_push_apiKey( $args ) {
    $options = get_option( 'track_box_push_options' );
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" style="width: 50%;"
           name="track_box_push_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
           data-custom="<?php echo esc_attr( $args['track_box_push_custom_data'] ); ?>"
           value="<?php echo isset($options[$args['label_for']]) ? esc_attr($options[$args['label_for']]) : ''; ?>" required />

    <p class="description">
        <?php esc_html_e( 'Trackbox API Key', 'track_box_push' ); ?>
    </p>
    <?php
}
function track_box_push_track_box_push_add_cb( $args ) {
    $options = get_option( 'track_box_push_options' );

    ?>
    <p class="button button-success" id="add_compaign" data-ajax="<?php echo admin_url('admin-ajax.php'); ?>">Add New</p>
    <?php
}


function track_box_push_details_cb( $args ) {
    $key= $args['key'];
    $options = get_option( 'track_box_push_options' );
    foreach ($args['details'] as $k => $single){
        $_name = 'track_box_push_options[custom]['.$key.']['.$k.']';
        if (is_array($single)) {
            $val = implode(',', $single);
        } else {
            $val = (!empty($single)) ? $single : 'MPC_1 = asd, MPC_2 = FreeParam, MPC_3 = FreeParam, MPC_4 = FreeParam, MPC_5 = FreeParam, MPC_6 = FreeParam, MPC_7 = FreeParam, MPC_8 = FreeParam, MPC_9 = FreeParam, MPC_10 = FreeParam';
        }
        if ($k === 'mpc') {
            ?>
            <textarea style="width: 50%;" name="<?php echo $_name; ?>" data-custom="custom" placeholder="<?php echo $k; ?>" required><?php echo $val; ?></textarea>
            <p class="description"><br />Enter multiple values separated by commas (e.g. value1, value2, value3)</p>
            <?php
        } else {
            ?>
            <input type="text" name="<?php echo $_name; ?>" placeholder="<?php echo $k; ?>" value="<?php echo $single; ?>" style="margin-bottom: 10px" required><br />
            <?php
        }

    }
}




