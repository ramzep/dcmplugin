<?php
/**
 * Archivo del plugin 
 * Este archivo es leído por WordPress para generar la información del plugin
 * en el área de administración del complemento. Este archivo también incluye 
 * todas las dependencias utilizadas por el complemento, registra las funciones 
 * de activación y desactivación y define una función que inicia el complemento.
 *
 * @link                http://dentrodemicomunidad.com/realdelvalle
 * @since               1.0.0
 * @package             Beziercode Blank
 *
 * @wordpress-plugin
 * Plugin Name:         DCMplugin
 * Plugin URI:          http://dentrodemicomunidad.com
 * Description:         Plugin de dentro de mi comunidad que sirve para cargar todo los detalles adicionales
 * Version:             1.0.0
 * Author:              Ramiro Zepeda 
 * License:             GPL2
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:         dentrodemicomunidad
 * Domain Path:         /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}
global $wpdb;
define( 'DCM_REALPATH_BASENAME_PLUGIN', dirname( plugin_basename( __FILE__ ) ) . '/' );
define( 'DCM_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'DCM_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'DCM_TABLE', "{$wpdb->prefix}dcm" );

/**
 * Código que se ejecuta en la activación del plugin
 */
function activate_dcmplugin() {
    require_once DCM_PLUGIN_DIR_PATH . 'includes/class-dcm-activator.php';
	DCM_Activator::activate();
}

/**
 * Código que se ejecuta en la desactivación del plugin
 */
function deactivate_dcmplugin() {
    require_once DCM_PLUGIN_DIR_PATH . 'includes/class-dcm-deactivator.php';
	DCM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dcmplugin' );
register_deactivation_hook( __FILE__, 'deactivate_dcmplugin' );

require_once DCM_PLUGIN_DIR_PATH . 'includes/class-dcm-master.php';

function run_dcm_master() {
    $dcm_master = new DCM_Master;
    $dcm_master->run();
}

run_dcm_master();
























