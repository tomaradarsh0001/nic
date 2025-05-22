<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItemsListController;
use App\Http\Controllers\Api\PublicGrievanceController;
use App\Http\Controllers\Api\ColonyController;
use App\Http\Controllers\Api\RequestController;
use App\Http\Controllers\FirebaseNotificationController;
use App\Http\Controllers\Api\PropertyCountController;
use App\Http\Controllers\Api\ClubMembershipController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/public-grievances', [PublicGrievanceController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('items/details', [ItemsListController::class, 'getItemsDetails']);
    Route::post('logistic/user-request-store', [RequestController::class, 'store']);
    Route::post('logistic/user-request-update/{requestId}', [RequestController::class, 'update']);
    Route::get('logistic/user-history', [RequestController::class, 'requestHistory']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/colonylist', [ColonyController::class, 'getAllcolonies'])->name('colonylist');

Route::post('/send-notification', [FirebaseNotificationController::class, 'sendNotification']);

// Route for fetching property summary for website Swati Mishra 20-01-2025
Route::get('/property-count/summary', [PropertyCountController::class, 'propertyCountSummary']); 

//Post Api for posting club membership form of IHC and DGC (website) Swati Mishra 26-01-2025
Route::post('/club-memberships/club_type={club_type}', [ClubMembershipController::class, 'store']);
//Get Api for Club Membership listings on the basis of status by Swati Mishra on 29-01-2025
Route::get('/membership/{club_type}/{status_name}', [ClubMembershipController::class, 'index']);
//Post api for upload document of Club Membership by Swati Mishra on 02-02-2025
Route::post('/upload-document/{club_type}/{membership_app_id}', [ClubMembershipController::class, 'uploadDocument']);
//Get Api for club membership table data for a particular record by Swati Mishra on 03-02-2025
Route::get('/download-pdf/{membership_id}', [ClubMembershipController::class, 'downloadMembershipPdf']);
//Post Api Category Filter Api for club membership listing by Swati Mishra on 04-02-2025
Route::post('/membership/filter', [ClubMembershipController::class, 'filterByClubStatusCategory']);