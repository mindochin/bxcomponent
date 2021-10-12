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
$this->setFrameMode(true);
global $KRAKEN_TEMPLATE_ARRAY;
global $DB_kraken;
?>
<?$yaWiz = "ym-record-keys";?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 questions active">
    <input type="hidden" name="site_id" value="<?=SITE_ID?>" />
    <input name="element" type="hidden" value="<?=$arResult['ID']?>">
    <input name="url" type="hidden" value="">

    <div class="row">
        <?if(strlen($arResult['PROPERTIES']['FORM_TITLE']['VALUE']) > 0):?>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 title-form main1 clearfix">
                <?=$arResult['PROPERTIES']['FORM_TITLE']['~VALUE']?>
            </div>
            <div class="clearfix"></div>

        <?endif;?>

        <?if(strlen($arResult['PROPERTIES']['FORM_SUBTITLE']['VALUE']) > 0):?>

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 subtitle-form clearfix">
                <?=$arResult['PROPERTIES']['FORM_SUBTITLE']['~VALUE']?>
            </div>
            <div class="clearfix"></div>

        <?endif;?>

        
        
        <?if($arResult["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "light" || $arResult["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == ""):?>


            <?if($arResult["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "radio" || $arResult["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "check"):?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                   

                    <?if(strlen($arResult["PROPERTIES"]["FORM_LIST_TITLE"]["VALUE"]) > 0):?>

                        <div class="name-tit bold">
                            <?=$arResult["PROPERTIES"]["FORM_LIST_TITLE"]["~VALUE"]?>
                        </div>

                    <?endif;?>

                     <?if($arResult["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "radio" && is_array($arResult["PROPERTIES"]["FORM_LIST"]["VALUE"]) && !empty($arResult["PROPERTIES"]["FORM_LIST"]["VALUE"])):?>

                            <ul class="form-radio">

                                <?foreach($arResult["PROPERTIES"]["FORM_LIST"]["~VALUE"] as $k=>$arElement):?>

                                    <li>

                                        <label>

                                            <input <?if($k == 0):?>checked <?endif;?> name='radiobutton<?=$arResult["ID"]?>' type="radio" value="<?=htmlspecialcharsEx($arElement)?>"><span></span><?=$arElement?>

                                        </label>
                                    </li>

                                <?endforeach;?>

                            </ul>

                     <?elseif ($arResult["PROPERTIES"]["FORM_RADIOCHECK"]["VALUE_XML_ID"] == "check" && is_array($arResult["PROPERTIES"]["FORM_LIST"]["VALUE"]) && !empty($arResult["PROPERTIES"]["FORM_LIST"]["VALUE"])):?>

                         <ul class="form-check">

                            <?foreach($arResult["PROPERTIES"]["FORM_LIST"]["~VALUE"] as $k => $arElement):?>

                                <li>
                                    <label>
                                        <input type="checkbox" name="checkbox<?=$arResult["ID"]?>[]" value="<?=htmlspecialcharsEx($arElement)?>">
                                        <span></span>                                                                          
                                        <span class="text"><?=$arElement?></span>
                                    </label>
                                </li>

                            <?endforeach;?>

                        </ul>

                    <?endif;?>

                    

                </div>

            <?endif;?>

            <?if(is_array($arResult["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"]) && !empty($arResult["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"])):?>

                <?foreach($arResult["PROPERTIES"]["FORM_INPUTS"]["VALUE_XML_ID"] as $k=>$arInput):?>

                    <?if($arInput == "name"):?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>
                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_NAME')?></span>
                                <input class='focus-anim <?if(in_array("name", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>' name="name" type="text">
                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?endif;?>

                    <?if($arInput == "phone"):?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>
                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_PHONE')?></span>

                                <input name="phone" class="phone focus-anim <?if(in_array("phone", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>" type="text">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?endif;?>

                    <?if($arInput == "email"):?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>

                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_EMAIL')?></span>
                                <input class="focus-anim email <?if(in_array("email", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>" name="email" type="text">
                                
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?endif;?>


                    <?if($arInput == "count"):?>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input count <?if(in_array("count", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>">

                                <div class="bg"></div>
                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_COUNT')?></span>
                                <input name="count" type="text" class="focus-anim <?if(in_array("count", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>"> <span class="plus"></span> <span class="minus"></span>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    <?endif;?>


                    <?if($arInput == "date"):?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input date-wrap <?if(in_array("date", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>">

                                <div class="bg"></div>
                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_DATE')?></span>
                                <input class="date focus-anim <?if(in_array("date", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>"  name="date" type="text">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?endif;?>

                    <?if($arInput == "address"):?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input input-textarea">
                                <div class="bg"></div>
                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_ADDRESS')?></span>
                                <textarea class='focus-anim <?if(in_array("address", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>'  name="address"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?endif;?>

                    <?if($arInput == "textarea"):?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input input-textarea">
                                <div class="bg"></div>
                                <span class="desc"><?=GetMessage('KRAKEN_CART_FORM_TEXTAREA')?></span>

                                <textarea class='focus-anim <?if(in_array("textarea", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?> <?=$yaWiz?>'  name="text"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    <?endif;?>

                    

                    <?if($arInput == "file"):?>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="load-file">
                                <label class="area-file">
                                    <div class="area-files-name">
                                        <span><?=GetMessage('KRAKEN_CART_FORM_FILE')?></span>
                                    </div>


                                <input class="hidden <?if(in_array("file", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?>require<?endif;?>"  name="userfile[]" type="file" multiple="">

                                <?if(in_array("file", $arResult["PROPERTIES"]["FORM_INPUTS_REQ"]["VALUE_XML_ID"])):?><span class="star-req"></span><?endif;?>

                                </label>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    <?endif;?>

                <?endforeach;?>

            <?endif;?>
            
        
        <?elseif($arResult["PROPERTIES"]["FORM_ADMIN"]["VALUE_XML_ID"] == "professional"):?>
            
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
                                <input class='focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" />
                                
                            </div>
                        </div>
                        
                    <?endif;?>
                    
                    
                    <?if($type[0] == "textarea"):?>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input input-textarea">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <textarea class='focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>' name="input_<?=$arResult["ID"]?>_<?=$key?>"></textarea>
                            </div>
                        </div>

                    <?endif;?>

                    <?if($type[0] == "name"):?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <input class='focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>' name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text" />
                                
                            </div>
                        </div>
                        
                    <?endif;?>
                    
                    <?if($type[0] == "email"):?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <input class="focus-anim email <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="email">
                                
                            </div>
                        </div>
                        
                    <?endif;?>
                    
                    <?if($type[0] == "phone"):?>
                           
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <input class="phone focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text">
                            </div>
                        </div>
        
                    <?endif;?>
                    
                    <?if($type[0] == "count"):?>
                                                                                 
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input count <?if($type[1] == "y"):?>require<?endif;?>">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <input class="focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text"> <span class="plus"></span> <span class="minus"></span>
                            </div>
                        </div>
        
                    <?endif;?>
                    
                    <?if($type[0] == "date"):?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input date-wrap <?if($type[1] == "y"):?>require<?endif;?>">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <input class="date focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="text">
                            </div>
                        </div>
        
                    <?endif;?>
                    
                    <?if($type[0] == "password"):?>
                    
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input">
                                <div class="bg"></div>
                                <span class="desc"><?=$arValue?></span>
                                <input class="focus-anim <?if($type[1] == "y"):?>require<?endif;?> <?=$yaWiz?>" name="input_<?=$arResult["ID"]?>_<?=$key?>" type="password">
                                
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
                                    
                                    <div class="select-list-choose first"><span class="list-area"><?=GetMessage('KRAKEN_CART_FORM_SELECT');?></span></div>

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
        
        
        <?endif;?>

       
        <?if($arParams["CART_PAGE"] == "Y"):?>
            <?if(!empty($KRAKEN_TEMPLATE_ARRAY['CART_PAY']['VALUE'])):?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 parent-choose-select">

                    <?
                    $title = GetMessage('KRAKEN_CART_FORM_PAY');

                    if(strlen($KRAKEN_TEMPLATE_ARRAY['CART_PAY_TIT']['VALUE']) > 0)
                        $title = $KRAKEN_TEMPLATE_ARRAY['CART_PAY_TIT']['~VALUE'];

                    if($KRAKEN_TEMPLATE_ARRAY['CART_PAY_TIT']['~VALUE'] == " ")
                        $title = "";

                    if(strlen($title) > 0):?>
                        <div class="name-tit-choose bold"><?=$title?></div>
                    <?endif;?>

                    <div class="input">

                        <div class="form-select">
                            <div class="ar-down"></div>
                            <div class="select-list-choose first"><span class="list-area"><?=$KRAKEN_TEMPLATE_ARRAY['CART_PAY']['ITEMS'][0]["NAME"]?></div>


                            <div class="select-list">
                                <?foreach($KRAKEN_TEMPLATE_ARRAY['CART_PAY']['ITEMS'] as $k => $arElement):?>
                                    <label>
                                        <span class="name">
                                        

                                            
                                            <input class="opinion cart-choose-select" data-choose-select = "<?=$arElement['ID']?>" type="radio" name='kraken_pay' <?if($k==0) echo "checked";?> value="<?=$arElement['ID']?>">
                                            <span class="text"><?=$arElement["NAME"]?></span>
                                            
                                        </span>
                                    </label>
                                <?endforeach;?>
                            </div>
                        </div>

                        <?foreach($KRAKEN_TEMPLATE_ARRAY['CART_PAY']['ITEMS'] as $k => $arElement):?>

                            <?if(strlen($arElement["DESCRIPTION"])>0):?>

                                <div class="inp-desc-style <?if($k == 0) echo "active";?> inp-show-js" data-choose-select = "<?=$arElement["ID"]?>">
                                    <?=$arElement["~DESCRIPTION"]?>
                                </div>

                            <?endif;?>

                        <?endforeach;?>

                    </div>

                 
                </div>
                <?$title = '';?>
            <?endif;?>

            <?if(!empty($KRAKEN_TEMPLATE_ARRAY['CART_DELIV']['ITEMS'])):?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 parent-choose-select">

                    <?
                    $title = GetMessage('KRAKEN_CART_FORM_DELIV');

                    if(strlen($KRAKEN_TEMPLATE_ARRAY['CART_DELIV_TIT']['VALUE']) > 0)
                        $title = $KRAKEN_TEMPLATE_ARRAY['CART_DELIV_TIT']['~VALUE'];

                    if($KRAKEN_TEMPLATE_ARRAY['CART_DELIV_TIT']['~VALUE'] == " ")
                        $title = "";

                    if(strlen($title) > 0):?>
                        <div class="name-tit-choose bold"><?=$title?></div>
                    <?endif;?>

                    <div class="input">

                        <div class="form-select">
                           
                            <div class="ar-down"></div>
                            <div class="select-list-choose first"><span class="list-area"><?=$KRAKEN_TEMPLATE_ARRAY['CART_DELIV']['ITEMS'][0]["NAME"]?></span>
                                
                                <?foreach($KRAKEN_TEMPLATE_ARRAY['CART_DELIV']['ITEMS'] as $k => $arElement):?>
                                    <?if($arElement["PRICE"]>0):?>

                                        <div class="outer-inp-price-style inp-show-js <?if($k == 0) echo "active";?>" data-choose-select = "<?=$arElement["ID"]?>">

                                            <table class="inp-price-style">
                                                <tr>
                                                    <td>+ <?=CKraken_format::convertMain($arElement["PRICE"], $arElement["CURRENCY"], $KRAKEN_TEMPLATE_ARRAY['BASE_CURR']['VALUE'])?></td>
                                                </tr>
                                            </table>

                                        </div>
                             
                                    <?endif;?>


                                <?endforeach;?>
                            </div>
                            
                            

                            <div class="select-list">
                                <?foreach($KRAKEN_TEMPLATE_ARRAY['CART_DELIV']['ITEMS'] as $k => $arElement):?>
                                    <label>
                                        <span class="name">
                                            
                                            <input class="opinion cart-choose-select" data-choose-select = "<?=$arElement["ID"]?>" type="radio" name='kraken_deliv' <?if($k==0) echo "checked";?> value="<?=$arElement["ID"]?>">
                                            <span class="text"><?=$arElement["NAME_ON_SITE"]?></span>

                                        </span>
                                    </label>
                                <?endforeach;?>
                            </div>
                        </div>

                        <?foreach($KRAKEN_TEMPLATE_ARRAY['CART_DELIV']['ITEMS'] as $k => $arElement):?>

                            <?if(strlen($arElement["~DESCRIPTION"])>0):?>

                                <div class="inp-desc-style <?if($k == 0) echo "active";?> inp-show-js" data-choose-select = "<?=$arElement["ID"]?>">
                                    <?=$arElement["~DESCRIPTION"]?>
                                </div>

                            <?endif;?>

                        <?endforeach;?>

                    </div>

                    <?foreach($KRAKEN_TEMPLATE_ARRAY['CART_DELIV']['ITEMS'] as $k => $arElement):?>

                        <?if($arElement["ADD_FIELD"] == "Y"):?>

                            <?
                                if($arElement["ADD_FIELD_HEIGHT"] == 0)
                                    $arElement["ADD_FIELD_HEIGHT"] = 1;


                                $active = "";

                                if($k == 0)
                                    $active = "active";
                                
                            
                                $body_class = "class='input kraken-inp inp-show-js'";
                                $body_desc = "";
                                $body_desc_anim = "";

                                if(strlen($arElement["ADD_FIELD_NAME"])>0)
                                {
                                    $body_desc = "<span class='desc inp-show-js-length'>".$arElement["ADD_FIELD_NAME"]."</span>";
                                    $body_desc_anim = "class='focus-anim ".$active."'";
                                }

                                $body_inp = "<input ".$body_desc_anim." name='deliv_text_".$arElement["ID"]."' type='text' />";

                                if($arElement["ADD_FIELD_HEIGHT"] > 1)
                                {
                                    $body_class = "class='input kraken-inp input-textarea inp-show-js inp-show-js-padding ".$active."'";
                                    $body_inp = "<textarea ".$body_desc_anim." name='deliv_text_".$arElement["ID"]."' rows='".$arElement["ADD_FIELD_HEIGHT"]."'></textarea>";
                                }
                                
                                
                                echo $res = "<div ".$body_class." data-choose-select = '".$arElement["ID"]."'>
                                    <div class='bg'></div>".$body_desc.$body_inp."</div>";

                            ?>

                        

                        <?endif;?>

                    <?endforeach;?>

                 
                </div>
                <?$title = '';?>
            <?endif;?>
        <?endif;?>

     



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

                    <?if(strlen($arResult["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]) > 0):?> data-link='<?=$arResult["PROPERTIES"]["FORM_TO_LINK"]["VALUE"]?>' <?endif;?>><?if(strlen($arResult['PROPERTIES']['FORM_BUTTON']['VALUE']) > 0):?><?=$arResult['PROPERTIES']['FORM_BUTTON']['~VALUE']?><?else:?><?=GetMessage('KRAKEN_CART_FORM_SUBMIT')?><?endif;?></button>
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
                <span class="text"><?if(strlen($KRAKEN_TEMPLATE_ARRAY["POLITIC_DESC"]['VALUE'])>0):?><?=$KRAKEN_TEMPLATE_ARRAY["POLITIC_DESC"]['~VALUE']?><?else:?><?=GetMessage('KRAKEN_CART_FORM_AGREEMENT')?><?endif;?></span>


                <?$agrCount = count($KRAKEN_TEMPLATE_ARRAY['AGREEMENT_FORM']);?>
                <?foreach($KRAKEN_TEMPLATE_ARRAY['AGREEMENT_FORM'] as $k => $arAgr):?>

                    <a class="call-modal callagreement" data-call-modal="agreement<?=$arAgr['ID']?>"><?if(strlen($arAgr['PROPERTIES']['CASE_TEXT']['VALUE'])>0):?><?=$arAgr['PROPERTIES']['CASE_TEXT']['VALUE']?><?else:?><?=$arAgr['NAME']?><?endif;?></a><?if($k+1 != $agrCount):?><span>, </span><?endif;?>

                    
                <?endforeach;?>
             
            </div>

        </div>
    <?endif;?>
</div>
    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 thank">
    <?if(!empty($arResult['PROPERTIES']['FORM_THANKS']['VALUE'])):?>
        <?=$arResult['PROPERTIES']['FORM_THANKS']['~VALUE']['TEXT']?>
    <?else:?>
        <?=GetMessage('KRAKEN_CART_FORM_THANK')?>
    <?endif;?>
</div>