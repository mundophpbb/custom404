<?php
/**
 *
 * Custom 404 Page ACP Info
 *
 * @package mundophpbb\custom404\acp
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */


namespace mundophpbb\custom404\acp;

class main_info
{
    function module()
    {
        return array(
            'filename' => '\mundophpbb\custom404\acp\main_module',
            'title'    => 'ACP_CUSTOM404_TITLE',
			'version'	=> '1.0.0',
            'modes'    => array(
                'settings' => array ( 'title' => 'ACP_CUSTOM404_SETTINGS', 'auth'  => 'ext_mundophpbb/custom404 && acl_a_board',  'cat'   => array ('ACP_CUSTOM404_TITLE')),
 			),
		);
	}
}