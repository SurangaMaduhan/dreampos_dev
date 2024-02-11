<?php
// Include the RelevanssiIndex class
require_once WP_PLUGIN_DIR . '/relevanssi/lib/indexing.php';
add_action('rest_api_init', function () {
    register_rest_route(
        'products/v1/',
        'index-all',
        array(
            'methods' => 'post',
            'callback' => 'index_all',
        )
    );
});
function index_all($deta)
{
    if (function_exists( 'relevanssi_search' )) {
        // Trigger Relevanssi index build
        $relevanssi_index = new RelevanssiIndex();
        $relevanssi_index->build_index();

        // Return a response
        return array('success' => true, 'message' => 'Relevanssi index build triggered successfully.');
    } else {
        // Relevanssi plugin not active
        return array('success' => false, 'message' => 'Relevanssi plugin is not active.');
    }
}
