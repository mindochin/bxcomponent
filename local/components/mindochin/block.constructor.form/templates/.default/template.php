<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
//echo "<pre>"; print_r($arResult); echo "</pre>";
$this->setFrameMode(true);
$id = $arResult['ID'];//randString();
$blockform = $bgStyle = '';
if($arParams['FORM_AS'] == 'inline')
	$bgClass = 'class="block-form-inline';
else
	$bgClass = 'class="block-form';

if(!empty($arResult['BACKGROUND_IMAGE']) or !empty($arParams['BLOCK_MARGIN']) or !empty($arParams['BLOCK_PADDING']))
	$bgStyle = ' style="';
if(isset($arResult['BACKGROUND_IMAGE'])) {
	$bgStyle .= 'background-image: url(' . $arResult['BACKGROUND_IMAGE']['src'] . ');';
	if(!empty($arResult['BG_IMAGE_FON']))
	{
		if($arResult['BG_IMAGE_FON'] == 'light') $bgClass .= ' bg-overlay-light';
		if($arResult['BG_IMAGE_FON'] == 'dark') $bgClass .= ' bg-overlay-dark';	
	}	
}
if(!empty($arParams['BLOCK_MARGIN']))
	$bgStyle .= 'margin: ' . $arParams['BLOCK_MARGIN'] . ';';
if(!empty($arParams['BLOCK_PADDING']))
	$bgStyle .= 'padding: ' . $arParams['BLOCK_PADDING'] . ';';
$yaKeys = "ym-record-keys";
//$this->addExternalJS($templateFolder."/forms.js");
//$this->addExternalCss($templateFolder."/forms.css");
$colText = '<div class="col-md-7">'.$arResult['PREVIEW_TEXT'].'</div>';
$colClass = '';

if($arParams['FORM_AS'] == 'block')
	$blockform = 'id="block-' . $id .'"';
if($arParams['FORM_AS'] == 'inline')
	$bgClass .= ' inline-form';

if(!empty($arResult['BACKGROUND_IMAGE']) or !empty($arParams['BLOCK_MARGIN']) or !empty($arParams['BLOCK_PADDING']))
	$bgStyle .= '"';

