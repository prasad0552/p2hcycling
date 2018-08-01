<div class="wrap">
    <h2><?php _e( 'User Rides', 'wep2h' ); ?> <a href="<?php echo admin_url( 'admin.php?page=user-rides&action=new' ); ?>" class="add-new-h2"><?php _e( 'Add New', 'wep2h' ); ?></a></h2>

    <form method="post">
        <input type="hidden" name="page" value="ttest_list_table">

        <?php
        $list_table = new P2H_Rides_List();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
        ?>
    </form>
</div>