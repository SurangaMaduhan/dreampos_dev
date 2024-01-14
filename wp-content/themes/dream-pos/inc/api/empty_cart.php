<?php 
add_action('rest_api_init', function () {
    register_rest_route(
        'v1/products/',
        'empty-cart',
        array(
            'methods' => 'post',
            'callback' => 'empty_cart',
        )
    );
});

function empty_cart()
{
    $result =  WC()->cart->empty_cart();
    
    if($result){
        return 'succsess';
    } else{
        return 'false';
    }
}