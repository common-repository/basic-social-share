<?php

/*
Plugin Name: Basic Social Share 
Plugin URI: 
Description: Shows the share buttons at the end of each post and add the [basic-social-share] code where you want them to appear on the pages.
Version: 1.0
Author: Tommaso Costantini
*/

function bss_menu_item()
{
  add_submenu_page("options-general.php", "Basic Social Share", "Basic Social Share", "manage_options", "social-share", "bss_page"); 
}

add_action("admin_menu", "bss_menu_item");

function bss_page()
{
   ?>
      <div class="wrap">
         <h1>Options | Basic Social Share</h1>
 
         <form method="post" action="options.php">
            <?php
               settings_fields("bss_config_section");
 
               do_settings_sections("bss");
                
               submit_button(); 
            ?>
         </form>
      </div>
   <?php
}

function social_share_settings()
{
    add_settings_section("bss_config_section", "", null, "bss");

    add_settings_field("bss-facebook", "Facebook", "social_share_facebook_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-twitter", "Twitter", "social_share_twitter_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-whatsapp", "WhatsApp", "social_share_whatsapp_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-tumblr", "Tumblr", "social_share_tumblr_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-telegram", "Telegram", "social_share_telegram_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-pinterest", "Pinterest", "social_share_pinterest_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-googleplus", "Google Plus", "social_share_googleplus_checkbox", "bss", "bss_config_section");
    add_settings_field("bss-linkedin", "LinkedIn", "social_share_linkedin_checkbox", "bss", "bss_config_section");
 
    register_setting("bss_config_section", "bss-facebook");
    register_setting("bss_config_section", "bss-twitter");
    register_setting("bss_config_section", "bss-whatsapp");
    register_setting("bss_config_section", "bss-tumblr");
    register_setting("bss_config_section", "bss-telegram");
    register_setting("bss_config_section", "bss-pinterest");
    register_setting("bss_config_section", "bss-googleplus");
    register_setting("bss_config_section", "bss-linkedin");
}

function social_share_facebook_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-facebook" value="1" <?php checked(1, get_option('bss-facebook'), true); ?> /> Abilita
   <?php
}

function social_share_twitter_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-twitter" value="1" <?php checked(1, get_option('bss-twitter'), true); ?> /> Abilita
   <?php
}

function social_share_whatsapp_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-whatsapp" value="1" <?php checked(1, get_option('bss-whatsapp'), true); ?> /> Abilita
   <?php
}

function social_share_tumblr_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-tumblr" value="1" <?php checked(1, get_option('bss-tumblr'), true); ?> /> Abilita
   <?php
}

function social_share_telegram_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-telegram" value="1" <?php checked(1, get_option('bss-telegram'), true); ?> /> Abilita
   <?php
}

function social_share_pinterest_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-pinterest" value="1" <?php checked(1, get_option('bss-pinterest'), true); ?> /> Abilita
   <?php
}

function social_share_googleplus_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-googleplus" value="1" <?php checked(1, get_option('bss-googleplus'), true); ?> /> Abilita
   <?php
}

function social_share_linkedin_checkbox()
{  
   ?>
        <input type="checkbox" name="bss-linkedin" value="1" <?php checked(1, get_option('bss-linkedin'), true); ?> /> Abilita
   <?php
}
 
add_action("admin_init", "social_share_settings");

function add_social_share_icons($content)
{
    $html = "<div class='bss-container'>";

    global $post;

    //$url = get_permalink($post->ID);
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url = esc_url($url);
    // $title = get_the_title();
    
    if(get_option("bss-facebook") == 1)
    {   
        $facebook_share_count = json_decode(file_get_contents("https://graph.facebook.com/{$url}"))->share->share_count;
        $html = $html . "<div class='bss-fb bss-button'><a href=\"\" onClick=\"javascript:window.open('http://www.facebook.com/sharer.php?u=" . $url . "', 'newwindow', 'width=700,height=450');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/facebook.png' ."'><span>Facebook</span><span class='bss-count'>" . " " . $facebook_share_count . " ". "</span></a></div>";
    }

    if(get_option("bss-twitter") == 1)
    {        
        $html = $html . "<div class='bss-tw bss-button'><a href=\"\" onClick=\"javascript:window.open('https://twitter.com/share?url=" .  $url . "&text=' + document.title, 'newwindow', 'width=700,height=450');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/twitter.png' ."'><span>Twitter</span></a></div>";
    }

    if(get_option("bss-whatsapp") == 1)
    {
        $html = $html . "<div class='bss-wa bss-button'><a href=\"\" onClick=\"javascript:window.open('whatsapp://send?url=" . $url . "', 'newwindow', 'width=700,height=450');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/whatsapp.png' ."'><span>WhatsApp</span></a></div>";
    }

    if(get_option("bss-tumblr") == 1)
    {
        $html = $html . "<div class='bss-tu bss-button'><a href=\"\" onClick=\"javascript:window.open('http://www.tumblr.com/share/link?url=" . $url . "&name=' + document.title, 'newwindow', 'width=700,height=450');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/tumblr.png' ."'><span>Tumblr</span></a></div>";
    }

    if(get_option("bss-telegram") == 1)
    {
        $html = $html . "<div class='bss-tl bss-button'><a href=\"\" onClick=\"javascript:window.open('https://t.me/share/url?url=" . $url . "', 'newwindow', 'width=700,height=450');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/telegram.png' ."'><span>Telegram</span></a></div>";
    }

    if(get_option("bss-pinterest") == 1)
    {
        $html = $html . "<div class='bss-pi bss-button'><a href=\"\" onClick=\"javascript:window.open('https://pinterest.com/pin/create/bookmarklet/?url=" . $url . "&description=' + document.title, 'newwindow', 'width=700,height=450');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/pinterest.png' ."'><span>Pinterest</span></a></div>";
    }

    if(get_option("bss-googleplus") == 1)
    {
        $html = $html . "<div class='bss-gp bss-button'><a href=\"\" onClick=\"javascript:window.open('https://plus.google.com/share?url=" . $url . "', 'newwindow', 'width=415,height=500');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/googleplus.png' ."'><span>Google Plus</span></a></div>";
    }

    if(get_option("bss-linkedin") == 1)
    {   
        $linkedin_share_count = json_decode(file_get_contents("https://www.linkedin.com/countserv/count/share?url={$url}&format=json"))->count;
        $html = $html . "<div class='bss-li bss-button'><a href=\"\" onClick=\"javascript:window.open('http://www.linkedin.com/shareArticle?url=" . $url . "&title=' + document.title, 'newwindow', 'width=415,height=500');\"><img src='" . plugin_dir_url(__FILE__) . '/icon-social/linkedin.png' ."'><span>LinkedIn</span><span class='bss-count'>" . " " . $linkedin_share_count . " ". "</span></a></div>";
    }

    $html = $html . "<div class='clear'></div></div>";

    return $content = $content . $html;
}

add_filter("the_content", "add_social_share_icons");
add_shortcode('basic-social-share', 'add_social_share_icons');

function bss_style() 
{
    wp_register_style("bss-style-file", plugin_dir_url(__FILE__) . "style.css");
    wp_enqueue_style("bss-style-file");
}

add_action("wp_enqueue_scripts", "bss_style");
