<?php

use App\Http\Controllers\{
    ProfileController,
    DashboardController,
    ReportController,
    MisController,
    MPropertyIdController,
    CommonController,
    MapController,
    ScriptController,
    RgrController,
    ColonyController,
    SteetviewController,
    MessageTempleteController,
    PropertySectionMappingController,
    AppointmentDetailController,
    AdminPublicGrievanceController,
    ApplicationController,
    ApplicantController,
    OfficialController,
    ChatBotController,
    DeedOfApartmentController,
    OtpController,
    PropertyMergingController,
    PaymentController,
	ConversionController,
    DemandController,
    LandUseChangeCalculationController,
    UnearnedIncreaseController,
    NocController


};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Settings\MailController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Settings\SmsController;
use App\Http\Controllers\Settings\WhatsappController;
use App\Http\Controllers\Settings\ActionController;
use App\Http\Controllers\logistic\PurchaseController;
use App\Http\Controllers\logistic\SupplierVendorDetailsController;
use App\Http\Controllers\logistic\ItemsController;
use App\Http\Controllers\logistic\RequestProcessingController;
use App\Http\Controllers\logistic\IssueController;
use App\Http\Controllers\logistic\CategoryController;
use App\Http\Controllers\application\MutationContoller;
use App\Http\Controllers\application\LandUseChangeController;
use App\Http\Controllers\Admin\{
    ApplicationController as AdminApplicationController
};
use App\Http\Controllers\application\ConversionController as ApplicationConversionController;



// Redirect Route for local system for running in development environment by Adarsh
Route::get('/', function () {
    return redirect('/edharti');
});


