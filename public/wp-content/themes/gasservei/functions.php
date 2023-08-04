<?php //Start building your awesome child theme functions
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/*
 *  START APP
 *  Sets initial state loading deps
 */
if (file_exists(__DIR__ . '/bootstrap/MimoticBootstrap.php')) {
    require_once  __DIR__ . '/bootstrap/MimoticBootstrap.php';

    $gasServeiApp = new MimoticBootstrap(array(
        "modules/sendinblueRegisterCheckbox",
        "modules/enqueueScripts",
        "modules/googleApiKey",
        "modules/analyticsScript",
        "modules/conditionalMenu",
        "modules/sendinblueChatSnippet",
        "modules/removeMetaTags",
        "modules/registerSidebars",
        "modules/custom-posts/distributors",
        "modules/menuImage",
        "modules/woocommerce/getProductAttributeTitle",
        "modules/woocommerce/actions",
        "modules/woocommerce/addProductAdditionalInformation",
        "modules/woocommerce/addCss",
        "modules/woocommerce/addPolicyCheckbox",
        "modules/woocommerce/removeMyAccountDownloadsTab",
        "modules/woocommerce/removeSingleProductTabs",
        "modules/woocommerce/translateWoocommerce",
        "modules/woocommerce/avoidQueryingChildProducts",
        "modules/woocommerce/removeSkuFromFrontend",
        "modules/woocommerce/removeSingleMeta",
        "modules/woocommerce/userFields",
        "modules/woocommerce/addFiguresOnWoocommerceCheckout",
        "modules/woocommerce/subCategoriesShortcode",
        "modules/woocommerce/productSearchRelevance",
        "modules/shopkeeper/headerIcons",
        "modules/woocommerce/categoriesMenu",
        "modules/woocommerce/translateOnSaleBadget",
        "modules/woocommerce/replaceThankyouTitle",
        "modules/woocommerce/avoidPriceRanges",
        // "modules/woocommerce/addCategoriesToSearchQuery",
        "modules/woocommerce/replaceCheckoutButtonText",
        "modules/woocommerce/fixSideBarFilterCounter",
        "modules/woocommerce/searchBySku",
    ));

    $gasServeiApp->start();
}
