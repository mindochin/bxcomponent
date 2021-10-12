BX.bindDelegate(document.body, 'click', {className: 'js-feedback' }, function(e){
		let _this = this;
		let oldHtml = this.innerHTML;
		
		showWait(this);
		
		BX.ajax.runComponentAction('mindochin:feedback.vue', 'getForm', {
			mode: 'class', //это означает, что мы хотим вызывать действие из class.php
			data: {},
		}).then(function (response) {
			//console.log('success',response);
			BX.ajax.loadScriptAjax(
			 response.data.script_url,
			 function (){
				 closeWait(_this,oldHtml);
			 }
			)	
		}, function (response) {
			//сюда будут приходить все ответы, у которых status !== 'success'
			console.log('error',response);
			closeWait(_this,oldHtml);			
		});
})
