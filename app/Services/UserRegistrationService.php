<?php

namespace App\Services;

use App\Models\Document;
use App\Models\PropertyMaster;
use App\Models\User;
use App\Models\UserProperty;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\SendCreadentialToRegisterUser;
use App\Models\ApplicantUserDetail;
use App\Models\ApplicationMovement;
use App\Models\Item;
use App\Models\Section;
use App\Models\ApplicationStatus;
use App\Models\NewlyAddedProperty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use App\Services\SettingsService;
use App\Services\CommunicationService;
use App\Mail\CommonMail;
use App\Models\Flat;

class UserRegistrationService
{
    protected $communicationService;
    protected $settingsService;

    public function __construct(CommunicationService $communicationService, SettingsService $settingsService)
    {
        $this->communicationService = $communicationService;
        $this->settingsService = $settingsService;
    }

    //Add by lalit on 31/07/2024 to approve user registeration
    public function approveRegistration(Request $request)
    {
        try {
            $transactionSuccess = false;
            DB::transaction(function () use ($request, &$transactionSuccess) {
                // Fetch Register User Details from user_registration table
                $getDetail = UserRegistration::find($request->registrationId);
                if (!empty($getDetail)) {
                    $randomPassword = Str::random(8);
                    // Create User
                    $user = User::create([
                        'user_type' => 'applicant',
                        'name' =>  $getDetail->name,
                        'country_code' => $getDetail->country_code,
                        'email' => $getDetail->email,
                        'mobile_no' => $getDetail->mobile,
                        'password' => Hash::make($randomPassword),
                        'status'    => 1
                    ]);
                    if ($user) {
                        $propertyDetails = PropertyMaster::where('old_propert_id', $request->oldPropertyId)->first();
                        $this->storeUserDetails($user->id, $getDetail);
                        $this->createDocuments($getDetail, $user->id,  $propertyDetails->id, $request->oldPropertyId, $request);
                        $this->mapUserToProperty($user->id, $request, $getDetail);
                        $this->updateUserRegistrationStatus($request->registrationId);
                        //Assign Role to register user as applicant
                        //Check if role exist in database then only assigned otherwise it gives error, So here i am checking user role for register user
                        $isRoleExists = Role::where('name', 'applicant')->exists();
                        if ($isRoleExists) {
                            $user->syncRoles("applicant");
                        }

                        $data = [
                            'propertyId' => $request->oldPropertyId,
                            'regNo' => $getDetail->applicant_number,
                            'email' => $getDetail->email,
                            'password' => $randomPassword,
                        ];
                        $action = 'REG_APP';
                        $checkEmailTemplateExists = checkTemplateExists('email', $action);
                        if (!empty($checkEmailTemplateExists)) {
                            // Apply the mail settings before sending the email
                            $this->settingsService->applyMailSettings($action);
                            Mail::to($getDetail->email)->send(new CommonMail($data, $action));
                        }
                        $checkSmsTemplateExists = checkTemplateExists('sms', $action);
                        if (!empty($checkSmsTemplateExists)) {
                            $this->communicationService->sendSmsMessage($data, $getDetail->mobile, $action, $getDetail->country_code);
                        }
                        $checkWhatsappTemplateExists = checkTemplateExists('whatsapp', $action);
                        if (!empty($checkWhatsappTemplateExists)) {
                            $this->communicationService->sendWhatsAppMessage($data, $getDetail->mobile, $action, $getDetail->country_code);
                        }
                    }
                    $transactionSuccess = true;
                }
            });

            return $transactionSuccess;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    protected function updateApplicationStatus($request)
    {
        $registerUser =  UserRegistration::where('id', $request->registrationId)->first();
        ApplicationStatus::create([
            // 'service_type'              => getServiceType('RS_REG'),
            'service_type'              => getServiceType('RS_NEW_REG'),
            'model_id'                  => $request->registrationId,
            'reg_app_no'                => $registerUser->applicant_number,
            'is_mis_checked'            => $request->is_mis_checked ? true : false,
            'is_scan_file_checked'      => $request->is_scan_file_checked ? true : false,
            'is_uploaded_doc_checked'   => $request->is_uploaded_doc_checked ? true : false,
            'created_by'                => Auth::user()->id,
        ]);
    }

    protected function storeUserDetails($userId, $getDetail)
    {
        ApplicantUserDetail::create([
            'user_id' => $userId,
            'applicant_number' => !empty($getDetail->applicant_number) ? $getDetail->applicant_number : '',
            'user_sub_type' => !empty($getDetail->user_type) ? $getDetail->user_type : '',
            'gender' => !empty($getDetail->gender) ? $getDetail->gender : '',
            'dob' => !empty($getDetail->dob) ? $getDetail->dob : '',
            'age' => !empty($getDetail->age) ? $getDetail->age : '',
            'so_do_spouse' => !empty($getDetail->prefix) ? $getDetail->prefix : '',
            'second_name' => !empty($getDetail->second_name) ? $getDetail->second_name : '',
            'pan_card' => !empty($getDetail->pan_number) ? $getDetail->pan_number : '',
            'aadhar_card' => !empty($getDetail->aadhar_number) ? $getDetail->aadhar_number : '',
            'address' => !empty($getDetail->comm_address) ? $getDetail->comm_address : '',
            'profile_photo' => !empty($getDetail->profile_photo) ? $getDetail->profile_photo : '',
            'organization_name' => !empty($getDetail->organization_name) ? $getDetail->organization_name : '',
            'organization_pan_card' => !empty($getDetail->organization_pan_card) ? $getDetail->organization_pan_card : '',
            'organization_address' => !empty($getDetail->organization_address) ? $getDetail->organization_address : '',
        ]);
    }

    //Add by lalit on 31/07/2024 to Insert documents record
    protected function createDocuments($getDetail, $userId, $newPropertyId, $oldPropertyId, $request)
    {

        if (!empty($request->flatId)) {
            $flatDetails = Flat::find($request->flatId);
            $flatId = $flatDetails->id;
        } else {
            $flatId = $getDetail->flat_id;
        }
        //Fetch item_id from items table for registration 
        $documentTypes = [
            'sale_deed_doc' => 'Sale Deed',
            'builder_buyer_agreement_doc' => 'Builder Buyer Agreement',
            'lease_deed_doc' => 'Lease Deed',
            'substitution_mutation_letter_doc' => 'Substitution Mutation Letter',
            'owner_lessee_doc' => 'Owner Lessee',
            'other_doc' => 'Other Document',
            'authorised_signatory_doc' => 'Authorised Signatory',
            'chain_of_ownership_doc' => 'Chain Of Ownership'
        ];

        foreach ($documentTypes as $field => $documentName) {
            if (!empty($getDetail->$field)) {
                // $documentParts = explode('/', $getDetail->$field);
                // $documentName = end($documentParts);
                Document::create([
                    'title' => $documentName,
                    'file_path' =>  $getDetail->$field,
                    'user_id' => $userId,
                    'property_master_id' => $newPropertyId,
                    'old_property_id' => $oldPropertyId,
                    'flat_id' => $flatId ?? null,
                    // 'service_type' => getServiceType('RS_REG'), //This should be exist in Items table
                    'service_type' => getServiceType('RS_NEW_REG'), //This should be exist in Items table
                    'model_name'    => 'User',
                    'model_id'  => $userId,
                    'document_type' => $documentName
                ]);
            }
        }
    }

    //Add by lalit on 31/07/2024 to map user to property
    protected function mapUserToProperty($userId, $request, $getDetail)
    {
        // $sectionCode = PropertyMaster::where('id', $request->suggestedPropertyId)->value('section_code');
        //This changes is made on 27 August after changes suggested property id from id to old_property_id
        $propertyDetails = PropertyMaster::where('old_propert_id', $request->oldPropertyId)->first();
        if ($propertyDetails) {
            if (!empty($request->flatId)) {
                $getFlatDetails = Flat::find($request->flatId);
                $flatId = $getFlatDetails->id;
                $locality = $getFlatDetails->locality;
                $block = $getFlatDetails->block;
                $plot = $getFlatDetails->plot;
                $knownAs = $getFlatDetails->known_as;
            } else {
                $flatId = $getDetail->flat_id;
                $locality = $getDetail->locality;
                $block = $getDetail->block;
                $plot = $getDetail->plot;
                $knownAs = $getDetail->known_as;
            }
            UserProperty::create([
                'user_id' => $userId,
                'old_property_id' => $request->oldPropertyId,
                'new_property_id' => $propertyDetails->id,
                'flat_id' => $flatId,
                'locality' => $locality,
                'block' => $block,
                'plot' => $plot,
                'known_as' => $knownAs,
                'section_code' => $propertyDetails->section_code ?: '',
                'property_link_status' => 1
            ]);
        }
    }


    //Add by lalit on 31/07/2024 to update user registration
    protected function updateUserRegistrationStatus($id)
    {
        $isUpdateStatus =  UserRegistration::where('id', $id)->update(['status' => getStatusName('RS_APP')]);
        if ($isUpdateStatus) {
            $registerUser =  UserRegistration::where('id', $id)->first();
            $applicationMovement = ApplicationMovement::create([
                'assigned_by'           => Auth::user()->id,
                // 'service_type'          => getServiceType('RS_REG'),
                'service_type'          => getServiceType('RS_NEW_REG'),
                'model_id'              => $id,
                'status'                => getStatusName('RS_APP'),
                'application_no'        => $registerUser->applicant_number
            ]);
            if ($applicationMovement) {
                return true;
            }
        } else {
            return false;
        }
    }



    //Add by lalit on 31/07/2024 to reject user registration
    public function rejectRegistration($userRegistrationId, Request $request)
    {
        try {
            if (!empty($userRegistrationId)) {
                $updateStatus = UserRegistration::where('id', $userRegistrationId)->update(['status' => 'rejected']);
                if ($updateStatus) {
                    return true;
                } else {
                    return false;
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    //Add by lalit on 1/08/2024 to move to under review application
    public function moveUnderReviewApplication($id, Request $request)
    {
        try {

            $transactionSuccess = false;
            DB::transaction(function () use ($id, $request, &$transactionSuccess) {
                if (!empty($id)) {
                    // Find the user registration by ID
                    $userRegistrationObj = UserRegistration::find($id);

                    if ($userRegistrationObj) {
                        // Update the user registration attributes
                        $userRegistrationObj->status = getStatusName('RS_UREW');
                        $userRegistrationObj->remarks =  $request->remarks;
                        // Save the changes to the database
                        if ($userRegistrationObj->save()) {
                            //Get User Id which belongs to section_code from user_registration table
                            if (!empty($userRegistrationObj->section_id)) {
                                //Get Deputy L & Do Officer User Id from section_user table where designation_id is 1 for Deputy L&DO
                                $designationId = 1;
                                $assignedToUserId = DB::table('section_user')->where('section_id', $userRegistrationObj->section_id)->where('designation_id', $designationId)->value('user_id');
                                ApplicationMovement::create([
                                    'assigned_by'           => Auth::user()->id,
                                    'assigned_to'           => !empty($assignedToUserId) ? $assignedToUserId : null,
                                    'current_user_id'       => !empty($assignedToUserId) ? $assignedToUserId : null,
                                    // 'service_type'          => getServiceType('RS_REG'),
                                    'service_type'          => getServiceType('RS_NEW_REG'),
                                    'model_id'              => $id,
                                    'status'                => getStatusName('RS_UREW'),
                                    'application_no'        => $userRegistrationObj->applicant_number,
                                    'remarks'               => $request->remarks,
                                    'suggested_property_id' => $request->sPid, // Suggested Property Id
                                    'old_property_id'       => $request->oPid, // Old Property Id
                                ]);
                            }

                            $transactionSuccess = true;
                        }
                    }
                }
            });
            return $transactionSuccess;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    //Add by lalit on 06/08/2024 to approve review request by L&DO
    public function approveReviewRequest(Request $request)
    {
        // dd($request);
        try {
            $transactionSuccess = false;

            DB::transaction(function () use ($request, &$transactionSuccess) {
                // Service type added in where clause by Lalit on 21/08/2024 becasue we are using common application_movement table for both user_registration & newly added property by applicant
                // $maxId = ApplicationMovement::where('model_id', $request->applicationMovementId)->where('service_type', getServiceType('RS_REG'))->max('id');
                // Date 25th September- Change this condition due to earliear only Deputy landdo officer can only see the list of review & under_review application but tester raise the issue like in dashboard we are showign all status listing so deputy landdo can see list of all so after discussion with mam we give all permisison to depute landdo
                $maxId = ApplicationMovement::where('model_id', $request->applicationMovementId)->where('service_type', getServiceType('RS_NEW_REG'))->max('id');
                if ($maxId > 0) {
                    $getAppMovementDetails = ApplicationMovement::find($maxId);
                    if ($getAppMovementDetails) {
                        $newRecordInserted = ApplicationMovement::create([
                            'assigned_by'           => !empty($getAppMovementDetails->assigned_to) ? $getAppMovementDetails->assigned_to :  Auth::user()->id,
                            'assigned_to'           => !empty($getAppMovementDetails->assigned_by) ? $getAppMovementDetails->assigned_by : null,
                            'current_user_id'       => !empty($getAppMovementDetails->assigned_by) ? $getAppMovementDetails->assigned_by :  Auth::user()->id,
                            'service_type'          => !empty($getAppMovementDetails->service_type) ? $getAppMovementDetails->service_type : null,
                            'model_id'              => !empty($getAppMovementDetails->model_id) ? $getAppMovementDetails->model_id : null,
                            'status'                => getStatusName('RS_REW'),
                            'application_no'        => !empty($getAppMovementDetails->application_no) ? $getAppMovementDetails->application_no : null,
                            'remarks'               => $request->remarks,
                            'suggested_property_id' => !empty($getAppMovementDetails->suggested_property_id) ? $getAppMovementDetails->suggested_property_id : null,
                            'old_property_id'       => !empty($getAppMovementDetails->old_property_id) ? $getAppMovementDetails->old_property_id : null,
                        ]);
                        if ($newRecordInserted) {
                            //Update status for old record
                            $userRegistrationObj = UserRegistration::find($request->applicationMovementId);
                            $userRegistrationObj->status = getStatusName('RS_REW');
                            $userRegistrationObj->remarks = $request->remarks;
                            $userRegistrationObj->save();
                            $transactionSuccess = true;
                        }
                    }
                }
            });

            return $transactionSuccess;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    //Add by lalit on 21/08/2024 to move to under review new property
    public function moveUnderReviewNewProperty($id, Request $request)
    {
        try {
            $transactionSuccess = false;
            DB::transaction(function () use ($id, $request, &$transactionSuccess) {
                if (!empty($id)) {
                    // Find new applicant property by ID
                    $newPropertyObj = NewlyAddedProperty::find($id);

                    if ($newPropertyObj) {
                        // Update the user registration attributes
                        $newPropertyObj->status = getStatusName('RS_UREW');
                        $newPropertyObj->remarks =  $request->remarks;
                        // Save the changes to the database
                        if ($newPropertyObj->save()) {
                            //Get User Id which belongs to section_code from user_registration table
                            if (!empty($newPropertyObj->section_id)) {
                                //Get Deputy L & Do Officer User Id from section_user table where designation_id is 1 for Deputy L&DO
                                $designationId = 1;
                                $assignedToUserId = DB::table('section_user')->where('section_id', $newPropertyObj->section_id)->where('designation_id', $designationId)->value('user_id');
                                ApplicationMovement::create([
                                    'assigned_by'           => Auth::user()->id,
                                    'assigned_to'           => !empty($assignedToUserId) ? $assignedToUserId : null,
                                    'current_user_id'       => !empty($assignedToUserId) ? $assignedToUserId : null,
                                    'service_type'          => getServiceType('RS_NEW_PRO'),
                                    'model_id'              => $id,
                                    'status'                => getStatusName('RS_UREW'),
                                    'application_no'        => $newPropertyObj->applicant_number,
                                    'remarks'               => $request->remarks,
                                    'suggested_property_id' => $request->sPid, // Suggested Property Id
                                    'old_property_id'       => $request->oPid, // Old Property Id
                                ]);
                            }

                            $transactionSuccess = true;
                        }
                    }
                }
            });
            return $transactionSuccess;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    //Add by lalit on 21/08/2024 to approve review request by L&DO
    public function approveReviewNewPropertyRequest(Request $request)
    {
        // dd($request);
        try {
            $transactionSuccess = false;

            DB::transaction(function () use ($request, &$transactionSuccess) {
                $maxId = ApplicationMovement::where('model_id', $request->applicationMovementId)->where('service_type', getServiceType('RS_NEW_PRO'))->max('id');
                if ($maxId > 0) {
                    $getAppMovementDetails = ApplicationMovement::find($maxId);
                    if ($getAppMovementDetails) {
                        $newRecordInserted = ApplicationMovement::create([
                            'assigned_by'           => !empty($getAppMovementDetails->assigned_to) ? $getAppMovementDetails->assigned_to :  Auth::user()->id,
                            'assigned_to'           => !empty($getAppMovementDetails->assigned_by) ? $getAppMovementDetails->assigned_by : null,
                            'current_user_id'       => !empty($getAppMovementDetails->assigned_by) ? $getAppMovementDetails->assigned_by :  Auth::user()->id,
                            'service_type'          => !empty($getAppMovementDetails->service_type) ? $getAppMovementDetails->service_type : null,
                            'model_id'              => !empty($getAppMovementDetails->model_id) ? $getAppMovementDetails->model_id : null,
                            'status'                => getStatusName('RS_REW'),
                            'application_no'        => !empty($getAppMovementDetails->application_no) ? $getAppMovementDetails->application_no : null,
                            'remarks'               => $request->remarks,
                            'suggested_property_id' => !empty($getAppMovementDetails->suggested_property_id) ? $getAppMovementDetails->suggested_property_id : null,
                            'old_property_id'       => !empty($getAppMovementDetails->old_property_id) ? $getAppMovementDetails->old_property_id : null,
                        ]);
                        if ($newRecordInserted) {
                            //Update status for old record
                            $userRegistrationObj = NewlyAddedProperty::find($request->applicationMovementId);
                            $userRegistrationObj->status = getStatusName('RS_REW');
                            $userRegistrationObj->remarks = $request->remarks;
                            $userRegistrationObj->save();
                            $transactionSuccess = true;
                        }
                    }
                }
            });

            return $transactionSuccess;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    //Add by lalit on 21/08/2024 to approve user registeration
    public function approveApplicantNewProperty(Request $request)
    {
        try {
            $transactionSuccess = false;

            DB::transaction(function () use ($request, &$transactionSuccess) {
                // Fetch newly added property details
                $property = NewlyAddedProperty::find($request->newlyAddedPropertyId);
                if (!empty($property)) {
                    $propertyDetails = PropertyMaster::where('old_propert_id', $request->oldPropertyId)->first();
                    // $this->createDocumentForNewProperty($property, $propertyDetails->id, $request->oldPropertyId, $property->user_id);
                    $this->createDocumentForNewProperty($property, $propertyDetails->id, $request, $property->user_id);
                    $this->mapUserWithNewProperty($property->user_id, $request, $property);
                    $this->updateApplicantNewPropertyStatus($request->newlyAddedPropertyId);
                    // //Send User creadentials on email
                    $user = User::find($property->user_id);
                    if ($user) {
                        $data = [
                            'name' => $user->name,
                            'regNo' => $property->applicant_number
                        ];
                        $action = 'N_PRO_SUC';
                        // Apply the mail settings before sending the email
                        $this->settingsService->applyMailSettings($action);
                        Mail::to($user->email)->send(new CommonMail($data, $action));
                        $this->communicationService->sendSmsMessage($data, $user->mobile_no, $action, $user->country_code);
                        $this->communicationService->sendWhatsAppMessage($data, $user->mobile_no, $action, $user->country_code);
                    }
                    $transactionSuccess = true;
                }
            });

            return $transactionSuccess;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    protected function updateNewApplicantPropertyStatus($request)
    {
        $newProperty =  NewlyAddedProperty::where('id', $request->newlyAddedPropertyId)->first();
        ApplicationStatus::create([
            'service_type'              => getServiceType('RS_NEW_PRO'),
            'model_id'                  => $request->newlyAddedPropertyId,
            'reg_app_no'                => $newProperty->applicant_number,
            'is_mis_checked'            => $request->is_mis_checked ? true : false,
            'is_scan_file_checked'      => $request->is_scan_file_checked ? true : false,
            'is_uploaded_doc_checked'   => $request->is_uploaded_doc_checked ? true : false,
            'created_by'                => Auth::user()->id,
        ]);
    }

    protected function createDocumentForNewProperty($property, $newPropertyId, $request, $userId)
    {
        $modelId = $request->newlyAddedPropertyId;
        $flatId = !empty($request->flatId) ? $request->flatId : $property->flat_id;
        $oldPropertyId = !empty($request->oldPropertyId) ? $request->oldPropertyId : $property->old_property_id;

        // List of document columns
        $docColumns = [
            'sale_deed_doc',
            'builder_buyer_agreement_doc',
            'lease_deed_doc',
            'substitution_mutation_letter_doc',
            'owner_lessee_doc',
            'other_doc'
        ];

        // Iterate over each document column
        foreach ($docColumns as $column) {
            $oldPath = $property->$column;

            if ($oldPath) {
                // Extract the directory part from the URL (before the file name)
                $parsedUrl = parse_url($oldPath, PHP_URL_PATH);
                $directoryParts = explode('/', $parsedUrl);

                // Get the old path part dynamically (it's the last directory part before the file name)
                $oldPathPart = $directoryParts[count($directoryParts) - 2];

                // Replace the old path part with the new path part in the URL
                $newPath = str_replace($oldPathPart, $newPropertyId, $oldPath);

                // Update the property object with the new URL
                $property->$column = $newPath;

                // Rename the directory on the server
                $oldDirectory = public_path(str_replace('/', DIRECTORY_SEPARATOR, dirname($parsedUrl)));
                $newDirectory = str_replace($oldPathPart, $newPropertyId, $oldDirectory);

                // Log the directory paths for debugging
                // Log::info("Old Directory: $oldDirectory");
                // Log::info("New Directory: $newDirectory");

                try {
                    // Check if the old directory exists
                    if (File::exists($oldDirectory)) {
                        // If the new directory does not exist, create it
                        if (!File::exists($newDirectory)) {
                            File::makeDirectory($newDirectory, 0755, true, true); // Create directory with permissions
                            File::move($oldDirectory, $newDirectory);
                        } else {
                            Log::warning("Directory already exists: $newDirectory");
                        }
                    } else {
                        Log::warning("Old directory not found: $oldDirectory");
                    }
                } catch (\Exception $e) {
                    Log::error("Error renaming or creating directory from $oldDirectory to $newDirectory: " . $e->getMessage());
                }
            }
        }

        // Save the updated record to the database
        $property->save();

        // Define the document types and corresponding columns
        $documentTypes = [
            'sale_deed_doc' => 'Sale Deed',
            'builder_buyer_agreement_doc' => 'Builder Buyer Agreement',
            'lease_deed_doc' => 'Lease Deed',
            'substitution_mutation_letter_doc' => 'Substitution Mutation Letter',
            'owner_lessee_doc' => 'Owner Lessee',
            'other_doc' => 'Other Document',
            'authorised_signatory_doc' => 'Authorized Signatory',
            'chain_of_ownership_doc' => 'Chain Of Owndership'
        ];

        // Create documents for each document type
        foreach ($documentTypes as $field => $documentName) {
            if (!empty($property->$field)) {
                Document::create([
                    'title' => $documentName,
                    'file_path' => $property->$field,
                    'user_id' => $userId,
                    'property_master_id' => $newPropertyId,
                    'old_property_id' => $oldPropertyId ?? null,
                    'flat_id' => $flatId ?? null,
                    'service_type' => getServiceType('RS_NEW_PRO'), // Ensure this exists in the Items table
                    'model_name' => 'NewlyAddedProperty',
                    'model_id' => $modelId,
                    'document_type' => $documentName
                ]);
            }
        }
    }

    /*protected function createDocumentForNewProperty($property, $newPropertyId, $oldPropertyId, $userId)
    {
        // List of document columns
        $docColumns = [
            'sale_deed_doc',
            'builder_buyer_agreement_doc',
            'lease_deed_doc',
            'substitution_mutation_letter_doc',
            'owner_lessee_doc',
            'other_doc'
        ];

        // Iterate over each document column
        foreach ($docColumns as $column) {
            $oldPath = $property->$column;

            if ($oldPath) {
                // Extract the directory part from the URL (before the file name)
                $parsedUrl = parse_url($oldPath, PHP_URL_PATH);
                $directoryParts = explode('/', $parsedUrl);

                // Get the old path part dynamically (it's the last directory part before the file name)
                $oldPathPart = $directoryParts[count($directoryParts) - 2];

                // Replace the old path part with the new path part in the URL
                $newPath = str_replace($oldPathPart, $newPropertyId, $oldPath);

                // Update the property object with the new URL
                $property->$column = $newPath;

                // Rename the directory on the server
                $oldDirectory = public_path(dirname($parsedUrl));
                $newDirectory = str_replace($oldPathPart, $newPropertyId, $oldDirectory);

                try {
                    if (File::exists($oldDirectory) && !File::exists($newDirectory)) {
                        File::move($oldDirectory, $newDirectory);
                    } else {
                        Log::warning("Directory already exists or old directory not found: $oldDirectory");
                    }
                } catch (\Exception $e) {
                    Log::error("Error renaming directory from $oldDirectory to $newDirectory: " . $e->getMessage());
                }
            }
        }

        // Save the updated record to the database
        $property->save();

        // Define the document types and corresponding columns
        $documentTypes = [
            'sale_deed_doc' => 'other_property',
            'builder_buyer_agreement_doc' => 'other_property',
            'lease_deed_doc' => 'other_property',
            'substitution_mutation_letter_doc' => 'other_property',
            'owner_lessee_doc' => 'other_property',
            'other_doc' => 'other_property',
            'authorised_signatory_doc' => 'other_property',
            'chain_of_ownership_doc' => 'other_property'
        ];

        // Create documents for each document type
        foreach ($documentTypes as $field => $documentType) {
            if (!empty($property->$field)) {
                $documentParts = explode('/', $property->$field);
                $documentName = end($documentParts);

                Document::create([
                    'title' => $documentName,
                    'file_path' =>  $property->$field,
                    'user_id' => $userId,
                    'property_master_id' => $newPropertyId,
                    'old_property_id' => $oldPropertyId,
                    'service_type' => getServiceType('RS_NEW_PRO'), // Ensure this exists in the Items table
                    'document_type' => $documentType
                ]);
            }
        }
    }*/

    //Add by lalit on 31/07/2024 to map user to property
    protected function mapUserWithNewProperty($userId, $request, $property)
    {
        // $sectionCode = PropertyMaster::where('id', $request->suggestedPropertyId)->value('section_code');
        //This changes is made on 27 August after changes suggested property id from id to old_property_id
        $propertyDetails = PropertyMaster::where('old_propert_id', $request->oldPropertyId)->first();
        if ($propertyDetails) {
            UserProperty::create([
                'user_id' => $userId,
                'old_property_id' => $request->oldPropertyId,
                'new_property_id' => $propertyDetails->id,
                'flat_id' => !empty($property->flat_id) ? $property->flat_id : null,
                'locality' => $property->locality,
                'block' => $property->block,
                'plot' => $property->plot,
                'known_as' => $property->known_as,
                'section_code' => $propertyDetails->section_code ?: '',
                'property_link_status' => 1
            ]);
        }
    }

    //Add by lalit on 31/07/2024 to update user registration
    protected function updateApplicantNewPropertyStatus($id)
    {
        $isUpdateStatus =  NewlyAddedProperty::where('id', $id)->update(['status' => getStatusName('RS_APP')]);
        if ($isUpdateStatus) {
            $newlyAddedProperty =  NewlyAddedProperty::where('id', $id)->first();
            $applicationMovement = ApplicationMovement::create([
                'assigned_by'           => Auth::user()->id,
                'service_type'          => getServiceType('RS_NEW_PRO'),
                'model_id'              => $id,
                'status'                => getStatusName('RS_APP'),
                'application_no'        => $newlyAddedProperty->applicant_number
            ]);
            if ($applicationMovement) {
                return true;
            }
        } else {
            return false;
        }
    }
}
