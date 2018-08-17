<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       http://dentrodemicomunidad.mx
 * @since      1.0.0
 *
 * @package    dcmplugin
 * @subpackage dcmplugin/admin
 */

/**
 * Define el nombre del plugin, la versión y dos métodos para
 * Encolar la hoja de estilos específica de administración y JavaScript.
 * 
 * @since      1.0.0
 * @package    dcmplugin
 * @subpackage dcmplugin/admin
 * @author     Ramiro Zepeda <email@example.com>
 * 
 * @property string $plugin_name
 * @property string $version
 */
class DCM_Admin {
    
    /**
	 * El identificador único de éste plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name  El nombre o identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;

      /**
	 * Versión actual del plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $build_menupage  crea los menus
	 */
    private $build_menupage;

    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;     
        $this->build_menupage= new DCM_Build_Menupage();
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_styles() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
		wp_enqueue_style( $this->plugin_name, DCM_PLUGIN_DIR_URL . 'admin/css/dcm-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style('dcmbootstrapadmincss', DCM_PLUGIN_DIR_URL . 'helpers/Bootstrap/css/bootstrap.min.css', array(), '4.1.3', 'all' );
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    1.0.0
     * @access   public
	 */
    public function enqueue_scripts() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
        wp_enqueue_script( $this->plugin_name, DCM_PLUGIN_DIR_URL . 'admin/js/dcm-admin.js', ['jquery'], $this->version, true );
        wp_localize_script( $this->plugin_name, 'miobjeto', [
            'url'  => admin_url( 'admin-ajax.php' ),
            'seguridad' => wp_create_nonce( 'dcmseg' )
        ]);
        wp_enqueue_script( 'dcmbootstrapadminjs', DCM_PLUGIN_DIR_URL . 'helpers/Bootstrap/js/bootstrap.min.js', ['jquery'], '4.1.3', true );
    }
    
     /**
	 * Registra los menus del plugin 
	 * en el area de administracion
	 * @since    1.0.0
     * @access   public
	 */

    public function add_menu() {
        $this->build_menupage->add_menu_page( 'DCMplugin', 'DCM Settings', 'manage_options', 'dcmsetting', [$this,'controlador_display_menu'], '', 25 );
        $this->build_menupage->run();
    }

    Public function controlador_display_menu()
    {
        require_once DCM_PLUGIN_DIR_PATH . 'admin/partials/dcm-admin-display.php';
    }
}







