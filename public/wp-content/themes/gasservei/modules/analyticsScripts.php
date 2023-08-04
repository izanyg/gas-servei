<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


add_action('wp_head','gss_analytics', 20);

function gss_analytics() {
    ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src=https://www.googletagmanager.com/gtag/js?id=G-ZPZDNJBGM8></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());  
        gtag('config', 'G-ZPZDNJBGM8');
        </script>
    <?php
}

