<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var TestOnewayComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$this->addExternalCss($templateFolder."/css/fotorama.css");
$this->addExternalJS($templateFolder."/js/jquery-2.1.3.min.js");
$this->addExternalJS($templateFolder."/js/fotorama.js");
$this->addExternalJS($templateFolder."/js/site_scripts.js");

foreach($arResult['ITEMS'] as $item) {
?>
<div class="site_container">
			<div class="aside">
				<div class="bl_table">
					<div>
						<div class="aside__person_img" style="background-image: url(<?= $item['PHOTO'] ?>);"></div>
						<div class="aside__person_name"><?= $item['NAME'] ?><span><?= $item['POST'] ?></span></div>
						<div class="aside__person_data">
							<ul>
								<li>
									<i class="i_icon-1"></i>
									<p><?= $item['PLACE'] ?></p>
								</li>
								<li>
									<i class="i_icon-2"></i>
									<p><?= $item['BIRTHDAY']['value'] ?>, <?= $item['BIRTHDAY']['year'] ?></p>
									<span><?= $item['BIRTHDAY']['next'] ?> до ДР</span>
								</li>
							</ul>
						</div>
						<div class="aside__person_descr">
						<?= $item['DESCRIPTION'] ?>
						</div>
					</div>
				</div>
				<div class="aside__background" style="background-image: url(<?= $item['PHOTO'] ?>);"></div>
			</div>
			<div class="content">
				<div class="bl_table">
					<div>
						<div class="content__slider">
							<div id="slider">
							<? foreach($item['SLIDER'] as $slide) { ?>
								<div>
									<div class="slide__img" style="background-image: url(<?= $slide['src']?>);"></div>
									<div class="slide__status">
										<input type="checkbox" id="like-<?= $slide['id'] ?>" name="like_status">
										<label for="like-<?= $slide['id'] ?>">
											<svg width="14px" height="12px" viewBox="0 3 14 12">
											    <path d="M12.8624934,4.11565118 C12.1279144,3.39601165 11.1513821,3 10.1124865,3 C9.07344319,3 8.09680006,3.39601165 7.36196247,4.11565118 L6.9999746,4.4703317 L6.63798673,4.11565118 C5.90337081,3.39601165 4.92650601,3 3.88768433,3 C2.84889958,3 1.8719609,3.39601165 1.13741887,4.11565118 C-0.379139622,5.60143682 -0.379139622,8.01887407 1.13741887,9.50408064 L6.57167032,14.8275818 C6.66052323,14.9149491 6.77113679,14.9684407 6.88670099,14.9890339 C6.92545638,14.9965256 6.96443344,15 7.00348438,15 C7.15721285,15 7.31119993,14.9425635 7.42827888,14.8275818 L12.8625303,9.50408064 C14.3791627,8.01887407 14.3791627,5.60143682 12.8624934,4.11565118 L12.8624934,4.11565118 Z M12.0129044,8.67184814 L7.00001155,13.582617 L1.98700787,8.67184814 C0.938949909,7.64530139 0.938949909,5.97504569 1.98700787,4.94795606 C2.49467018,4.45071569 3.16987841,4.17721359 3.88768433,4.17721359 C4.60556413,4.17721359 5.28058764,4.45071569 5.78806522,4.94795606 L6.5751801,5.71927761 C6.80080369,5.93997575 7.19944107,5.93997575 7.42502772,5.71927761 L8.21184703,4.94795606 C8.71936156,4.45071569 9.39442202,4.17721359 10.1125235,4.17721359 C10.8304033,4.17721359 11.5053899,4.45071569 12.0129044,4.94795606 C13.0610732,5.97504569 13.0610732,7.6452652 12.0129044,8.67184814 L12.0129044,8.67184814 Z" sketch:type="MSShapeGroup"></path>
											</svg>
											<?= $slide['like'] ?>
										</label>
									</div>
								</div>
							<? } ?>
							</div>
							<div class="content__slider_pag">
								<span class="i_icon-4"></span>
								<span class="i_icon-5"></span>
							</div>
						</div>
						<div class="content__text">
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates explicabo nulla rerum odit debitis placeat, illum est, eligendi beatae ea laborum eum error non.</p>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus minus, voluptates ratione amet saepe quas!</p>
						</div>
					</div>
				</div>
			</div>
		</div>
<? } ?>