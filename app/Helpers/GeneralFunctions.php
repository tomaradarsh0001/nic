<?php

namespace App\Helpers;

use App\Models\UserActionLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Otp;
use App\Models\UserRegistration;
use App\Models\PropertyMaster;
use App\Models\UserProperty;
use App\Models\ApplicantUserDetail;
use App\Models\Item;
use App\Models\TempSubstitutionMutation;
use App\Models\TempCoapplicant;
use App\Models\MutationApplication;
use App\Models\Coapplicant;
use App\Models\DocumentKey;
use App\Models\TempDocumentKey;
use App\Models\TempDocument;
use App\Models\Document;
use App\Models\Application;
use App\Models\DeedOfApartmentApplication;
use App\Models\TempDeedOfApartment;
use App\Models\LandUseChangeApplication;
use App\Models\Payment;
use App\Models\ApplicationMovement;
use App\Models\ConversionApplication;
use App\Models\Demand;
use App\Models\TempLandUseChangeApplication;
use App\Models\TempConversionApplication;
use App\Models\PropertySectionMapping;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use URL;
use Illuminate\Support\Facades\Storage;
use App\Services\CommonService;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonMail;
use App\Models\City;
use App\Models\Country;
use App\Models\PayerDetail;
use App\Models\State;
use App\Services\PropertyMasterService;
use App\Services\CommunicationService;
use Carbon\Carbon;
use App\Models\TempNoc;
use App\Models\NocApplication;

class GeneralFunctions
{

    //for generating otp
    public static function generateUniqueRandomNumber($digits)
    {
        $maxAttempts = 10;
        while ($maxAttempts > 0) {
            $randomNumber = mt_rand(pow(10, $digits - 1), pow(10, $digits) - 1); // Generate random number
            $exists = Otp::where('email_otp', $randomNumber)->where('mobile_otp', $randomNumber)->exists();
            if (!$exists) {
                return $randomNumber;
            }

            $maxAttempts--;
        }

        throw new Exception("Unable to generate a unique random number within the specified attempts.");
    }

    //for uploding file
    public static function uploadFile($file, $pathToUpload, $type)
    {
        $date = now()->format('YmdHis');
        $fileName = $type . '_' . $date . '.' . $file->extension();
        $path = $file->storeAs($pathToUpload, $fileName, 'public');
        return $path;
    }



