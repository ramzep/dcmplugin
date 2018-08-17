(function( $ ) {
	

	/**
	 * Todo el código Javascript orientado a la administración
	 * debe estar escrito aquí
	 */
    			jQuery('#parent_cat').change(function(){
				var parentCat=jQuery('#parent_cat').val();				
				jQuery('#sub_grupo_div').show();
				jQuery('#parent_articulo').empty();
				// call ajax
				
				jQuery.ajax({
					url:miobjeto.url,
					type:'POST',
					data:{
						action:'category_select_action',
						nameid:'parent_grado',
						parent_cat_ID: parentCat,
						nonce:miobjeto.seguridad
					},
					success:function(results)
					{
						jQuery("#sub_cat_div").html(results);
					}
				})
			});

			//segundo drop down
			jQuery('#sub_cat_div').on('change','#parent_grado',function(){
			var parentCat=jQuery('#parent_grado').val();
				// call ajax
				
				jQuery.ajax({
					url:miobjeto.url,
					type:'POST',
					data:{action:'category_select_action',
					nameid:'parent_grupo',
					nonce:miobjeto.seguridad,
					parent_cat_ID: parentCat},
					success:function(results)
					{
						jQuery("#sub_grupo_div").html(results);
					}
				})
			});

		
			jQuery('.btnsavemaestro').click(function(){
				var gradoescuela=jQuery('#parent_grupo').val();
				var maestro=jQuery('#teacherusers').val();
				jQuery.ajax({
				url:miobjeto.url,
				type:'POST',
				data:{action:'guardarmaestro',
				grupo:gradoescuela,
				userid:maestro,
				nonce:miobjeto.seguridad},
				success:function(results)
					{
						console.log(results);
						jQuery('#guardadomensaje').html(results);
					}
			})
			});

})( jQuery );