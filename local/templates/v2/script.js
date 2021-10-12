BX.ready(function(){
	let loader = '<i class="fa fa-spinner fa-pulse fa-fw"></i> Загрузка...';
	let modalTemplate = '';
	
	showWait = function(node) {
		BX.adjust(node,{html: loader});			
	};
	//html - предыдущее содержимое
	closeWait = function(node, html) {
		BX.adjust(node,{html});	
	};
	/*BX.bindDelegate(document.body, 'click', {className: 'js-modal' }, function(e){
		//e.preventDefault();
		//e.stopPropagation();
		let _this = this;
		let oldHtml = this.innerHTML;
		let formId = this.dataset.form;
		let now = parseInt(Date.now() / 1000);
		let divId = formId;// + now;
		showWait(this);
		BX.ajax.post(
			BX.message('SITE_DIR') + "/ajax/form.php",//siteOptions['SITE_TEMPLATE_PATH'] + 
			{"formId": formId},
			function(msg){
				document.body.insertAdjacentHTML('beforeend', msg);
				closeWait(_this,oldHtml);
				let dmodal = document.getElementById(divId);
				let bmodal = new bootstrap.Modal(dmodal);
				bmodal.show();
				dmodal.addEventListener('hidden.bs.modal', function (event) {					
					BX.remove(dmodal);
				})
				
				BX.bindDelegate(document.body, 'click', {className: 'js-send' }, function(e){
					let form = e.delegateTarget.querySelector('form');
					let input = document.createElement("input");
          input.type = "hidden";
          input.name = "formId";
					input.value = "feedback";
          form.appendChild(input);
					let btn = form.querySelector('input[name="iblock_submit"]');
					btn.click();
					//console.log(form)
				})
			}		
		)

		//await sleep(2000);
		//BX.closeWait(this,oldHtml);
		return false;
	});*/
})

function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}
function modalTpl(id, msg){
	let modal = '<div class="modal fade" id="'+id+'" tabindex="-1" aria-labelledby="'+id+'Label" aria-hidden="true">';
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