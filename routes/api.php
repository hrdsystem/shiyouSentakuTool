<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShiyoushoCatalogController;
use App\Http\Controllers\MasterMaintenanceController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/save',[ShiyoushoCatalogController::class,'saveCart']);
Route::get('/getData',[ShiyoushoCatalogController::class,'getData']);
Route::post('/remove/{id}',[ShiyoushoCatalogController::class,'removeItem']);

//GETTING OF DATA FROM HRDSQLS
Route::get('/getDataHRDSQL8',[ShiyoushoCatalogController::class,'getDataHRDSQL8']);
Route::get('/getDataHRDSQL7',[ShiyoushoCatalogController::class,'getDataHRDSQL7']);
Route::post('/getDataShio',[ShiyoushoCatalogController::class,'getDataShio']);
Route::post('/saveToShioCatalog',[ShiyoushoCatalogController::class,'saveToShioCatalog']);

//GETTING OF DATA FROM SENTAKU TOOL
Route::get('/getDataSentakuTool',[ShiyoushoCatalogController::class,'getDataSentakuTool']);
// Route::get('/getDataSentakuTool', 'ShiyoushoCatalogController@getDataSentakuTool');
Route::post('/getMaker',[ShiyoushoCatalogController::class, 'getMaker']);
Route::post('/getClassification',[ShiyoushoCatalogController::class, 'getClassification']);
Route::post('/getClassificationTwo',[ShiyoushoCatalogController::class, 'getClassificationTwo']);
Route::post('/getClassificationThree',[ShiyoushoCatalogController::class, 'getClassificationThree']);

Route::get('/navigationDrawer/selectCategory',[ShiyoushoCatalogController::class,'selectCategory']);
Route::get('/navigationDrawer/selectMasterCategory',[ShiyoushoCatalogController::class,'selectMasterCategory']);
Route::post('/navigationDrawer/selectItem',[ShiyoushoCatalogController::class,'selectItem']);

Route::post('/getColor',[ShiyoushoCatalogController::class,'getColor']);


//MASTER MAINTENANCE TOOL(G) 
Route::post('/masterMaintenance/getData/{id}',[MasterMaintenanceController::class,'getData']);
Route::get('/masterMaintenance/editItems/{id}',[MasterMaintenanceController::class,'editItems']);
Route::post('/masterMaintenance/updateData/{id}', [MasterMaintenanceController::class, 'updateData']);
Route::post('/masterMaintenance/updateItem1/{id}', [MasterMaintenanceController::class, 'updateItem1']);
Route::post('/mastermaintenance/saveItem2', [MasterMaintenanceController::class, 'saveItem2']);
Route::get('/masterMaintenance/editItem2/{id}',[MasterMaintenanceController::class,'editItem2']);

Route::post('/masterMaintenance/getData',[MasterMaintenanceController::class,'getData']);
Route::post('/masterMaintenance/editItems',[MasterMaintenanceController::class,'editItems']);
Route::post('/masterMaintenance/updateData', [MasterMaintenanceController::class, 'updateData']);
Route::post('/masterMaintenance/saveData', [MasterMaintenanceController::class, 'saveData']);

Route::get('/masterMaintenance/getData',[MasterMaintenanceController::class,'getData']);
Route::get('/masterMaintenance/editItems',[MasterMaintenanceController::class,'editItems']);
Route::get('/masterMaintenance/updateData', [MasterMaintenanceController::class, 'updateData']);
Route::get('/masterMaintenance/saveData', [MasterMaintenanceController::class, 'saveData']);


// GEETING OF ITEMS
Route::get('/masterMaintenance/getItem1',[MasterMaintenanceController::class,'getItem1']);
Route::get('/masterMaintenance/getItem2',[MasterMaintenanceController::class,'getItem2']);
Route::get('/masterMaintenance/products',[MasterMaintenanceController::class,'products']);
Route::get('/masterMaintenance/colors',[MasterMaintenanceController::class,'colors']);

Route::post('/masterMaintenance/getItem1',[MasterMaintenanceController::class,'getItem1']);
Route::post('/masterMaintenance/getItem2',[MasterMaintenanceController::class,'getItem2']);
Route::post('/masterMaintenance/products',[MasterMaintenanceController::class,'products']);
Route::post('/masterMaintenance/colors',[MasterMaintenanceController::class,'colors']);

// Route::get('/masterMaintenance/getCategories',[MasterMaintenanceController::class,'getCategories']);
// // Route::get('/masterMaintenance/getItem1',[MasterMaintenanceController::class,'getItem1']);
// Route::get('/masterMaintenance/getItem2',[MasterMaintenanceController::class,'getItem2']);
// Route::get('/masterMaintenance/products',[MasterMaintenanceController::class,'products']);
// Route::get('/masterMaintenance/colors',[MasterMaintenanceController::class,'colors']);

Route::post('/masterMaintenance/deleteData',[MasterMaintenanceController::class,'deleteData']);



