$(document).ready(function(){
	var $fotoramaDiv = $("#slider").fotorama({
		nav: false,
		width: '100%',
		height: '408px',
		arrows: false,
		click: false,
		swipe: false
	});
	var fotorama = $fotoramaDiv.data('fotorama');
	$(".content__slider_pag span:first-child").click(function(){
		fotorama.show('<');
	});
	$(".content__slider_pag span:last-child").click(function(){
		fotorama.show('>');
	});
	
	$(document).on('click', '[id^=like-]', function(e) {
		e.stopPropagation();
		
		let cbox = $(e.target);
		cbox.prop('checked', false);
		
		BX.ajax.runComponentAction('mindochin:test.oneway', 'setLike', {
			mode: 'class',
			data: {
				imgId: e.target.id,				
			},
		}).then(function (response) {
			
			let count = response.data.success.count;
			let label = cbox.next('label')[0];
			let child = $(label).children();
			
			$(label).html('');
			$(label).append(child);
			$(label).append(' ' + count);			
			
			if(response.data.success.set == 'add'){
				cbox.prop('checked', true);
			}
			
			return false;
			
		}, function (response) {				
			console.log('error',response);
			return false;
		});
	});
});