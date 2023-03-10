<script>
	$.fn.serializeObject = function(){
		var o = {};
		var a = this.serializeArray();
		$.each(a, function() {
		if (o[this.name] !== undefined) {
			if (!o[this.name].push) {
			o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || '');
		} else {
			o[this.name] = this.value || '';
		}
		});
		return o;
	};

	function popUp(ruta,params={},fn = function(){},fnP={}){
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		params[token['csrfName']] = token['csrfHash'];

		$('#popCont').empty();
		// console.log(params);
		// console.log(ruta);
		$('#popCont').load(ruta,params, function(){
			if(fn){
				fn(fnP);
			}
		});
		
		$('#popUp').modal('show');
		$('.modal-dialog').css({marginTop:'30px'});
	}

	function popUpMapa(ruta,params,fn = function(){},fnP={}){
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		params[token['csrfName']] = token['csrfHash'];
		$('#popContMapa').empty();
		$('#popContMapa').load(ruta,params, function(){
			if(fn){
				fn(fnP);
			}
		});
		
		$('#popUpMapa').modal('show');
		$('.modal-dialog').css({marginTop:'30px'});
	}

	function popUpImg(ruta,params,fn = function(){},fnP={}){
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		params[token['csrfName']] = token['csrfHash'];
		$('#popContImg').empty();
		$('#popContImg').load(ruta,params, function(){
			if(fn){
				fn(fnP);
			}
		});
		
		$('#popUpImg').modal('show');
		$('.modal-dialog').css({marginTop:'30px'});
	}

	function popUpCuest(ruta,params,fn = function(){},fnP={}){
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		params[token['csrfName']] = token['csrfHash'];
		$('#popContCuest').empty();
		$('#popContCuest').load(ruta,params, function(){
			if(fn){
				fn(fnP);
			}
		});
		$('#popUpCuest').modal('show');
		$('.modal-dialog').css({marginTop:'30px'});
	}

	function popUpAlerta(ruta,params,fn = function(){},fnP={}){
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		params[token['csrfName']] = token['csrfHash'];
		$('#alertasCont').empty();
		$('#alertasCont').load(ruta,params, function(){
			if(fn){
				fn(fnP);
			}
		});
		$('#alertas').modal('show');
		$('.modal-dialog').css({marginTop:'30px'});
	}

	function verImagen(src){
		popUpImg('lib/j/php/verImg.php',{src:src},function(){},{});
	}

	function convertUTCDateToLocalDate(date) {
	    // var newDate = new Date(date.getTime()+date.getTimezoneOffset()*60*1000);
	    var newDate = new Date(date.getTime());

	    var offset = date.getTimezoneOffset() / 60;
	    var hours = date.getHours();

	    newDate.setHours(hours - offset);
	    // newDate.setHours(hours);
	    // console.log(date.getTimezoneOffset())
	    // console.log(newDate);
	    return newDate;   
	}

	function ptsHoraLocal(pts){

		for(var i in pts){
			var ff = pts[i].fecha;
			var hh = pts[i].hora;
			var date = new Date(pts[i]['Time UTC']);
			// var date =  new Date(ff.split('-')[0], ff.split('-')[1], ff.split('-')[2], hh.split(':')[0], hh.split(':')[1], hh.split(':')[2], 00);
			var d = convertUTCDateToLocalDate(date);

			pts[i].fecha = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
			pts[i].hora = d.getHours()+':'+("0" + d.getMinutes()).slice(-2);
			

			// console.log( nDate.getFullYear() );

		}
	}

	function camposObligatorios(forma){
		var todos = true;

		$.each( $(forma+' .oblig'), function(index, val) {
			var tipo = $(this)[0].tagName;
			if(tipo == 'DIV'){			
				if($(this).text() == '' && $(this).is(':visible')){
					$(this).css({backgroundColor:'rgba(255,0,0,.5)'});
					todos = false;
				}
			}else{			
				// console.log($(this).val())
				if(($(this).val() == '' || $(this).val()== null ) && $(this).is(':visible')){
					$(this).css({backgroundColor:'rgba(255,0,0,.5)'});
					todos = false;
				}
			}
		});

		return todos;
	}

	function load(dom_elem,ruta,params= {}){
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		params[token['csrfName']] = token['csrfHash'];

		$(dom_elem).load(ruta,params);
	}

	function jsonF(archivo,datos={}){
		with ((console && console._commandLineAPI) || {}) {
		  r = '';
		}
		// console.log(archivo);
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		datos[token['csrfName']] = token['csrfHash'];
		var r = '';
		$.ajax({
			url: archivo,
			type: 'POST',
			data: datos,
			async:false
		})
		.done(function(data) {
			r = data
		})
		.fail(function(e) {
			console.log("error");
			console.log(e);
		});
		
		return r;
	}

	function jsonFG(archivo,datos={}){
		with ((console && console._commandLineAPI) || {}) {
		  r = '';
		}
		var r = '';
		$.ajax({
			url: archivo,
			type: 'GET',
			data: datos,
			async:false
		})
		.done(function(data) {
			r = data
		})
		.fail(function(e) {
			console.log("error");
			console.log(e);
		});
		
		return r;
	}

	function jsonFA(archivo,datos,fnc){
		with ((console && console._commandLineAPI) || {}) {
		  r = '';
		}
		var r = '';
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		datos[token['csrfName']] = token['csrfHash'];
		$.ajax({
			url: archivo,
			type: 'POST',
			data: datos,
			async:true
		})
		.done(function(data) {
			// console.log(data);
			// r = data;
			fnc(data,datos);
		})
		.fail(function(e) {
			console.log("error");
			console.log(e);
		});
		
		return r;
	}

	function jsonFF(archivo,fnc,params){
		with ((console && console._commandLineAPI) || {}) {
		  r = '';
		}
		var r = '';
		token =  $.parseJSON(jsonFG('<?= base_url(); ?>/general/general/csrfToken/json'));
		datos[token['csrfName']] = token['csrfHash'];
		$.ajax({
			url: archivo,
			type: 'POST',
			data: datos,
			async:false
		})
		.done(function(data) {
			r = data
			fnc(params);
		})
		.fail(function() {
			console.log("error");
		});
		
		return r;
	}

	function optsSel(arr,elemSel,sinVacio,nomVacio,add){
		add = typeof add == 'undefined'?false:add;
		if(!add){
			elemSel.empty();
			if(!sinVacio){	
				if(nomVacio == "" || nomVacio == undefined){
					var o = new Option('- - - - - - - -','');
				}else{
					var o = new Option(nomVacio,'');
				}
				elemSel.append(o);
			}
		}
		
		for(var e in arr){
			if(arr[e].clase != undefined){
				var o = '<option value="'+arr[e].val+'" class="'+arr[e].clase+'">'+arr[e].nom+'</option>'
			}else{
				var o = new Option(arr[e].nom,arr[e].val);
			}
				elemSel.append(o);
		}
	}

	function alerta(tipo,texto){
		if(tipo == 'danger'){
			$('<div>')
			.attr({'class':'alert alert-'+tipo, role:'alert'})
			.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span>'+
				'</button><strong>'+texto+'</strong>')
			.appendTo('#dAlerta')
			.fadeTo(0, 0)
			.fadeTo(500, 1);
		}else{

			$('<div>')
			.attr({'class':'alert alert-'+tipo, role:'alert'})
			.html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">??</span>'+
				'</button><strong>'+texto+'</strong>')
			.appendTo('#dAlerta')
			.fadeTo(0, 0)
			.fadeTo(500, 1)
			.fadeTo(5000, 1,function(){$(this).remove()});
		}
	}

	function alertar(html,fnc=function(){},params={}){
		// console.log('vvv')
		var c = null;
		popUpAlerta('<?= base_url(); ?>/general/general/alert',{html:html},function(e){
			$('#alertas #envOkModal').click(function(event) {
				fnc(e);
			});
		},params);
	}

	function conf(controller,html,params,fnc){
		var c = null;
		popUpAlerta(controller,{html:html},function(e){
			$('#alertas #envOkModal').click(function(event) {
				fnc(params);
			});
		},params) ;
	}

	/**
	* Sube un archivo a un directorio espec??fico y le cambia el nombre a prefijo_nombreDelArchivo.
	*
	* @method subArch
	* @param {String} elementoId El id del bot??n de upload.
	* @param {String} prefijo El prefijo que tendr?? el archivo al guardarlo
	* @param {String} dir La ruta del directorio donde se guardar?? el archivo a partir del directorio raiz
	* @param {String} funcion El m??todo que se ejecutar?? al terminar la carga del archivo.

	* @return {Void}
	*/
	function subArch(
			elemento,
			url,
			formData,
			extensiones,
			dragDrop,
			funcion,
			allowMultiple=true,
			uploadStr = 'Select',
			dragDropStr = "<span style='margin-bottom:20px;'> &nbsp; Drag and drop files</span>",
			extErrorStr = "cannot be loaded. Only the following extensions are accepted "
		){
		// console.log("pppppp", evitarNombreOriginal);
		var r = '';
		elemento.uploadFile({
			url:url,
			fileName:"myfile",
			allowedTypes:extensiones,
			dragDrop:dragDrop,
			dataType:"json",
			multiple: allowMultiple,
			formData:formData,
			showStatusAfterSuccess: false,
			uploadStr:uploadStr,
			extErrorStr:extErrorStr,
			dragDropStr:dragDropStr,
			onSuccess:
			function(files,data,data2){
				// console.log(data);
				var infoArchivo = $.parseJSON(data);
				// console.log(infoArchivo);
				if(infoArchivo.ok == 1){
					if(funcion){
						funcion(infoArchivo);
					}
				}else{
					console.log(data);
				}
				
			},
			onError:function(files, status, message, pd){
				console.log(files);
				console.log(status);
				console.log(message);
				console.log(pd);
			}
		});
	}




	/**
	* S??lo permite escribir n??meros en un campo de texto 
	*
	* @method soloNumeros
	* @param {Object} idInputTexto El elemento en jQuery del objeto al que se aplicar?? el m??todo.
	* @return {Void}
	*/
	function soloNumeros(elem){
		// console.log(elem)
		elem.keydown(function(event){
			// console.log(event.keyCode)
			
			// Acepta: backspace, delete, tab, escape, and enter
			if(event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 190 ||
				// Acepta: Ctrl+A
				(event.keyCode == 65 && event.ctrlKey === true) || 
				// Acepta: Ctrl+R
				(event.keyCode == 82 && event.ctrlKey === true) || 
				// Acepta: home, end, left, right
				(event.keyCode >= 35 && event.keyCode <= 39)) {
					// no hacer nada
					// console.log(event.keyCode)
					return;
			}else{
				// Ensure that it is a number and stop the keypress
				if(event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
					// console.log(event.keyCode)
					
					event.preventDefault();
				}
			}

		});
		elem.mousedown(function(e) {
			if( e.button == 2 ) { 
			  return false; 
			} 
			return true; 
		});

		elem.keyup(function(event) {
			var point = false;
			var str = '';
			for(var k = 0; k<elem.val().length; k++){
				if(!isNaN(elem.val()[k]) && elem.val()[k] != ' '){
					// console.log('entra:',elem.val()[k]);
					str += elem.val()[k];
				}
				if(elem.val()[k] == '.' && !point){
					str += elem.val()[k];	
					point = true;
				}
				if(elem.val()[k] == '-' && $k==0){
					str += elem.val()[k];
				}
			}
			// console.log('str:',str);
			elem.val(str);
		});


	}
	/**
	* S??lo permite escribir n??meros en un campo de texto 
	*
	* @method soloNumeros
	* @param {Object} idInputTexto El elemento en jQuery del objeto al que se aplicar?? el m??todo.
	* @return {Void}
	*/
	function desactivaEsc(elem){
		// console.log(elem)
		elem.keydown(function(event){
			// console.log(event.keyCode)
			
			// Acepta: backspace, delete, tab, escape, and enter
			if(event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
				// console.log(event.keyCode)
				
				event.preventDefault();
			}

		});
		elem.mousedown(function(e) {
			if( e.button == 2 ) { 
			  return false; 
			} 
			return true; 
		});
	}

	function loading(){
		disableScroll();
		$('<div>')
		.attr({
			id: 'over'
		})
		.css({
			width: '100%',
			height:'100%',
			backgroundColor: 'rgba(0,0,0,.6)',
			position:'absolute',
			top:'0px',
			left:'0px',
			zIndex: 1000
		}).appendTo(document.body);

		$('<div>')
		.attr({
			id: 'loader',
			class: 'loader'
		}).appendTo('#over')
		.css({
			position: 'absolute',
			top: '45%',
			left:'45%'
		});
	}

	function removeLoading(){
		$('#over').remove();
		enableScroll();
	}

	function disableScroll() {
	  if (window.addEventListener) // older FF
	      window.addEventListener('DOMMouseScroll', preventDefault, false);
	  window.onwheel = preventDefault; // modern standard
	  window.onmousewheel = document.onmousewheel = preventDefault; // older browsers, IE
	  window.ontouchmove  = preventDefault; // mobile
	  document.onkeydown  = preventDefaultForScrollKeys;
	}

	function enableScroll() {
	    if (window.removeEventListener)
	        window.removeEventListener('DOMMouseScroll', preventDefault, false);
	    window.onmousewheel = document.onmousewheel = null; 
	    window.onwheel = null; 
	    window.ontouchmove = null;  
	    document.onkeydown = null;  
	}

	function preventDefault(e) {
	  e = e || window.event;
	  if (e.preventDefault)
	      e.preventDefault();
	  e.returnValue = false;  
	}

	function preventDefaultForScrollKeys(e) {
	    if (keys[e.keyCode]) {
	        preventDefault(e);
	        return false;
	    }
	}

	function parseaObjeto(obj){

		for(var i in obj){
			if( typeof(obj[i]) == 'object'){
				if(i != 'cats'){
					parseaObjeto(obj[i]);
				}
			}else{
				// console.log(obj[i]);
				// console.log(obj[i],parseFloat(obj[i]));

				if(isNaN(filterFloat(obj[i]))  ) {
					obj[i] = obj[i];
					// console.log("NaN",obj[i]);
					// console.log('cadena');
				}else{
					obj[i] = parseFloat(obj[i]);
					// console.log("no NaN",obj[i]);
					// console.log('numero');
				}
				// console.log(parseFloat(obj[i]));
				// obj[i] = isNaN(parseFloat(obj[i]))?obj[i]:parseFloat(obj[i]);
			}
		}
	}

	function genGrid(){
		var gridster = $('.grid-stack').gridstack({
			handle: '.widgetBar',
			// float: true
		}).data('gridstack');
		return gridster;
	}

	function isInt(x) {
	    return x % 1 === 0;
	}

	function ajustaWidget(wId){
		// console.log(wId);
		var liH = $('#wid_'+wId).height();
		var bH = $('#wid_'+wId).find('.widgetBar').height();
		// console.log(liH,bH,liH-bH-10);
		$('#wid_'+wId).find('.grafica').height(liH-bH-10);
		// console.log($('#wid'+wId).find('.grafica').highcharts());
		if( typeof $('#wid_'+wId).find('.grafica').highcharts() != "undefined" ){
			$('#wid_'+wId).find('.grafica').highcharts().reflow();
		}
	}

	var filterFloat = function(value) {
	    if (/^(\-|\+)?([0-9]+(\.[0-9]+)?|Infinity)$/
	      .test(value))
	      return Number(value);
	  return NaN;
	}

	function strip(html){
	   var tmp = document.createElement("DIV");
	   tmp.innerHTML = html;
	   return tmp.textContent || tmp.innerText || "";
	}

	function isNumeric(n) {
	  return !isNaN(parseFloat(n)) && isFinite(n);
	}

	function muestraResultados(dat){
		if(dat.length == 0)
			dat.cuenta = "contar";
		switch( $('.'+dat.cuenta).length){
			case 0:
			$('#contador').html("No se encontraron resultados para la b??squeda.");		
			break;
			case 1:
			$('#contador').html("Se encontr?? <span class='cuenta'>1</span> resultado para la b??squeda.");		
			break;
			default:
			$('#'+dat.id).html("Se encontraron <span class='cuenta'>"+$('.'+dat.cuenta).length+"</span> resultados.");		
		}
	}

	function validateEmail(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

	function addSA(layer,rutaGet,acc,pregId,vId = 0,style = {}){
		var getSA = jsonF(rutaGet,{acc:acc,pId:pregId,vId:vId});
		// console.log(getSA);
		var SAs = $.parseJSON(getSA);

		var allPoints = [];
		for(var saId in SAs){

			var points = [];
			var sa = SAs[saId];
			if(sa.geometry == null){
				continue;
			}
			var geometry = $.parseJSON(sa.geometry);
			var coordinates = geometry.coordinates;
			// console.log(typeof coordinates);
			for(var i in coordinates){
				var p = coordinates[i];
				for(var j in p){
					// console.log('j:',j,p[j],typeof p[j]);
					allPoints.push(L.marker( [ p[j][1], p[j][0] ] ));
					points.push( [ p[j][1], p[j][0] ] );
				}
				// console.log(sa[i]);
				// if(sa[i]['lat'] == null || sa[i]['lng'] == null){
				// 	continue;
				// }
			// 	// points.push([sa[i]['lat'],sa[id]['lng']]);
			}

			// console.log('aa',points.length, points);
			if(points.length > 0){		
				var polygon = L.polygon(points);
				polygon.setStyle(style);

				polygon.dbId = sa['id'];
				polygon.type = geometry['type'].toLowerCase();

				layer.addLayer(polygon);
			}
		}
		return allPoints;
	}

	function chUrl(request,key,value,pushState = true,onlyRequest = false){
		var url = window.location.href;
		urlE = url.split('?');
		var params={};
		window.location.search
		  .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str,key,value) {
		    params[key] = value;
		  }
		);

		// console.log(url,request);
		for(var i in request){
			params[i] = request[i];
		}

		if(key != ''){
			params[key] = value;
		}
		// console.log(url,request);
		var str = '?';

		if(!onlyRequest){
			delete(params['logout']);

			for(var i in params){
				str += i+'='+params[i]+'&';
			}
		}else{
			for(var i in request){
				str += i+'='+request[i]+'&';
			}
		}
		

		// console.log(urlE,str);
		url = urlE[0]+str;
		// console.log('URL: ',url)
		if(pushState){
			history.pushState('data', '', url);
		}
		return params;
	}

	function change(state) {
	    if(state === null) { // initial page
	        $("div").text("Original");
	    } else { // page added with pushState
	        $("div").text(state.url);
	    }
	}

	function tooltipETS(elems){
		for(var i = 0; i<elems.length ; i++){
			var o = $('<span>').attr({class:"tooltiptextETS"}).text($(elems[i]).attr('tooltiptext')).appendTo(elems[i]);	
		}
	}

	function escapeHtml(text) {
	  return text
	      .replace(/&/g, "&amp;")
	      .replace(/</g, "&lt;")
	      .replace(/>/g, "&gt;")
	      .replace(/"/g, "&quot;")
	      .replace(/'/g, "&#039;");
	}	
</script>
