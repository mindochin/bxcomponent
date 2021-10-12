function formAttentionScroll(dist, parent) {
	$(parent).animate({
		scrollTop: dist
	}, 700);
}
$(document).on("click", "button.form-submit", function(event) {

	var script_dir = $("input[name='cpath']").val();

	var form = $(this).parents("form.send");

	var path = script_dir + "/ajax/forms.php";
	
	var product = $(this).data('product');

	//var form_id = $("input[name='form-id']", form).val();
	var button = $("button[name='form-submit']", form);
	//var link = button.attr("data-link");
	var header = $("input[name='header']", form);
	//var agreecheck = $("input.agreecheck", form);
	var form_block = $("div.form-block", form);
	var load = $("div.form-load", form);
	var thank = $("div.form-thanks", form);
	var error = 0;
	form.find("input[name='url']").val(decodeURIComponent(location.href));


	var formSendAll = new FormData();

	formSendAll.append("send", "Y");
	if(typeof product !== 'undefined')
		if(product.length > 0)
			formSendAll.append("product", product);

	$("input[type='email'], input[type='text'], input[type='password'], textarea", form).each(
		function(key, value) {
			if ($(this).hasClass("email") && $(this).val().length > 0) {
				if (!(
						/^([a-z0-9_\-]+\.)*[a-z0-9_\-]+@([a-z0-9][a-z0-9\-]*[a-z0-9]\.)+[a-z]{2,4}$/i
					).test($(this).val())) {
					$(this).addClass("is-invalid");//parent("div.form-control").
					error = 1;
				}
			}
			if ($(this).prop('required')) {
				if ($(this).val().length <= 0) {
					$(this).addClass("is-invalid");
					error = 1;
				}
				else {
					$(this).removeClass("is-invalid");
				}
			}
		});
	$("input[type='file']", form).each(function(key, value) {
		if ($(this).hasClass("require")) {
			if ($(this).closest('.load-file').find('span.area-file').hasClass(
					'area-file')) {
				$(this).closest('.load-file').addClass("has-error");
				error = 1;
			}
		}
	});
	/*if (!$('.kraken-modal').hasClass('form-modal')) {
		var otherHeight = 0;
		if ($('header').hasClass('fixed')) otherHeight = $('header .header-top').outerHeight(
			true);
	}*/
	if (error == 1 && !(form.parents('#modalBlockForm'))) {
		formAttentionScroll(form.find('.is-invalid:first').offset().top, "html:not(:animated),body:not(:animated)");
	}
	if (error == 0) {
		form.css({
			"height": form.outerHeight() + "px"
		});

		form_arr = $(form).find(':input,select,textarea').serializeArray();

	    for (var i = 0; i < form_arr.length; i++)
	    {
	        formSendAll.append(form_arr[i].name, form_arr[i].value);
	    };

	    if (form.hasClass('file-download'))
	    {
	    	form.find('input[type=file]').each(function(key)
	    	{

	    		var inp = $(this);
	    		var file_list_name = "";

	    		$(inp[0].files).each(
		            function(k){
		            	formSendAll.append(inp.attr('name'), inp[0].files[k], inp[0].files[k].name);
		            }
		        );

	    	});
	    }
	    
		//button.attr("disabled", true);
		//button.html('<i class="fa fa-spinner fa-pulse fa-fw"></i> Секундочку...');
		form_block.removeClass("active");
		load.addClass("active");
		setTimeout(function() {
			$.ajax({
				url: path,
				type: "post",
				contentType: false,
				processData: false,
				data: formSendAll,
				dataType: 'json',
				success: function(json) {
					/*$("body").append(json);*/
					if (json.OK == "N") {
						//button.addClass("active");
						form_block.addClass("active");
						load.removeClass("active");
						if(!(form.parents('#modalBlockForm')))
							formAttentionScroll(form.find('.form-load').offset().top, "html:not(:animated),body:not(:animated)");
					}
					if (json.OK == "Y") {
						/*$.ajax({
							url: "/",
							type: "post",
							success: function(json) {}
						});*/
						if(!(form.parents('#modalBlockForm')))
							setTimeout(function() {
								formAttentionScroll(form.find('.form-thanks').offset().top, "html:not(:animated),body:not(:animated)");
							}, 300);
						
						if (typeof(link) != "undefined") {
							setTimeout(function() {
								window.location.href = link;
							}, 3000);
						}

						load.removeClass("active");
						thank.addClass("active");

						if (json.SCRIPTS.length > 0) {
							/*$('body').append("<script>"+json.SCRIPTS+"</script>");*/
							form.append("<script type=\"text/javascript\">"+json.SCRIPTS+"</script>");
						}
						
					}
				}
			});
		}, 1000);
	}
});
/*$(document).on("focus", "form input[type='text'], form textarea", function() {
	$(this).parent("div.input").removeClass("has-error");
	if ($(this).val().length <= 0 && !$(this).hasClass("phone")) {
		$(this).attr("data-placeholder", $(this).attr("placeholder"));
		$(this).attr("placeholder", "");
	}
});
$(document).on("blur", "form input[type='text'], form textarea", function() {
	if ($(this).val().length <= 0 && !$(this).hasClass("phone")) $(this).attr(
		"placeholder", $(this).attr("data-placeholder"));
});*/
$(document).on("keypress", "form.form div.count input", function(e) {
	e = e || event;
	if (e.ctrlKey || e.altKey || e.metaKey) return;
	var chr = getChar(e);
	if (chr == null) return false;
});
$(document).on("keyup", "form.form div.count input", function(e) {
	var value = $(this).val().toString();
	var newVal = "";
	for (var i = 0; i < value.length; i++) {
		if (value[i] == "0" || value[i] == "1" || value[i] == "2" || value[i] ==
			"3" || value[i] == "4" || value[i] == "5" || value[i] == "6" || value[i] ==
			"7" || value[i] == "8" || value[i] == "9") newVal += value[i];
	}
	if (newVal == 0) newVal = 1;
	$(this).val(newVal);
	if ($(this).val() == "") $(this).parent().addClass('in-focus');
});
$(document).on("click", "form.form div.count span.plus", function(e) {
	var input = $(this).parent("div.count").find("input");
	var value = parseFloat(input.val());
	if (isNaN(value)) value = 0;
	value += 1;
	input.val(value);
	if ($(this).val() == "") $(this).parent().addClass('in-focus');
});
$(document).on("click", "form.form div.count span.minus", function(e) {
	var input = $(this).parent("div.count").find("input");
	var value = parseFloat(input.val());
	if (isNaN(value)) value = 0;
	value -= 1;
	if (value < 0) value = '';
	if (value == 0) value = 1;
	input.val(value);
});
$(document).on("keypress", ".only-num", function(e) {
	e = e || event;
	if (e.ctrlKey || e.altKey || e.metaKey) return;
	var chr = getChar(e);
	if (chr == null) return false;
});
/*$(document).on("focus", "input.focus-anim, textarea.focus-anim", function() {
	if ($(this).val() == "") $(this).parent().addClass('in-focus');
});
$(document).on("blur", "input.focus-anim, textarea.focus-anim", function() {
	element = $(this);
	setTimeout(function() {
		if (element.val() == "") element.parent().removeClass('in-focus');
	}, 200);
});*/
$(document).ready(function() {
	$("form.send").keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
	}
   });
   
	$('#modalBlockForm').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget);
		var product = button.data('product');
		var modal = $(this);
		modal.find('button.form-submit').attr('data-product', product);
	});
});