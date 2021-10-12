BX.ready(function(){
	if (typeof vueFeedback === 'undefined') {
		const tplVueFeedback = `
		<div id="vueFeedbackNode">
		
			<button class="btn btn-outline-light js-feedback" :disabled="btnDisabled" @click="showFeedback()"><i class="fa" :class="btnClass"></i> {{btnText}}</button>
		
			<div v-if="boolModal" class="modal fade" id="feedback" ref="feedback" tabindex="-1" aria-labelledby="feedbackLabel" aria-hidden="true" @hidden.bs.modal="onHiddenModal">
				<div class="modal-dialog">
				
				<transition name="modal">
				
					<div v-if="success" class="modal-content">
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
				
				</transition>
				
					<div v-if="!success" class="modal-content">
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
				
				</div>
			</div>
			
		</div>
		`;

		const vueFeedback = BX.Vue.create({
			el: '#vueFeedbackNode',
			template: tplVueFeedback,
			data: {
				btnText: 'Оставить сообщение',
				btnClass: 'fa-comment-o',
				btnDisabled: false,
				boolModal: false,
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
				onHiddenModal(){					
					if(this.btnDisabled === false){
						this.btnText = 'Оставить сообщение';
						this.btnClass = 'fa-comment-o';
					}
				},
				async showFeedback() {
					this.boolModal = true;
				
					this.btnClass = 'fa-spinner fa-pulse fa-fw';
					this.btnText = 'Загружаю...';
					
					if(!this.theModal){
						if(!document.getElementById('feedback')){					
							await setTimeout(function run() {
								if(!document.getElementById('feedback')){							
									setTimeout(run, 500);
								}
							}, 500);
						}
						this.theModal = new bootstrap.Modal(document.getElementById('feedback'), {});
						
						let _this = this;
						
						document.getElementById('feedback').addEventListener('hidden.bs.modal', function (event) {
							_this.onHiddenModal();
						})
					}
					
					this.btnText = 'Ожидаю...';
					
					this.theModal.show();
				},
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
					
					this.btnClass = 'fa-spinner fa-pulse fa-fw';
					this.btnText = 'Отправляю...';
					let _this = this;
					
					BX.ajax.runComponentAction('mindochin:feedback.vue', 'setForm', {
						mode: 'class',
						signedParameters: siteOptions["FEEDBACK_VUE_PARAMS"],
						data: {
							fbContact: this.fbContact,
							fbMessage: this.fbMessage,
						},
					}).then(function (response) {
						//console.log('success',response);
						_this.success = true;
						_this.btnDisabled = true;
						_this.btnText = 'Отправлено';
						_this.btnClass = 'fa-comment-o';
					}, function (response) {				
						console.log('error',response);
						_this.errors.all = response.data.error;	
						_this.btnText = 'Ошибка...';
						_this.btnClass = 'fa-comment-o';						
					});				
				},
			},
		})	
	}
})