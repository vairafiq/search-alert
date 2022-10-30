<?php

namespace searchAlert\Utility\Enqueuer;

abstract class Enqueuer extends Enqueuer_Base {

    /**
     * @var string
     */
    public $asset_group = 'public';

    /**
     * Load Scripts
     *
     * @return void
     */
    abstract public function load_scripts();

    /**
     * Enqueue Scripts
     *
     * @return void
     */
    public function enqueue_scripts( $page = '' ) {

        // Set Script Version
        $this->setup_load_min_files();

        // Set Script Version
        $this->setup_script_version();

        // Load Script
        $this->load_scripts();

        // Apply Hook to Scripts
        $this->apply_hook_to_scripts();

        // CSS
        $this->register_css_scripts();
        $this->enqueue_css_scripts_by_group( ['group' => $this->asset_group, 'page' => $page] );

        // JS
        $this->register_js_scripts();
        $this->enqueue_js_scripts_by_group( ['group' => $this->asset_group, 'page' => $page] );
    }

    /**
     * Load min files
     *
     * @return void
     */
    public function setup_load_min_files() {
        $this->load_min = apply_filters( 'exlac_customer_support_app_load_min_files', SEARCH_ALERT_LOAD_MIN_FILES );
    }

    /**
     * Set Script Version
     *
     * @return void
     */
    public function setup_script_version() {
        $script_version       = ( $this->load_min ) ? SEARCH_ALERT_SCRIPT_VERSION : md5( time() );
        $this->script_version = apply_filters( 'exlac_customer_support_app_script_version', $script_version );
    }

    /**
     * Apply Hook to Scripts
     *
     * @return void
     */
    public function apply_hook_to_scripts() {
        $this->css_scripts = apply_filters( 'exlac_customer_support_app_css_scripts', $this->css_scripts );
        $this->js_scripts  = apply_filters( 'exlac_customer_support_app_js_scripts', $this->js_scripts );
    }

}
