<?php

function saf_filter_perset_group() {
    $remove_taxs = [
        'product_type',
        'product_visibility',
        'product_shipping_class',
    ];
    $taxonomies = get_object_taxonomies('product');
    foreach ($remove_taxs as $remove_tax) {
        if (($key = array_search($remove_tax, $taxonomies)) !== false) {
            array_splice($taxonomies, $key, 1);
        }
    }
    echo json_encode($taxonomies);
    exit();
}

add_action('wp_ajax_saf_filter_perset_group', 'saf_filter_perset_group');