Route::prefix('edharti')->group(function () {

    Route::get('test', function () {
       return response()->json([
           'message' => 'API is working!',
           'status' => 200
       ]);
   });
   
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/colony-filter', [DashboardController::class, 'dashbordColonyFilter'])->name('dashbordColonyFilter');
    Route::get('/dashboard/property-type-data/{typeId}/{coonyId?}', [DashboardController::class, 'propertyTypeDetails'])->name('propertyTypeDetails');
	Route::get('/dashboard/main', [DashboardController::class, 'mainDashboard'])->name('dashboard.main')->middleware('permission:main.dashboard');
    Route::post('report/get-distinct-subType', [ReportController::class, 'getDistinctSubTypes'])->name('getDistinctSubTypes');

    Route::post('/dashboard/section-filter', [DashboardController::class, 'dashbordSectionFilter'])->name('dashbordSectionFilter');
    Route::get('/report/colonywise-section-report/{sectionId}', [ReportController::class, 'colonywiseSectionReport'])->name('colonywiseSectionReport');
    Route::get('/dashboard/main', [DashboardController::class, 'mainDashboard'])->name('dashboard.main')->middleware('permission:main.dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
     // Routes for showing unalloted recores By Lalit Tiwari (10/Jan/2025)
     Route::get('/reports/detailed-report', [ReportController::class, 'detailedReport'])->name('detailedReport');

    Route::get('/property-form', [MisController::class, 'index'])->name('mis.index');
    Route::post('/propert-sub-type', [MisController::class, 'prpertySubTypes'])->name('prpertySubTypes');
    Route::post('/property-form/store', [MisController::class, 'store'])->name('mis.store');
	Route::post('/property-form/unallotted/store', [MisController::class, 'unallottedPropertiesStore'])->name('mis.unallottedPropertiesStore'); // Added for unallotted properties - 10-12-2024
    Route::get('/property-form-multiple', [MisController::class, 'misFormMultiple'])->name('mis.form.multiple');
    Route::post('/property-form-multiple/store', [MisController::class, 'misStoreMultiple'])->name('mis.store.multiple');
    Route::get('/property-details', [MisController::class, 'propertDetails'])->name('propertDetails')->middleware('permission:viewDetails');
    Route::post('mis/is-property-available', [MisController::class, 'isMisPropertyAvailable'])->name('isMisPropertyAvailable')->middleware('permission:viewDetails');
    Route::delete('property-destroy/{id}', [MisController::class, 'propertyDestroy'])->name('property.destroy');
    Route::get('/property-details/child/{id}', [MisController::class, 'propertyChildDetails'])->name('propertyChildDetails')->middleware('permission:viewDetails');
    Route::post('/property/search', [MPropertyIdController::class, 'propertySearchById'])->name('propertySearch');
    Route::post('/is-property-available', [MPropertyIdController::class, 'isPropertyAvailable'])->name('isPropertyAvailable');
    Route::get('/tabular-record', [ReportController::class, 'tabularRecord'])->name('tabularRecord');
    Route::get('/property-details/{property}/view', [MisController::class, 'viewDetails'])->name('viewDetails')->middleware('permission:viewDetails');
    Route::get('/property-details/{property}/edit', [MisController::class, 'editDetails'])->name('editDetails')->middleware('permission:viewDetails');
    Route::get('/property-details/{property}/child-edit', [MisController::class, 'editChildDetails'])->name('editChildDetails')->middleware('permission:viewDetails');
    Route::put('/property-details/child/{property}', [MisController::class, 'updateChild'])->name('mis.update.child')->middleware('permission:viewDetails');
    Route::put('/property-details/{property}', [MisController::class, 'update'])->name('mis.update')->middleware('permission:viewDetails');
    Route::get('/property-details/{property}/view-property-details', [MisController::class, 'viewPropertyDetails'])->name('viewPropertyDetails');//->middleware
    Route::get('/download-pdf/{property}', [MisController::class, 'downloadPdf'])->name('download.pdf');

    // lalit ji property status routes
    Route::post('/get-old-property-status/{propertyId}/{propertyStatusId}', [MisController::class, 'getOldPropertyStatusValue'])->name('get.old.property.value');
    Route::post('/property-original-destroy/{id}', [MisController::class, 'destroyOriginalById'])->name('original.destroy');
    Route::post('/property-land-batch-transfer-destroy/{batchId}/{propertyMasterId}', [MisController::class, 'destroyLandTransferByBatchId'])->name('property.land.batch.transfer.destroy');
    Route::post('/property-land-batch-transfer-individual-destroy/{landTransferId}/{batchId}/{propertyMasterId}', [MisController::class, 'destroyLandTransferByIndividualId'])->name('property.land.batch.transfer.individual.destroy');
    Route::post('/soft-delete-old-property-status-record', [MisController::class, 'softDeleteOldPropertyStatusRecord'])->name('soft.delete.old.property.status.record');
    Route::get('/user-actions-logs', [MisController::class, 'actionLogListings'])->name('actionLogListings');
    Route::get('/application/deed-of-apartment-form', [ApplicationController::class, 'create'])->name('application.apartment.create');
    Route::post('/application/deed_of_apartment/store_application_details', [ApplicationController::class, 'store'])->name('application.apartment.store');

      // Applicant Routes added by Lalit on 21/08/2024
      Route::get('applicant/new/properties', [OfficialController::class, 'applicantNewProperties'])->name('applicantNewProperties');
      Route::get('get/applicant/property/listings', [OfficialController::class, 'getApplicantPropertyListings'])->name('get.applicant.property.listings');
      Route::get('applicant/property/{id}/view', [OfficialController::class, 'newPropertyDetails'])->name('applicant.properties.details');
      Route::get('applicant/property/{id}/view/details', [OfficialController::class, 'newPropertyViewDetails'])->name('applicant.properties.view.details');
      Route::put('review/applicant/new/property/{id}', [OfficialController::class, 'reviewApplicantNewProperty'])->name('review.applicant.new.property');
      Route::post('approve/review/applicant/new/property', [OfficialController::class, 'approvedReviewApplicantNewProperty'])->name('approve.review.applicant.new.property');
      Route::put('reject/applicant/new/property/{id}', [OfficialController::class, 'rejectApplicantNewProperty'])->name('reject.applicant.new.property');
      Route::post('approve/applicant/new/property', [OfficialController::class, 'approvedApplicantNewProperty'])->name('approve.applicant.new.property');
      Route::post('approve-mis', [OfficialController::class, 'approveMis'])->name('approveMis');
      Route::post('scanned-files-checked', [OfficialController::class, 'scannedFilesChecked'])->name('scannedFilesChecked');
      Route::post('uploaded-docs-checked', [OfficialController::class, 'uploadedDocsChecked'])->name('uploadedDocsChecked');

      //Routes for checking property id available while doing MIS throug It Cell - Lalit Tiwari - (22/jan/2025)
    Route::post('/search/property/locality_block_plot', [MPropertyIdController::class, 'searchPropThroughLocalityBlockPlot'])->name('searchPropThroughLocalityBlockPlot');
     // Handle form submission routes ajax request for Transfer Property To section - Lalit (23/Jan/2025)
     Route::post('/transfer/property/to/section', [MPropertyIdController::class, 'transferPropertyToSection'])->name('transfer.property.section');
     // Handle form submission routes ajax request for Reject User Registered Property - Lalit (3/March/2025)
     Route::post('/reject/user/registered/property', [OfficialController::class, 'rejectUserRegisteredProperty'])->name('reject.user.registered.property');
 

    //uploaded on live - SOURAV CHAUHAN - 16/Jan/2024 ****************** START *************************
    //applicantion routes - Sourav Chauhan - 12/sep/2024
    Route::get('application/new', [ApplicationController::class, 'newApplication'])->name('new.application')->middleware('permission:apply.application');
        Route::post('updateApllicantStatus', [ApplicationController::class, 'updateApllicantStatus'])->name('updateApllicantStatus');
    Route::post('app-get-property-details', [ApplicationController::class, 'getPropertyDetails'])->name('appGetPropertyDetails');
    Route::post('app-get-property-details-edit', [ApplicationController::class, 'getPropertyDetailsForEdit'])->name('getPropertyDetailsForEdit');
    Route::get('fetch-user-details', [ApplicationController::class, 'fetchUserDetails'])->name('fetchUserDetails');
    Route::post('mutation-step-first', [MutationContoller::class, 'mutationStepFirst'])->name('mutationStepFirst');
    Route::post('upload-file', [ApplicationController::class, 'uploadFile'])->name('uploadFile');
    Route::post('mutation-step-second', [MutationContoller::class, 'mutationStepSecond'])->name('mutationStepSecond');
    Route::post('mutation-step-third', [MutationContoller::class, 'mutationStepThird'])->name('mutationStepThird');
    Route::get('applications/draft', [ApplicationController::class, 'draftApplications'])->name('draftApplications');
    Route::post('delete-application', [ApplicationController::class, 'deleteApplication'])->name('deleteApplication');
    Route::get('getDraftApplications', [ApplicationController::class, 'getDraftApplications'])->name('getDraftApplications');
    Route::get('applications/draft/{id}', [ApplicationController::class, 'getDraftApplication'])->name('getApplication.draft');
    Route::get('applications/edit/{id}', [ApplicationController::class, 'getEditApplications'])->name('getApplication.edit');
    Route::get('applications/history/details', [ApplicationController::class, 'applicationsHistoryDetails'])->name('applications.history.details');
    Route::get('getHistoryApplications', [ApplicationController::class, 'getHistoryApplications'])->name('getHistoryApplications');
    Route::post('is-property-free', [ApplicationController::class, 'isPropertyFree'])->name('isPropertyFree');
    Route::post('withdraw-application', [ApplicationController::class, 'withdrawApplication'])->name('withdrawApplication')->middleware('permission:withdraw.application');
    Route::get('applications/history/withdraw', [ApplicationController::class, 'applicationsWithdrawDetails'])->name('applications.history.withdraw.details');
    Route::get('getWithdrawApplications', [ApplicationController::class, 'getWithdrawApplications'])->name('getWithdrawApplications');
    /** To delete a uploaded documnent -- Added By Nitin On - 06 Nov 2024*/
    Route::post('delete-uploaed-document', [ApplicationController::class, 'deleteUploadedTempDocument'])->name('deleteUploadedTempDocument');
    /** To delete a uploaded documnent -- Added By Nitin On - 07 Nov 2024*/
    Route::post('delete-temp-coapplicant', [ApplicationController::class, 'deleteTempCoapplicant'])->name('deleteTempCoapplicant');
    /** To forward application to other department -- Added By Lalit On - 25 Nov 2024*/
    Route::post('applications/forward/department', [AdminApplicationController::class, 'forwardApplicationToDepartment'])->name('forwardApplicationToDepartment');
    /** To revert application to assignee -- Added By Lalit On - 26 Nov 2024*/
    Route::post('applications/revert/assignee', [AdminApplicationController::class, 'revertApplicationToAssignee'])->name('revertApplicationToAssignee');

    /**Land use change application added by Nitin */
    Route::post('/application/fetch-luc-details', [LandUseChangeController::class, 'fetchLandUseChangeDetails'])->name('fetchLandUseChangeDetails');
    Route::post('/application/luc-step-1', [LandUseChangeController::class, 'step1Submit'])->name('step1Submit');
    Route::post('/application/luc-step-2', [LandUseChangeController::class, 'step2Submit'])->name('step2Submit');

    /**Conversion Application routes added by Nitin */
    Route::post('/conversion/step-1', [ApplicationConversionController::class, 'step1submit'])->name('conversionStep1');
    Route::post('/conversion/step-2', [ApplicationConversionController::class, 'step2submit'])->name('conversionStep2');
    Route::post('/conversion/step-3', [ApplicationConversionController::class, 'step3submit'])->name('conversionStep3');

    /**NOC Application routes added by Lalit Tiwari (17/March/2025) */
    Route::post('noc-step-first', [NocController::class, 'nocStepFirst'])->name('nocStepFirst');
    Route::post('noc-final-step', [NocController::class, 'nocFinalStep'])->name('nocFinalStep');

    Route::post('/doa-step-first', [DeedOfApartmentController::class, 'deedOfApartmentStepFirstStore'])->name('doa.step.first');
    Route::post('/doa-step-final', [DeedOfApartmentController::class, 'deedOfApartmentStepFinalStore'])->name('doa.step.final');

    /** Update application -- Added By Lalit On - 02 Dec 2024*/
    Route::post('application/update', [AdminApplicationController::class, 'updateApplication'])->name('updateApplication');
    //uploaded on live - SOURAV CHAUHAN - 16/Jan/2024 ************* END *******************




      //Add by lalit on 29/07/2024 to show register user listing
    Route::get('register/users', [OfficialController::class, 'index'])->name('regiserUserListings')->middleware('permission:view.register.user.listings');
    Route::get('get/registered/users', [OfficialController::class, 'getRegisteredUsers'])->name('get.registered.users');
    Route::get('register/user/{id}/view', [OfficialController::class, 'details'])->name('register.user.details');
    Route::get('register/user/{id}/view/details', [OfficialController::class, 'viewDetails'])->name('register.user.view.details');
    Route::put('registration/status/{id}', [OfficialController::class, 'updateStatus'])->name('update.registration.status');
    Route::post('check/property/exists', [OfficialController::class, 'checkProperty'])->name('register.user.checkProperty');
    // Route::post('register/user/{id}/', [OfficialController::class, 'checkProperty'])->name('register.user.checkProperty');
    Route::post('approve/user/registration', [OfficialController::class, 'approvedUserRegistration'])->name('approve.user.registration');
    Route::put('register/user/{id}', [OfficialController::class, 'rejectUserRegistration'])->name('reject.user.registration');
    Route::put('review/user/registration/{id}', [OfficialController::class, 'reviewUserRegistration'])->name('review.user.registration');
    Route::post('approve/review/application', [OfficialController::class, 'approvedReviewApplication'])->name('approve.review.application');

    Route::get('flats', [OfficialController::class, 'flats'])->name('flats');
    Route::get('get/flats', [OfficialController::class, 'getFlats'])->name('get.flats');
    Route::get('mis/add-flat/{applicationMovementId?}', [OfficialController::class, 'createFlatForm'])->name('create.flat.form');
    // Route::get('flat-form', [OfficialController::class, 'createFlatForm'])->name('create.flat.form');
    Route::post('flat/store_flat_details', [OfficialController::class, 'storeFlatDetails'])->name('store.flat.details');
    Route::post('flat/update_flat_details', [OfficialController::class, 'updateFlatDetails'])->name('update.flat.details');
    Route::get('/flat/{id}/view', [OfficialController::class, 'viewFlatDetails'])->name('viewFlatDetails');
    Route::get('/flat/{id}/edit', [OfficialController::class, 'editFlatDetails'])->name('editFlatDetails');
    Route::post('flat/delete', [OfficialController::class, 'flatDestroy'])->name('flat.destroy');
    Route::get('/appointments', [AppointmentDetailController::class, 'index'])->name('appointments.index');
    Route::get('/admin-grievances', [AdminPublicGrievanceController::class, 'create'])->name('grievance.create');
    Route::get('applicant/profile', [ApplicantController::class, 'index'])->name('applicant.profile');
    Route::get('application/new', [ApplicationController::class, 'newApplication'])->name('new.application');
    Route::get('applicant/property/details', [ApplicantController::class, 'propertiesDetails'])->name('applicant.properties')->middleware('role:applicant');
    Route::get('application/history', [ApplicantController::class, 'applicationHistory'])->name('application.history');

    Route::post('applicant/property/store', [ApplicantController::class, 'storeNewProperty'])->name('applicant.properties.store');

    /**route added by Nitin to book applicant appointment  20/Nov/24*/
    Route::get('applicant/appointment/{applicationId}/{timestamp}', [ApplicantController::class, 'appointment'])->name('applicant.apppointment');
    Route::get('applicant/getappointments', [ApplicantController::class, 'getappointments'])->name('applicant.getappointments');
    Route::post('applicant/book-appointment', [ApplicantController::class, 'bookAppointment'])->name('applicant.bookAppointment');
    Route::post('applicant/delete-alues-for-unchecked-document', [ApplicantController::class, 'deleteValuesForUncheckedDocument'])->name('applicant.deleteValuesForUncheckedDocument');

    //appointment
    Route::get('/appointments', [AppointmentDetailController::class, 'index'])->name('appointments.index')->middleware('permission:view.appointment');
    Route::get('getAppointments', [AppointmentDetailController::class, 'getAppointments'])->name('get.appointments');
    Route::patch('/appointments/update-status/{id}', [AppointmentDetailController::class, 'updateStatus'])->name('appointments.updateStatus');
    Route::patch('/appointments/update-attendance/{id}', [AppointmentDetailController::class, 'updateAttendance'])->name('appointments.updateAttendance');

    //admin-grievance
    Route::get('/admin-grievances', [AdminPublicGrievanceController::class, 'create'])->name('grievance.create')->middleware('permission:add.grievance');
    Route::post('/grievance/store-initial', [AdminPublicGrievanceController::class, 'storeInitial'])->name('grievance.storeInitial');
    Route::post('/grievance/upload-recording', [AdminPublicGrievanceController::class, 'uploadRecording'])->name('grievance.uploadRecording');

    Route::post('/grievance/store', [AdminPublicGrievanceController::class, 'store'])->name('grievance.store');

    // Display the index DataTable view
    Route::get('/grievances', [AdminPublicGrievanceController::class, 'index'])->name('grievance.index')->middleware('permission:view.grievance');

    // Handle DataTables server-side processing
    Route::get('/grievances/list', [AdminPublicGrievanceController::class, 'getGrievances'])->name('grievance.getGrievances');

    Route::get('grievance/edit/{id}', [AdminPublicGrievanceController::class, 'edit'])->name('grievance.edit')->middleware('permission:edit.grievance');
    Route::put('grievance/update/{id}', [AdminPublicGrievanceController::class, 'update'])->name('grievance.update');
    Route::get('grievances/{id}/remarks', [AdminPublicGrievanceController::class, 'showRemarks'])->name('admin_public_grievances.remarks');

    Route::put('/grievance/update-remarks/{id}', [AdminPublicGrievanceController::class, 'updateRemarks'])->name('admin_public_grievances.update_remarks');
    Route::get('/grievances/details/{id}', [AdminPublicGrievanceController::class, 'getGrievanceDetails'])->name('grievance.details');


    //uploaded on live - SOURAV CHAUHAN - 16/Jan/2024m *************************** START ************************
    //applications route at admin side - SOURAV cHAUHAN (11/oct/2024)
    Route::get('admin/applications', [AdminApplicationController::class, 'index'])->name('admin.applications')->middleware('permission:view.applications');
    Route::get('getApplications', [AdminApplicationController::class, 'getApplications'])->name('admin.getApplications')->middleware('permission:view.applications');
    Route::get('getApplicationsAssignedToUser', [AdminApplicationController::class, 'getApplicationsAssignedToUser'])->name('admin.getApplicationsAssignedToUser')->middleware('permission:view.applications');
    Route::get('applications/{id}', [AdminApplicationController::class, 'view'])->name('applications.view')->middleware('permission:view.applications');
    Route::post('upload-file-for-cdv', [AdminApplicationController::class, 'uploadFileforCdv'])->name('uploadFileforCdv');
    Route::post('delete-file-for-cdv', [AdminApplicationController::class, 'deleteFileforCdv'])->name('deleteFileforCdv');
    Route::post('save-official-documents', [AdminApplicationController::class, 'saveOfficialDocs'])->name('saveOfficialDocs');
       // Received & Disposed Applications Routes - Lalit Tiwari (27/Feb/2025)
   Route::get('admin/applications/disposed', [AdminApplicationController::class, 'applicationsDisposed'])->name('applications.disposed');
   Route::get('getApplicationsDisposed', [AdminApplicationController::class, 'getApplicationsDisposed'])->name('get.applications.disposed');
    //route added by nitin for technical users

    Route::get('admin/applicationsAssignedToUser/{onlyCurrentApplicatinos?}', [AdminApplicationController::class, 'applicationsAssignedToUser'])->name('admin.applicationsAssignedToUser')->middleware('permission:view.applications');

    // for application actions by official users
    Route::post('applications/action', [AdminApplicationController::class, 'applicationAction'])->name('applications.action')->middleware('permission:applications.action');
    Route::post('applications/get/movements', [AdminApplicationController::class, 'getFileMovements'])->name('applications.get.movements')->middleware('permission:view.applications');
    Route::get('applications/{appNo}/movement', [AdminApplicationController::class, 'getFileMovements'])->name('applications.movements')->middleware('permission:view.applications');
    Route::get('applications/movement/new', [AdminApplicationController::class, 'newgetFileMovements'])->name('applications.new.movements');
    Route::post('applications/checklist', [AdminApplicationController::class, 'checklist'])->name('applications.checklist')->middleware('permission:applications.action');
    Route::post('applications/upload-signed-letter', [AdminApplicationController::class, 'uploadSignedLetter'])->name('uploadSignedLetter');
    Route::get('applications/{id}/start-proof-reading', [AdminApplicationController::class, 'startProofReading'])->name('startProofReading');
    Route::post('applications-object-remark', [AdminApplicationController::class, 'applicationsObjectRemark'])->name('applications.object.remark');

    //Routes for Property Transfer - Lalit (5/March/2025)
    Route::get('miscellaneous/property-transfer', [OfficialController::class, 'miscPropertyTransfer'])->name('miscellaneous.property.transfer')->middleware('permission:miscellaneous.property.transfer');
    Route::post('property-transfer-section', [OfficialController::class, 'propertyTransferSection'])->name('property.transfer.section');
  
    //Send Application Meeting Url to the Applicant Route - Lalit Ji - (22/Nov/2024)
    Route::post('applications/appointment/link', [AdminApplicationController::class, 'sendAppointmentLinkToApplicant'])->name('applications.send.appointment.link');

    Route::post('app-get-flat-details', [ApplicationController::class, 'appGetFlatDetails'])->name('appGetFlatDetails');
    //uploaded on live - SOURAV CHAUHAN - 16/Jan/2024m *************************** END ************************

    Route::post('request-edit-mis', [OfficialController::class, 'requestEditMis'])->name('requestEditMis');
    Route::get('mis/update/request/list', [OfficialController::class, 'misUpdateRequestList'])->name('misUpdateRequestList')->middleware('permission:section.property.mis.update.request');
    Route::get('getUpdatePropertyDetailsList', [OfficialController::class, 'getUpdatePropertyDetailsList'])->name('get.update.property.details.list');
    Route::post('allowEditPermission', [OfficialController::class, 'allowEditPermission'])->name('allow.edit.permission');

    //route added by Nitin to get details of a property

    Route::post('/property-basic-detail', [CommonController::class, 'propertyBasicdetail'])->name('propertyCommonBasicdetail');

    Route::post('property-details/export', [ReportController::class, 'detailsExport'])->name('detailsExport');
	
	//Filter report routes moved from Admin group to auth only by Amita [12-02-2025]
	Route::post('report/filter', [ReportController::class, 'getPropertyResults'])->name('getPropertyResults');
	Route::post('report/get-distinct-subType', [ReportController::class, 'getDistinctSubTypes'])->name('getDistinctSubTypes');
	Route::post('report/export', [ReportController::class, 'reportExport'])->name('reportExport');
	
       Route::get('/reports/unalloted-properties', [ReportController::class, 'unallotedPropertyView'])->name('unallotedReport');

        Route::get('get/properties/unalloted', [ReportController::class, 'getUnallotedProperties'])->name('getUnallotedProperties');
    Route::group(['middleware' => ['isAdmin']], function () {
        Route::get('/logistic/items', [ItemsController::class, 'index'])->name('logistic.index');
        Route::get('/logistic/items/add', [ItemsController::class, 'create'])->name('logistic.create');
        Route::post('/logistic_items', [ItemsController::class, 'store'])->name('logistic_items.store');
        Route::post('/logistic/items/update', [ItemsController::class, 'update'])->name('logistic_items.update');
        Route::post('/logistic/items/updatelabel', [ItemsController::class, 'updatelabel'])->name('updatelabel');
        // Route::get('/logistic/items/{roleId}/delete', [ItemsController::class, 'destroy'])->name('logistic.delete');
        Route::get('logistic/items/{itemId}/update-status', [ItemsController::class, 'updateStatus'])->name('items.updateStatus');
        Route::get('/logistic/items/{id}/edit', [ItemsController::class, 'edit'])->name('logistic.edit');
        Route::put('/logistic/items/{id}', [ItemsController::class, 'update'])->name('logistic.update');
        Route::get('/logistic/items/autocomplete', [ItemsController::class, 'autocomplete'])->name('items.autocomplete');

        Route::get('/logistic/category', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/logistic/category/update', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/logistic/category/add', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/logistic_category', [CategoryController::class, 'store'])->name('logistic_category.store');
        Route::post('logistic/category/{itemId}/update-status', [CategoryController::class, 'updateStatus'])->name('category.updateStatus');
        // Route::get('/logistic/category/{roleId}/delete', [CategoryController::class, 'destroy'])->name('logisticCategory.delete');
        Route::get('/logistic/category/autocomplete', [CategoryController::class, 'autocomplete'])->name('category.autocomplete');
        Route::post('/logistic/category/check-name', [CategoryController::class, 'checkName'])->name('logistic_category.checkName');
        // routes/web.php or routes/api.php
        Route::get('/check-contact/{contact_no}', [SupplierVendorDetailsController::class, 'checkContact'])->name('check.contact');
        Route::get('/check-email/{email}', [SupplierVendorDetailsController::class, 'checkEmail'])->name('check.email');
    

        Route::get('/logistic/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
        Route::get('getPurchaseItems', [PurchaseController::class, 'getPurchaseItems'])->name('get.purchase.items');
        Route::get('/logistic/purchase/add', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::post('/logistic_purchase', [PurchaseController::class, 'store'])->name('logistic_purchase.store');
        Route::get('/logistic/purchase/{roleId}/delete', [PurchaseController::class, 'destroy']);
        Route::get('/logistic/purchase/{id}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
        Route::put('/logistic/purchase/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
        Route::get('/logistic/available-units/{logisticItemId}', [PurchaseController::class, 'getAvailableUnits']);


        Route::get('/logistic/history', [PurchaseController::class, 'indexHistory'])->name('purchaseHistory.index');
        Route::get('getLogisticHistories', [PurchaseController::class, 'getLogisticHistories'])->name('get.logistic.histories');
        Route::get('/logistic/stock', [PurchaseController::class, 'stockIndex'])->name('purchaseStock.index');


        Route::get('/logistic/issued-item', [IssueController::class, 'create'])->name('issued_item.create');
        Route::post('/logistic/issued-item', [IssueController::class, 'store'])->name('issued_item.store');
        Route::get('/get-available-units/{id}', [PurchaseController::class, 'getAvailableUnits']);
        // Route::post('/logistic/issued-item/{issuedItem}', [IssueController::class, 'update'])->name('issued_item.update');
        // Route::get('/logistic/issued-items', [IssueController::class, 'index'])->name('issued_item.index');
        // Route::post('/logistic/issued-items/update', [IssueController::class, 'updateEditable']);

        Route::get('/logistic/requested-items', [RequestProcessingController::class, 'index'])->name('requested_item.index');
        Route::get('getLogisticRequestItems', [RequestProcessingController::class, 'getLogisticRequestItems'])->name('get.logistic.request.items');
        Route::get('/logistics/request/{requestId}/create', [RequestProcessingController::class, 'create'])->name('request.create');
        Route::post('/logistics/request/{requestId}/update', [RequestProcessingController::class, 'updateStatus'])->name('request.update');


        Route::get('/logistic/vendor', [SupplierVendorDetailsController::class, 'index'])->name('supplier.index');
        Route::get('/logistic/vendor/add', [SupplierVendorDetailsController::class, 'create'])->name('supplier.create');
        Route::post('/supplier_vendor_details', [SupplierVendorDetailsController::class, 'store'])->name('supplier_vendor_details.store');
        // Route::get('/logistic/vendor/{roleId}/delete', [SupplierVendorDetailsController::class, 'destroy']);
        Route::get('logistic/vendor/{itemId}/update-status', [SupplierVendorDetailsController::class, 'updateStatus'])->name('supplier.updateStatus');
        Route::get('/logistic/vendor/{id}/edit', [SupplierVendorDetailsController::class, 'edit'])->name('supplier.edit');
        Route::put('/logistic/vendor/{id}', [SupplierVendorDetailsController::class, 'update'])->name('supplier.update');
        
        
        //Permissions
        Route::resource('permissions', App\Http\Controllers\PermissionController::class);
        Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    
        //Roles
        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole'])->name('roles.addPermission');;
        Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole'])->name('roles.givePermission');;

        //Users
        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::get('getUserList', [App\Http\Controllers\UserController::class, 'getUserList'])->name('getUserList');
        Route::get('users/delete/{userId}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.delete')->middleware('permission:delete user');
        Route::get('users/{id}/status', [App\Http\Controllers\UserController::class, 'status'])->name('user.status')->middleware('permission:status.user');
        Route::get('users/update-user-details/{id}', [App\Http\Controllers\UserController::class, 'updateUserDetails'])->name('user.details.update');
        Route::put('/users/permission/update/{id}', [App\Http\Controllers\UserController::class, 'updateUser'])->name('user.permission.update');
        Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');

        
        // Routes for showing unalloted recores By Lalit Tiwari (10/Jan/2025)
        // Route::get('/reports/detailed-report', [ReportController::class, 'detailedReport'])->name('detailedReport');
  
  
       
 
        Route::get('/reports/customized-report', [ReportController::class, 'customizeReport'])->name('customizeReport');
        Route::get('/reports/get-customized-report-data', [ReportController::class, 'getCustomizeReportData'])->name('get.customized.reports.data');
     
        Route::group(['middleware' => ['can:create.rgr']], function () {
            Route::get('rgr', [RgrController::class, 'index'])->name('rgr');
            Route::get('rgr-single-property', [RgrController::class, 'singlePropertyRGRInput'])->name('singlePropertyRGRInput');
            Route::get('rgr-colony', [RgrController::class, 'rgrColony'])->name('rgrColony');
    
            Route::post('rgr/create', [RgrController::class, 'create'])->name('createRgr');
            Route::post('rgr/calculate', [RgrController::class, 'calculateGroundRent'])->name('calculateGroundRent');
    
            Route::post('rgr/check-area-chnaged', [RgrController::class, 'checAreaChanged'])->name('checAreaChanged');
            Route::post('rgr/check-property-status-chnaged', [RgrController::class, 'checkPropertyStatusChanged'])->name('checkPropertyStatusChanged');
            Route::post('rgr/save-edited-rgr', [RgrController::class, 'saveEditedRGR'])->name('saveEditedRGR');
            Route::post('rgr/edit-multiple-rgr', [RgrController::class, 'editMultipleRGR'])->name('editMultipleRGR');
            Route::get('rgr/complete-list/{id?}', [RgrController::class, 'completeList'])->name('completeList');
        });
        Route::group(['middleware' => ['can:view.rgr.list']], function () {
            Route::get('rgr/list', [RgrController::class, 'list'])->name('rgrList');
            Route::get('rgr/property-rgr-details', [RgrController::class, 'rgrDetailsForProperty'])->name('rgrDetailsForProperty');
        });
        Route::group(['middleware' => ['can:create.rgr.draft']], function () {
            Route::get('rgr/save-as-pdf/{id}', [RgrController::class, 'saveAsPdf'])->name('saveAsPdf');
            Route::post('rgr/save-multiple-pdf', [RgrController::class, 'saveMultiplePdf'])->name('saveMultiplePdf');
        });
        Route::group(['middleware' => ['can:send.rgr.draft']], function () {
            Route::get('rgr/send-draft/{rgrId}', [RgrController::class, 'sendDraft'])->name('sendDraft');
            Route::post('rgr/send-multiple-draft', [RgrController::class, 'sendMultipleDrafts'])->name('sendMultipleDrafts');
        });
        Route::post('rgr/colony-rgr', [RgrController::class, 'reviseGroundRentForColony'])->name('reviseGroundRentForColony');
        Route::get('rgr/view-draft/{rgrId}', [RgrController::class, 'viewDraft'])->name('viewDraft');
        Route::get('rgr/status-change-list', [RgrController::class, 'statusChangeList'])->name('statusChangeList');
        Route::get('rgr/area-change-list', [RgrController::class, 'areaChangeList'])->name('areaChangeList');
        Route::get('rgr/reentered-list', [RgrController::class, 'reenteredList'])->name('reenteredList');
        
        Route::post('rgr/property-basic-detail', [RgrController::class, 'propertyBasicdetail'])->name('propertyBasicdetail');
        Route::post('rgr/colony-details', [RgrController::class, 'colonyRGRDetails'])->name('colonyRGRDetails');
    


           //Communication Templates
           Route::get('/message-templates', [MessageTempleteController::class, 'show'])->name('msgtempletes');
           Route::get('getMessageTemplateListing', [MessageTempleteController::class, 'getMessageTemplateListing'])->name('getMessageTemplateListing');
           Route::get('/template/use/{id}', [MessageTempleteController::class, 'useTemplate'])->name('template.use');
           Route::put('/templates/{id}', [MessageTempleteController::class, 'update'])->name('templates.update')->defaults('skipSanitization', true);
           Route::get('/template/status/{id}', [MessageTempleteController::class, 'updateStatus'])->name('template.status');
           Route::get('/templates/create', [MessageTempleteController::class, 'create'])->name('templates.create');
           Route::post('/templates', [MessageTempleteController::class, 'store'])->name('templates.store')->defaults('skipSanitization', true);


        //Common Activities
        Route::get('change-date', [App\Http\Controllers\CommonController::class, 'changeLeaseExpirationDate'])->name('changeLeaseExpirationDate'); //To update the expiration date -- 22-05-2024

        //2 sep 2024 By sourav
         //settings*************************************************************
        //Mail
        Route::get('/setting/mail', [MailController::class, 'index'])->name('settings.mail.index');
        Route::get('/setting/mail/create', [MailController::class, 'create'])->name('settings.mail.create');
        Route::post('/setting/mail/store', [MailController::class, 'store'])->name('settings.mail.store');
        Route::get('/setting/mail/status/{id}', [MailController::class, 'updateStatus'])->name('settings.mail.status')->middleware('permission:settings.mail.status');
        Route::get('/setting/mail/{id}', [MailController::class, 'edit'])->name('settings.mail.edit')->middleware('permission:settings.mail.update');
        Route::put('/setting/mail/{id}', [MailController::class, 'update'])->name('settings.mail.update')->middleware('permission:settings.mail.update');
        Route::get('/setting/mail/{id}/test', [MailController::class, 'mailTest'])->name('settings.mail.mailTest');

                // Import data from excel
                Route::get('/import', [ImportController::class, 'showImportForm'])->name('import.form');
                Route::post('/import', [ImportController::class, 'importTable'])->name('import.table');

        //Sms
        Route::get('/setting/sms', [SmsController::class, 'index'])->name('settings.sms.index');
        Route::get('/setting/sms/create', [SmsController::class, 'create'])->name('settings.sms.create');
        Route::post('/setting/sms/store', [SmsController::class, 'store'])->name('settings.sms.store');
        Route::get('/setting/sms/status/{id}', [SmsController::class, 'updateStatus'])->name('settings.sms.status')->middleware('permission:settings.sms.status');
        Route::get('/setting/sms/{id}', [SmsController::class, 'edit'])->name('settings.sms.edit')->middleware('permission:settings.sms.update');
        Route::put('/setting/sms/{id}', [SmsController::class, 'update'])->name('settings.sms.update')->middleware('permission:settings.sms.update');
        Route::get('/setting/sms/{id}/test', [SmsController::class, 'smsTest'])->name('settings.sms.smsTest');


        //Whatsapp
        Route::get('/setting/whatsapp', [WhatsappController::class, 'index'])->name('settings.whatsapp.index');
        Route::get('/setting/whatsapp/create', [WhatsappController::class, 'create'])->name('settings.whatsapp.create');
        Route::post('/setting/whatsapp/store', [WhatsappController::class, 'store'])->name('settings.whatsapp.store');
        Route::get('/setting/whatsapp/status/{id}', [WhatsappController::class, 'updateStatus'])->name('settings.whatsapp.status')->middleware('permission:settings.whatsapp.status');
        Route::get('/setting/whatsapp/{id}', [WhatsappController::class, 'edit'])->name('settings.whatsapp.edit')->middleware('permission:settings.whatsapp.update');
        Route::put('/setting/whatsapp/{id}', [WhatsappController::class, 'update'])->name('settings.whatsapp.update')->middleware('permission:settings.whatsapp.update');
        Route::get('/setting/whatsapp/{id}/test', [WhatsappController::class, 'whatsappTest'])->name('settings.whatsapp.whatsappTest');


        //actions
        Route::get('/setting/action', [ActionController::class, 'index'])->name('settings.action.index');
        Route::get('/setting/action/create', [ActionController::class, 'create'])->name('settings.action.create');
        Route::post('/setting/action/store', [ActionController::class, 'store'])->name('settings.action.store');
        Route::get('/setting/action/{id}', [ActionController::class, 'index'])->name('settings.action.edit')->middleware('permission:settings.action.update');
        Route::put('/setting/action/{id}', [ActionController::class, 'update'])->name('settings.action.update')->middleware('permission:settings.action.update');

         //property assignment routes
         Route::get('/property-assignment', [PropertySectionMappingController::class, 'propertyAssignment'])->name('propertyAssignment');
         Route::post('/get-all-property-types', [PropertySectionMappingController::class, 'getAllPropertyTypes'])->name('getAllPropertyTypes');
         Route::post('/property-assignment', [PropertySectionMappingController::class, 'propertyAssignmentStore'])->name('propertyAssignmentStore');
         Route::post('/i-colony-assigned-to-section', [PropertySectionMappingController::class, 'isColonyAssignedToSection'])->name('isColonyAssignedToSection');

          //property merging routes
          Route::get('/colony-merger', [PropertyMergingController::class, 'create'])->name('colony.merger.create');
        Route::post('/colony/merge', [PropertyMergingController::class, 'merge'])->name('colony.merge');
        Route::get('/colony/property-count', [PropertyMergingController::class, 'getPropertyCount'])->name('colony.propertyCount');

    });
	
    Route::get('rgr/properties-in-block/{colonyId}/{blockId}/{leaseHoldOnly?}', [RgrController::class, 'propertiesInBlock'])->name('propertiesInBlock');
    Route::get('rgr/blocks-in-colony/{colonyId}/{leaseHoldOnly?}', [RgrController::class, 'blocksInColony'])->name('blocksInColony');
	//Again added routes for the calculator --Amita [21-01-2025]
	//Routes related to calculator
	Route::group(['middleware' => ['can:calculate.conversion']], function () {
        Route::get('/conversion/calculate-charges', [ConversionController::class, 'calculateConversionCharges'])->name('calculateConversionCharges');
        Route::get('conversion/charges-for-property', [ConversionController::class, 'chargesForProperty'])->name('chargesForProperty');
    });
	
	Route::group(['middleware' => ['can:calculate.landUseChange']], function () {
        Route::get('land-use-change/calculate-charges', [LandUseChangeCalculationController::class, 'calculateLandUseChangeCharges'])->name('calculateLandUseChangeCharges');
        Route::get('land-use-change/property-type-options/{propertyId}', [LandUseChangeCalculationController::class, 'propertyTypeOptions'])->name('propertyTypeOptions');
    });
    Route::group(['middleware' => ['can:calculate.unearnedIncrease']], function () {
        Route::get('unearned-increase', [UnearnedIncreaseController::class, 'index'])->name('calculateUnearnedIncrease');
        Route::get('unearned-increase/property-details/{propertyId}', [UnearnedIncreaseController::class, 'propertyDetails'])->name('calculateUnearnedIncreaseForProperty');
    });
	
	//End of Calculator routes
	/** create demand routes added by Nitin 30-12-2024 */
    Route::group(['middleware' => ['permission:create.demand']], function () {
        Route::get('/demand', [DemandController::class, 'createDemandView'])->name('createDemandView');
        Route::get('/demand/edit/{demandId}', [DemandController::class, 'EditDemand'])->name('EditDemand');
        Route::get('/demand/view/{demandId}', [DemandController::class, 'ViewDemand'])->name('ViewDemand');
        Route::get('/demand/withdraw/{demandId}', [DemandController::class, 'withdrawDemand'])->name('withdrawDemand');
        Route::get('/demand/approve/{demandId}', [DemandController::class, 'ApproveDemand'])->name('ApproveDemand');
        Route::get('/demand/getExistingPropertyDemand/{oldPropertyId}', [DemandController::class, 'getExistingPropertyDemand'])->name('getExistingPropertyDemand');
        Route::post('/demand/store', [DemandController::class, 'storeDemand'])->name('storeDemand');
        Route::get('/demand/index', [DemandController::class, 'index'])->name('demandList');
        Route::get('/demand/create-applicationDemand/{applicationNo}', [DemandController::class, 'createApplicationDemand'])->name('createApplicationDemand');
        Route::get('/demand/old-demand-data/{oldDemands}', [DemandController::class, 'oldDemandData'])->name('oldDemandData');
        Route::get('/demand/get-demand-heads/{newAllotment}', [DemandController::class, 'getDemandHeads'])->name('getDemandHeads');
        Route::get('/demand/get-land-value-at-date', [CommonController::class, 'getLandValueAtDate'])->name('getLandValueAtDate');
        // Route::get('/demand/manual-demand-create', [DemandController::class, 'manualDemandCreate'])->name('manualDemandCreate');
        Route::get('/land-use-change/commercial-land-value/{propertyId}', [LandUseChangeCalculationController::class, 'getCommercialLandValue'])->name('getCommercialLandValue');

         # Added new route to display demand dues against each property in filter report through ajax - Swati Mishra (11-04-2025)
        Route::post('/get-demand-details', [ReportController::class, 'getDemandDetails'])->name('getDemandDetails');
    });

    Route::get('/applicant/pending-demands', [DemandController::class, 'applicantPendingDemands'])->name('applicant.pendingDemands');
    Route::get('/applicant/view-demand/{demandId}', [DemandController::class, 'applicantViewDemand'])->name('applicant.viewDemand');
    Route::get('/applicant/pay-demand/{demandId}', [DemandController::class, 'applicantPayForDemand'])->name('applicant.payForDemand');

    Route::group(['middleware' => ['can:calculate.landUseChange']], function () {
        Route::get('land-use-change/calculate-charges', [LandUseChangeCalculationController::class, 'calculateLandUseChangeCharges'])->name('calculateLandUseChangeCharges');
        Route::get('land-use-change/property-type-options/{propertyId}', [LandUseChangeCalculationController::class, 'propertyTypeOptions'])->name('propertyTypeOptions');
        //Route::get('landUseChange/charges-for-property/{propertyId}', [ConversionController::class, 'chargesForProperty'])->name('chargesForProperty');
    });
    Route::group(['middleware' => ['can:calculate.unearnedIncrease']], function () {
        Route::get('unearned-increase', [UnearnedIncreaseController::class, 'index'])->name('calculateUnearnedIncrease');
        Route::get('unearned-increase/property-details/{propertyId}', [UnearnedIncreaseController::class, 'propertyDetails'])->name('calculateUnearnedIncreaseForProperty');
        //Route::get('land-use-change/property-type-options/{propertyId}', [LandUseChangeCalculationController::class, 'propertyTypeOptions'])->name('propertyTypeOptions');
        //Route::get('landUseChange/charges-for-property/{propertyId}', [ConversionController::class, 'chargesForProperty'])->name('chargesForProperty');
    });

    /**Application payments -- added by Nitin on 28-01-2025 */
    Route::get('/application-payment/{modelName}/{modelId}', [PaymentController::class, 'applicationPayment'])->name('applicationPayment');
    Route::post('/application-payment', [PaymentController::class, 'applicationPaymentSubmit'])->name('applicationPaymentSubmit');

});
Route::post('/propert-sub-type', [MisController::class, 'prpertySubTypes'])->name('prpertySubTypes');

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';

Route::get('/update-land-value', [ScriptController::class, 'updateLandRates'])->name('updateLandRates');
Route::get('/update-land-value/{id}', [ScriptController::class, 'updateLandValue'])->name('updateLandValue');
Route::get('/update-land-value-in-child/{id}', [ScriptController::class, 'updateLandValueInChild'])->name('updateLandValueInChild');
Route::get('/update-rgr-date/{id}', [ScriptController::class, 'updateGrDurationAndDate'])->name('updateGrDurationAndDate');
Route::get('/update-current-lessee/{id}', [ScriptController::class, 'updateCurrentLessee'])->name('updateCurrentLessee');
// Routes addded by amita srivastava on 13 january 2025
Route::get('/update-current-lessee-of-leased-property', [ScriptController::class, 'updateCurrentLesseeOfLeasedProperty'])->name('updateCurrentLesseeOfLeasedProperty');
//Route for flat rates update script
Route::get('/update-flat-rates', [ScriptController::class, 'updateExistingFlatsRateAndValue']);

Route::get('map', [MapController::class, 'map'])->name('map');
Route::get('/streetview/{id}', [SteetviewController::class, 'map'])->name('streetview');
Route::get('/download/{file}', [ReportController::class, 'download']);

Route::middleware('guest')->group(function () {
    Route::get('/public-register', [RegisteredUserController::class, 'publicRegister'])->name('publicRegister');
    Route::post('/public-register', [RegisteredUserController::class, 'publicRegisterCreate'])->name('publicRegisterCreate');
    Route::post('/save-otp', [RegisteredUserController::class, 'saveOtp'])->name('saveOtp');
    Route::post('/send-login-otp', [AuthenticatedSessionController::class, 'sendLoginOtp'])->name('sendLoginOtp');
    Route::post('/verifyLoginOtp', [AuthenticatedSessionController::class, 'verifyLoginOtp'])->name('verifyLoginOtp');
    Route::post('/verify-otp', [RegisteredUserController::class, 'verifyOtp'])->name('verifyOtp')->middleware('throttle:otp-verify');
    Route::post('/locality-blocks', [ColonyController::class, 'localityBlocks'])->name('localityBlocks');
    Route::post('/block-plots', [ColonyController::class, 'blockPlots'])->name('blockPlots');
    Route::post('/plot-knownas', [ColonyController::class, 'plotKnownas'])->name('plotKnownas');
	// Routes for Resent OTP - Lalit (25/Oct/2024)
    Route::post('/resend-otp', [RegisteredUserController::class, 'reSendOtp'])->name('reSendOtp')->middleware('throttle:otp-resend');
    //Appointment OTP

    Route::get('/appointment-detail', [AppointmentDetailController::class, 'create'])->name('appointmentDetail');
    Route::post('/appointment-detail', [AppointmentDetailController::class, 'store'])->name('appointmentStore');
    Route::get('/appointments/get-available-time-slots', [AppointmentDetailController::class, 'getAvailableTimeSlots']);
    Route::get('/appointments/get-fully-booked-dates', [AppointmentDetailController::class, 'getFullyBookedDates']);
    Route::get('/appointments/get-holidays', [AppointmentDetailController::class, 'getHolidays']);


    Route::post('/save-app-otp', [OtpController::class, 'saveAptOtp'])->name('saveAptOtp');
    Route::post('/verify-app-otp', [OtpController::class, 'verifyAptOtp'])->name('verifyAptOtp');
    Route::post('/resend-apt-otp', [OtpController::class, 'resendAptOtp'])->name('resendAptOtp');
});


//lalit ji on 17 sept 
Route::post('/locality-blocks', [ColonyController::class, 'localityBlocks'])->name('localityBlocks');
Route::post('/block-plots', [ColonyController::class, 'blockPlots'])->name('blockPlots');
Route::post('/plot-knownas', [ColonyController::class, 'plotKnownas'])->name('plotKnownas');
Route::post('/knownas-flat', [ColonyController::class, 'knownAsFlat'])->name('knownAsFlat');
Route::post('/flat-details', [OfficialController::class, 'getFlatDetails'])->name('getFlatDetails');
Route::post('/get-property-details', [OfficialController::class, 'getPropertyDetails'])->name('getPropertyDetails');
//Route for Property Auto Suggesion - Lalit (23/Oct/2024)
Route::post('/search-property', [OfficialController::class, 'searchProperty'])->name('search.property');
//Route for fetch Property Details through Auto Suggesion - Lalit (23/Oct/2024)
Route::get('/get-property-data/{propertyId}', [OfficialController::class, 'getPropertyData']);
Route::post('/land-types', [ColonyController::class, 'landTypes'])->name('landTypes');
// Adding given below routes to get Property Sub Types dropdown for registration by Lalit Tiwari - 13/02/2025
Route::post('/land-sub-types', [ColonyController::class, 'landSubTypes'])->name('landSubTypes');

//routes added by Nitin for address dropdowns - 08012025
Route::get('/country-state-list/{country_id}', [CommonController::class, 'countryStateList'])->name('countryStateList');
Route::get('/state-city-list/{country_id}', [CommonController::class, 'stateCityList'])->name('stateCityList');




//payment urls added by Nitin 22012025
Route::get('/payment', [PaymentController::class, 'paymentInputForm'])->name('paymentInputForm');
Route::get('/payment-details', [PaymentController::class, 'getPaymentDetails'])->name('getPaymentDetails');
Route::post('/applicant/demand-payment', [DemandController::class, 'applicantDemandPayment'])->name('applicant.demandPayment');
Route::get('/payment-status/{status}', [PaymentController::class, 'paymentStatusDisplay'])->name('paymentStatusDisplay');
Route::get('/updated-payment-status/{paymentId}', [PaymentController::class, 'checkUpdatedPaymentStatus'])->name('checkUpdatedPaymentStatus');

// by nitin on 13 feb 2025 for public dashboard
Route::get('/public-dashboard', [DashboardController::class, 'publicDashboard'])->name('publicDahboard');
Route::get('/dashboard/property-type-data/{typeId}/{coonyId?}', [DashboardController::class, 'propertyTypeDetails'])->name('propertyTypeDetails'); //moved out of auth after last discussion about public dashboard - Nitin -  12-02-2025
Route::post('/dashboard/colony-filter', [DashboardController::class, 'dashbordColonyFilter'])->name('dashbordColonyFilter');



//chatbot by adarsh
Route::post('/botman', [ChatBotController::class, 'handle'])->name('botman');

//Added the route for redirection URL of Bharatkosh ---Amita [14-01-2025]
//Route::get('/payment-response', [PaymentController::class, 'paymentResponse'])->name('paymentResponse');
Route::match(['get', 'post'], '/payment-response', [PaymentController::class, 'paymentResponse'])->name('paymentResponse'); //Updated the method to match --Amita [20-02-2025]


});
