<?php

/**
 * Define la funcionalidad de internacionalización
 *
 * Carga y define los archivos de internacionalización de este plugin para que esté listo para su traducción.
 *
 * @link       http://dentrodemicomunidad.mx
 * @since      1.0.0
 *
 * @package    dcmplugin
 * @subpackage dcmplugin/includes
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      1.0.0
 * @package    dcmplugin
 * @subpackage dcmplugin/includes
 * @author     Ramiro Zepeda <email@example.com>
 */
class DCM_i18n {
    
    /**
	 * Carga el dominio de texto (textdomain) del plugin para la traducción.
	 *
     * @since    1.0.0
     * @access public static
	 */    
    public function load_plugin_textdomain() {
        
        load_plugin_textdomain(
            'dcmplugin-textdomain',
            false,
            DCM_PLUGIN_DIR_PATH . 'languages'
        );
        
    }
    
}