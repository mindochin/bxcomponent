if (typeof vueFeedbackNode === 'undefined') {
	let vueFeedbackNode = document.createElement("div");
	vueFeedbackNode.id = "vueFeedbackNode";
	document.body.appendChild(vueFeedbackNode);
}

if (typeof vueFeedback === 'undefined') {
		
	const tplVueFeedback = `
		<div class="modal fade" id="feedback" tabindex="-1" aria-labelledby="feedbackLabel" aria-hidden="true">
			<div class="modal-dialog">
			
			<template v-if="success">
			
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="feedbackLabel">Сообщение отправлено</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div class="alert alert-success" role="alert">
							<p>Скоро я получу Ваше сообщение и свяжусь с Вами.</p>
							<p>Благодарю за интерес!</p>
						</div>						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-bs-dismiss="modal">Закрыть</button>
					</div>
				</div>
				
			</template>
			<template v-else>
			
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="feedbackLabel">Оставить сообщение</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<div v-if="errors.all" class="alert alert-danger" role="alert">{{errors.all}}</div>
						<form>
							<div class="mb-3">
								<label for="fbContact" class="form-label">Ваш контакт для связи</label>
								<input type="text" class="form-control" :class="validatedClass('fbContact')" name="fbContact" id="fbContact" v-model.trim="fbContact">
								<div v-if="errors.fbContact" class="invalid-feedback">{{errors.fbContact}}</div>
							</div>
							<div class="mb-3">
								<label for="fbMessage" class="form-label">Сообщение</label>
								<textarea class="form-control" :class="validatedClass('fbMessage')" name="fbMessage" id="fbMessage" rows="3" v-model.trim="fbMessage"></textarea>
								<div v-if="errors.fbMessage" class="invalid-feedback">{{errors.fbMessage}}</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Закрыть</button>
						<button type="button" class="btn btn-success js-send" @click="sendFeedback()">Отправить</button>
					</div>
				</div>
				
			</template>
			
			</div>
		</div>
	`;

	const { Modal } = bootstrap;

  const vueFeedback = BX.Vue.create({
    el: '#vueFeedbackNode',
    template: tplVueFeedback,
		data: {
			wasValidated: false,
			theModal: null,
			fbContact: '',
			fbMessage: '',
			errors: [],
			success: false,
		},
		watch: {
			fbContact: function (newVal, oldVal) {
				this.validateData();
			},
			fbMessage: function (newVal, oldVal) {
				this.validateData();
			},
		},
		mounted() {
			if(!this.theModal)
				this.theModal = new Modal(this.$el, {}),
      
			this.theModal.show();
    },
		computed: {
			validatedClass() {
				return (input) => {
					return {
						'is-valid': this.wasValidated && !this.errors[input],
						'is-invalid': !this.wasValidated && this.errors[input],
					}
				}
			},
		},
		methods: {
			validateData(){
				this.errors = [];
				this.wasValidated = false;
				let error = false;
				this.fbContact = this.fbContact.trim();
				this.fbMessage = this.fbMessage.trim();
				
				if(this.fbContact.length < 5) {
					this.errors.fbContact = 'Поле с контактом не должно быть пустым (меньше 5 символов)';
					error = true;
				}

				if(this.fbMessage.length < 10) {
					this.errors.fbMessage = 'Поле с сообщением не должно быть пустым (меньше 10 символов)';
					error = true;
				}
				
				if(error === true){					
					return false;
				}
				else{
					this.wasValidated = true;
					return true;
				}				
			},
			sendFeedback(){
				
				if(this.validateData() === false) {
					return;
				}
				
				if (!window.fetch) {
					this.errors.all = 'Ваш браузер не поддерживает отправку данных';
					return;
				}
								
	      var formData = new FormData();
	      formData.append('fbContact', this.fbContact);
	      formData.append('fbMessage', this.fbMessage);
				formData.append('formId', 'feedback');
				formData.append('action', 'send');
				formData.append('sessId', BX.bitrix_sessid());
				
	      promise = fetch(BX.message('SITE_DIR') + "/ajax/form.php", {
	        method: 'POST',
	        body: formData,
	        mode: "cors"
	      });
				
				promise.then(function (response) {
					return response.json();
				}).then(function (data) {
					if (data.error) {
						//throw new Error(data.error);
						this.errors.all = date.error;
					}
					else{						
						this.success = true;
					}
				}).catch(function (error) {
					this.errors.all = error;
				});
	    },
		},
  })	
}