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
$route['default_controller'] = 'homeController';

$route['home'] = 'homeController/home';
$route['login'] = 'homeController/login';
$route['equipment-type'] = 'homeController/equipmentType';

$route['signUp'] = 'homeController/signUp';
$route['register'] = 'customController/register';
$route['equipments'] = 'homeController/equipments';
$route['designations'] = 'homeController/designations';
$route['borrowLogs'] = 'homeController/borrowLogs';
$route['reports'] = 'homeController/reports';
$route['defective-logs'] = 'homeController/defectiveLogs';
$route['fixes-logs'] = 'homeController/fixesLogs';


// Ajax
$route['ajax/get-all-users'] = 'customController/getAllUsers';
$route['ajax/get-equipment-types'] = 'customController/getEquipmentTypes';
$route['ajax/get-equipment-type'] = 'customController/getEquipmentType';
$route['ajax/get-new-password'] = 'customController/getnewpassword';
$route['ajax/get-designations'] = 'customController/getDesignations';
$route['ajax/get-designation'] = 'customController/getDesignation';
$route['ajax/get-equipments'] = 'customController/getEquipments';
$route['ajax/get-equipment'] = 'customController/getEquipment';
$route['ajax/get-equipment-details'] = 'customController/getEquipmentDetails';
$route['ajax/get-borrow-logs'] = 'customController/getBorrowLogs';
$route['ajax/get-defect-logs'] = 'customController/getDefectiveLogs';

$route['ajax/login'] = 'globalController/validatelogin';
$route['ajax/update-password'] = 'customController/updatepassword';
$route['ajax/update-equipment'] = 'customController/updateEquipment';
$route['ajax/update-equipment-type'] = 'customController/updateEquipmentType';
$route['ajax/update-designation'] = 'customController/updateDesignation';


$route['ajax/add-equipment-type'] = 'customController/addEquipmentType';
$route['ajax/add-designation'] = 'customController/addDesignation';
$route['ajax/add-equipment'] = 'customController/addEquipment';


// deletes
$route['ajax/delete-equipment'] = 'customController/deleteEquipment';
$route['ajax/delete-equipment-type'] = 'customController/deleteEquipmentType';
$route['ajax/delete-designation'] = 'customController/deleteDesignation';


$route['ajax/get-weekly-borrows'] = 'CustomController/getWeeklyBorrows';
$route['ajax/get-monthly-borrows'] = 'CustomController/getMonthlyBorrows';
$route['ajax/get-yearly-borrows'] = 'CustomController/getYearlyBorrows';

$route['ajax/get-totals'] = 'CustomController/getTotals';
$route['ajax/get-reports'] = 'CustomController/getReports';

$route['ajax/set-defective'] = 'CustomController/setEquipmentAsDefective';
$route['ajax/set-fixed'] = 'CustomController/setEquipmentAsFixed';


// api
$route['api/v1/getUser'] = 'apiController/getUserData';
$route['api/v1/employee-sign-up'] = 'apiController/employeeSignUp';
$route['api/v1/validate-employee-login'] = 'apiController/validateEmployeeLogin';
$route['api/v1/getEquipment'] = 'apiController/getEquipment';
$route['api/v1/getDesignations'] = 'customController/getDesignations';
$route['api/v1/borrow-equipment'] = 'apiController/borrowEquipment';
$route['api/v1/getBorrowedEquipment'] = 'apiController/getBorrowedEquipment';
$route['api/v1/getAllEquipments'] = 'customController/getEquipments';
$route['api/v1/return-equipment'] = 'apiController/returnEquipment';
$route['api/v1/report-equipment'] = 'apiController/reportEquipment';

$route['logout'] = 'homeController/logout';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

