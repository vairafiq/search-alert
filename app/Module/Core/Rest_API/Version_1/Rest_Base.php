<?php

namespace searchAlert\Module\Core\Rest_API\Version_1;

use searchAlert\Module\Core\Rest_API\Base;

abstract class Rest_Base extends Base {

    /**
     * @var string
     */
    public $namespace = SEARCH_ALERT_REST_BASE_PREFIX . '/v1';

}
