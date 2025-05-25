<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(["namespace" => "Api"], function () {
    Route::get("/loginapi/", "LandingApiController@getlogin");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/leavefileapi/", "LandingApiController@aleavemployee");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/getleavegetapi/", "LandingApiController@aleaveget");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/saveleavegetapi/", "LandingApiController@saveleaveget");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/holidaymployeeprofileapi/", "LandingApiController@holidayemployee");

});

Route::group(["namespace" => "Api"], function () {
    Route::get("/allholidayprofileapi/", "LandingApiController@allholdaymployee");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/leaverequapi/", "LandingApiController@leaveapprivere");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/leaverequapediti/", "LandingApiController@leaveapprivereedit");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/dailymployeeprofileapi/", "LandingApiController@dailytimeemployee");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/timeinmployeeprofileapi/", "LandingApiController@timeinemployee");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/timeoutmployeeprofileapi/", "LandingApiController@timeoutemployee");

});

Route::group(["namespace" => "Api"], function () {

    Route::get("/employerleaverequapi/{emp_id}", "LandingApiController@employerleaveapprivere");

});

Route::group(["namespace" => "Api"], function () {

    Route::get("/dailyattandanceapi/{emp_id}", "LandingApiController@dailyattandanceshow");

});

Route::group(["namespace" => "Api"], function () {
    Route::get("/leavedayscountbydate/{employee_id}/{from_date}/{to_date}/{leave_type}", "LandingApiController@LeaveCountdate");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/employerleaverequapediti/", "LandingApiController@employerleaveapprivereedit");
});

Route::group(["namespace" => "Api"], function () {

    Route::get("/employerleaverequesteditapi/", "LandingApiController@employerSaveLeavePermission");
});

Route::group(["namespace" => "Api"], function () {
    Route::get("/leaverequesteditapi/", "LandingApiController@SaveLeavePermission");
});
