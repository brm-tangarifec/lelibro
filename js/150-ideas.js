jQuery(document).ready(function($) {

	  /*FUncion para prevenir frame jacking*/

/*
Función enviada por nestlé "GLOBE"
Content of bfbs.js
=====================================================*/
var __pcja_style = document.createElement('style');
__pcja_style.type = 'text/css';
__pcja_style.id = 'bfbs_cja';
var __pcja_css = 'html{ display:none !important; }';
if (__pcja_style.styleSheet){
                __pcja_style.styleSheet.cssText = __pcja_css;
	}else{
                __pcja_style.appendChild(document.createTextNode(__pcja_css));
          }

document.getElementsByTagName("head")[0].appendChild(__pcja_style);
if( self === top ){
	                var __bfbs_cja = document.getElementById( 'bfbs_cja' );
	                __bfbs_cja.parentNode.removeChild( document.getElementById( 'bfbs_cja' ) );
	}else{
                top.location = self.location;
          }

/*Función para verificar el dominio XSF*/
try {
if (top.location.hostname != self.location.hostname) throw 1;
} catch (e) {
top.location.href = self.location.href;
}




	//Mostrar tipo de archivo para compartir
	$('.btn-up').click(function(e) {
		e.preventDefault();

		//Mostrar subir imagen
		if (  $(this).attr('data-up') == 'img'  ) {

			$('.btn').removeClass('btn-active');
			$(this).addClass('btn-active');

			$('.form-upload').addClass('hidden');
			$('.form-up-img').removeClass('hidden');
			jQuery('.form-up-img .content-upload').html('<label for="upload-img"><img src="images/upload.svg"></label><input type="file" name="upload-img" id="upload-img">');
			if(jQuery('#upload-video').length>0){
				jQuery('#upload-video').prev().remove();
				jQuery('#upload-video').remove();
			}

		};

		//Mostrar subir video
		if ( $(this).attr('data-up') == 'video'  ) {

			$('.btn').removeClass('btn-active');
			$(this).addClass('btn-active');

			$('.form-upload').addClass('hidden');
			$('.form-up-video').removeClass('hidden');
			jQuery('.form-up-video .content-upload').html('<label for="upload-video"><img src="images/upload.svg"></label><input type="file" name="upload-video" id="upload-video">');
			if(jQuery('#upload-img').length>0){
				jQuery('#upload-img').prev().remove();
				jQuery('#upload-img').remove();
			}


		};


	});
	
	//Mostrar el formulario
	$('.btn-comparte').click(function(e) {
		e.preventDefault();

		$('#idea')
			.velocity(
			  { 
			    opacity: 1
			  },
			  { 
			    duration: 200,
			    display: 'block'
			  })
			.velocity('scroll', {
	            duration: 800,
	            offset: -100,
	            easing: 'ease-in-out'
	        });

	    $('footer').removeClass('pos-absolute');

	});

	//stick footer
	var alto =  $(document).height(),
		screenWidth = $(window).width();

	if ( alto > 824 && screenWidth > 1400 ) {

			$('footer').addClass('pos-absolute');


		}else{
			
			$('footer').removeClass('pos-absolute');
	};


	
	$(alto).change(function() {

		if ( alto > 824 && screenWidth > 1400 ) {

			$('footer').addClass('pos-absolute');


		}else{
			
			$('footer').removeClass('pos-absolute');
		};
	});



	//Logos modo slider en mobile

	if( screenWidth <= 768 && screenWidth >= 501 ){

		$('.slider-logos').bxSlider({
		  minSlides: 4,
		  maxSlides: 4,
		  slideWidth: 120,
		  slideMargin: 5,
		  moveSlides: 1,
		  pager:false,
		  nextText: '',
		  prevText: ''
		});
		
	}if( screenWidth <= 500 && screenWidth >= 421 ){
		$('.slider-logos').bxSlider({
		  minSlides: 2,
		  maxSlides: 2,
		  slideWidth: 150,
		  slideMargin: 10,
		  moveSlides: 1,
		  pager:false,
		  nextText: '',
		  prevText: ''
		});

	}if( screenWidth <= 420 && screenWidth >= 300 ){
		$('.slider-logos').bxSlider({
		  minSlides: 2,
		  maxSlides: 2,
		  slideWidth: 100,
		  slideMargin: 1,
		  moveSlides: 1,
		  pager:false,
		  nextText: '',
		  prevText: ''
		});

	};



	//Datepicker para fecha de nacimiento	
	$( "#fechaN" )
		.datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			maxDate: "-18y",
			dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
			monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
		})
		.on('change', function () {
			$(this).datepicker('option', 'monthNamesShort', 'dayNamesMin');
		});





	//Validar letras con espacios y caracteres especiales//
	jQuery.validator.addMethod("letras", function(value, element)
	   {
	       return this.optional(element) || /^[a-z" "ñÑáéíóúÁÉÍÓÚ,.;]+$/i.test(value);
	   });


	//Validación de campos
	$('#idea').validate({
	
		//por defecto es false
		// debug:true,
	
		//Contenedor y clase donde se pinta el error
		errorElement: "div",
		errorClass: "mensaje",
	
		//Campos a validar
		rules:{
			ideaE: {required: true},
			nombre: {required: true, letras:true},
			email: {required: true, email:true},
			tipoD: {required: true},
			numDoc: {required: true, digits:true},
			fechaN: {required: true, date:true},
			departamento: {required: true},
			ciudad: {required: true},
			direccion: {required: true},
			autorizo: {required: true},
			terminos: {required: true}
		},
	
		//Mensaje de error cuando no cumple la regla
		messages:{
			ideaE: {required: 'Debes contarnos tu idea'},
			nombre: {required: 'Debes escribir tu nombre', letras:'solo se acepta texto'},
			email: {required: 'Debes ingresar un email', email:'ingresa un email v&aacute;lido'},
			tipoD: {required: 'Selecciona un tipo de documento'},
			numDoc: {required: 'Debes escribir tu n&uacute;mero de documento', digits:'solo se aceptan n&uacute;meros'},
			fechaN: {required: 'Debes indicar tu fecha de nacimiento', date:'Fecha no v&aacute;lida '},
			departamento: {required: 'Selecciona un departamento'},
			ciudad: {required: 'Selecciona una ciudad'},
			direccion: {required: 'Ingresa una direcci&oacute;n'},
			autorizo: {required: 'Debes aceptar las politicas de tratamientos de datos'},
			terminos: {required: 'Debes aceptar los t&eacute;rminos'}
		},
	
		//ubicación del mensaje de error
	
		errorPlacement: function (error, element) {	      
	
		    error.insertAfter(element.parent());
		  
	
		}
	
	});



