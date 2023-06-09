<?php
// helper functions

add_action('admin_menu', 'borncreative_wc_cart_view_admin_stuff', 99);

function borncreative_wc_cart_view_admin_stuff()
{
	add_menu_page(
        'Born Creative',
        'Born Creative',
        'edit_others_posts',
        'born-creative',
        '',
        'dashicons-admin-generic',
        2
    );
    
    // Create a sub-menu under the top-level menu
    add_submenu_page(
        'born-creative',
        'View Carts',
        'View Carts',
        'edit_others_posts',
        'view-carts',
        'borncreative_wc_cart_admin_view'
    );
}

function borncreative_wc_cart_admin_view()
{
    // include admin view
    if (file_exists(plugin_dir_path(__FILE__) . '../views/born-creative-wc-cart-view-admin-view.php')) {
        require_once plugin_dir_path(__FILE__) . '../views/born-creative-wc-cart-view-admin-view.php';
    }
}

function borncreative_wc_get_carts_information()
{
    global $wpdb;
    // carts are in woocommerce_sessions table
    // first we need to get that whole table.

    echo '<h2>Carts</h2>';
    $table_name = $wpdb->prefix . 'woocommerce_sessions';
    $result = $wpdb->get_results("SELECT * FROM $table_name");

    echo "<table>";
    echo "<tr><td>Product ID</td><td>Product Name</td><td>Quantity</td><td>Total</td></tr>";
    foreach ($result as $session) {
        // do we have actual cart datas?
        $datas = unserialize($session->session_value);
        if (!empty($datas)) {
            $array = unserialize($datas['cart']);

            if (!empty($array)) {
                //     // we have a cart

                $temp = array_keys($array);
                $key = $temp[0];
                $cart = $array[$key];
                $product = wc_get_product($cart['product_id']);
                echo "<tr>";
                echo "<td>" . $cart['product_id'] . "</td>";
                echo "<td>". $product->get_name() . "</td>";
                echo "<td>" . $cart['quantity'] . "</td>";
                echo "<td>" . $cart['line_total'] . "</td>";
                echo "</tr>";



                // echo "<tr><td>" . $product->get_name() . "</td><td>" . $cart[$key_name[0]]['quantity'] . "</td></tr>";

                // $product = wc_get_product( $cart[$key_name[0]]);

            }
        }
    }
    echo "</table>";
}
