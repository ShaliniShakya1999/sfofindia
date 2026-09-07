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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Clean URLs for website pages (legacy *.php links -> Welcome::_remap)
$route['about'] = 'welcome/about';
$route['service'] = 'welcome/service';
$route['financial'] = 'welcome/financial';
$route['education'] = 'welcome/education';
$route['disability'] = 'welcome/disability';
$route['employment'] = 'welcome/employment';
$route['donation'] = 'welcome/donation';
$route['documents'] = 'welcome/documents';
$route['team'] = 'welcome/team';
$route['join-us'] = 'member_apply/index';
$route['join-us/submit'] = 'member_apply/submit';
// Aadhaar OTP API disabled; member identity is reviewed manually.
// $route['join-us/send_aadhaar_otp'] = 'member_apply/send_aadhaar_otp';
// $route['join-us/verify_aadhaar_otp'] = 'member_apply/verify_aadhaar_otp';
$route['member-login'] = 'member_portal/login';
$route['member-login/submit'] = 'member_portal/do_login';
$route['member-panel'] = 'member_portal/dashboard';
$route['member-panel/logout'] = 'member_portal/logout';
$route['member-panel/document/(:any)'] = 'member_portal/document/$1';
$route['admin/profile'] = 'admin/profile';
$route['admin/member_document/(:any)'] = 'admin/member_document/$1';
$route['gallery'] = 'welcome/gallery';
$route['event'] = 'welcome/event';
$route['feature'] = 'welcome/feature';
$route['contact'] = 'welcome/contact';
$route['refund_policy'] = 'welcome/refund_policy';
$route['legal_compliance'] = 'welcome/legal_compliance';
$route['privacy_policy'] = 'welcome/privacy_policy';
$route['terms'] = 'welcome/terms';
$route['create_order'] = 'welcome/create_order';
$route['razorpay_config'] = 'welcome/razorpay_config';
$route['send'] = 'welcome/send';

// NGO CMS (admin content for public site)
$route['cms'] = 'cms/index';
$route['cms/(:any)'] = 'cms/$1';

// NGO Management (members, donations, public verify)
$route['member_verify/(:any)'] = 'member_verify/index/$1';
$route['members/(:any)'] = 'members/$1';
$route['donations/(:any)'] = 'donations/$1';
