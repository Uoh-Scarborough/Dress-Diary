<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['custom_page_types']['Page']['children'] = true;
$config['custom_page_types']['Page']['allowed_children'] = "Page";


$config['custom_page_types']['Folder']['children'] = true;
$config['custom_page_types']['Folder']['allowed_children'] = "Page:Event:Boutique:Dress";


$config['custom_page_types']['Home']['children'] = true;
$config['custom_page_types']['Home']['allowed_children'] = "Page";


$config['custom_page_types']['Event']['children'] = false;
$config['custom_page_types']['Event']['allowed_children'] = "";
