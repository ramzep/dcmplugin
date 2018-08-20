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
            global $wpdb;     
            check_ajax_referer( 'dcmseg', 'nonce' );
           if ( isset ( $_POST["action"]) )
                    $idgrupo=$_POST["grupo"];
                    $userid=$_POST["userid"];
                    $data= ['term_id'=>$idgrupo,'id'=>$userid];
                    $table = $wpdb->prefix .'user_taxonomy';
                   $existeya=$wpdb->query("select *  from " . $wpdb->prefix."user_taxonomy where term_id=" . $idgrupo . " and id=" .$userid );
                  if ($existeya !== false )
                   {
                       if( $existeya != 0 ){
                          $salida =   "Ya existe el usuario para este grupo" ;
                        
                        }
                          else
                         {
                            $wpdb->insert($table,$data,array('%d','%d'));
                                echo "  <table class='table-responsive'><thead><tr><th>Maestro</th><th>Escuela</th><th>Grupo</th><th>Grado</th></tr></thead><tbody>";
                                $sql="SELECT u.display_name,u.id ,te.name grado,te2.name grupo,te3.name escuela FROM ". $wpdb->prefix  ."user_taxonomy t inner join ". $wpdb->prefix  ."users u on u.id=t.id inner join ". $wpdb->prefix  ."terms te on te.term_id = t.term_id inner join ". $wpdb->prefix  ."term_taxonomy ta on te.term_id = ta.term_id inner join ". $wpdb->prefix  ."terms te2 on te2.term_id = ta.parent inner join ". $wpdb->prefix  ."term_taxonomy ta2 on te2.term_id = ta2.term_id inner join ". $wpdb->prefix  ."terms te3 on te3.term_id = ta2.parent";
                                $resultado=$wpdb->query( $sql );
                                $resultado=$wpdb->last_result;
                                foreach ( $resultado as $term ) :
                                        echo '<tr><td>' . $term->display_name . '</td><td>' . $term->escuela . '</td><td>' . $term->grupo . '</td><td>' . $term->grado . '</td></tr>';
                                endforeach;
                                    echo "</tbody></table>";

                         }  
                          
                    }
                    else
                    {
                            $salida="Este es el " .$idgrupo;
                            $wpdb->insert($table,$data,array('%d','%d'));//inserta maestros
                            updatetable();
                    }
                    
                     wp_die();          
            } // end if llenado de select
               
            function llenargridmaestros(){
                global $wpdb;
                check_ajax_referer( 'dcmseg', 'nonce' );
                if (isset($_POST['action']))
                {
                        $maestroid=$_POST["maestroid"];
                        echo "  <table class='table-responsive'><thead><tr><th>Maestro</th><th>Escuela</th><th>Grupo</th><th>Grado</th></tr></thead><tbody>";
                        $sql="SELECT u.display_name,u.id ,te.name grado,te2.name grupo,te3.name escuela FROM ". $wpdb->prefix  ."user_taxonomy t inner join ". $wpdb->prefix  ."users u on u.id=t.id inner join ". $wpdb->prefix  ."terms te on te.term_id = t.term_id inner join ". $wpdb->prefix  ."term_taxonomy ta on te.term_id = ta.term_id inner join ". $wpdb->prefix  ."terms te2 on te2.term_id = ta.parent inner join ". $wpdb->prefix  ."term_taxonomy ta2 on te2.term_id = ta2.term_id inner join ". $wpdb->prefix  ."terms te3 on te3.term_id = ta2.parent where u.id=" . $maestroid;
                        $resultado=$wpdb->query( $sql );
                        $resultado=$wpdb->last_result;
                        foreach ( $resultado as $term ) :
                            echo '<tr><td>' . $term->display_name . '</td><td>' . $term->escuela . '</td><td>' . $term->grupo . '</td><td>' . $term->grado . '</td></tr>';
                        endforeach;
                        echo "</tbody></table>";
                }
                wp_die();
            }




        function updatetable() {
                  //actualiza tabla
                         global $wpdb;
                          echo "  <table class='table-responsive'><thead><tr><th>Maestro</th><th>Escuela</th><th>Grupo</th><th>Grado</th></tr></thead><tbody>";
					  $sql="SELECT u.display_name,u.id ,te.name grado,te2.name grupo,te3.name escuela FROM ". $wpdb->prefix  ."user_taxonomy t inner join ". $wpdb->prefix  ."users u on u.id=t.id inner join ". $wpdb->prefix  ."terms te on te.term_id = t.term_id inner join ". $wpdb->prefix  ."term_taxonomy ta on te.term_id = ta.term_id inner join ". $wpdb->prefix  ."terms te2 on te2.term_id = ta.parent inner join ". $wpdb->prefix  ."term_taxonomy ta2 on te2.term_id = ta2.term_id inner join ". $wpdb->prefix  ."terms te3 on te3.term_id = ta2.parent";
					  $resultado=$wpdb->query( $sql );
					  $resultado=$wpdb->last_result;
					  foreach ( $resultado as $term ) :
							echo '<tr><td>' . $term->display_name . '</td><td>' . $term->escuela . '</td><td>' . $term->grupo . '</td><td>' . $term->grado . '</td></tr>';
      				  endforeach;
                        echo "</tbody></table>";
        }
}