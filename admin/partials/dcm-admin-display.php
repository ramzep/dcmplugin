<?php

/**
  * Proporcionar una vista de área de administración para el plugin
  *
  * Este archivo se utiliza para marcar los aspectos de administración del plugin.
  *
  * @link http://dentrodemicomunidad.mx
  * @since desde 1.0.0
  *
  * @package dcmplugin
  * @subpackage dcmplugin/admin/parcials
  */
/* Este archivo debe consistir principalmente en HTML con un poco de PHP. */
?><head><article>
<p>Configuracion de Maestros</p>
<div class="consultadegrupo col-sm-12">
			<div id="parent_cat_div" class="col-sm-6 margindiv10"><?php 
			$terms=get_terms('grupos',
			array(
				'hide_empty' => false,
				'parent' => 0,
			)
			);
			$datosparent="";
			
			echo '<select id="parent_cat" name="escuelas">';
			// Get categories as array  
			 echo '<option disabled selected value> -- Seleccione Escuela -- </option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->term_id . '">' . $term->name . '</option>';
				$datosparent=$datosparent . ',' . $term->term_id;
			endforeach;
			echo '</select>';
		 ?></div>
         		<div id="sub_cat_div" class="col-sm-6 margindiv10"><select class="ddlgrado" name="sub_cat_disabled" id="parent_grado" disabled="disabled"><option>Seleccione grado!</option></select></div>

		<div id="sub_grupo_div"  class="col-sm-6 margindiv10"><select class="ddlgrupo" name="sub_grupo_disabled" id="parent_grupo" disabled="disabled"><option>Seleccione grupo!</option></select></div>
		<br/>
		<div class="consultadegrupo col-sm-6">
			<div id="user_div" class="col-sm-6 margindiv10"><?php 
			$terms = get_users( 'orderby=nicename&role=Maestro' );
			//$terms = new WP_User_Query( array( 'role' => 'Administrator' ) );
			$datosparent="";
			
			echo '<select id="teacherusers" name="teachers">';
			// Get categories as array  
			 echo '<option disabled selected value> -- Seleccione Maestro -- </option>';
			foreach ( $terms as $term ) :
				echo '<option value="' . $term->ID . '">' . $term->display_name . '</option>';
				
			endforeach;
			echo '</select>';
		 ?></div>
		
		<div>
			<table class="table-responsive">
				<thead>
					<tr>
						<th>Maestro</th>
						<th>Escuela</th>
						<th>Grupo</th>
						<th>Grado</th>
					</tr>
				</thead>
				<tbody>
					<?php
					  global $wpdb;
					  $sql="SELECT u.display_name,u.id ,te.name grado,te2.name grupo,te3.name escuela FROM ". $wpdb->prefix  ."user_taxonomy t inner join ". $wpdb->prefix  ."users u on u.id=t.id inner join ". $wpdb->prefix  ."terms te on te.term_id = t.term_id inner join ". $wpdb->prefix  ."term_taxonomy ta on te.term_id = ta.term_id inner join ". $wpdb->prefix  ."terms te2 on te2.term_id = ta.parent inner join ". $wpdb->prefix  ."term_taxonomy ta2 on te2.term_id = ta2.term_id inner join ". $wpdb->prefix  ."terms te3 on te3.term_id = ta2.parent";
					  $resultado=$wpdb->query( $sql );
					  $resultado=$wpdb->last_result;
					  foreach ( $resultado as $term ) :
							echo '<tr><td>' . $term->display_name . '</td><td>' . $term->escuela . '</td><td>' . $term->grupo . '</td><td>' . $term->grado . '</td></tr>';
      				  endforeach;
					?>
				</tbody>
  			</table>
		</div>
		<div class="resultadoguardado" id="guardadomensaje"></div>
		<div><button type='button' class='btn btn-primary col-sm-6 margindiv10 btnsavemaestro' >Guardar</button><div>
</article></head>

