<?php
// Set maximum execution time to unlimited
set_time_limit(0);

// Initialize cURL
$ch = curl_init();

// Configure cURL options
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt(
    $ch,
    CURLOPT_URL,
    "https://xxxxxx:shpat_xxxxx@shopify_store_url.com/admin/api/2023-07/products.json?limit=250&fields=id,variants"
);

// Execute cURL and store result
$result_products = curl_exec($ch);

// Decode JSON result
$products = json_decode($result_products, true);
$variants_ids = [];
$product_ids = [];

// Extract variant and product IDs
foreach ($products["products"] as $product) {
    array_walk_recursive($product["variants"], function ($value, $key) use (&$variants_ids) {
        if ($key == "id") {
            $variants_ids[] = $value;
        }
    });

    if (isset($product["id"])) {
        $product_ids[] = $product["id"];
    }
}

// Clean up cURL resources
curl_close($ch);

// Result arrays for variant and inventory data
$result_sites_variant = [];
$result_sites_inventory = [];

// Process each variant
foreach ($variants_ids as $variant_id) {
    // Initialize cURL for variant data
    $ch_variant = curl_init();

    // Construct variant API endpoint
    $site_variant = "https://shopify_store_url.com/admin/api/2023-07/variants/{$variant_id}.json?fields=id,product_id,inventory_item_id";

    // Set cURL options for variant request
    curl_setopt($ch_variant, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_variant, CURLOPT_URL, $site_variant);

    // Execute cURL for variant data and decode JSON
    $json_variant = curl_exec($ch_variant);
    $obj_variant = json_decode($json_variant);

    // Store variant data in result array
    $result_sites_variant[] = $obj_variant;

    // Extract product and inventory IDs
    $product_id = $obj_variant->variant->product_id;
    $inventory_item_id = $obj_variant->variant->inventory_item_id;

    // Clean up cURL resources for variant data
    curl_close($ch_variant);

    // Initialize cURL for inventory item data
    $ch_inventory = curl_init();

    // Construct inventory item API endpoint
    $site_inventory_item = "https://shopify_store_url.com/admin/api/2023-07/inventory_items/{$inventory_item_id}.json";

    // Set cURL options for inventory item request
    curl_setopt($ch_inventory, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_inventory, CURLOPT_URL, $site_inventory_item);

    // Execute cURL for inventory item data and decode JSON
    $json_inventory = curl_exec($ch_inventory);
    $obj_inventory = json_decode($json_inventory);

    // Store inventory item data in result array
    $result_sites_inventory[] = $obj_inventory;

    // Extract variant cost from inventory item
    $variant_cost = $obj_inventory->inventory_item->cost;

    // Clean up cURL resources for inventory item data
    curl_close($ch_inventory);

    // Initialize cURL for updating metafield
    $ch_update_metafield = curl_init();

    // Construct metafield API endpoint
    $url = "https://lovebriks-3.myshopify.com/admin/api/2023-07/variants/{$variant_id}/metafields.json";

    // Prepare data for updating metafield
    $data = [
        "namespace" => "custom",
        "key" => "variant_cost",
        "type" => "number_decimal",
        "value" => $variant_cost,
    ];
    $postdata = json_encode(["metafield" => $data]);

    // Set cURL options for updating metafield
    curl_setopt($ch_update_metafield, CURLOPT_POST, 1);
    curl_setopt($ch_update_metafield, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch_update_metafield, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch_update_metafield, CURLOPT_URL, $url);
    curl_setopt($ch_update_metafield, CURLOPT_HTTPHEADER, [
        "X-Shopify-Access-Token: shpat_xxxxx",
        "Content-Type: application/json",
    ]);

    // Execute cURL for updating metafield and decode JSON
    $result_update_metafield = curl_exec($ch_update_metafield);
    $obj_update_metafield = json_decode($result_update_metafield);

    // Clean up cURL resources for updating metafield
    curl_close($ch_update_metafield);

    // Extract metafield ID
    $metafield_id = $obj_update_metafield->id;
}

// Print "done" when script completes
print_r("done");
?>
