<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 * 
 */

$routes->setDefaultController('Login'); // Change 'Login' to your desired controller

$routes->get('/', 'Login::index');

$routes->get('user', 'User::index', ['filter' => 'AuthFilter']);

$routes->get('dashboard', 'User::dashboard');

$routes->get('dashboard1', 'User::dashboard1');

$routes->get('login', 'User::login', ['filter' => 'NoAuthFilter']);
$routes->post('login', 'User::login');

$routes->get('loginF', 'User::loginF', ['filter' => 'NoAuthFilter']);
$routes->post('loginF', 'User::loginF');

$routes->get('logout', 'User::logout');

$routes->get('forgotpassword', 'User::forgotpassword');
$routes->post('forgotpassword', 'User::forgotpassword');
$routes->post('sendOTP', 'User::sendOTP');
$routes->get('verify_otp', 'User::verify_otp');
$routes->post('verifyOTPU', 'User::verifyOTPU');
$routes->get('resetpassword', 'User::resetPassword');
$routes->post('updatePassword', 'User::updatePassword');

$routes->get('register', 'User::register');
$routes->post('register', 'User::register');

$routes->get('registerF', 'User::registerF');
$routes->post('registerF', 'User::registerF');

$routes->get('user/add', 'User::add', ['filter' => 'AuthFilter']);
$routes->post('user/add', 'User::add');

$routes->get('user/addUser', 'User::addUser', ['filter' => 'AuthFilter']);
$routes->post('user/addUser', 'User::addUser');

$routes->get('user/edit', 'User::edit', ['filter' => 'AuthFilter']);
$routes->post('user/updateUser', 'User::updateUser');
//$routes->match(['get', 'post'], 'user/edit/(:num)', 'User::edit/$1');

$routes->get('user/getUserDetails/(:any)', 'User::getUserDetails/$1');

$routes->get('user/delete', 'User::delete', ['filter' => 'AuthFilter']);
$routes->post('user/delete', 'User::delete');

$routes->get('getUserDetailF', 'User::getUserDetailF');
$routes->post('getUserDetailF', 'User::getUserDetailF');

$routes->get('client/register', 'Client::register');
$routes->post('client/register', 'Client::register');

$routes->get('registerC', 'Client::registerC');
$routes->post('registerC', 'Client::registerC');
$routes->get('registerEdit', 'Client::registerEdit');
$routes->post('registerEdit', 'Client::registerEdit');

$routes->get('client/uploadFilesOnly', 'Client::uploadFilesOnly');
$routes->post('client/uploadFilesOnly', 'Client::uploadFilesOnly');

//$routes->post('user/getOffices', 'User::getOffices');
$routes->get('user/getOffices', 'User::getOffices');
$routes->get('user/getOfficeDetails/(:any)', 'User::getOfficeDetails/$1');


$routes->get('confirmation', 'Client::confirmation');
$routes->post('confirmation', 'Client::confirmation');

$routes->get('releasing', 'Client::releasing');
$routes->post('releasing', 'Client::releasing');

$routes->get('print', 'Client::print');
$routes->post('print', 'Client::print');

$routes->get('printCashier', 'Client::printCashier');
$routes->post('printCashier', 'Client::printCashier');

$routes->get('reports', 'Client::reports');
$routes->post('reports', 'Client::reports');

//$routes->get('client', 'Client::confirmation');
//$routes->get('client', 'Client::releasing');
$routes->get('getPendingRegistrationNo/(:segment)', 'Client::getPendingRegistrationNo/$1');
$routes->get('getUserRolesByOffice/(:segment)', 'Client::getUserRolesByOffice/$1');

$routes->get('getUserRoleByUserId/(:any)', 'User::getUserRoleByUserId/$1');

$routes->get('getUserDetailsF/(:segment)', 'User::getUserDetailsF/$1');
$routes->get('checkSerialNo/(:any)', 'Client::checkSerialNo/$1');
$routes->get('getRegistrationNumbers/(:any)', 'Client::getRegistrationNumbers/$1');
$routes->get('getRegistrationDetails/(:any)', 'Client::getRegistrationDetails/$1');

$routes->get('client/getClientInfo/(:any)', 'Client::getClientInfo/$1');
$routes->post('client/updateClientStatus/(:any)', 'Client::updateClientStatus/$1');
$routes->post('client/sendSms', 'Client::sendSms');

$routes->post('sendSmsF', 'Client::sendSmsF');
$routes->post('verifyOtp', 'Client::verifyOtp');
$routes->post('resetPassword', 'Client::resetPassword');



$routes->post('client/updateRegistration', 'Client::updateRegistration');
$routes->post('client/savePayment', 'Client::savePayment');
$routes->post('savePaymentF', 'Client::savePaymentF');
$routes->get('client/getClientInfoByUserID/(:any)', 'Client::getClientInfoByUserID/$1');
$routes->post('client/updatePaymentStatus', 'Client::updatePaymentStatus');

$routes->post('client/getClientStatus', 'Client::getClientStatus');
$routes->post('client/releaseClient', 'Client::releaseClient');

$routes->get('client/getFiles/(:any)', 'Client::getFiles/$1');

$routes->get('client/getClientDetailsByStatusAndPayment/(:segment)/(:segment)', 'Client::getClientDetailsByStatusAndPayment/$1/$2');
$routes->get('client/getClientDetailsByStatusAndPayment/(:segment)', 'Client::getClientDetailsByStatusAndPayment/$1');

$routes->get('client/printCOR/(:any)', 'Client::printCOR/$1');
$routes->get('client/printOC/(:any)', 'Client::printOC/$1');

$routes->get('client/getReleasedClients', 'Client::getReleasedClients');
$routes->post('client/getReleasedClients', 'Client::getReleasedClients');
$routes->get('client/printReports/(:segment)', 'Client::printReports/$1');
$routes->post('client/printReports/(:segment)', 'Client::printReports/$1');

$routes->get('client/getClientDetails/(:segment)', 'Client::getClientDetails/$1');

//$routes->get('getClientDetailsQR/(:any)', 'Client::getClientDetailsQR/$1');
$routes->get('getClientDetailsQR/(:segment)', 'Client::getClientDetailsQR/$1');

//$routes->get('getClientDetailsQR', 'Client::getClientDetailsQR');


$routes->post('getClientDetailsQR/(:segment)', 'Client::getClientDetailsQR/$1');



