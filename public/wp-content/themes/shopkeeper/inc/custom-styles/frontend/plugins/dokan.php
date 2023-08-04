<?php

$custom_styles .= '
    body.dokan-dashboard #page_wrapper.transparent_header .content-area,
    body.dokan-dashboard #page_wrapper.sticky_header .content-area
    {
        padding-top: ' . $content_margin . 'px;
    }

    .dokan-btn, .dokan-btn-theme,
    .dokan-feat-image-btn,
    body.dokan-store .woocommerce-breadcrumb,
    .dokan-single-store .dokan-store-tabs ul li a,
    body.dokan-dashboard .dokan-dash-sidebar .dokan-dashboard-menu a
    {
        font-family: ' . Shopkeeper_Fonts::get_main_font() . ';
    }

    body.dokan-dashboard .select2-search__field
    {
        font-family: ' . Shopkeeper_Fonts::get_secondary_font() . ';
    }

    body.dokan-dashboard .dokan-table .row-actions .edit a,
    body.dokan-dashboard .dokan-table .row-actions .view a,
    body.dokan-dashboard .dokan-table td p a,
    body.dokan-dashboard .dokan-product-listing .dokan-product-listing-area del .amount,
    body.dokan-dashboard .pagination li span.current,
    body.dokan-dashboard .pagination li span:hover,
    body.dokan-dashboard .pagination li a:hover,
    body.dokan-store .dokan-pagination li.active a,
    body.dokan-store .dokan-pagination li span:hover,
    body.dokan-store .dokan-pagination li a:hover,
    body.dokan-dashboard .btn.btn-default:hover,
    body.dokan-store .dokan-widget-area ul li a
    {
        color: ' . esc_html(Shopkeeper_Opt::getOption( 'body_color', '#545454' )) . ';
    }

    body.dokan-store .woocommerce-breadcrumb,
    body.dokan-store .woocommerce-breadcrumb a,
    body.dokan-store .woocommerce-breadcrumb span
    {
        color: rgba(' . shopkeeper_hex2rgb(Shopkeeper_Opt::getOption( 'body_color', '#545454' )) . ',0.55);
    }

    .dokan-dashboard .dokan-dash-sidebar
    {
        background-color: ' . Shopkeeper_Opt::getOption( 'headings_color', '#000000' ) . ';
    }

    body.dokan-store .woocommerce-breadcrumb a:hover
    {
        color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
    }

    .dokan-btn.dokan-btn-theme:not(.dokan-add-new-product):not([name="dokan_update_payment_settings"]):not([name="dokan_update_product"]):not([name="dokan_update_store_settings"]):not([name="dokan_save_account_details"]):not(.vendor-dashboard),
    .dokan-dashboard .btn-theme.add_note,
    .dokan-dashboard .gravatar-button-area a,
    .dokan-btn.dokan-btn-sm.delete,
    .dokan-product-edit .upload_file_button
    {
        color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
    }

    .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.active,
    .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li:hover,
    .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li.dokan-common-links a:hover,
    .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li .tooltip .tooltip-inner
    {
        background: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
    }

    .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li .tooltip .tooltip-arrow
    {
        border-top-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
    }

    body.dokan-dashboard .dokan-table ins
    {
        background-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
    }

    .dokan-btn.vendor-dashboard,
    .dokan-feat-image-btn,
    .dokan-btn.dokan-add-new-product,
    .dokan-btn.dokan-btn-info,
    .dokan-form-horizontal .dokan-form-group .dokan-w4 .dokan-btn-theme,
    .dokan-new-product-area .dokan-btn[name="add_product"],
    .dokan-product-edit .dokan-btn[name="dokan_update_product"],
    .dokan-btn.insert-file-row
    {
        background-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . '!important;
    }

    .dokan-btn.dokan-btn-theme,
    .dokan-dashboard .gravatar-button-area a,
    .dokan-form-horizontal .dokan-form-group .dokan-w4 .dokan-btn-theme,
    .dokan-feat-image-btn
    {
        border-color: ' . Shopkeeper_Opt::getOption( 'main_color', '#EC7A5C' ) . ';
    }

    .dokan-single-store .dokan-store-tabs ul li a
    {
        color: ' . Shopkeeper_Opt::getOption( 'sticky_header_color', '#000' ) . ';
    }';

if( (isset(Shopkeeper_Opt::getOption( 'main_background', array('background-color' => '#FFFFFF') )['background-color'])) ) {

    $custom_styles .= '
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a,
        .dokan-dashboard .dokan-dash-sidebar ul.dokan-dashboard-menu li a i
        {
            color: ' . Shopkeeper_Opt::getOption( 'main_background', array('background-color' => '#FFFFFF') )['background-color'] . '!important;
        }';
}