/*Funciones varias*/
		/*Ciudades*/
	jQuery('#departamento').on('change',function() {
   //console.log('Hola soy un select');
   	jQuery('#ciudad').attr('disabled');
   	jQuery('#ciudad').empty().append('<option value="">Ciudad/Municipio	</option>');
   	var idDepto=jQuery('#departamento').val();
			 /*Inicia ajax*/
			jQuery.ajax({
		    url: 'eventos.php',
			dataType:'json' ,
			type: 'POST',
			data: {
				idDepto:idDepto,
				vrtCrt:'ciudad'
			},
			success: function (data){
				var conteo=jQuery(data).length;
				console.log(conteo);
				jQuery('#ciudad').removeAttr('disabled');
				for (var i =0; i<conteo; i++ ) {
					console.log(data[i]);
					jQuery('#ciudad').append('<option value="'+data[i].idCiudad+'">'+data[i].nombre+'</option>')
				}
				 
				
			}
	
		});
	return false;
		 /*Finaliza */
	});

	/*Registro*/
	jQuery('#submit').click(function(){
		console.log('hola');
		
		if(jQuery('#idea').valid()){

		var nombre=jQuery('#nombre').val(),
		email=jQuery('#email').val(),
		idea=jQuery('#ideaE').val(),
		tipoDoc=jQuery('#tipoD').val(),
		fechaN=jQuery('#fechaN').val(),
		documento=jQuery('#numDoc').val(),
		departamento=jQuery('#departamento').val(),
		ciudad=jQuery('#ciudad').val(),
		direccion=jQuery('#direccion').val(),
		aceptar=jQuery('#autorizo').val(),
		terminos=jQuery('#terminos').val(),
		url="eventos.php";
		jQuery.ajax({
				url: 'eventos.php',
				dataType:'json' ,
				type: 'POST',
				data: {
					nombre:nombre,
					email:email,
					idea:idea,
					idDepto:departamento,
					idCiudad:ciudad,
					tipodoc:tipoDoc,
					fechaN:fechaN,
					documento:documento,
					direccion:direccion,				
					autorizo:aceptar,
					terminos:terminos,
					vrtCrt:'registrar'
				},
				success: function (data){
					console.log(data);
					/*if(data=='exitoso'){

						jQuery('.exitoso').removeClass('hidden');
						jQuery('.clearI').val('');
						jQuery('.registrousu').hide('fade');
						jQuery('.multipacks').hide('fade');
						
						jQuery('#btn-registro').show('fade');
						dataLayer.push({'event': 'registro-camisetas-exitoso'});
					}*/
				}

			});
			return false;

		}

	});

	/*F registro*/
	/*F fuciones varias*/





});