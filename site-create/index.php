<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Недорогой сайт на битрикс \"под ключ\"");
?>
<div class="container">
	<div id="header">
		<div class="row">
			<div class="col-md-2">
				<p class="logo strong">
					<a href="/">
						VladName.ru
					</a>
				</p>
			</div>
			<div class="col-md-7">
				<p>
					Разработка недорогих сайтов на битрикс. Сопровождение сайтов. Программирование, верстка шаблонов
				</p>
			</div>
			<div class="col-md-3 text-right">
				<?$APPLICATION->IncludeComponent(
					"mindochin:feedback.utm",
					"order-call",
					array(
						"USE_CAPTCHA"           => "Y",
						"OK_TEXT"               => "Спасибо, ваше сообщение принято.",
						"EMAIL_TO"              => "mindochin@yandex.ru",
						"REQUIRED_FIELDS"        => array(
							0=> "NAME",
							1=> "EMAIL",
						),
						"EVENT_MESSAGE_ID"       => array(
							0=> "7",
						),
						"AJAX_MODE"             => "Y",
						"AJAX_OPTION_JUMP"      => "N",
						"AJAX_OPTION_STYLE"     => "Y",
						"AJAX_OPTION_HISTORY"   => "N",
						"TITLE"                 => "Оставьте заявку!",
						"ID_COUNTER"            => "20647768",
						"ID_YAMETRICA"          => "ORDER-SITE",
						"AJAX_OPTION_ADDITIONAL"=> ""
					),
					false
				);?>
			</div>
		</div>
	</div>

	<div id="pagetitle">
		<div class="row">
			<div class="col-md-12">
				<h1 >
					<?$APPLICATION->ShowTitle(false)?>
				</h1>
			</div>
		</div>
	</div>

	<div id="content">
		<div class="row">
			<div class="col-md-12">
				<div class="head-top">
					<div class="row">
						<div class="col-md-6">
							<ul>
								<li>
									Сайт "под ключ"
								</li>
								<li>
									Удобное управление сайтом
								</li>
								<li>
									Наполнение 5 страниц
								</li>
								<li>Гарантия 1 год

								</li>
								<li>Недорого

								</li>
							</ul>
							<p class="price">
								<span>
									От 6000 рублей
								</span>
							</p>
						</div>


						<div class="col-md-6">
							<?$APPLICATION->IncludeComponent(
								"mindochin:feedback.utm",
								"alpha",
								Array(
									"USE_CAPTCHA"           => "N",
									"OK_TEXT"               => "Спасибо, ваше сообщение принято.",
									"EMAIL_TO"              => "mindochin@yandex.ru",
									"REQUIRED_FIELDS"        => array(0=>"NAME",1=>"EMAIL", ),
									"EVENT_MESSAGE_ID"       => array(0=>"7", ),
									"AJAX_MODE"             => "Y",
									"AJAX_OPTION_JUMP"      => "N",
									"AJAX_OPTION_STYLE"     => "Y",
									"AJAX_OPTION_HISTORY"   => "N",
									"TITLE"                 => "Закажите сайт прямо сейчас!",
									"ID_COUNTER"            => "20647768",
									"ID_YAMETRICA"          => "ORDER-SITE",
									"AJAX_OPTION_ADDITIONAL"=> ""
								)
							);?>
						</div>
					</div>
				</div>
				<h2>
					<small>Нужен сайт, но нет лишних денег?
					</small><br />
					Полностью готовый недорогой сайт визитка, сайт каталог
				</h2>
				<ul class="problem">
					<li>
						У вас есть бизнес оффлайн (магазин, киоск, производство и т.д.) и продажи идут, вы хотите привлечь больше клиентов, но все деньги в обороте.
					</li>

					<li>
						Вы только начинаете бизнес, и лишних денег нет.
					</li>

					<li>
						У вас уже есть сайт, но он не работает или устарел, либо нужно что-то поменять на нем.
					</li>
				</ul>
				<p>
					Если вы впервые выходите в интернет, 100000 и более рублей за сайт от именитых студий &mdash; действительно дорого.
				</p>
				<p>
					Оптимально и разумно будет заказать разработку недорогого сайта всего за 6000-10000 рублей. Вы получите сайт-визитку с информацией о компании или простой сайт-каталог с вашей продукцией.
				</p>
				<p>
					Когда появятся новые заявки, пойдут продажи, и вы поймете, что сайт работает &mdash; тогда уже можно задуматься о дорогом стильном дизайне, увеличении лояльности своих клиентов внедрением различных удобных сервисов и прочих новых возможностях. Сайт на 1С-Битрикс позволяет наращивать свои основные возможности легко и просто, обновив систему управления сайтом на более функциональную редакцию (форумы, блоги, многопользовательские галереи, интернет-магазин, складской учет).
				</p>
				<p>
					Итак, давайте посмотрим, как я могу вам помочь.
				</p>

				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">
									Недорогой простой сайт под ключ
								</h3>
							</div>
							<ul class="list-group">
								<li class="list-group-item">
									система управления сайтом 1С-Битрикс
									<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="На Ваше имя, бесплатные обновления и поддержка от фирмы-разработчика на 1 год">
										<span class="glyphicon glyphicon-question-sign">
										</span>
									</a>
								</li>

								<li class="list-group-item">
									хостинг
									<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Дом для сайта, на Ваше имя, на 1 год">
										<span class="glyphicon glyphicon-question-sign">
										</span>
									</a>
								</li>

								<li class="list-group-item">
									доменное имя
									<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Адрес сайта, тоже регистрируется на Вас, на 1 год">
										<span class="glyphicon glyphicon-question-sign">
										</span>
									</a>
								</li>

								<li class="list-group-item">
									простой адаптивный дизайн
									<a href="javascript:void(0)" data-toggle="tooltip" data-original-title="для компьютеров, планшетов и смартфонов">
										<span class="glyphicon glyphicon-question-sign">
										</span>
									</a>
								</li>

								<li class="list-group-item">
									несколько страниц информации (1-5)
								</li>

								<li class="list-group-item">
									первичная seo оптимизация
								</li>

								<li class="list-group-item">
									статистика сайта от Яндекса
								</li>
							</ul>
							<div class="panel-footer">
								от 6000 руб
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">
									Сопровождение, поддержка сайта
								</h3>
							</div>
							<ul class="list-group">
								<li class="list-group-item">
									размещение информации (новости, фото)
								</li>

								<li class="list-group-item">
									решение текущих проблем
								</li>

								<li class="list-group-item">
									исправление ошибок
								</li>

								<li class="list-group-item">
									поддержка работоспособности
								</li>

								<li class="list-group-item">
									мелкие доработки шаблона
								</li>

								<li class="list-group-item">
									модернизация, обновление сайта
								</li>

								<li class="list-group-item">
									отчеты по статистике сайта
								</li>
							</ul>
							<div class="panel-footer">
								от 1000 руб/мес
							</div>
						</div>
					</div>

					<div class="col-md-4">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<h3 class="panel-title">
									Программирование, верстка
								</h3>
							</div>
							<ul class="list-group">
								<li class="list-group-item">
									верстка шаблонов из картинки или PSD в html
								</li>
								<li class="list-group-item">
									доработка существующих шаблонов
								</li>
								<li class="list-group-item">
									установка шаблонов в CMS Битрикс
								</li>

								<li class="list-group-item">
									доработка стандартных компонентов
								</li>

								<li class="list-group-item">
									создание нетиповых компонентов
								</li>

								<li class="list-group-item">
									разработка нового функционала
								</li>

								<li class="list-group-item">
									внедрение различных сервисов
								</li>
							</ul>
							<div class="panel-footer">
								300 руб/час
							</div>
						</div>
					</div>
				</div>
				<h2>
					Преимущества разработки недорогого сайта на 1С-Битрикс
				</h2>
				<img width="143" alt="Система управления сайтом Битрикс" src="/upload/medialibrary/6c3/bus_143158_1_.png" height="158" title="Система управления сайтом Битрикс" border="0" align="right" />
				<ul class="ul-center">
					<li>
						гарантированная техподдержка производителя
					</li>
					<li>
						множество партнеров-разработчиков
					</li>
					<li>
						безопасность
					</li>
					<li>
						расширяемость
					</li>
					<li>
						постоянное развитие и обновление
					</li>
				</ul>

				<div id="examples">

					<h2>
						Пример сайта на битрикс
					</h2>

					<div class="row">

						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3">
									<img src="/bitrix/templates/site-create/img/ico3.jpg" class="img-responsive"/>
								</div>
								<div class="col-sm-9">
									<h4>Персональный сайт/блог
									</h4>
									<p>
										<em>Хостинг, домен, дизайн, верстка, программирование, наполнение
										</em>
									</p>
									<p>Сайт: <!--noindex-->
										<a href="http://vladname.ru" target="_blank" rel="nofollow">vladname.ru
										</a><!--/noindex-->
									</p>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3">
									<img src="/bitrix/templates/site-create/img/ico1.jpg" class="img-responsive"/>
								</div>
								<div class="col-sm-9">
									<h4>Казначейство города
									</h4>
									<p>
										<em>Хостинг, домен, дизайн, верстка, программирование
										</em>
									</p>
									<p>Сайт: <!--noindex-->
										<a href="http://ksp-okt.ru" target="_blank" rel="nofollow">ksp-okt.ru
										</a><!--/noindex-->
									</p>
								</div>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3">
									<img src="/bitrix/templates/site-create/img/ico2.jpg" class="img-responsive"/>
								</div>
								<div class="col-sm-9">
									<h4>Третейский суд
									</h4>
									<p>
										<em>Хостинг, домен, дизайн, верстка, программирование, наполнение
										</em>
									</p>
									<p>Сайт: <!--noindex-->
										<a href="http://pravo-okt.ru" target="_blank" rel="nofollow">pravo-okt.ru
										</a><!--/noindex-->
									</p>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3">
									<img src="/bitrix/templates/site-create/img/ico4.jpg" class="img-responsive"/>
								</div>
								<div class="col-sm-9">
									<h4>Сайт промышленного предприятия
									</h4>
									<p>
										<em>Дизайн, верстка, программирование, наполнение
										</em>
									</p>
									<p>Сайт: <!--noindex-->
										<a href="http://npf-paker.ru" target="_blank" rel="nofollow">npf-paker.ru
										</a><!--/noindex-->
									</p>
								</div>
							</div>
						</div>

					</div>

					<div class="row">

						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3">
									<img src="/bitrix/templates/site-create/img/ico5.jpg" class="img-responsive"/>
								</div>
								<div class="col-sm-9">
									<h4>Сайт производственного предприятия
									</h4>
									<p>
										<em>Верстка, программирование, наполнение
										</em>
									</p>
									<p>Сайт: <!--noindex-->
										<a href="http://mega-flex.ru" target="_blank" rel="nofollow">mega-flex.ru
										</a><!--/noindex-->
									</p>
								</div>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-3">
									<img src="/bitrix/templates/site-create/img/ico6.jpg" class="img-responsive"/>
								</div>
								<div class="col-sm-9">
									<h4>Продающая страница производства сумок
									</h4>
									<p>
										<em>Верстка, программирование, наполнение
										</em>
									</p>
									<p>Сайт: <!--noindex-->
										<a href="http://spanbag.ru" target="_blank" rel="nofollow">spanbag.ru
										</a><!--/noindex-->
									</p>
								</div>
							</div>
						</div>

					</div>
				</div>

				<p class="lead">
					Почему я
				</p>
				<ul class="ul-center">
					<li>
						мне это интересно
					</li>
					<li>
						люблю программировать
					</li>
					<li>
						обожаю рещать интересные задачки
					</li>
					<li>
						довожу дело до конца
					</li>
					<li>
						имею соответствующий опыт
					</li>
				</ul>

				<p>
					Срок разработки и запуска от 3 дней.<?/* Информация о
					<!--noindex-->
					<a href="http://dev.1c-bitrix.ru/docs/php.php" target="_blank" rel="nofollow" >
					работе с Битрикс
					</a>
					<!--/noindex-->(авторизация, создание страниц, наполнение и т.д.).
					*/?>
				</p>

				<blockquote>
					<p>
						В будущем на рынке останется два вида компаний: те, кто в Интернет и те, кто вышел из бизнеса.
					</p>
					<footer>
						Билл Гейтс. Цитата из книги &quot;Бизнес со скоростью мысли&quot;
					</footer>
				</blockquote>


			</div>
		</div>
	</div>

	<div id="footer">
		<div class="row">

			<div class="col-md-4">
				<div class="row">
					<div class="col-xs-offset-4 col-xs-4 col-md-offset-0 col-md-12"><img src="/bitrix/templates/site-create/img/logo-footer.jpg" class="img-responsive img-circle" />
					</div>
				</div>


			</div>
			<div class="col-md-8">
				<?$APPLICATION->IncludeComponent(
					"mindochin:feedback.utm",
					"gorizontal",
					Array(
						"USE_CAPTCHA" => "N",
						"OK_TEXT" => "Спасибо, ваше сообщение принято.",
						"EMAIL_TO"              => "mindochin@yandex.ru",
						"REQUIRED_FIELDS"        => array(0=>"NAME",1=>"EMAIL", ),
						"EVENT_MESSAGE_ID"       => array(0=>"7", ),
						"AJAX_MODE"             => "Y",
						"AJAX_OPTION_JUMP"      => "N",
						"AJAX_OPTION_STYLE"     => "Y",
						"AJAX_OPTION_HISTORY"   => "N",
						"TITLE"                 => "Остались вопросы? Задавайте!",
						"ID_COUNTER"            => "20647768",
						"ID_YAMETRICA"          => "ORDER-SITE",
						"AJAX_OPTION_ADDITIONAL"=> ""
					)
				);?>
			</div>

		</div>
	</div>

</div><!--container-->
<script type="text/javascript">
	$(function () {
			$("[data-toggle='tooltip']").tooltip();
		});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>