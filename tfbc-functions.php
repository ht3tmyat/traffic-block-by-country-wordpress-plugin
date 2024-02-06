<?php
   function tfbc_plugin_menu() {
    add_menu_page( 'TFBC Settings', 'TFBC', 'manage_options', 'tfbc-plugin-settings', 'tfbc_plugin_settings_page', 'dashicons-dashboard');
}

function tfbc_plugin_settings_page() {
    ?>
     <h1>Welcome to Traffic Blocker by Country</h1>
     <form method="post" action="options.php">
        <!-- on or off option -->
        <?php settings_fields( 'tfbc-settings-group' ); ?>
        <?php do_settings_sections( 'tfbc-settings-group' ); ?>
        <table class="form-table">
            <tr valign="top">
            <th scope="row">Block Traffic</th>
            <td><input type="checkbox" name="tfbc_block_traffic" value="1" <?php checked(1, get_option('tfbc_block_traffic'), true); ?> /></td>
            <td>Check this box to block traffic from the selected countries</td>
            </tr>
            <tr valign="top">
    <th scope="row">Select Countries</th>
    <td><input type="text" name="tfbc_countries" placeholder="eg. US, MM" value="<?php echo esc_attr( get_option('tfbc_countries') ); ?>" />
    </td>
    <td>Enter the country codes by comma you want to block</td>
</tr>
    <tr valign="top">
    <th scope="row">Block Types</th>
    <td>
        <select name="tfbc_block_type">
        <option value="redirect" <?php selected( get_option('tfbc_block_type'), 'redirect' ); ?>>Redirect</option>
        <option value="popup_alert_image" <?php selected( get_option('tfbc_block_type'), 'popup_alert_image' ); ?>>Popup Alert Image</option>
        <option value="popup_alert_image_dis" <?php selected( get_option('tfbc_block_type'), 'popup_alert_image_dis' ); ?>>Popup Alert Message with Dismissable</option>
        <option value="popup_alert_msg" <?php selected( get_option('tfbc_block_type'), 'popup_alert_msg' ); ?>>Popup Alert Message</option>
        <option value="popup_alert_msg_dis" <?php selected( get_option('tfbc_block_type'), 'popup_alert_msg_dis' ); ?>>Popup Alert Message with Dismissable</option>
        </select>
    </td>
    <td>Select the type of block</td>
</tr>
<tr valign="top">
    <th scope="row">Redirect URL</th>
    <td><input type="text" name="tfbc_redirect_url" value="<?php 
    if(get_option('tfbc_redirect_url') == ''){
        echo 'https://www.google.com';
    }else{
        echo esc_attr( get_option('tfbc_redirect_url') );
    }
    ?>" />
    </td>
    <td>Enter the URL to redirect the blocked traffic</td>
</tr>
<tr valign="top">
    <th scope="row">Popup Alert Image Url</th>
    <td><input type="url" name="tfbc_popup_alert_image" value="<?php 
    if(get_option('tfbc_popup_alert_image') == ''){
        echo 'https://via.placeholder.com/300';
    }else{
        echo esc_attr( get_option('tfbc_popup_alert_image') );
    }
    ?>
    " />
    </td>
    <td>Enter the URL of the image to show in the popup alert</td>  
</tr>
<tr valign="top">
    <th scope="row">Popup Alert Message</th>
    <td><textarea name="tfbc_popup_alert_message" style="width: 300px" rows="3">
    <?php
    if(get_option('tfbc_popup_alert_message') == ''){
        echo 'You are not allowed to access this site';
    }else{
        echo esc_attr( get_option('tfbc_popup_alert_message') );
    }
    ?>
    </textarea>
    </td>
    <td>Enter the message to show in the popup alert</td>
</tr>
<tr valign="top">
    <th scope="row">Disable Ads</th>    
    <td><input type="checkbox" name="tfbc_disable_ads" value="1" <?php checked(1, get_option('tfbc_disable_ads'), true); ?> /> <span style="color:#ffcc00">* This may be remove all javascript codes from your site</span> </td>
    <td>Check this box to disable ads on the site.</td>
</tr>
<tr valign="top">
    <td><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></td>
    <td style="color: red;">* Please note that the plugin will not work if the country code is not in the correct format</td>
</tr>
<tr valign="top">
    <td><?php if(isset($_GET['settings-updated'])) { ?>
        <div id="message" class="updated notice" style="width:150px"><p>Successfully Updated </p></div>
    <?php } ?>
    </td>
</tr>
<tr valign="top">
    <h4>Thank you for using my plugin. If you like my plugin, please consider buying me a coffee. It will help me to keep the plugin updated and add more features</h4>
    <a href="https://www.buymeacoffee.com/ht3tmyat" target="_blank"><img src="https://cdn.buymeacoffee.com/buttons/default-orange.png" alt="Buy Me A Coffee" style="height: 40px !important;width: 150px !important;" ></a>
</tr>
        </table>
     </form>
    <?php }     

