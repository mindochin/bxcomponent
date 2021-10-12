$(document).ready(function(){
	let loader = '<i class="fa fa-spinner fa-pulse fa-fw"></i> Загрузка...';
	let modalTemplate = '';
	showWait = function(node) {
		$(node).html(loader);		
	};
	closeWait = function(node, html) {
		$(node).html(html);
	};
	$(document).on('click', '.js-modal', function(e){
		e.preventDefault();
		e.stopPropagation();
		let _this = this;
		let oldHtml = $(this).html();		
		let formId = $(this).data('form');
		let formName = $(this).text();
		let now = parseInt(Date.now() / 1000);
		let divId = formId + now;
		showWait(this);
		$.ajax({
				url: siteOptions['SITE_TEMPLATE_PATH'] + "/ajax/form.php",
				dataType: "html",
				type: "POST",
				data: {"formId": formId},
				success: function(msg){
					let modalBody = modalTpl(divId, msg);
					$(modalBody).appendTo('body');
					let modal = new bootstrap.Modal(document.getElementById(divId));					
					//console.log('modal',modal)
					
					modal.show();
					closeWait(_this,oldHtml);
				},
				error: function(msg){
					//console.log('error',msg)
					closeWait(_this,oldHtml);
				}
		})

		//await sleep(2000);
		//BX.closeWait(this,oldHtml);
		return false;
	});
})
function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}
function modalTpl(id, msg){
	let modal = '<div class="modal fade" id="'+id+'" tabindex="-1" aria-labelledby="'+id+'Label" aria-hidden="true"';
  modal += '<div class="modal-dialog">';
  modal += '<div class="modal-content">';
  modal += '<div class="modal-header">';
  modal += '<h5 class="modal-title" id="'+id+'Label">Modal title</h5>';
  modal += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
  modal += '</div>';
  modal += '<div class="modal-body">';
	modal += msg;
  modal += '</div>';
  /*<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
  </div>*/
  modal += '</div>';
  modal += '</div>';
	modal += '</div>';
	
	return modal;
}