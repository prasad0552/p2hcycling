<div class="wrap">
    <h1><?php _e( 'Add New Cycle', 'wep2h' ); ?></h1>

    <?php $item = p2h_get_cycle( $id ); ?>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-name">
                    <th scope="row">
                        <label for="name"><?php _e( 'Name', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="name" id="name" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->name ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-description">
                    <th scope="row">
                        <label for="description"><?php _e( 'Description', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <textarea name="description" id="description"placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" rows="5" cols="30" required="required"><?php echo esc_textarea( $item->description ); ?></textarea>
                    </td>
                </tr>
                <tr class="row-image">
                    <th scope="row">
                        <label for="image"><?php _e( 'Image Path', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="image" id="image" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->image ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-status">
                    <th scope="row">
                        <label for="status"><?php _e( 'Status', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <select name="status" id="status" required="required">
                            <option value="1" <?php selected( $item->status, '1' ); ?>><?php echo __( 'Yes', 'wep2h' ); ?></option>
                            <option value="0" <?php selected( $item->status, '0' ); ?>><?php echo __( 'No', 'wep2h' ); ?></option>
                        </select>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="<?php echo $item->id; ?>">

        <?php wp_nonce_field( 'wp_p2h_cycles' ); ?>
        <?php submit_button( __( 'Update Cycle', 'wep2h' ), 'primary', 'submit_cycle' ); ?>

    </form>
</div>