$bgClass .= '"';
?>
<?if($arParams['FORM_AS'] == 'modal') { ?>
<div class="modal fade" id="modalBlockForm" tabindex="-1" role="dialog" aria-labelledby="modalBlockFormTitle" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalBlockFormTitle"><?= !empty($arResult['TITLE']) ? $arResult['TITLE'] : 'Оформить заказ'; ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>				
			</div>
			<div class="modal-body">
<?}?>
<div <?=$blockform?><?=$bgClass?><?=$bgStyle?>>
<div class="container">
<?if(!empty($arResult['TITLE']) or !empty($arResult['SUBTITLE']) ) { ?>
	<div class="row">
		<div class="col-12">
		<? if(isset($arResult['TITLE']) and $arParams['FORM_AS'] != 'modal') :?>
			<h2 class="title"><?=$arResult['TITLE']?></h2>
		<?endif;?>
		<? if(isset($arResult['SUBTITLE'])) :?>
			<p class="subtitle"><?=$arResult['SUBTITLE']?></p>
		<?endif;?>
		</div>
	</div>
<? } ?>
	<div class="row">
	<?if(!empty($arResult["PREVIEW_TEXT"]) and !empty($arResult['FORM_POS'])) {
		$colClass = 'col-12';
		if($arResult['FORM_POS'] == 'left') { ?>
		<div class="col-md-5">
		<?} if($arResult['FORM_POS'] == 'right') {
			echo $colText; ?>
		<div class="col-md-5">
	<?	}
	} else { ?>
		<div class="col-12">
	<?}?>
		<form class="mx-auto send <?=$colClass?>" method="post" enctype="multipart/form-data">
		
			<div class="form-block active">
			
			<input name="site_id" type="hidden" value="<?=$arParams['SITE_ID']?>" />
			<input name="element" type="hidden" value="<?=$arResult['ID']?>" />
			<input name="url" type="hidden" value="" />
			<input name="cpath" type="hidden" value="<?=$componentPath?>" />
			<input name="tpath" type="hidden" value="<?=$templateFolder?>" />
			<input name="ibo" type="hidden" value="<?=$arParams["IBLOCK_ORDER"]?>" />
			<?if(isset($arResult["TITLE"])):?>
			<input name="title" type="hidden" value="<?=htmlspecialcharsEx($arResult["TITLE"])?>" />
			<?elseif(!empty($arResult["FORM_TITLE"])):?>
			<input name="header" type="hidden" value="<?=htmlspecialcharsEx($arResult["FORM_TITLE"])?>" />
			<?endif;?>
			<? if(isset($arResult['FORM_TITLE'])) :?>
			<p class="form-title"><?=$arResult['FORM_TITLE']?></p>
			<?endif;?>
			
			<?foreach($arResult["FORM_INPUTS"]["VALUE"] as $key=>$arValue):?>
									
				<?if(strlen($arValue) > 0):?>
					
					<?$type = $arResult["FORM_INPUTS"]["DESCRIPTION"][$key];?>
					
					<?$type = explode(":", ToLower($type));?>
					
					<?foreach($type as $k=>$val):?>
						<?$type[$k] = trim($val);?>
					<?endforeach;?>
					
					
					<?if($type[0] == "text"):?>
						
						<div class="form-group">							
							<input class='form-control <?=$yaKeys?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" placeholder="<?=$arValue?>"<?if($type[1] == "y"):?> required<?endif;?> />
						</div>
						
					<?endif;?>
					
					
					<?if($type[0] == "textarea"):?>
						
						<div class="form-group">
							<textarea class='form-control <?=$yaKeys?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" rows="3" placeholder="<?=$arValue?>"<?if($type[1] == "y"):?> required<?endif;?>></textarea>
						</div>

					<?endif;?>

					<?if($type[0] == "name"):?>
					
						<div class="form-group">
							<input class='form-control <?=$yaKeys?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" placeholder="<?=$arValue?>"<?if($type[1] == "y"):?> required<?endif;?> />
						</div>
						
					<?endif;?>
					
					<?if($type[0] == "email"):?>
					
						<div class="form-group">
							<input class="form-control email <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="email" placeholder="<?=$arValue?>"<?if($type[1] == "y"):?> required<?endif;?> />
						</div>
						
					<?endif;?>
					
					<?if($type[0] == "phone"):?>
						   
						<div class="form-group">
							<input class="form-control phone <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" placeholder="<?=$arValue?>"<?if($type[1] == "y"):?> required<?endif;?> />
						</div>
		
					<?endif;?>
					
					<?if($type[0] == "count"):?>
																				 
						<div class="form-group">
							<div class="input count <?if($type[1] == "y"):?>require<?endif;?>">
								<div class="bg"></div>
								<span class="desc"><?=$arValue?></span>
								<input class="form-control <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" placeholder="<?=$arValue?>"<?if($type[1] == "y"):?> required<?endif;?> /> <span class="plus"></span> <span class="minus"></span>
							</div>
						</div>
		
					<?endif;?>
					
					<?if($type[0] == "date"):?>
					
						<div class="form-group">
							<div class="input date-wrap <?if($type[1] == "y"):?>require<?endif;?>">
								<div class="bg"></div>
								<span class="desc"><?=$arValue?></span>
								<input class="date <?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text">
							</div>
						</div>
		
					<?endif;?>
					
					<?if($type[0] == "password"):?>
					
						<div class="form-group">
							<div class="input">
								<div class="bg"></div>
								<span class="desc"><?=$arValue?></span>
								<input class="<?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="password">
								
							</div>
						</div>
						
					<?endif;?>
					
					
					<?if($type[0] == "file"):?>

						<div class="form-group">
							<div class="load-file">
								<label class="area-file">
									<div class="area-files-name">
										<span><?=$arValue?></span> 
									</div>

									<input class="hidden <?if($type[1] == "y"):?>require<?endif;?>"  name="input_<?=$arResult["ID"]?>_<?=$key?>[]" type="file" multiple="">

								<?if($type[1] == "y"):?><span class="star-req"></span><?endif;?>

								</label>
							</div>
						</div>

					<?endif;?>
					
					
					<?if($type[0] == "radio"):?>
						
						<?$list = explode(";", htmlspecialcharsBack($arValue));?>
						
						<?
						$first = $list[0];
						
						if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
						{
							$tit = str_replace(array("<", ">"), array("", ""), $first);
							unset($list[0]);
						}
						
						?>
					
						<div class="form-group">
						
							<?if(strlen($tit) > 0):?>
								<div class="name-tit bold"><?=$tit?></div>
							<?endif;?>

							<ul class="form-radio">
							
								<?$c = 0;?>

								<?foreach($list as $arElement):?>

									<li>

										<label>

											<input <?if($c == 0):?>checked <?endif;?> name='input_<?=$arResult["ID"]?>_<?=$key?>' type="radio" value="<?=htmlspecialcharsEx($arElement)?>"><span></span><?=$arElement?>

										</label>
									</li>
									
									<?$c++;?>

								<?endforeach;?>

							</ul>

						</div>
					
					<?endif;?>
					
					
					<?if($type[0] == "checkbox"):?>
						
						<?$list = explode(";", htmlspecialcharsBack($arValue));?>
						
						<?
						$first = $list[0];
						
						if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
						{
							$tit1 = str_replace(array("<", ">"), array("", ""), $first);
							unset($list[0]);
						}
						
						?>
					
						<div class="form-group">
						
						<?if(strlen($tit1) > 0):?>
							<div class="name-tit bold"><?=$tit1?></div>
						<?endif;?>

						<?foreach($list as $cb_id => $arElement):?>
								
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="input_<?=$arResult["ID"]?>_<?=$key?>[]" id="input_<?=$arResult["ID"]?>_<?=$key?>_<?=$cb_id?>" value="<?=htmlspecialcharsEx($arElement)?>">
								<label class="form-check-label" for="input_<?=$arResult["ID"]?>_<?=$key?>_<?=$cb_id?>"><?=$arElement?></label>
							</div>

						<?endforeach;?>

							

						</div>
					
					<?endif;?>

					<?if($type[0] == "select"):?>
						
						<?$list = explode(";", htmlspecialcharsBack($arValue));?>
						
						<?
						$first = $list[0];
						
						if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
						{
							$tit2 = str_replace(array("<", ">"), array("", ""), $first);
							unset($list[0]);
						}
						
						?>
					
						<div class="form-group">

							<?if(strlen($tit2) > 0):?>
								<div class="name-tit bold"><?=$tit2?></div>
							<?endif;?>

							<div class="input">
						
								<div class="form-select">
									<div class="ar-down"></div>
									
									<div class="select-list-choose first">
										<span class="list-area"><?=GetMessage('KRAKEN_MODAL_FORM_SELECT');?></span></div>

									<div class="select-list">
										
										<?foreach($list as $arElement):?>
											<label>
												<span class="name">
													
													<input class="opinion" type="radio" name='input_<?=$arResult["ID"]?>_<?=$key?>' value="<?=htmlspecialcharsEx($arElement)?>">
													<span class="text"><?=$arElement?></span>
													
												</span>
											</label>
										<?endforeach;?>
									</div>
								</div>

							</div>

						 
						</div>
					
					<?endif;?>

				<?endif;?>
					
				
					
			<?endforeach;?>

			<button type="button" class="btn btn-gkms form-submit btn-lg col-12"<?if(!empty($arParams['DATA_PRODUCT'])) echo ' data-product="'.$arParams['DATA_PRODUCT'].'"'?>><?=$arResult['BUTTON_TITLE']?></button>
			
			</div><!-- /form-block -->
			
			<div class="col-12 form-load">
				<i class="fa fa-spinner fa-pulse fa-fw"></i> Секундочку...
			</div>
			<div class="col-12 form-thanks">
				<?if(!empty($arResult['THANKS_TEXT'])) :?>
				<?=$arResult['THANKS_TEXT']?>
				<?else:?>
				Спасибо! Ваша заявка отправлена
				<?endif;?>
			</div>
		</form>
		
		
	<?if(!empty($arResult["PREVIEW_TEXT"]) and !empty($arResult['FORM_POS'])) {
		if($arResult['FORM_POS'] == 'left') {?>
		</div>
		<?echo $colText; }?>		
		<? if($arResult['FORM_POS'] == 'right') {?>
		</div>
		<? } ?>		
	<? } else { ?>
		</div>
	<? } ?>
	</div>
