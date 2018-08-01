<div class="wrap">
    <h1><?php _e( 'Add New Ride', 'wep2h' ); ?></h1>

    <?php $item = p2h_get_ride( $id ); ?>

    <form action="" method="post">
        <table class="form-table">
            <tbody>
                <tr class="row-user-id">
                    <th scope="row">
                        <label for="user_id"><?php _e( 'User', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="user_id" id="user_id" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->user_id ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-date">
                    <th scope="row">
                        <label for="date"><?php _e( 'Date', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="date" name="date" id="date" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->date ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-start-time">
                    <th scope="row">
                        <label for="start_time"><?php _e( 'Start Time', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="time" name="start_time" id="start_time" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->start_time ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-end-time">
                    <th scope="row">
                        <label for="end_time"><?php _e( 'End Time', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="time" name="end_time" id="end_time" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->end_time ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-fare">
                    <th scope="row">
                        <label for="fare"><?php _e( 'Fare', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="fare" id="fare" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->fare ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-is-submitted">
                    <th scope="row">
                        <label for="is_submitted"><?php _e( 'Submitted', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <select name="is_submitted" id="is_submitted" required="required">
                            <option value="1" <?php selected( $item->is_submitted, '1' ); ?>><?php echo __( 'Yes', 'wep2h' ); ?></option>
                            <option value="0" <?php selected( $item->is_submitted, '0' ); ?>><?php echo __( 'No', 'wep2h' ); ?></option>
                        </select>
                    </td>
                </tr>
                <tr class="row-rating">
                    <th scope="row">
                        <label for="rating"><?php _e( 'Rating', 'wep2h' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="rating" id="rating" class="regular-text" placeholder="<?php echo esc_attr( '', 'wep2h' ); ?>" value="<?php echo esc_attr( $item->rating ); ?>" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="ride_id" value="<?php echo $item->ride_id; ?>">

        <?php wp_nonce_field( 'user-rides-new' ); ?>
        <?php submit_button( __( 'Update Ride', 'wep2h' ), 'primary', 'submit_ride' ); ?>

    </form>
</div>