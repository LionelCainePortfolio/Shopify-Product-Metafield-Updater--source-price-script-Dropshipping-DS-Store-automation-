<h1>Shopify Product Metafield Updater</h1>

   This PHP script is designed to retrieve product information from a Shopify store, extract variant details, and update a custom metafield named "variant_cost" with the corresponding inventory item cost. This script utilizes the Shopify API to interact with the store.
    <h2>Requirements</h2>
    <ul>
        <li>PHP with cURL support enabled</li>
        <li>Shopify store with API access</li>
        <li>Shopify API credentials (API key, password, store URL)</li>
    </ul>
    <h2>How to Use</h2>
    <ol>
        <li>
            <h3>Set Up Shopify API Credentials:</h3>
            <ul>
                <li>Obtain your Shopify store API key, password, and store URL.</li>
                <li>Update the script with your credentials in the appropriate places.</li>
            </ul>
        </li>
        <li>
            <h3>Run the Script:</h3>
            <ul>
                <li>Upload the script to your server or execute it locally.</li>
                <li>Ensure that cURL is enabled in your PHP configuration.</li>
                <li>Run the script, and it will fetch product and variant information, update the "variant_cost" metafield, and print "done" upon completion.</li>
            </ul>
        </li>
    </ol>
    <h2>Configuration</h2>
    <p>Adjust the following variables in the script according to your Shopify store details:</p>
    <code>
        $storeUrl = 'your_shopify_store_url';<br>
        $apiKey = 'your_api_key';<br>
        $password = 'your_api_password';
    </code>
    <h2>Important Notes</h2>
    <ul>
        <li>This script disables the time limit to allow for longer execution times (<code>set_time_limit(0);</code>). Ensure that your server configuration allows for prolonged script execution.</li>
    </ul>
    <h2>Security Considerations</h2>
    <ul>
        <li>Exercise caution when storing or sharing scripts containing API credentials.</li>
        <li>It's recommended to restrict script access and permissions to trusted entities.</li>
        <li>Avoid hardcoding sensitive information directly in the script; consider using environment variables or a secure configuration file.</li>
    </ul>
    <h2>Disclaimer</h2>
    <p>This script is provided as-is and may require adjustments based on your specific use case or changes in the Shopify API. Use it responsibly and review the Shopify API documentation for any updates or modifications to the API endpoints.</p>
    <h2>License</h2>
    <p>This script is released under the <a href="LICENSE">MIT License</a>, granting you the freedom to modify and distribute the script as needed.</p>
