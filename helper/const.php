<?php

if ( ! defined( 'SEARCH_ALERT_VERSION' ) ) {
    define( 'SEARCH_ALERT_VERSION', '1.1.1' );
}

if ( ! defined( 'SEARCH_ALERT_PREFIX' ) ) {
    define( 'SEARCH_ALERT_PREFIX', 'search-alert' );
}

if ( ! defined( 'SEARCH_ALERT_DB_TABLE_PREFIX' ) ) {
    define( 'SEARCH_ALERT_DB_TABLE_PREFIX', SEARCH_ALERT_PREFIX );
}

if ( ! defined( 'SEARCH_ALERT_REST_BASE_PREFIX' ) ) {
    define( 'SEARCH_ALERT_REST_BASE_PREFIX', SEARCH_ALERT_PREFIX );
}

if ( ! defined( 'SEARCH_ALERT_IN_DEVELOPMENT' ) ) {
    define( 'SEARCH_ALERT_IN_DEVELOPMENT', SCRIPT_DEBUG );
}

if ( ! defined( 'SEARCH_ALERT_SCRIPT_VERSION' ) ) {
    define( 'SEARCH_ALERT_SCRIPT_VERSION', SEARCH_ALERT_VERSION );
}

if ( ! defined( 'SEARCH_ALERT_FILE' ) ) {
    define( 'SEARCH_ALERT_FILE', dirname( dirname( __FILE__ ) ) . '/search-alert.php' );
}

if ( ! defined( 'SEARCH_ALERT_BASE' ) ) {
    define( 'SEARCH_ALERT_BASE', dirname( dirname( __FILE__ ) ) . '/' );
}

if ( ! defined( 'SEARCH_ALERT_LANGUAGES' ) ) {
    define( 'SEARCH_ALERT_LANGUAGES', SEARCH_ALERT_BASE . 'languages' );
}

if ( ! defined( 'SEARCH_ALERT_POST_TYPE' ) ) {
    define( 'SEARCH_ALERT_POST_TYPE', 'search-alert' );
}

if ( ! defined( 'SEARCH_ALERT_TEMPLATE_PATH' ) ) {
    define( 'SEARCH_ALERT_TEMPLATE_PATH', SEARCH_ALERT_BASE . 'template/' );
}

if ( ! defined( 'SEARCH_ALERT_VIEW_PATH' ) ) {
    define( 'SEARCH_ALERT_VIEW_PATH', SEARCH_ALERT_BASE . 'view/' );
}

if ( ! defined( 'SEARCH_ALERT_URL' ) ) {
    define( 'SEARCH_ALERT_URL', plugin_dir_url( SEARCH_ALERT_FILE ) );
}

if ( ! defined( 'SEARCH_ALERT_ASSET_URL' ) ) {
    define( 'SEARCH_ALERT_ASSET_URL', SEARCH_ALERT_URL . 'assets/' );
}

if ( ! defined( 'SEARCH_ALERT_ASSET_SRC_PATH' ) ) {
    define( 'SEARCH_ALERT_ASSET_SRC_PATH', 'src/' );
}

if ( ! defined( 'SEARCH_ALERT_JS_PATH' ) ) {
    define( 'SEARCH_ALERT_JS_PATH', SEARCH_ALERT_ASSET_URL . 'js/' );
}

if ( ! defined( 'SEARCH_ALERT_VENDOR_JS_PATH' ) ) {
    define( 'SEARCH_ALERT_VENDOR_JS_PATH',  SEARCH_ALERT_ASSET_URL . 'js/vendor-js' );
}

if ( ! defined( 'SEARCH_ALERT_VENDOR_JS_SRC_PATH' ) ) {
    define( 'SEARCH_ALERT_VENDOR_JS_SRC_PATH', 'assets/vendor-js/' );
}

if ( ! defined( 'SEARCH_ALERT_CSS_PATH' ) ) {
    define( 'SEARCH_ALERT_CSS_PATH', SEARCH_ALERT_ASSET_URL . 'css/' );
}

if ( ! defined( 'SEARCH_ALERT_LOAD_MIN_FILES' ) ) {
    define( 'SEARCH_ALERT_LOAD_MIN_FILES', ! SEARCH_ALERT_IN_DEVELOPMENT );
}

// Meta Keys
if ( ! defined( 'SEARCH_ALERT_META_PREFIX' ) ) {
    define( 'SEARCH_ALERT_META_PREFIX',  SEARCH_ALERT_PREFIX . '_' );
}

if ( ! defined( 'SEARCH_ALERT_USER_META_AVATER' ) ) {
    define( 'SEARCH_ALERT_USER_META_AVATER', SEARCH_ALERT_META_PREFIX . 'user_avater' );
}

if ( ! defined( 'SEARCH_ALERT_USER_META_IS_GUEST' ) ) {
    define( 'SEARCH_ALERT_USER_META_IS_GUEST', SEARCH_ALERT_META_PREFIX . 'is_guest' );
}

if ( ! defined( 'SEARCH_ALERT_OPTIONS' ) ) {
    define( 'SEARCH_ALERT_OPTIONS', SEARCH_ALERT_META_PREFIX . 'options' );
}