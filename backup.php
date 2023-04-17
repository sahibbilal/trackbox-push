function track_box_push_details_cb( $args ) {
    $key= $args['key'];
    $options = get_option( 'track_box_push_options' );
    foreach ($args['details'] as $k => $single){
        $_name = 'track_box_push_options[custom]['.$key.']['.$k.']';
        if ($k === 'mpc') {
            $mpc_values = is_array($single) ? $single : explode(',', $single);
            ?>
            <textarea name="<?php echo $_name; ?>" data-custom="custom" placeholder="<?php echo $k; ?>" required><?php echo implode(',', $mpc_values); ?></textarea>
            <span class="description">Enter multiple values separated by commas (e.g. value1, value2, value3)</span>
            <?php
        } else {
            ?>
            <input type="text" name="<?php echo $_name; ?>" placeholder="<?php echo $k; ?>" value="<?php echo $single; ?>" required><br />
            <?php
        }

    }
}




function track_box_push_details_cb( $args ) {
    $key= $args['key'];
    $options = get_option( 'track_box_push_options' );
    foreach ($args['details'] as $k => $single){
        $_name = 'track_box_push_options[custom]['.$key.']['.$k.']';
        $val = (!empty($single)) ? $single : 'MPC_1 = asd, MPC_2 = FreeParam, MPC_3 = FreeParam, MPC_4 = FreeParam, MPC_5 = FreeParam, MPC_6 = FreeParam, MPC_7 = FreeParam, MPC_8 = FreeParam, MPC_9 = FreeParam, MPC_10 = FreeParam';
//        if ($k === 'mpc') {
            ?>
            <textarea style="width: 50%;" name="<?php echo $_name; ?>" data-custom="custom" placeholder="<?php echo $k; ?>" required><?php echo $val; ?></textarea>
            <span class="description"><br />Enter multiple values separated by commas (e.g. value1, value2, value3)</span>
            <?php
//        }
        else {
            ?>
            <input type="text" name="<?php echo $_name; ?>" placeholder="<?php echo $k; ?>" value="<?php echo $single; ?>" required><br />
            <?php
        }

    }
}