function tfbc_register_settings() {
    register_setting( 'tfbc-settings-group', 'tfbc_block_traffic', 'intval' );
    register_setting( 'tfbc-settings-group', 'tfbc_countries', 'sanitize_text_field' );
    register_setting( 'tfbc-settings-group', 'tfbc_block_type', 'sanitize_text_field' );
    register_setting( 'tfbc-settings-group', 'tfbc_redirect_url', 'esc_url_raw' );
    register_setting( 'tfbc-settings-group', 'tfbc_popup_alert_image', 'esc_url_raw' );
    register_setting( 'tfbc-settings-group', 'tfbc_popup_alert_message', 'sanitize_textarea_field' );
    register_setting( 'tfbc-settings-group', 'tfbc_popup_alert_image_dis', 'esc_url_raw' );
    register_setting( 'tfbc-settings-group', 'tfbc_popup_alert_message_dis', 'sanitize_textarea_field' );
    register_setting( 'tfbc-settings-group', 'tfbc_disable_ads', 'intval' );
}

function getClientIP() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function tfbc_check_country(){
    $country_code = $_SERVER["HTTP_CF_IPCOUNTRY"];
    if($country_code == ''){
         $ip = getClientIP();
            $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
            $country_code = $details->country;
    }
    $blocked_countries = get_option('tfbc_countries');
    $blocked_countries = explode(',', $blocked_countries);
    if(in_array($country_code, $blocked_countries)){
        if(get_option('tfbc_disable_ads') == 1){
            ob_start('tfbc_remove_ads');
        }
         $block_type = get_option('tfbc_block_type');
         if($block_type == 'redirect'){
           $redirect_url = get_option('tfbc_redirect_url');
           header("Location: $redirect_url");
           exit();
         }else if($block_type == 'popup_alert_msg'){
           $popup_alert_message = get_option('tfbc_popup_alert_message');
           echo "
           <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
           <script>
           window.onload = function() {
            Swal.fire({
                title: 'Alert',
                text: '$popup_alert_message',
                icon: 'error',
                showConfirmButton: false,
                dismissOnClickOutside: false,
                allowOutsideClick: false,
                padding: '2em'
              })
           }
           </script>";
         }else if($block_type == 'popup_alert_image'){
           $popup_alert_image = get_option('tfbc_popup_alert_image');
           echo "
           <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
           <script>
           window.onload = function() {
            Swal.fire({
                imageUrl: '$popup_alert_image',
                background: 'rgba(255, 255, 255, .4)',
                imageAlt: 'Alert image'
                showConfirmButton: false,
                dismissOnClickOutside: false,
                allowOutsideClick: false,
                padding: '0em',
              })
           }
           </script>";
         }
         else if($block_type == 'popup_alert_image_dis'){
           $popup_alert_image = get_option('tfbc_popup_alert_image');
           $popup_alert_message = get_option('tfbc_popup_alert_message');
           echo "
           <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
           <script>
           window.onload = function() {
            Swal.fire({
                imageUrl: '$popup_alert_image',
                background: 'rgba(255, 255, 255, .4)',
                imageAlt: 'Alert image',
                text: '$popup_alert_message',
                showCancelButton: true,
                padding: '0em',
              })
           }
           </script>";
         }
         else if($block_type == 'popup_alert_msg_dis'){
           $popup_alert_message = get_option('tfbc_popup_alert_message');
           echo "
           <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
           <script>
           window.onload = function() {
            Swal.fire({
                title: 'Alert',
                text: '$popup_alert_message',
                icon: 'warning',
                showConfirmButton: true,
                padding: '2em'
              })
           }
           </script>";
         }
    }
}

function tfbc_remove_ads($buffer){
    $buffer = preg_replace('/<script(?!.*?(sweetalert2@11|Swal\.fire\()).*?<\/script>/s', '', $buffer);
    return $buffer;
}

function tfbc_check_admin() {
    if (!current_user_can('manage_options')) {
        if(get_option('tfbc_block_traffic') == 1){
            add_action('wp_head', 'tfbc_check_country');
        }
    }
}

add_action('plugins_loaded', 'tfbc_check_admin');
add_action( 'admin_init', 'tfbc_register_settings' );
add_action( 'admin_menu', 'tfbc_plugin_menu' );