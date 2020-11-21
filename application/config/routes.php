<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['106a6c241b8797f52e1e77317b96a201'] = "home";
$route['106a6c241b8797f52e1e77317b96a201/([a-zA-Z0-9]+)'] = "home/$1";

$route['ee11cbb19052e40b07aac0ca060c23ee'] = "user";
$route['ee11cbb19052e40b07aac0ca060c23ee/([a-zA-Z0-9]+)'] = "user/$1";

$route['d13bc5b68b2bd9e18f29777db17cc563'] = "Common";
$route['d13bc5b68b2bd9e18f29777db17cc563/([a-zA-Z0-9]+)'] = "Common/$1";

$route['786960e2f42d803d3fc3c9df9407c8f5'] = "CommonBulk";
$route['786960e2f42d803d3fc3c9df9407c8f5/([a-zA-Z0-9]+)'] = "CommonBulk/$1";

$route['f6068daa29dbb05a7ead1e3b5a48bbee'] = "Data";
$route['f6068daa29dbb05a7ead1e3b5a48bbee/([a-zA-Z0-9]+)'] = "Data/$1";

$route['dd560916dcc8bb795671b54a5640cec3'] = "Contract_Tariff";
$route['dd560916dcc8bb795671b54a5640cec3/([a-zA-Z0-9]+)'] = "Contract_Tariff/$1";

$route['eaeb30f9f18e0c50b178676f3eaef45f'] = "Task";
$route['eaeb30f9f18e0c50b178676f3eaef45f/([a-zA-Z0-9]+)'] = "Task/$1";

$route['4b1b4dc8cf38b3c64b1d657da8f5ac8c'] = "Report";
$route['4b1b4dc8cf38b3c64b1d657da8f5ac8c/([a-zA-Z0-9]+)'] = "Report/$1";
$route['4b1b4dc8cf38b3c64b1d657da8f5ac8c/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)'] = "Report/$1";
$route['4b1b4dc8cf38b3c64b1d657da8f5ac8c/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)'] = "Report/$1";

$route['a0ce6e32fcbd45dfec6dc291b36a59ad'] = "InvoiceManagement";
$route['a0ce6e32fcbd45dfec6dc291b36a59ad/([a-zA-Z0-9]+)'] = "InvoiceManagement/$1";

$route['dd85641c28bfd5bae3047879853d4a33'] = "Vessel";
$route['dd85641c28bfd5bae3047879853d4a33/([a-zA-Z0-9]+)'] = "Vessel/$1";

$route['742e367b489bd598edcb306560e3b1f4'] = "Tariff";
$route['742e367b489bd598edcb306560e3b1f4/([a-zA-Z0-9]+)'] = "Tariff/$1";

$route['4ea1b85cf2a0ed82a52686576e6a31e8'] = "Users_Management";
$route['4ea1b85cf2a0ed82a52686576e6a31e8/([a-zA-Z0-9]+)'] = "Users_Management/$1";

$route['a240fa27925a635b08dc28c9e4f9216d'] = "Order";
$route['a240fa27925a635b08dc28c9e4f9216d/([a-zA-Z0-9]+)'] = "Order/$1";

$route['cf51066f49e517f274b8173cc265c60b'] = "Job";
$route['cf51066f49e517f274b8173cc265c60b/([a-zA-Z0-9]+)'] = "Job/$1";

$route['f241ae5ffa37d55ce7e667c8b272a747'] = "Vessel_Delivery";
$route['f241ae5ffa37d55ce7e667c8b272a747/([a-zA-Z0-9]+)'] = "Vessel_Delivery/$1";

$route['63d721d24d2dde776e05e4b8c47f08a3'] = "gate";
$route['63d721d24d2dde776e05e4b8c47f08a3/([a-zA-Z0-9]+)'] = "gate/$1";

$route['8d05346598cd730d88308156cac41e6d'] = "tally";
$route['8d05346598cd730d88308156cac41e6d/([a-zA-Z0-9]+)'] = "tally/$1";

$route['f81e986ee4c9f80d6002bf5302b3ea87'] = "che";
$route['f81e986ee4c9f80d6002bf5302b3ea87/([a-zA-Z0-9]+)'] = "che/$1";

$route['20d2cc8e59bf2ffde5b3f713072b25c4'] = "ReportAndStatistics";
$route['20d2cc8e59bf2ffde5b3f713072b25c4/([a-zA-Z0-9]+)'] = "ReportAndStatistics/$1";

$route['53adf84e5794a0677301d887acfe66ab'] = "DataBulk";
$route['53adf84e5794a0677301d887acfe66ab/([a-zA-Z0-9]+)'] = "DataBulk/$1";
$route['53adf84e5794a0677301d887acfe66ab/([a-zA-Z0-9]+)/([a-zA-Z0-9]+)'] = "DataBulk/$1";

$route['34da875e03f8175113bd901cb46c2945'] = "Scales";
$route['34da875e03f8175113bd901cb46c2945/([a-zA-Z0-9]+)'] = "Scales/$1";