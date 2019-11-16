<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('can:isAdmin');

Route::resource('staffs', 'StaffController')->middleware('can:isAdmin');

Route::get('/staffs/enable/{id}', 'StaffController@enable')->middleware('can:isAdmin');
Route::get('/staffs/disable/{id}', 'StaffController@disable')->middleware('can:isAdmin');

Route::get('/staffs/sendmail/{user}', 'StaffController@send_password_reset')->middleware('can:isAdmin');

Route::get('/staffs/salary/{staff}', 'StaffController@editSalaryDetails')->middleware('can:isAdmin');
Route::post('/staffs/salary/{staff}', 'StaffController@updateSalaryDetails')->middleware('can:isAdmin');

Route::get('/staffs/salary_slip/{staff}', 'StaffController@salarySlip')->middleware('can:isAdmin');

Route::get('/users/change_password', 'StaffController@change_password');
Route::post('/users/change_password', 'StaffController@update_password');

Route::get('/requests', 'RequestController@index')->name('requests')->middleware('can:isAdmin');
Route::post('/requests/update', 'RequestController@updateStatus')->middleware('can:isAdmin');

Route::get('/holidays', 'HolidayController@index');
Route::get('/holidays/create', 'HolidayController@create')->middleware('can:isAdmin');
Route::post('/holidays/store', 'HolidayController@store')->middleware('can:isAdmin');
Route::delete('/holidays/destroy/{holiday}', 'HolidayController@destroy')->middleware('can:isAdmin');
Route::get('/holidays/edit/{holiday}', 'HolidayController@edit')->middleware('can:isAdmin');
Route::post('/holidays/update/{holiday}', 'HolidayController@update')->middleware('can:isAdmin');

Route::get('/leaves', 'LeaveController@index')->middleware('can:isAdmin');
Route::post('/leaves/update', 'LeaveController@update')->middleware('can:isAdmin');


//<<<<<<<<<<<Employee Section>>>>>>>>>>>>>>>>>>>>>>

Route::get('/employee/home', 'Employee\HomeController@index')->middleware('can:isEmployee');
//Route::get('/employee/requests', 'Employee\RequestController@index')->middleware('can:isEmployee');

Route::resource('employee/requests', 'Employee\RequestController')->middleware('can:isEmployee');

