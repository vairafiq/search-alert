<?php

namespace searchAlert\Module\Core\Asset;

use searchAlert\Utility\Enqueuer\Enqueuer;
use searchAlert\Base\Helper;

class Public_Asset extends Enqueuer {

    /**
     * Constuctor
     *
     */
    function __construct() {
        $this->asset_group = 'public';
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_scripts'] );
    }

    /**
     * Load Admin CSS Scripts
     *
     * @return void
     */
    public function load_scripts() {
        $this->add_css_scripts();
        $this->add_js_scripts();
    }

    /**
     * Load Public CSS Scripts
     *
     * @Example
      $scripts['search-alert-core-public-style'] = [
          'file_name' => 'public',
          'base_path' => SEARCH_ALERT_CSS_PATH,
          'deps'      => [],
          'ver'       => $this->script_version,
          'group'     => 'public',
      ];
     * 
     * @return void
     */
    public function add_css_scripts() {
        $scripts = [];

        // $scripts['search-alert-public-main-style'] = [
        //     'file_name' => 'public-main',
        //     'base_path' => SEARCH_ALERT_CSS_PATH,
        //     'deps'      => [],
        //     'ver'       => $this->script_version,
        //     'group'     => 'public',
        // ];

        $scripts['search-alert-core-public-style'] = [
            'file_name' => 'core-public',
            'base_path' => SEARCH_ALERT_CSS_PATH,
            'deps'      => [],
            'ver'       => $this->script_version,
            'group'     => 'public',
        ];

        $scripts           = array_merge( $this->css_scripts, $scripts );
        $this->css_scripts = $scripts;
    }

    /**
     * Load Public JS Scripts
     *
     * @Example
      $scripts['search-alert-core-public-script'] = [
          'file_name' => 'public',
          'src_path'  => SEARCH_ALERT_ASSET_SRC_PATH . 'modules/core/js/public/',
          'base_path' => SEARCH_ALERT_JS_PATH,
          'group'     => 'public',
          'data'      => [ 'object-key' => [] ],
      ];
     * 
     * @return void
     */
    public function add_js_scripts() {
        $scripts = [];
        
        $scripts['search-alert-core-public-script'] = [
            'file_name' => 'core-public',
            'src_path'  => SEARCH_ALERT_ASSET_SRC_PATH . 'modules/core/js/public/',
            'base_path' => SEARCH_ALERT_JS_PATH,
            'group'     => 'public',
            'data'      => [
                'searchAlert' => [
                    'apiEndpoint'   => rest_url( 'search_alert_base/v1' ),
                    'nonce'         => wp_create_nonce( Helper\get_nonce_key() ),
                    'currentPageID' => get_the_ID(),
                    'currentPageID' => get_the_ID(),
                    'current_user_id' => ! is_admin() ? get_current_user_id() : '',
                    'isFrontPage'   => is_front_page(),
                    'isHome'        => is_home(),
                    'ajaxurl'       => admin_url( 'admin-ajax.php' ),
                    'i18'           => [
                        'deleteText'    => __( 'Delete Search Alert', 'search-alert'),
                        'addText'       => __( 'Set Search Alert', 'search-alert'),
                        'onRequest'     => __( 'Please wait...', 'search-alert'),
                    ]
                ],
            ],
        ];

        $scripts          = array_merge( $this->js_scripts, $scripts );
        $this->js_scripts = $scripts;
    }
}