<?php
//
//namespace App\Http\Controllers\Prestashop;
//
//use App\Http\Controllers\Controller;
//use App\Models\Product;
//use PrestaShopWebservice;
//use PrestaShopWebserviceException;
//
//class TestController extends Controller
//{
//    function AddProduct($root_path, $authentication_key, $id, $name, $desc, $cat, $qta, $price)
//    {
//        try {
//            $webService = CreateWebServer($root_path, $authentication_key);
//            $xml = $webService->get(array('resource' => 'products?schema=synopsis'));
//        } catch (PrestashopWebserviceException $ex) {
//            echo $ex->getMessage();
//            return -1;
//        }
//
//
//        $resources = $xml->children()->children();
//
//        unset($resources->position_in_category);
//        unset($resources->manufacturer_name);
//
//        $resources->price = floatval($price);
//        $resources->quantity = intval($qta);
//        $resources->link_rewrite->language[0][0] = str_replace(' ', '-', $name);
//        $resources->name->language[0][0] = $name;
//        $resources->description->language[0][0] = $desc;
//
//        $node = dom_import_simplexml($resources->description->language[0][0]);
//        $no = $node->ownerDocument;
//        $node->appendChild($no->createCDATASection($desc));
//
//        $resources->associations = '';
//
//        //echo $xml->asXML();
//        try {
//            $opt = array('resource' => 'products');
//            $opt['postXml'] = $xml->asXML();
//            $xml = $webService->add($opt);
//        } catch (PrestaShopWebserviceException $ex) {
//            echo $ex->getMessage();
//        }
//        return 0;
//    }
//
//    function CreateProduct($update, $webService, $root_path, $n_id, $n_id_category_default, $n_id_category, $n_price, $n_active, $n_avail4order, $n_show_price, $n_id_stock_availables, $n_id_id_product_attribute, $n_l_id, $n_name, $n_desc, $n_desc_short, $n_link_rewrite, $n_meta_title, $n_meta_description, $n_meta_keywords, $n_available_now, $n_available_later, $idtaglist, $cod)
//    {
//
//        $xml = $webService->get(array('url' => $root_path . '/api/products?schema=blank'));
//        $resources = $xml->children()->children();
//        unset($resources->id);
//        unset($resources->position_in_category);
//        unset($resources->id_shop_default);
//        unset($resources->date_add);
//        unset($resources->date_upd);
//
//        unset($resources->associations->combinations);
//        unset($resources->associations->product_options_values);
//        unset($resources->associations->product_features);
//        unset($resources->associations->stock_availables->stock_available->id_product_attribute);
//
////unset($resources->associations->categories->category->id);
//
////unset($resources-> id_category_default);
//
////$resources->position_in_category = '0';
////unset($resources->position_in_category);
//
////$resources -> position = '0';
//        if ($update) $resources->id = $n_id;
//        $resources->id_manufacturer = '1';
//        $resources->id_supplier = '1';
//        $resources->id_category_default = $n_id_category_default;
//        $resources-> new = '0'; ; //condition, new is also a php keyword!!
//$resources->cache_default_attribute;
//$resources->id_default_image;
//$resources->id_default_combination = '0';
//$resources->id_tax_rules_group = '1';
////$resources-> id_shop_default;
////$resources-> quantity = '50';
//$resources->reference = $cod;
//$resources->supplier_reference;
//$resources->location;
//$resources->width;
//$resources->height;
//$resources->depth;
//$resources->weight;
//$resources->quantity_discount;
//$resources->ean13;
//$resources->upc;
//$resources->cache_is_pack;
//$resources->cache_has_attachments;
//$resources->is_virtual;
//$resources->on_sale;
//$resources->online_only;
//$resources->ecotax;
////$resources-> minimal_quantity = 10;
//$resources->price = $n_price;
//$resources->wholesale_price;
//$resources->unity;
//$resources->unit_price_ratio;
//$resources->additional_shipping_cost;
//$resources->customizable;
//$resources->text_fields;
//$resources->uploadable_files;
//$resources->active = $n_active;
//$resources->available_for_order = $n_avail4order;
//$resources->available_date;
//$resources->condition;
//$resources->show_price = $n_show_price;
//$resources->indexed = '1';
//$resources->visibility = 'both';
//$resources->advanced_stock_management = '0';
//$resources->date_add;
//$resources->date_upd;
//
//$resources->associations->categories->addChild('category')->addChild('id', $n_id_category);
//
//$node = dom_import_simplexml($resources->name->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_name));
//$resources->name->language[0][0] = $n_name;
//$resources->name->language[0][0]['id'] = $n_l_id;
//$resources->name->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->description->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_desc));
//$resources->description->language[0][0] = $n_desc;
//$resources->description->language[0][0]['id'] = $n_l_id;
//$resources->description->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->description_short->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_desc_short));
//$resources->description_short->language[0][0] = $n_desc_short;
//$resources->description_short->language[0][0]['id'] = $n_l_id;
//$resources->description_short->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->link_rewrite->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_link_rewrite));
//$resources->link_rewrite->language[0][0] = $n_link_rewrite;
//$resources->link_rewrite->language[0][0]['id'] = $n_l_id;
//$resources->link_rewrite->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->meta_title->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_meta_title));
//$resources->meta_title->language[0][0] = $n_meta_title;
//$resources->meta_title->language[0][0]['id'] = $n_l_id;
//$resources->meta_title->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->meta_description->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_meta_description));
//$resources->meta_description->language[0][0] = $n_meta_description;
//$resources->meta_description->language[0][0]['id'] = $n_l_id;
//$resources->meta_description->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->meta_keywords->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_meta_keywords));
//$resources->meta_keywords->language[0][0] = $n_meta_keywords;
//$resources->meta_keywords->language[0][0]['id'] = $n_l_id;
//$resources->meta_keywords->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->available_now->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_available_now));
//$resources->available_now->language[0][0] = $n_available_now;
//$resources->available_now->language[0][0]['id'] = $n_l_id;
//$resources->available_now->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
//$node = dom_import_simplexml($resources->available_later->language[0][0]);
//$no = $node->ownerDocument;
//$node->appendChild($no->createCDATASection($n_available_later));
//$resources->available_later->language[0][0] = $n_available_later;
//$resources->available_later->language[0][0]['id'] = $n_l_id;
//$resources->available_later->language[0][0]['xlink:href'] = $root_path . '/api/languages/' . $n_l_id;
//
////echo '<br/><br/>';
////aggiungo i tag
//foreach ($idtaglist as $tag) {
//    $resources->associations->tags->addChild('tags')->addChild('id', $tag);
//    //$resources -> asssociations -> tags -> tags -> id = $tag;
//    //echo $resources -> asssociations -> tags -> tags -> id.'--'.$tag.'<br/>';
//}
//
//$id = "";
//try {
//    $opt = array('resource' => 'products');
//    if (!$update) {
//        $opt['postXml'] = $xml->asXML();
//        $xml = $webService->add($opt);
//        $id = $xml->product->id;
//    } else {
//        $opt['putXml'] = $xml->asXML();
//        //echo 'n_id: '.$n_id;
//        $opt['id'] = $n_id;
//        $xml = $webService->edit($opt);
//        $id = $n_id;
//    }
//
//} catch (PrestaShopWebserviceException $ex) {
//    //echo '<b>Error : '.$ex->getMessage().'</b>';
//}
//return $id;
//}
//}