</div>
</div>

<?if($arParams['FORM_AS'] == 'modal') { ?>
			</div>
		</div>
	</div>
</div>
<?}?>
<?/*?>
<div class="shadow-modal"></div>

<div class="kraken-modal form-modal">

    <div class="kraken-modal-dialog">
        
        <div class="dialog-content">
            <a class="close-modal"></a>

            <div class="form-modal-table">

                <?if(strlen($arResult["PROPERTIES"]['TITLE_COMMENT']['VALUE']) > 0 || strlen($arResult["PREVIEW_TEXT"]) > 0 || strlen($arResult["DETAIL_PICTURE"]) > 0 ):?>

                    <div class="form-modal-cell part-more hidden-xs <?if($arResult["PROPERTIES"]['COVER']['VALUE'] == "Y"):?>cover <?endif;?><?=$arResult["PROPERTIES"]["FORM_POSITION_IMAGE"]["VALUE_XML_ID"]?> <?=$arResult["PROPERTIES"]["FORM_TEXT_TITLE_COLOR"]["VALUE_XML_ID"]?>"<?if(strlen($arResult["DETAIL_PICTURE"]) > 0):?> style="background-image: url('<?=$img["src"]?>');"<?endif;?>>

                        <?if(strlen($arResult["PROPERTIES"]['TITLE_COMMENT']['VALUE']) > 0):?>

                            <div class="comment main1">
                                <?=$arResult["PROPERTIES"]['TITLE_COMMENT']['~VALUE']?>
                            </div>

                        <?endif;?>

                        <?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>

                            <div class="text-content">
                                <?=$arResult["~PREVIEW_TEXT"]?>
                            </div>

                        <?endif;?>
                    </div>

                <?endif;?>


                <div class="form-modal-cell part-form" <?if(strlen($arResult["PREVIEW_PICTURE"]) > 0):?><?$img_form = CFile::ResizeImageGet($arResult["PREVIEW_PICTURE"], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, false);?><?endif;?> style="background-image: url('<?=$img_form["src"]?>'); background-color: <?=$arResult["PROPERTIES"]['FORM_BGC']['VALUE']?>;">

                    <?if($arResult["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"] == ""):?>
                        <?$arResult["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"] = "dark";?>
                    <?endif;?>

                    <form action="/" class="form send <?=$arResult["PROPERTIES"]["FORM_TEXT_COLOR"]["VALUE_XML_ID"]?> <?if($arParams["CART_FORM"] == "Y") echo "form-cart";?>" method="post" role="form">

                        <input type="hidden" name="site_id" value="<?=SITE_ID?>" />

                        <input name="element" type="hidden" value="<?=$arResult['ID']?>">
                        <input name="url" type="hidden" value="">
                        <input name="header" type="hidden" value="<?if(strlen($arResult["PROPERTIES"]["HEADER"]["~VALUE"]) > 0):?><?=htmlspecialcharsEx($arResult["PROPERTIES"]["HEADER"]["VALUE"])?><?endif;?>">
                        <input type="hidden" name="form_admin" value="<?=$arResult["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"]?>" />

                        <?if(strlen($arParams["ELEMENT_TYPE"])>0):?>
                            <input name="element_block" type="hidden" value="<?=$arResult["ELEMENT"]["ID"]?>">
                            <input name="element_type" type="hidden" value="<?=$arParams["ELEMENT_TYPE"]?>">
                        <?endif;?>
                        
                        <table class="wrap-act">
                            <tr>
                                <td>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questions active">
                                        <div class="row">
                                            <?if(strlen($arResult['PROPERTIES']['FORM_TITLE']['VALUE']) > 0):?>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-form main1 clearfix">
                                                    <?=$arResult['PROPERTIES']['FORM_TITLE']['~VALUE']?>
                                                </div>
                                                <div class="clearfix"></div>

                                            <?endif;?>

                                            <?if(strlen($arParams["ELEMENT_TYPE"])>0):?>
                                            
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 add_text <?if(strlen($arResult['PROPERTIES']['FORM_SUBTITLE']['VALUE']) <= 0):?>more_margin<?endif;?>">

                                                    <?=strip_tags($arResult["ELEMENT"]["NAME"])?>
                                                    

                                                </div>
                                                <div class="clearfix"></div>

                                            <?endif;?>

                                            <?if(strlen($arResult['PROPERTIES']['FORM_SUBTITLE']['VALUE']) > 0):?>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 subtitle-form clearfix">
                                                    <?=$arResult['PROPERTIES']['FORM_SUBTITLE']['~VALUE']?>
                                                </div>
                                                <div class="clearfix"></div>

                                            <?endif;?>

                                            
                                                
                                                <?foreach($arResult["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"] as $key=>$arValue):?>
                                                                        
                                                    <?if(strlen($arValue) > 0):?>
                                                        
                                                        <?$type = $arResult["PROPERTIES"]["FORM_PROP_INPUTS"]["DESCRIPTION"][$key];?>
                                                        
                                                        <?$type = explode(";", ToLower($type));?>
                                                        
                                                        <?foreach($type as $k=>$val):?>
                                                            <?$type[$k] = trim($val);?>
                                                        <?endforeach;?>
                                                        
                                                        
                                                        <?if($type[0] == "text"):?>
                                                            
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class='<?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" />
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "textarea"):?>
                                                            
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input input-textarea">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <textarea class='<?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>' name="input_<?=$arResult["ID"]?>_<?=$key?>"></textarea>
                                                                </div>
                                                            </div>

                                                        <?endif;?>

                                                        <?if($type[0] == "name"):?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class='<?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" />
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "email"):?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="email <?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="email">
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "phone"):?>
                                                               
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="phone <?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text">
                                                                </div>
                                                            </div>
                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "count"):?>
                                                                                                                     
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input count <?if($type[1] == "y"):?>require<?endif;?>">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="<?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text"> <span class="plus"></span> <span class="minus"></span>
                                                                </div>
                                                            </div>
                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "date"):?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input date-wrap <?if($type[1] == "y"):?>require<?endif;?>">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="date <?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text">
                                                                </div>
                                                            </div>
                                            
                                                        <?endif;?>
                                                        
                                                        <?if($type[0] == "password"):?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="input">
                                                                    <div class="bg"></div>
                                                                    <span class="desc"><?=$arValue?></span>
                                                                    <input class="<?if($type[1] == "y"):?>require<?endif;?> <?=$yaKeys?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="password">
                                                                    
                                                                </div>
                                                            </div>
                                                            
                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "file"):?>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                <div class="load-file">
                                                                    <label class="area-file">
                                                                        <div class="area-files-name">
                                                                            <span><?=$arValue?></span> 
                                                                        </div>

                                                                        <input class="hidden <?if($type[1] == "y"):?>require<?endif;?>"  name="input_<?=$arResult["ID"]?>_<?=$key?>[]" type="file" multiple="">

                                                                    <?if($type[1] == "y"):?><span class="star-req"></span><?endif;?>

                                                                    </label>
                                                                </div>
                                                            </div>

                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "radio"):?>
                                                            
                                                            <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                            
                                                            <?
                                                            $first = $list[0];
                                                            
                                                            if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                            {
                                                                $tit = str_replace(array("<", ">"), array("", ""), $first);
                                                                unset($list[0]);
                                                            }
                                                            
                                                            ?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            
                                                                <?if(strlen($tit) > 0):?>
                                                                    <div class="name-tit bold"><?=$tit?></div>
                                                                <?endif;?>

                                                                <ul class="form-radio">
                                                                
                                                                    <?$c = 0;?>

                                                                    <?foreach($list as $arElement):?>

                                                                        <li>

                                                                            <label>

                                                                                <input <?if($c == 0):?>checked <?endif;?> name='input_<?=$arResult["ID"]?>_<?=$key?>' type="radio" value="<?=htmlspecialcharsEx($arElement)?>"><span></span><?=$arElement?>

                                                                            </label>
                                                                        </li>
                                                                        
                                                                        <?$c++;?>

                                                                    <?endforeach;?>

                                                                </ul>

                                                            </div>
                                                        
                                                        <?endif;?>
                                                        
                                                        
                                                        <?if($type[0] == "checkbox"):?>
                                                            
                                                            <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                            
                                                            <?
                                                            $first = $list[0];
                                                            
                                                            if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                            {
                                                                $tit1 = str_replace(array("<", ">"), array("", ""), $first);
                                                                unset($list[0]);
                                                            }
                                                            
                                                            ?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            
                                                                <?if(strlen($tit1) > 0):?>
                                                                    <div class="name-tit bold"><?=$tit1?></div>
                                                                <?endif;?>

                                                                <ul class="form-check">
                                                                
                                                                    <?foreach($list as $arElement):?>

                                                                        <li>

                                                                            <label>

                                                                                <input name='input_<?=$arResult["ID"]?>_<?=$key?>[]' type="checkbox" value="<?=htmlspecialcharsEx($arElement)?>"><span></span><span class="text"><?=$arElement?></span>

                                                                            </label>
                                                                        </li>
                                                                        
                                                                    <?endforeach;?>

                                                                </ul>

                                                            </div>
                                                        
                                                        <?endif;?>

                                                        <?if($type[0] == "select"):?>
                                                            
                                                            <?$list = explode(";", htmlspecialcharsBack($arValue));?>
                                                            
                                                            <?
                                                            $first = $list[0];
                                                            
                                                            if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                                                            {
                                                                $tit2 = str_replace(array("<", ">"), array("", ""), $first);
                                                                unset($list[0]);
                                                            }
                                                            
                                                            ?>
                                                        
                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                <?if(strlen($tit2) > 0):?>
                                                                    <div class="name-tit bold"><?=$tit2?></div>
                                                                <?endif;?>

                                                                <div class="input">
                                                            
                                                                    <div class="form-select">
                                                                        <div class="ar-down"></div>
                                                                        
                                                                        <div class="select-list-choose first">
                                                                            <span class="list-area"><?=GetMessage('KRAKEN_MODAL_FORM_SELECT');?></span></div>

                                                                        <div class="select-list">
                                                                            
                                                                            <?foreach($list as $arElement):?>
                                                                                <label>
                                                                                    <span class="name">
                                                                                        
                                                                                        <input class="opinion" type="radio" name='input_<?=$arResult["ID"]?>_<?=$key?>' value="<?=htmlspecialcharsEx($arElement)?>">
                                                                                        <span class="text"><?=$arElement?></span>
                                                                                        
                                                                                    </span>
                                                                                </label>
                                                                            <?endforeach;?>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                             
                                                            </div>
                                                        
                                                        <?endif;?>

                                                    <?endif;?>
                                                        
                                                    
                                                        
                                                <?endforeach;;?>
                                            
                                            
                                          


                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="input-btn">
                                                    <div class="load">
                                                        <div class="xLoader form-preload"><div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div></div>
                                                    </div>

                                                    <?

                                                        $b_options = array(
                                                            "MAIN_COLOR" => "main-color",
                                                            "STYLE" => ""
                                                        );

                                                        if(strlen($arResult["PROPERTIES"]["FORM_BUTTON_BG_COLOR"]["VALUE"]))
                                                        {

                                                            $b_options = array(
                                                                "MAIN_COLOR" => "btn-bgcolor-custom",
                                                                "STYLE" => "background-color: ".$arResult["PROPERTIES"]["FORM_BUTTON_BG_COLOR"]["VALUE"].";"
                                                            );

                                                        }

                                                    ?>

                                                    <button class="button-def <?=$b_options["MAIN_COLOR"]?> big active <?=$KRAKEN_TEMPLATE_ARRAY['BTN_VIEW']['VALUE']?> btn-submit" name="form-submit" type="button" 

                                                        <?if(strlen($b_options["STYLE"])):?>
                                                            style = "<?=$b_options["STYLE"]?>"
                                                        <?endif;?>

                                                        <?if(strlen($arResult["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]) > 0):?> data-link='<?=$arResult["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]?>' <?endif;?>><?if(strlen($arResult['PROPERTIES']['FORM_BUTTON']['VALUE']) > 0):?><?=$arResult['PROPERTIES']['FORM_BUTTON']['~VALUE']?><?else:?><?=GetMessage('FORM_SUBMIT')?><?endif;?></button>
                                                </div>
                                            </div>
                                        </div>

                                        <?if(!empty($KRAKEN_TEMPLATE_ARRAY['AGREEMENT_FORM'])):?>

                                            <div class="wrap-agree">

                                                <label>
                                                    <input type="checkbox" class="agreecheck" name="checkboxAgree" value="agree" <?if($KRAKEN_TEMPLATE_ARRAY["POLITIC_CHECKED"]['VALUE'][0] == 'Y'):?> checked<?endif;?>>
                                                    <span></span>   
                                                </label>   

                                                <div class="wrap-desc">                                                                    
                                                    <span class="text"><?if(strlen($KRAKEN_TEMPLATE_ARRAY["POLITIC_DESC"]['VALUE'])>0):?><?=$KRAKEN_TEMPLATE_ARRAY["POLITIC_DESC"]['~VALUE']?><?else:?><?=GetMessage('KRAKEN_MODAL_FORM_AGREEMENT')?><?endif;?></span>


                                                    <?$agrCount = count($KRAKEN_TEMPLATE_ARRAY['AGREEMENT_FORM']);?>
                                                    <?foreach($KRAKEN_TEMPLATE_ARRAY['AGREEMENT_FORM'] as $k => $arAgr):?>

                                                        <a class="call-modal callagreement from-modal from-modalform" data-call-modal="agreement<?=$arAgr['ID']?>"><?if(strlen($arAgr['PROPERTIES']['CASE_TEXT']['VALUE'])>0):?><?=$arAgr['PROPERTIES']['CASE_TEXT']['VALUE']?><?else:?><?=$arAgr['NAME']?><?endif;?></a><?if($k+1 != $agrCount):?><span>, </span><?endif;?>

                                                        
                                                    <?endforeach;?>
                                                 
                                                </div>

                                            </div>
                                        <?endif;?>
                                    </div>
                                        
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 thank">
                                        <?if(!empty($arResult['PROPERTIES']['FORM_THANKS']['VALUE'])):?>
                                            <?=$arResult['PROPERTIES']['FORM_THANKS']['~VALUE']['TEXT']?>
                                        <?else:?>
                                            <?=GetMessage('KRAKEN_MODAL_FORM_THANK')?>
                                        <?endif;?>
                                    </div>
                                    
                                    
                                </td>
                            </tr>
                        </table>
                        


                        <div class="clearfix">
                        </div>
                    </form>
                </div>

                <?if(strlen($arResult["PROPERTIES"]['TITLE_COMMENT']['VALUE']) > 0 || strlen($arResult["PREVIEW_TEXT"]) > 0 || strlen($arResult["DETAIL_PICTURE"]) > 0 ):?>

                    <div class="form-modal-cell part-more <?if(strlen($arResult["PROPERTIES"]['TITLE_COMMENT']['VALUE']) > 0 || strlen($arResult["PREVIEW_TEXT"]) > 0):?>visible-xs <?else:?>hidden<?endif;?> <?=$arResult["PROPERTIES"]["FORM_TEXT_TITLE_COLOR"]["VALUE_XML_ID"]?>" <?if(strlen($arResult["DETAIL_PICTURE"]) > 0):?> style="background-image: url('<?=$img["src"]?>')"<?endif;?>>

                        <?if(strlen($arResult["PROPERTIES"]['TITLE_COMMENT']['VALUE']) > 0):?>

                            <div class="comment main1">
                                <?=$arResult["PROPERTIES"]['TITLE_COMMENT']['~VALUE']?>
                            </div>

                        <?endif;?>

                        <?if(strlen($arResult["PREVIEW_TEXT"]) > 0):?>

                            <div class="text-content">
                                <?=$arResult["~PREVIEW_TEXT"]?>
                            </div>

                        <?endif;?>
                    </div>

                <?endif;?>
            </div>


        </div>

    </div>
</div>
<?*/?>