<?php

namespace searchAlert\Module\Settings_Panel;

use searchAlert\Helper;
use searchAlert\Base\Helper as G_Helper;
class Init {

    /**
     * Constuctor
     *
     * @return void
     */
    public function __construct() {

        // Register Controllers
        $controllers = $this->get_controllers();
        Helper\Serve::register_services( $controllers );

        $this->save_initial_data();
    }

    /**
     * Controllers
     *
     * @return array
     */
    protected function get_controllers() {
        return [
            Asset\Init::class,
            Rest_API\Init::class,
        ];
    }

    private function save_initial_data() {
        
        if( G_Helper\get_options() ){
            return;
        }
        
        $options = [
            'enable_search_alert' => 'true',
            'emailSubject' => 'New Post Alert',
            'emailBody' => 'Dear User,

            Thank You For Sharing Your Concern. 
            
            The post you were searching is just found! Let\'s check this out from the link {{POST_LINK}}
            
            Thanks,
            The Administrator',
            'email_footer' => 'true'
            
        ];

        foreach( $options as $key => $value ){
            G_Helper\update_option( $key, $value );
        }
        
    }

}