    //For generating registration number
    public static function generateRegistrationNumber()
    {
        $lastRegistration = UserRegistration::latest('created_at')->first();

        if ($lastRegistration) {
            $lastNumber = intval(substr($lastRegistration->applicant_number, 4)); // Skip 'REG-'
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        $formattedNumber = str_pad($newNumber, 7, '0', STR_PAD_LEFT);
        $registrationNumber = 'APL' . $formattedNumber;
        return $registrationNumber;
    }

    //For generating registration number
    public static function generateUniqueApplicationNumber($model, $column)
    {
        do {
            // Generate a 10-digit random number
            $randomNumber = random_int(1000000000, 9999999999); // 10 digits
            // Check for uniqueness in your model's table/column
            $numberExists = $model::where($column, $randomNumber)->exists();
        } while ($numberExists);

        return $randomNumber;
    }

    //Introduce flatid - Lalit on 04/Nov/2024
    public static function isPropertyFree($propertyId, $flatId = null)
    {
        $property = PropertyMaster::where('old_propert_id', $propertyId)->first();
        if ($property) {
            if (!empty($propertyId) && !empty($flatId)) {
                $ispropertyLinked = UserProperty::where('old_property_id', $propertyId)
                    ->where('flat_id', $flatId)
                    ->first();
            } else {
                $ispropertyLinked = UserProperty::where('old_property_id', $propertyId)->whereNull('flat_id')->first();
            }

            if (!empty($ispropertyLinked['user_id'])) {
                $applicant = ApplicantUserDetail::where('user_id', $ispropertyLinked['user_id'])->first();
                if (!empty($applicant)) {
                    $data = [
                        'success' => false,
                        'message' => 'Property linked with another applicant ' . $applicant['applicant_number'] . '.',
                        'details' => '
                            <h6 class="text-danger">Property linked with another applicant ' . $applicant['applicant_number'] . '</h6>
                            <table class="table table-bordered property-table-info">
                                <tbody>
                                    <tr>
                                        <th>Name :</th>
                                        <td>' . $applicant->user->name . '</td>
                                        <th>Email :</th>
                                        <td>' . $applicant->user->email . '</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile:</th>
                                        <td>' . $applicant->user->mobile_no . '</td>
                                        <th>Address:</th>
                                        <td>' . $applicant->address . '</td>
                                    </tr>
                                    <tr>
                                        <th>PAN:</th>
                                        <td>' . $applicant->pan_card . '</td>
                                        <th>Aadhaar:</th>
                                        <td>' . $applicant->aadhar_card . '</td>
                                    </tr>
                                </tbody>
                            </table>'
                    ];
                } else {
                    $data = [
                        'success' => false,
                        'message' => 'Applicant User Details Not Found',
                        'details' => ''
                    ];
                }
            } else {
                $data = [
                    'success' => true,
                    'message' => 'Property is free',
                    'details' => ''
                ];
            }
        } else {
            // Case where no property is found in PropertyMaster
            $data = [
                'success' => false,
                'message' => 'Property not found',
                'details' => ''
            ];
        }

        return $data;
    }


    public static function getItemsByGroupId($id)
    {
        return Item::where('group_id', $id)->get();
    }

    //For storing application temporary tables data to final tables - SOURAV CHAUHAN (1/Oct/2024)
    public static function convertTempAppToFinal($modelId, $modelName, $paymentComplete)
    {
        $instance = new self();
        $finalModel = Application::class;
        $prefix = "APP";
        $column = "application_no";
        $commonService = new CommonService;
        $settingsService = new SettingsService;
        $applicationNo = $commonService->getUniqueID($finalModel, $prefix, $column);
        switch ($modelName) {
            case 'TempSubstitutionMutation':
                $serviceType = getServiceType('SUB_MUT');
                $mailServiceType = 'Mutation';
                $transactionSuccess = $instance->convertMutationApplication($modelName, $modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete);
                break;
            case 'TempDeedOfApartment':
                $serviceType = getServiceType('DOA');
                $mailServiceType = 'Deed Of Apartment';
                $transactionSuccess = $instance->convertDOAApplication($modelName, $modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete);
                break;
            case 'TempLandUseChangeApplication':
                $serviceType = getServiceType('LUC');
                $mailServiceType = 'Land Use Changed';
                $transactionSuccess = $instance->convertLUCApplication($modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete);
                break;
            case 'TempConversionApplication':
                $serviceType = getServiceType('CONVERSION');
                $mailServiceType = 'Conversion';
                $transactionSuccess = $instance->convertConversionApplication($modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete);
                break;
            case 'TempNoc':
                $serviceType = getServiceType('NOC');
                $mailServiceType = 'Noc';
                $transactionSuccess = $instance->convertNocApplication($modelName, $modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete);
                break;
            default:
                break;
        }
        if ($transactionSuccess) {
            // Prepare notification data
            $data = [
                'application_type' => $mailServiceType,
                'application_no' => $applicationNo,
                'date' => Carbon::now()->format('d-m-Y'),
                'time' => Carbon::now('Asia/Kolkata')->format('H:i:s'),
            ];

            // Action type for notifications
            $action = 'APP_ACK';
            $checkEmailTemplateExists = checkTemplateExists('email', $action);
            if (!empty($checkEmailTemplateExists)) {
                // Apply mail settings and send notifications
                $settingsService->applyMailSettings($action);
                // Send notifications
                $application = Application::where('application_no', $applicationNo)->first();
                $userId = $application->created_by;
                $registerUser = User::find($userId);
                //dd($registerUser);
                Mail::to($registerUser->email)->send(new CommonMail($data, $action));
            }
            $mobileNo = $registerUser->mobile_no;
            $checkSmsTemplateExists = checkTemplateExists('sms', $action);
            $communicationService = new CommunicationService;
            if (!empty($checkSmsTemplateExists)) {
                $communicationService->sendSmsMessage($data, $mobileNo, $action);
            }
            $checkWhatsappTemplateExists = checkTemplateExists('whatsapp', $action);
            if (!empty($checkWhatsappTemplateExists)) {
                $communicationService->sendWhatsAppMessage($data, $mobileNo, $action);
            }
            return response()->json(['status' => 'success', 'message' => 'Application submitted succesfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Application not submitted!']);
        }
    }

    //For storing mutation application temporary tables data to final tables - SOURAV CHAUHAN (1/Oct/2024)
    public function convertMutationApplication($modelName, $modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete)
    {
        // dd($modelName,$modelId,$finalModel,$applicationNo,$serviceType,$paymentComplete);
        $transactionSuccess = false;
        DB::transaction(function () use ($modelName, &$transactionSuccess, &$modelId, &$finalModel, &$applicationNo, &$serviceType, &$paymentComplete) {

            //Step 1:- store the main details to mutation applications table - SOURAV CHAUHAN (3/Oct/2024)
            $newApp =  Self::storeMutationApplication($applicationNo, $modelId);
            if (!empty($newApp)) {
                //Step 2:- store the coapplicants details to coapplicants table - SOURAV CHAUHAN (3/Oct/2024)
                Self::storeCoapplicants($modelName, $modelId, $serviceType, 'MutationApplication', $newApp->id, $applicationNo);

                //Step 3:- store the uploaded douments and thei keys to documents table - SOURAV CHAUHAN (3/Oct/2024)
                Self::storeDocuments($modelName, $modelId, $serviceType, 'MutationApplication', $newApp->id, $applicationNo);

                //Step 5:- store to common applications table - SOURAV CHAUHAN (3/Oct/2024)
                Self::storeApplication($finalModel, $applicationNo, $serviceType, 'MutationApplication', $newApp->id, $newApp->section_id, $paymentComplete->created_by);

                //Step 6:- update the payment table with new model and id - SOURAV CHAUHAN (9/Oct/2024)
                Self::updatePayment('MutationApplication', $newApp->id, $paymentComplete, $paymentComplete->created_by);

                //Step 7:- store the appliction movement - SOURAV CHAUHAN (9/Oct/2024)
                Self::applicationMovement($applicationNo, $newApp->id, $serviceType, $paymentComplete->created_by);

                //Step 8:- delete all the temp data - SOURAV CHAUHAN (3/Oct/2024)
                Self::deleteApplicationAllTempData($modelName, $modelId, $serviceType);
                $transactionSuccess = true;
            }
        });

        return $transactionSuccess;
    }

    //store the main details to mutation applications table - SOURAV CHAUHAN (3/Oct/2024)
    public function storeMutationApplication($applicationNo, $modelId)
    {
        //fetch details from temp table
        $tempSubstitutionMutation = TempSubstitutionMutation::find($modelId);
        $sectionId = self::findSection($tempSubstitutionMutation['property_master_id']);
        if ($tempSubstitutionMutation) {
            //store to final table
            $newApp =  MutationApplication::create([
                'application_no' => $applicationNo,
                'status' => getServiceType('APP_NEW'), //item code for new application
                'section_id' => $sectionId,
                'old_property_id' => $tempSubstitutionMutation['old_property_id'],
                'new_property_id' => $tempSubstitutionMutation['new_property_id'],
                'property_master_id' => $tempSubstitutionMutation['property_master_id'],
                'property_status' => $tempSubstitutionMutation['property_status'],
                'status_of_applicant' => $tempSubstitutionMutation['status_of_applicant'],
                'name_as_per_lease_conv_deed' => $tempSubstitutionMutation['name_as_per_lease_conv_deed'],
                'executed_on' => $tempSubstitutionMutation['executed_on'],
                'reg_no_as_per_lease_conv_deed' => $tempSubstitutionMutation['reg_no_as_per_lease_conv_deed'],
                'book_no_as_per_lease_conv_deed' => $tempSubstitutionMutation['book_no_as_per_lease_conv_deed'],
                'volume_no_as_per_lease_conv_deed' => $tempSubstitutionMutation['volume_no_as_per_lease_conv_deed'],
                'page_no_as_per_deed' => $tempSubstitutionMutation['page_no_as_per_deed'],
                'reg_date_as_per_lease_conv_deed' => $tempSubstitutionMutation['reg_date_as_per_lease_conv_deed'],
                'sought_on_basis_of_documents' => $tempSubstitutionMutation['sought_on_basis_of_documents'],
                'property_stands_mortgaged' => $tempSubstitutionMutation['property_stands_mortgaged'],
                'mortgaged_remark' => $tempSubstitutionMutation['mortgaged_remark'],
                'is_basis_of_court_order' => $tempSubstitutionMutation['is_basis_of_court_order'],
                'court_case_no' => $tempSubstitutionMutation['court_case_no'],
                'court_case_details' => $tempSubstitutionMutation['court_case_details'],
                'undertaking' => $tempSubstitutionMutation['undertaking'],
                'created_by' => Auth::user()->id
            ]);
            return $newApp;
        }
    }

    //to get section id by property master id - SOURAV CHAUHAN (14/Oct/2024)
    public function findSection($propertyMasterId)
    {
        $propertyDetails = PropertyMaster::find($propertyMasterId);
        $colony = $propertyDetails->new_colony_name;
        $propertyType = $propertyDetails->property_type;
        $propertySubType = $propertyDetails->property_sub_type;
        $propertySectionMapping = PropertySectionMapping::where('colony_id', $colony)->where('property_type', $propertyType)->where('property_subtype', $propertySubType)->first();
        $sectionId = $propertySectionMapping['section_id'];
        return $sectionId;
    }

    //store the coapplicants details to coapplicants table - SOURAV CHAUHAN (3/Oct/2024)
    public function storeCoapplicants($modelName, $modelId, $serviceType, $newModelName, $newModelId, $applicationNo)
    {
        //fetch coapplicants
        $tempCoapplicants = TempCoapplicant::where('model_id', $modelId)
            ->where('model_name', $modelName)
            ->where('service_type', $serviceType)
            ->get();
        if ($tempCoapplicants) {

            foreach ($tempCoapplicants as $tempCoapplicant) {
                // dd($tempCoapplicant);
                //for coapplicant photo
                $initialPathForPhoto = $tempCoapplicant->image_path;
                $pathPartsForPhoto = explode('/', $initialPathForPhoto);
                $pathPartsForPhoto[count($pathPartsForPhoto) - 4] = $applicationNo;
                //dd($pathPartsForPhoto);
                $newPathForPhoto = implode('/', $pathPartsForPhoto);
                if (Storage::disk('public')->exists($initialPathForPhoto)) {
                    Storage::disk('public')->move($initialPathForPhoto, $newPathForPhoto);
                }
                //for coapplicant Aadhaar
                $initialPathForAadhaar = $tempCoapplicant->aadhaar_file_path;
                $pathPartsForAadhaar = explode('/', $initialPathForAadhaar);
                $pathPartsForAadhaar[count($pathPartsForAadhaar) - 4] = $applicationNo;
                $newPathForAadhaar = implode('/', $pathPartsForAadhaar);
                if (Storage::disk('public')->exists($initialPathForAadhaar)) {
                    Storage::disk('public')->move($initialPathForAadhaar, $newPathForAadhaar);
                }
                //for coapplicant PAN
                $initialPathForPan = $tempCoapplicant->pan_file_path;
                $pathPartsForPan = explode('/', $initialPathForPan);
                $pathPartsForPan[count($pathPartsForPan) - 4] = $applicationNo;
                $newPathForPan = implode('/', $pathPartsForPan);
                if (Storage::disk('public')->exists($initialPathForPan)) {
                    Storage::disk('public')->move($initialPathForPan, $newPathForPan);
                }

                Coapplicant::create([
                    'service_type' => $tempCoapplicant->service_type,
                    'model_name' => $newModelName,
                    'model_id' => $newModelId,
                    'co_applicant_name' => $tempCoapplicant->co_applicant_name,
                    'co_applicant_gender' => $tempCoapplicant->co_applicant_gender,
                    'co_applicant_age' => $tempCoapplicant->co_applicant_age,
                    'prefix' => $tempCoapplicant->prefix,
                    'co_applicant_father_name' => $tempCoapplicant->co_applicant_father_name,
                    'co_applicant_aadhar' => $tempCoapplicant->co_applicant_aadhar,
                    'aadhaar_file_path' => $newPathForAadhaar,
                    'co_applicant_pan' => $tempCoapplicant->co_applicant_pan,
                    'pan_file_path' => $newPathForPan,
                    'co_applicant_mobile' => $tempCoapplicant->co_applicant_mobile,
                    'image_path' => $newPathForPhoto,
                    'created_by' => Auth::user()->id
                ]);
            }

            // Delete old directories if they are empty
            foreach ($tempCoapplicants as $tempCoapplicant) {
                Self::deleteIfEmptyDirectory(dirname($tempCoapplicant->image_path));
                Self::deleteIfEmptyDirectory(dirname($tempCoapplicant->aadhaar_file_path));
                Self::deleteIfEmptyDirectory(dirname($tempCoapplicant->pan_file_path));
            }
        }
    }


    function deleteIfEmptyDirectory($directory)
    {
        if (Storage::disk('public')->exists($directory) && empty(Storage::disk('public')->files($directory))) {
            Storage::disk('public')->deleteDirectory($directory);
        }
    }

    //store the uploaded douments to documents table - SOURAV CHAUHAN (3/Oct/2024)
    public function storeDocuments($modelName, $modelId, $serviceType, $newModelName, $newModelId, $applicationNo)
    {
        //fetch documents
        $tempDocuments = TempDocument::where('model_id', $modelId)
            ->where('model_name', $modelName)
            ->where('service_type', $serviceType)
            ->get();
        if ($tempDocuments) {
            foreach ($tempDocuments as $tempDocument) {

                $initialPath = $tempDocument->file_path;
                $pathParts = explode('/', $initialPath);
                $pathParts[count($pathParts) - 2] = $applicationNo;
                $newPath = implode('/', $pathParts);
                if (Storage::disk('public')->exists($initialPath)) {
                    Storage::disk('public')->move($initialPath, $newPath);
                    Storage::disk('public')->deleteDirectory($initialPath);
                }

                //store to documents table
                $document = Document::create([
                    'title' => $tempDocument->title,
                    'file_path' => $newPath,
                    'user_id' => $tempDocument->created_by,
                    'service_type' => $tempDocument->service_type,
                    'model_name' => $newModelName,
                    'model_id' => $newModelId,
                    'document_type' => $tempDocument->document_type

                ]);
                if ($document) {
                    //fetch document keys
                    $tempDocumentKeys = TempDocumentKey::where('temp_document_id', $tempDocument->id)->get();
                    if ($tempDocumentKeys) {
                        Self::storeDocumentKeys($tempDocumentKeys, $document->id);
                    }
                }
            }
        }
    }

    //store the doument keys to documentkeys table - SOURAV CHAUHAN (3/Oct/2024)
    public function storeDocumentKeys($tempDocumentKeys, $documentId)
    {
        foreach ($tempDocumentKeys as $tempDocumentKey) {
            DocumentKey::create([
                'document_id' => $documentId,
                'key' => $tempDocumentKey->key,
                'value' => $tempDocumentKey->value,
                'created_by' => $tempDocumentKey->created_by //Auth::user()->id
            ]);
        }
    }

    //store the appliction movement - SOURAV CHAUHAN (9/Oct/2024)
    public function applicationMovement($applicationNo, $modelId, $serviceType, $createdBy)
    {
        //entry to application movement for withdraw
        $applicationMovement = ApplicationMovement::create([
            'assigned_by' => Auth::check() ? Auth::id() : $createdBy, // if user not authenticated then take Id of user who pay
            'assigned_by_role' => 6, //added by Nitin - role was not showing in application movemnts - 12 dec 2024
            'service_type' => $serviceType, //for mutation,LUC,DOA etc
            'model_id' => $modelId,
            'status' => getServiceType('APP_NEW'), //for new application
            'application_no' => $applicationNo,
        ]);
    }

    public function deleteApplicationAllTempData($modelName, $modelId, $serviceType)
    {
        //delete from temp main table
        switch ($modelName) {
            case 'TempSubstitutionMutation':
                TempSubstitutionMutation::find($modelId)?->delete();
                break;
            case 'TempDeedOfApartment':
                TempDeedOfApartment::find($modelId)?->delete();
            case "TempLandUseChangeApplication":
                TempLandUseChangeApplication::find($modelId)?->delete();
            case "TempConversionApplication":
                TempConversionApplication::find($modelId)?->delete();
                break;
            case "TempNoc":
                TempNoc::find($modelId)?->delete();
                break;
            default:
                break;
        }

        //delete coapplicants from temp table
        TempCoapplicant::where('model_id', $modelId)
            ->where('model_name', $modelName)
            ->where('service_type', $serviceType)
            ->delete();

        //delete documents from temp table
        $tempDocuments = TempDocument::where('model_id', $modelId)
            ->where('model_name', $modelName)
            ->where('service_type', $serviceType)
            ->with('tempDocumentKeys')
            ->get();

        foreach ($tempDocuments as $tempDocument) {
            $tempDocument->tempDocumentKeys()->delete(); // Delete associated keys
            $tempDocument->delete(); // Delete the document
        }
        return true;
    }


    //store to common applications table - SOURAV CHAUHAN (3/Oct/2024)
    public function storeApplication($finalModel, $applicationNo, $serviceType, $modelName, $modelId, $sectionId, $createdBy)
    {
        $finalModel::create([
            'application_no' => $applicationNo,
            'section_id' => $sectionId,
            'service_type' => $serviceType,
            'model_name' => $modelName,
            'model_id' => $modelId,
            'status' => getServiceType('APP_NEW'),
            'created_by' => Auth::check() ? Auth::user()->id : $createdBy
        ]);
    }

    //For storing deed of apartment application temporary tables to final tables - Lalit (10/Oct/2024)
    public function convertDOAApplication($modelName, $modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete)
    {

        $transactionSuccess = false;
        DB::transaction(function () use ($modelName, &$transactionSuccess, &$modelId, &$finalModel, &$applicationNo, &$serviceType, &$paymentComplete) {

            //Step 1:- store the main details to mutation applications table - SOURAV CHAUHAN (3/Oct/2024)
            $newApp =  Self::storeDOAApplication($applicationNo, $modelId);
            if (!empty($newApp)) {

                //Step 3:- store the uploaded douments and thei keys to documents table - SOURAV CHAUHAN (3/Oct/2024)
                Self::storeDocuments($modelName, $modelId, $serviceType, 'DeedOfApartmentApplication', $newApp->id, $applicationNo);

                //Step 5:- store to common applications table - SOURAV CHAUHAN (3/Oct/2024)
                Self::storeApplication(
                    $finalModel,
                    $applicationNo,
                    $serviceType,
                    'DeedOfApartmentApplication',
                    $newApp->id,
                    $newApp->section_id,
                    $paymentComplete->created_by
                );

                //Step 6:- store to common applications table - SOURAV CHAUHAN (3/Oct/2024)
                Self::updatePayment('DeedOfApartmentApplication', $newApp->id, $paymentComplete);

                //Step 7:- store the appliction movement - SOURAV CHAUHAN (9/Oct/2024)
                Self::applicationMovement($applicationNo, $newApp->id, $serviceType, $paymentComplete->created_by);

                //Step 8:- delete all the temp data - SOURAV CHAUHAN (3/Oct/2024)
                Self::deleteApplicationAllTempData($modelName, $modelId, $serviceType);
                $transactionSuccess = true;
            }
        });

        return $transactionSuccess;
    }

    //store the main details to deed of apartment applications table - Lalit (10/Oct/2024)
    public function storeDOAApplication($applicationNo, $modelId)
    {
        //fetch details from temp table
        $tempDoa = TempDeedOfApartment::find($modelId);
        if ($tempDoa) {
            $sectionId = self::findSection($tempDoa['property_master_id']);
            //store to final table
            $newApp =  DeedOfApartmentApplication::create([
                'application_no' => $applicationNo,
                'section_id' => $sectionId,
                'status' => getServiceType('APP_NEW'), //item code for new application
                'old_property_id' => $tempDoa['old_property_id'],
                'new_property_id' => $tempDoa['new_property_id'],
                'property_master_id' => $tempDoa['property_master_id'],
                'splited_property_detail_id' => $tempDoa['splited_property_detail_id'],
                'property_status' => $tempDoa['property_status'],
                'status_of_applicant' => $tempDoa['status_of_applicant'],
                'service_type' => getServiceType('DOA'),
                'applicant_name' => $tempDoa['applicant_name'],
                'applicant_address' => $tempDoa['applicant_address'],
                'building_name' => $tempDoa['building_name'],
                'locality' => $tempDoa['locality'],
                'block' => $tempDoa['block'],
                'plot' => $tempDoa['plot'],
                'known_as' => $tempDoa['known_as'],
                'flat_id' => $tempDoa['flat_id'],
                'isFlatNotListed' => $tempDoa['isFlatNotListed'],
                'flat_number' => $tempDoa['flat_number'],
                'builder_developer_name' => $tempDoa['builder_developer_name'],
                'original_buyer_name' => $tempDoa['original_buyer_name'],
                'present_occupant_name' => $tempDoa['present_occupant_name'],
                'purchased_from' => $tempDoa['purchased_from'],
                'purchased_date' => $tempDoa['purchased_date'],
                'flat_area' => $tempDoa['flat_area'],
                'plot_area' => $tempDoa['plot_area'],
                'undertaking' => $tempDoa['undertaking'],
                'created_by' => Auth::user()->id
            ]);
            return $newApp;
        }
    }

    //moved to general functions and modifications by Nitin on 07-10-2024
    public static function paymentComplete($modelId, $modelName)
    {
        try {
            switch ($modelName) {
                case 'TempSubstitutionMutation':
                    $amount = getApplicationCharge(getServiceType('SUB_MUT'));
                    break;
                case 'TempLandUseChangeApplication':
                    $amount = getApplicationCharge(getServiceType('LUC'));
                    break;
                case 'TempDeedOfApartment':
                    $amount = getApplicationCharge(getServiceType('DOA'));
                    break;
                case 'TempConversionApplication':
                    $amount = getApplicationCharge(getServiceType('CONVERSION'));
                    break;
                case 'TempNoc':
                    $amount = getApplicationCharge(getServiceType('NOC'));
                    break;
                default:
                    $amount = '';
                    break;
            }

            $payment = Payment::create([
                'model' => $modelName,
                'model_id' => $modelId,
                'property_master_id' => 1,
                'master_old_property_id' => 11,
                'amount' => $amount ?? 5000,
                'transaction_id' => bin2hex(random_bytes(10)),
                'unique_payment_id' => bin2hex(random_bytes(10)),
                'status' => true,

            ]);
            if ($payment) {
                return $payment;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Log::error("Error storing coapplicants: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while storing coapplicants', 'error' => $e->getMessage()], 500);
        }
    }

    //moved to general functions and modifications by Nitin on 07-10-2024
    public static function updatePayment($model, $modelId, $paymentComplete)
    {
        $payment = Payment::find($paymentComplete->id); // id added by Nitin
        $payment->model = $model;
        $payment->model_id = $modelId;
        if ($payment->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function convertLUCApplication($modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete)
    {
        $transactionSuccess = false;
        //store in LandUseChangeApplication Model
        DB::transaction(function () use ($modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete, &$transactionSuccess) {
            $tempRow = TempLandUseChangeApplication::find($modelId);
            $tempModelName = 'TempLandUseChangeApplication';
            $modelName = 'LandUseChangeApplication';
            $tempAttributes = $tempRow->toArray();
            unset($tempAttributes['id'], $tempAttributes['created_at'], $tempAttributes['updated_at']);
            /* $tempAttributes['created_by'] = Auth::id();
            $tempAttributes['updated_by'] = Auth::id(); */
            $tempAttributes['application_no'] = $applicationNo;
            $tempAttributes['status'] = getServiceType('APP_NEW');
            $tempAttributes['section_id'] = self::findSection($tempAttributes['property_master_id']);
            $newRow = LandUseChangeApplication::create($tempAttributes);
            if ($newRow) {
                Self::storeCoapplicants($tempModelName, $modelId, $serviceType, $modelName, $newRow->id, $applicationNo);
                Self::storeDocuments($tempModelName, $modelId, $serviceType, $modelName, $newRow->id, $applicationNo);
                Self::storeApplication($finalModel, $applicationNo, $serviceType, $modelName, $newRow->id, $tempAttributes['section_id'], $paymentComplete->created_by);

                //Step 6:- store to common applications table - SOURAV CHAUHAN (3/Oct/2024)
                Self::updatePayment($modelName, $newRow->id, $paymentComplete);

                //Step 7:- store the appliction movement - SOURAV CHAUHAN (9/Oct/2024)
                Self::applicationMovement($applicationNo, $newRow->id, $serviceType, $paymentComplete->created_by);

                Self::deleteApplicationAllTempData($tempModelName, $modelId, $serviceType);
                $transactionSuccess = true;
            }
        });
        return $transactionSuccess;
    }
    public function convertConversionApplication($modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete)
    {
        //store in LandUseChangeApplication Model

        $tempRow = TempConversionApplication::find($modelId);
        $tempModelName = 'TempConversionApplication';
        $modelName = 'ConversionApplication';
        $tempAttributes = $tempRow->toArray();
        $transactionSuccess = false;
        unset($tempAttributes['id'], $tempAttributes['created_at'], $tempAttributes['updated_at'], $tempAttributes['created_by'], $tempAttributes['updated_by']);
        $tempAttributes['created_by'] = Auth::check() ? Auth::id() : $paymentComplete->created_by;
        $tempAttributes['updated_by'] = Auth::check() ? Auth::id() : $paymentComplete->created_by; // added by nitin to fix issue if payment is not updated immediately
        $tempAttributes['application_no'] = $applicationNo;
        $tempAttributes['status'] = getServiceType('APP_NEW');
        $tempAttributes['section_id'] = self::findSection($tempAttributes['property_master_id']);
        $newRow = ConversionApplication::create($tempAttributes);
        if ($newRow) {
            Self::storeCoapplicants($tempModelName, $modelId, $serviceType, $modelName, $newRow->id, $applicationNo);
            Self::storeDocuments($tempModelName, $modelId, $serviceType, $modelName, $newRow->id, $applicationNo);
            Self::storeApplication($finalModel, $applicationNo, $serviceType, $modelName, $newRow->id, $tempAttributes['section_id'], $paymentComplete->created_by);

            //Step 6:- store to common applications table - SOURAV CHAUHAN (3/Oct/2024)
            Self::updatePayment($modelName, $newRow->id, $paymentComplete);

            //Step 7:- store the appliction movement - SOURAV CHAUHAN (9/Oct/2024)
            Self::applicationMovement($applicationNo, $newRow->id, $serviceType, $paymentComplete->created_by);

            Self::deleteApplicationAllTempData($tempModelName, $modelId, $serviceType);

            $transactionSuccess = true;
        }
        return $transactionSuccess;
    }

    //for storing temp co Applicants 
    public static function storeTempCoApplicants($serviceType, $modelName, $modelId, $colonyCode, $request)
    {
        try {
            $allSaved = true;

            foreach ($request->coapplicants as $i => $coapplicantData) {
                // dd($coapplicantData);
                if (!empty($coapplicantData['name'])) {
                    $coapplicantId = isset($coapplicantData['coapplicantId']) && $coapplicantData['coapplicantId'] > 0
                        ? $coapplicantData['coapplicantId']
                        : 0;


                    $indexNo = $coapplicantData['indexNo'] ?? 0;
                    if ($coapplicantId > 0) {
                        $existingCoapplicant = $coapplicantId ? TempCoapplicant::find($coapplicantId) : null;
                        $recordExistCheckArray = ['id' => $coapplicantId]; // if coaaplicant idis available then check record for id exist
                    } else {
                        $existingCoapplicant = $coapplicantId ? TempCoapplicant::where('model_name', $modelName)->where('model_id', $modelId)->where('index_no', $indexNo)->first() : null;
                        $existingCoapplicant = !empty($existingCoapplicant) ? $existingCoapplicant : null;
                        $recordExistCheckArray = ['model_name' => $modelName, 'model_id' => $modelId, 'index_no' => $indexNo]; // if id id not available then match model name, model id , index not uniquely identify existing record. useful for create case// coming back on step after submitting
                    }
                    // Retrieve or initialize the coapplicant model
                    $user = Auth::user();
                    $userDetails = $user->applicantUserDetails;
                    $registrationNumber = $userDetails->applicant_number;
                    $date = now()->format('YmdHis');

                    $pathToUpload = "$registrationNumber/$colonyCode/$serviceType/$modelId/coapplicant/" . $indexNo;

                    // Handle each file type (photo, aadhaar, pan)
                    $imageFullPath = self::handleFileUpload($request, "coapplicants.$i.photo", $pathToUpload, 'image-', $date, $existingCoapplicant, 'image_path');
                    $aadhaarFullPath = self::handleFileUpload($request, "coapplicants.$i.aadhaarFile", $pathToUpload, 'aadhaar-', $date, $existingCoapplicant, 'aadhaar_file_path');
                    $panFullPath = self::handleFileUpload($request, "coapplicants.$i.panFile", $pathToUpload, 'pan-', $date, $existingCoapplicant, 'pan_file_path');

                    // Save or update co-applicant details
                    $tempCoapplicant = TempCoapplicant::updateOrCreate(
                        $recordExistCheckArray,
                        [
                            'service_type' => getServiceType($serviceType),
                            'model_name' => $modelName,
                            'index_no' => $indexNo ?? null,
                            'model_id' => $modelId,
                            'co_applicant_name' => $coapplicantData['name'],
                            'co_applicant_gender' => $coapplicantData['gender'],
                            'co_applicant_age' => $coapplicantData['dateOfBirth'],
                            'prefix' => $serviceType == "SUB_MUT" ? $coapplicantData['prefixInv'] :$coapplicantData['conPrefixInv'],
                            'co_applicant_father_name' => $serviceType == "SUB_MUT" ? $coapplicantData['secondnameInv']:$coapplicantData['fathername'],
                            'co_applicant_aadhar' => $coapplicantData['aadharnumber'],
                            'co_applicant_pan' => $coapplicantData['pannumber'],
                            'co_applicant_mobile' => $coapplicantData['mobilenumber'],
                            'created_by' => Auth::id(),
                            'image_path' => $imageFullPath,
                            'aadhaar_file_path' => $aadhaarFullPath,
                            'pan_file_path' => $panFullPath
                        ]
                    );

                    if (!$tempCoapplicant) {
                        $allSaved = false;
                    }
                }
            }

            return $allSaved;
        } catch (\Exception $e) {
            Log::error("Error storing coapplicants: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'An error occurred while storing coapplicants', 'error' => $e->getMessage()], 500);
        }
    }

    private static function handleFileUpload($request, $inputName, $pathToUpload, $prefix, $date, $existingCoapplicant, $fileColumnName)
    {
        $file = $request->file($inputName);
        if ($file) {
            $fileName = $prefix . $date . '.' . $file->getClientOriginalExtension();
            $fullPath = "$pathToUpload/$fileName";

            Storage::disk('public')->put($fullPath, file_get_contents($file));

            // Delete old file if an existing coapplicant and file column exist
            if (!empty($existingCoapplicant)) {
                self::deleteOldFile($existingCoapplicant, $fileColumnName);
            }

            return $fullPath;
        }

        return $existingCoapplicant ? $existingCoapplicant->{$fileColumnName} : null;
    }

    public static function deleteOldFile($row, $fileColumnName)
    {
        if (!empty($row->{$fileColumnName}) && Storage::disk('public')->exists($row->{$fileColumnName})) {
            Storage::disk('public')->delete($row->{$fileColumnName});
        }
    }

    public static function createUniqueDemandId($propertyId)
    {
        $latestId = Demand::max('id');
        $newId = !is_null($latestId) ? ($latestId + 1) : 1;
        return 'D' . $propertyId . date('Ymd') . str_pad($newId, 6, '0', STR_PAD_LEFT); //removed 'His' from date after latest discussion - 06-01-2025
    }

    public static function getUserDemandData($countOnly = false, $onlyActiceDemands = true)
    {
        $user = Auth::user();
        $userProperties = $user->userProperties->select('old_property_id', 'flat_id')->toArray();
        $newDemandCount = 0;
        $demands = collect();
        $pms = new PropertyMasterService();
        foreach ($userProperties as $upr) {
            $findProperty = $pms->propertyFromSelected($upr['old_property_id']);
            if ($findProperty['status'] == 'error') {
                return $countOnly ? 0 : collect(); //incase of error return empty collection
            } else {
                $masterProperty = $findProperty['masterProperty'];
                $propertyMasterId = $masterProperty->id;
                $childProperty = $findProperty['childProperty'] ?? null;
                $childId = $childProperty?->id;
                $demandFindQuery = Demand::where('property_master_id', $propertyMasterId);
                if ($childId) {
                    $demandFindQuery = $demandFindQuery->where('splited_property_detail_id', $childId);
                }
                if (!empty($upr['flat_id'])) {
                    $demandFindQuery = $demandFindQuery->where('flat_id', $upr['flat_id']);
                }
                if ($onlyActiceDemands) {
                    $demandFindQuery = $demandFindQuery->whereIn('status', [getServiceType('DEM_PENDING'), getServiceType('DEM_PART_PAID')]);
                }
                if ($countOnly) {
                    $newDemandCount += $demandFindQuery->count();
                } else {
                    $demands = $demands->merge($demandFindQuery->get());
                }
            }
        }
        return $countOnly ? $newDemandCount : $demands;
    }

    /** function added by Nitin on 30-01=2024 --- to save payer details likely to be reused */
    public static function savePayerDetails($request, $paymentId)
    {
        PayerDetail::create([
            'payment_id' => $paymentId,
            'first_name' => $request['payer_first_name'],
            'last_name' => $request['payer_last_name'],
            'mobile' => $request['payer_mobile'],
            'email' => $request['payer_email'],
            'address_1' => $request['address_1'],
            'address_2' => $request['address_2'],
            'postal_code' => $request['postal_code'],
            'region' => $request['region'],
            'city_id' => $request['city'],
            'state_id' => $request['state'],
            'country_id' => $request['country']
        ]);
    }

    /** function added by Nitin on 30-01=2024 --- to get names of city, state and country likely to be reused */
    public static function getAddressNames($addressData)
    {
        extract($addressData);
        $countryData = Country::find($country);
        $countryName = $countryData->name ?? '';
        $stateData = State::find($state);
        $stateName = $stateData->name ?? '';
        $cityData = City::find($city);
        $cityName = $cityData->name ?? '';
        return array($countryName, $stateName, $cityName);
    }

    //Insert noc application temporary tables data to final tables - Lalit Tiwari (17/March/2025)
    public function convertNocApplication($modelName, $modelId, $finalModel, $applicationNo, $serviceType, $paymentComplete)
    {
        // dd($modelName,$modelId,$finalModel,$applicationNo,$serviceType,$paymentComplete);
        $transactionSuccess = false;
        DB::transaction(function () use ($modelName, &$transactionSuccess, &$modelId, &$finalModel, &$applicationNo, &$serviceType, &$paymentComplete) {

            //Step 1:- store the main details to noc applications table - Lalit Tiwari (17/March/2025)
            $newApp =  Self::storeNocApplication($applicationNo, $modelId);
            if (!empty($newApp)) {
                //Step 2:- store the coapplicants details to coapplicants table - Lalit Tiwari (17/March/2025)
                Self::storeCoapplicants($modelName, $modelId, $serviceType, 'NocApplication', $newApp->id, $applicationNo);

                //Step 3:- store the uploaded douments and thei keys to documents table - Lalit Tiwari (17/March/2025)
                Self::storeDocuments($modelName, $modelId, $serviceType, 'NocApplication', $newApp->id, $applicationNo);

                //Step 5:- store to common applications table - Lalit Tiwari (17/March/2025)
                Self::storeApplication($finalModel, $applicationNo, $serviceType, 'NocApplication', $newApp->id, $newApp->section_id, $paymentComplete->created_by);

                //Step 6:- update the payment table with new model and id - SOURAV CHAUHAN (9/Oct/2024)
                Self::updatePayment('NocApplication', $newApp->id, $paymentComplete, $paymentComplete->created_by);

                //Step 7:- store the appliction movement - SOURAV CHAUHAN (9/Oct/2024)
                Self::applicationMovement($applicationNo, $newApp->id, $serviceType, $paymentComplete->created_by);

                //Step 8:- delete all the temp data - Lalit Tiwari (17/March/2025)
                Self::deleteApplicationAllTempData($modelName, $modelId, $serviceType);
                $transactionSuccess = true;
            }
        });

        return $transactionSuccess;
    }

    //store the main details to mutation applications table - SOURAV CHAUHAN (3/Oct/2024)
    public function storeNocApplication($applicationNo, $modelId)
    {
        //fetch details from temp table
        $tempNoc = TempNoc::find($modelId);
        $sectionId = self::findSection($tempNoc['property_master_id']);
        if ($tempNoc) {
            //store to final table
            $newApp =  NocApplication::create([
                'application_no' => $applicationNo,
                'status' => getServiceType('APP_NEW'), //item code for new application
                'section_id' => $sectionId,
                'old_property_id' => $tempNoc['old_property_id'],
                'new_property_id' => $tempNoc['new_property_id'],
                'property_master_id' => $tempNoc['property_master_id'],
                'property_status' => $tempNoc['property_status'],
                'status_of_applicant' => $tempNoc['status_of_applicant'],
                'name_as_per_noc_conv_deed' => $tempNoc['name_as_per_noc_conv_deed'],
                'executed_on_as_per_noc_conv_deed' => $tempNoc['executed_on_as_per_noc_conv_deed'],
                'reg_no_as_per_noc_conv_deed' => $tempNoc['reg_no_as_per_noc_conv_deed'],
                'book_no_as_per_noc_conv_deed' => $tempNoc['book_no_as_per_noc_conv_deed'],
                'volume_no_as_per_noc_conv_deed' => $tempNoc['volume_no_as_per_noc_conv_deed'],
                'page_no_as_per_noc_conv_deed' => $tempNoc['page_no_as_per_noc_conv_deed'],
                'reg_date_as_per_noc_conv_deed' => $tempNoc['reg_date_as_per_noc_conv_deed'],
                'con_app_date_as_per_noc_conv_deed' => $tempNoc['con_app_date_as_per_noc_conv_deed'],
                'undertaking' => $tempNoc['undertaking'],
                'created_by' => Auth::user()->id
            ]);
            return $newApp;
        }
    }
}
