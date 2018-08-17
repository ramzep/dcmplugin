<?php

/**
 * Se activa en la activación del plugin
 *
 * @link       http://dentrodemicomunidad.com
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
class DCM_Ajax {
    
    /**
	 * Método constructor
	 *
	 * Se ejecuta cuando se instancia la +
	 *
	 * @since    1.0.0
     * access public
	 */    
        public function __construct() {
            
            // Algún código a ejecutar en la instancia del objeto
            
        }
    
    /**
	 * Método para interactuar con el archivo Javascript
	 *
	 * Se usa para interactuar con un archivo específico
     * de javascript con el método AJAX
	 *
	 * @since    1.0.0
     * @access public
	 */ 
        public function peticiones() {
            
            // Checkea el código generado por wp_create_nonce()
            // y pasado al archivo javascript
            
            check_ajax_referer( 'dcmseg', 'nonce' );
           
            if ( isset($parent_cat_ID) ) // inicia llenado de select
            {
                   
                    $terms=get_terms('grupos',
                    array(
                        'hide_empty' => false,
                        'parent' => $parent_cat_ID,
                    )
                    );		
                    if ( $terms ) {
                            echo '<select id="' . $nameid . '" name="grado">';
                            // Get categories as array
                            echo '<option disabled selected value> -- Seleccione Grado -- </option>';
                            foreach ( $terms as $term ) :
                                echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
                            endforeach;
                            echo '</select>';
                            
                    } else {
                        
                        ?>
                        <script type="text/javascript">document.getElementById('sub_grupo_div').style.display = 'none';</script>
                        
                        <select name="sub_cat_disabled" id="sub_cat_disabled" disabled="disabled"><option>No child categories!</option></select><?php
                    } 
            wp_die();
            } // end if llenado de select
            
        }
       
            
         public function guardar() {
            
            // Checkea el código generado por wp_create_nonce()
            // y pasado al archivo javascript
            
            check_ajax_referer( 'dcmseg', 'nonce' );
           if ( isset ( $_POST["action"]) )
                    $idgrupo=$_POST["grupo"];
                    $userid=$_POST["userid"];
                    $data= ['term_id'=>$idgrupo,'id'=>$userid];

                   //if(!$wpdb->update($wpdb->prefix.'user_taxonomy',$data,array('id'=>$duserid,'term_id'=>$idgrupo),array('%d','%d'),array('%d','%d'))){
                         $wpdb->insert($wpdb->prefix.'user_taxonomy',$data,array('%d','%d'));
                        
                     //}  

                    echo json_encode(["results" => "Hemos recibido los datos correctamente"]);
                    
                     wp_die();          
            } // end if llenado de select
               
}