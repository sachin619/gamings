<?php
/*
 * Plugin Name: Bets Table
 * Description: An example of how to use the WP_List_Table class to display data in your WordPress Admin area
 * Plugin URI: http://www.paulund.co.uk
 * Author: Paul Underwood
 * Author URI: http://www.paulund.co.uk
 * Version: 1.0
 * License: GPL2
 */
error_reporting(0);
if (is_admin()) {
    new Paulund_Wp_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Paulund_Wp_List_Table {

    /**
     * Constructor will create the menu item
     */
    public function __construct() {
        add_action('admin_menu', array($this, 'add_menu_example_list_table_page'));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_example_list_table_page() {
        add_menu_page('Bets', 'Bets', 'manage_options', 'example-list-table.php', array($this, 'list_table_page'));
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page() {
        $exampleListTable = new Example_List_Table();
        $exampleListTable->prepare_items();
        ?>
        <div class="wrap">
            <div id="icon-users" class="icon32"></div>
            <h2>Total Bets</h2>
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
class Example_List_Table extends WP_List_Table {

    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id', true),
            'uid' => array('uid', true),
            'mid' => array('mid', true),
            'tid' => array('tid', true),
            'team_id' => array('team_id', true),
            'pts' => array('pts', true),
            'bet_at' => array('bet_at', true)
        );
        return $sortable_columns;
    }

    public function prepare_items() {
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
            'pts' => 'Points',
            'bet_at' => 'Bet Placed On'
        );

        return $columns;
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data() {
        $orderby = isset($_GET['orderby']) ? $_GET['orderby'] : 'id';
        $order = isset($_GET['order']) ? $_GET['order'] : 'asc';
        global $wpdb;

        $data = $wpdb->get_results("SELECT * FROM wp_bets order by $orderby $order ", ARRAY_A);
        return $data;
    }

    public function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id':
                return $item[$column_name];
                break;
            case 'uid':
                $getUsername = get_userdata($item[$column_name]);
                return $getUsername->data->user_login;
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
            case 'pts':
                return $item[$column_name];
                break;
            case 'bet_at':
                return date('d M, Y h:i a', strtotime($item[$column_name]));

            default:
                return print_r($item, true);
        }
    }

}
?>