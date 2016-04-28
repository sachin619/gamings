<?php
/*
 * Plugin Name: Distribution Table

 */
error_reporting(0);
if (is_admin()) {
    new Distribution_Wp_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Distribution_Wp_List_Table {

    /**
     * Constructor will create the menu item
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_menu_example_dlist_table_page'));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_example_dlist_table_page() {
        add_menu_page('Distribution', 'Points Distribution', 'manage_options', 'pointsDistribution.php', array($this, 'distribution_dlist_table_page'));
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function distribution_dlist_table_page() {
        $exampleListTable = new Distribution_Table();
        $exampleListTable->the_prepare_items();
        ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Points Distribution</h2>
            <div>
                <form method="post" action="<?= get_site_url(); ?>/wp-admin/admin.php?page=pointsDistribution.php">
                    <input type="text" value="<?= $_POST['tName'] ?>" name="tName" class="tourAuto" placeholder="Select Tournament"  />
                    <input type="text" value="<?= $_POST['matchTitle'] ?>" placeholder="Select Match"  name="matchTitle" class="matcAuto">
                    <input type="submit" value="Search" />
                </form>
            </div>
            <?php $exampleListTable->display(); ?>
        </div>
        <?php
    }

}

// WP_List_Table is not loaded automatically so we need to load it in our application
if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Distribution_Table extends WP_List_Table {

    public function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id', true),
            'uid' => array('uid', true),
            'mid' => array('mid', true),
            'tid' => array('tid', true),
            'team_id' => array('team_id', true),
            'gain_points' => array('gain_points', true),
            'date' => array('date', true)
        );
        return $sortable_columns;
    }

    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function the_prepare_items() {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns() {
        $columns = array(
            'id' => 'ID',
            'uid' => 'User',
            'tid' => 'Tournament',
            'mid' => 'Match',
            'team_id' => 'Team',
            'gain_points' => 'Gain Points',
            'date' => 'Date & Time'
        );

        return $columns;
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data() {
        $getTName = trim($_POST['tName']);
        $getMName = trim($_POST['matchTitle']);
        $getTitleId = get_page_by_title($getTName, OBJECT, 'tournaments');
        $getId = $getTitleId->ID;
        $where = isset($getId) ? " AND tid=" . $getId : "";
        if ($getMName != ""):
            $getMTitleId = get_page_by_title($_POST['matchTitle'], OBJECT, 'matches');
            $getMId = $getMTitleId->ID;
            if ($getMId != ""):
                $whereM = " AND mid=" . $getMId;
            endif;
        endif;
        global $wpdb;
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        $data = $wpdb->get_results("SELECT * FROM  wp_distribution WHERE id IS NOT NULL  $where $whereM ORDER BY  $orderby $order ", ARRAY_A);
        return $data;
    }

    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id':
                return $item[$column_name];
                break;
            case 'uid':
                $getUserData = get_userdata($item[$column_name]);
                return $getUserData->data->display_name;
                break;
            case 'mid':
                return get_the_title($item[$column_name]);
                break;
            case 'tid':
                return get_the_title($item[$column_name]);
                break;
            case 'team_id':
                return get_the_title($item[$column_name]);
                break;
            case 'gain_points':
                return $item[$column_name];
                break;
            case 'date':
                return date('d M, Y h:i a', strtotime($item[$column_name]));

            default:
                return print_r($item, true);
        }
    }

}
?>