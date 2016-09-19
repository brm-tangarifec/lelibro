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


$.validator.addMethod('filesize', function (value, element, param) {
	//console.log(element.files[0].size);
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than {0}');

	//Mostrar tipo de archivo para compartir
	$('.btn-up').click(function(e) {
		e.preventDefault();

		//Mostrar subir imagen
		if (  $(this).attr('data-up') == 'img'  ) {

			$('.btn').removeClass('btn-active');
			$(this).addClass('btn-active');

			$('.form-upload').addClass('hidden');
			$('.form-up-img').removeClass('hidden');
			jQuery('.form-up-img .content-upload').html('<label for="upload-img"><img src="images/upload.svg"></label><input type="file" name="upload-img" id="upload-img" accept="image/*">');
			jQuery("#upload-img").rules("add", {
					required: true,
					accept:"image/*",
					filesize: 1048576,
					messages: {
						required: "Por favor seleccione una imagen",
						accept: "La extensión no es valida",
						filesize: "El archivo no debe ser mayor a 1MB"
						}
					});
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
			jQuery('.form-up-video .content-upload').html('<label for="upload-video"><img src="images/upload.svg"></label><input type="file" name="upload-video" id="upload-video" accept="video/*">');
			jQuery("#upload-video").rules("add", {
					required: true,
					accept:"video/*",
					filesize: 26214400,
					messages: {
						required: "Seleccione un archivo de v&iacute;deo",
						accept: "La extensi&oacute;n no es v&aacute;lida",
						filesize: "El archivo no debe ser mayor a 25 MB"
					}
				});
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

/*Validar archivos file*/
if(jQuery("#upload-img").length>0){
	console.log('hola, imagen');

}
if(jQuery("#upload-video").length>0){
	console.log('hola, video');

}
 //accept:"image/*"
/*Fin validacion*/
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
		//console.log('hola');
		if(jQuery('#upload-img').length>0){
			var imagen = $("#idea #upload-img").val();
			imagen= imagen.split('.');
			var img= '';
			var ext =false;
			//console.log(imagen[(imagen.length -1)]);
		    ext=imagen[(imagen.length -1)];
				if ( ext === 'jpg' || ext ==='png' || ext === 'gif' || ext === 'jpeg' || ext === 'JPG' || ext === 'PNG' || ext ==='GIF' || ext === 'JPEG') {
					img=true;
				}else {
					$("#info").addClass('error');
						$("#info").html('<span style="color:#f04124;">Por favor selecciona una imagen.</span>');
			}
		}else{

			/*Video*/
			var video = $("#idea #upload-video").val();
				video= video.split('.');
				var video2= '';
				var ext2 =false;
				//console.log(video[(video.length -1)]);
			    ext2=video[(video.length -1)];
			    ext2=ext2.toLowerCase();
					if ( ext2 === 'mp4' || ext2 ==='wmv' || ext2 === 'mpg' || ext2 === 'mpeg' || ext2 === '3gp' || ext2 === '3g2' || ext2 === 'avi') {
						video2=true;
					}else {
						$("#info").addClass('error');
							$("#info").html('<span style="color:#f04124;">Por favor selecciona una video.</span>');
			}
		}
		
		
		if(jQuery('#idea').valid() && (img || video2)){
		var nombre=jQuery('#nombre').val(),
		jQuery('.btn-submit').hide('float');
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
		var formData = new FormData(document.getElementById("idea"));
		jQuery.ajax({
				url: 'eventos.php',
				dataType:'json' ,
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				/*data: {
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
				},*/
				success: function (data){
					console.log(data);
					if(data=='exitoso'){

						//jQuery('.exitoso').removeClass('hidden');
						jQuery('input').val('');
						jQuery('.btn-submit').show('fade');
						//dataLayer.push({'event': 'registro-camisetas-exitoso'});

						//Animaciones
						$('.form-group, .checkbox')
							.velocity({
								height: 0,
								opacity: 0
							}, {
								duration: 800,
								easing: 'ease-in-out'

							});

						$(this)
							.velocity({
								backgroundColor: '#007edd',
								width: '100%',
								complete: function () {
									$(this).text('Tu idea fue envíada');
								}
							});
						
						$(this).attr('readonly', 'readonly');
					}
				}

			});
			return false;

		}

	});

	/*F registro*/

	/*Tamaño imagen*/
	function displayPreview(files,id) {
		//console.log(files.type);
		if(files.type.match('image.*') || files.type.match('video.*')){
				
			var reader = new FileReader();
			var img = new Image();
			reader.onload = function (e) {
				img.src = e.target.result;
				fileSize = Math.round(files.size / 1024);
				//alert("File size is " + fileSize + " kb");
				img.onload = function () {
					console.log(fileSize);
					console.log(id);
					if(id=="upload-img" && fileSize>880){
						jQuery('#'+id).val('');
						jQuery('#'+id).parent().next().remove();
						jQuery('#'+id).parent().after('<div class="mensaje">El archivo no debe pesar más de 3MB </div>');
					}else{
						jQuery('#'+id).parent().next().remove();
						//jQuery('#'+id).parent().after('<div class="mensaje"></div>');
					}
	
				};
				if(id=="upload-video" && fileSize>26000){
						//console.log('Entra acá');
						jQuery('#'+id).val('');
						jQuery('#'+id).parent().next().remove();
						jQuery('#'+id).parent().after('<div class="mensaje">El archivo no debe pesar más de 25MB </div>');
				}else{
					jQuery('#'+id).parent().next().remove();
					//jQuery('#'+id).parent().after('<div class="mensaje"></div>');
				}
			};
			reader.readAsDataURL(files);
		}else{
			jQuery('#'+id).val('');
			jQuery('#'+id).parent().after('<div class="mensaje">Formato no v&aacute;lido</div>');
		}
	}
	jQuery(document).on("change",'#upload-img',function () {
		var input=jQuery(this).attr('id');
		//console.log(input);
		var file = this.files[0];
		displayPreview(file,input);
				 
		//console.log('cambia');
	});
	jQuery(document).on("change",'#upload-video',function () {
		var input=jQuery(this).attr('id');
		//console.log(input);
		var file = this.files[0];
		displayPreview(file,input);
		//console.log('cambia');
	});
	/*Tamaño imagen*/
	/*F fuciones varias*/

/*Subir imagenes*/
// 'use strict';


       /*F Subir imagenes*/
/*No tocar*/
});