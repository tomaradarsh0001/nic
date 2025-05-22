<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralFunctions;
use App\Http\Controllers\Controller;
use App\Models\ApplicantUserDetail;
use App\Models\Application;
use App\Models\ApplicationAppointmentLink;
use App\Models\Holiday;
use App\Models\NewlyAddedProperty;
use App\Models\OldColony;
use App\Models\PropertyMaster;
use App\Models\PropertySectionMapping;
use App\Models\User;
use App\Models\UserProperty;
use App\Models\PropertyLeaseDetail;
use App\Models\TempDocument;
use App\Models\TempDocumentKey;
use App\Services\ColonyService;
use App\Services\MisService;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommonMail;
use App\Services\CommunicationService;

class ApplicantController extends Controller
{
    protected $communicationService;
    protected $settingsService;

    public function __construct(CommunicationService $communicationService, SettingsService $settingsService)
    {
        $this->communicationService = $communicationService;
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {
        $user = User::find(Auth::id());
        return view('applicant.index', ['user' => $user]);
    }

    public function propertiesDetails(ColonyService $colonyService, MisService $misService)
    {
        $user = User::with('applicantUserDetails', 'userProperties.documents', 'userProperties.flat')->findOrFail(Auth::id());
        $colonyList = $colonyService->getColonyList();
        $propertyTypes = $misService->getItemsByGroupId(1052);
        //Get Newly Added Property Details
        $newProperties = NewlyAddedProperty::where('user_id', Auth::id())->where('status', getStatusName('RS_PEN'))->get();
        return view('applicant.property', compact('user', 'colonyList', 'propertyTypes', 'newProperties'));
    }


    public function applicationHistory()
    {
        return view('applicant.application_history');
    }

    public function storeNewProperty(Request $request)
    {
        $userId = Auth::id();
        if (isset($request->propertyId)) {
            $locality   = $request->localityInvFill;
            $block      = $request->blocknoInvFill;
            $plot       = $request->plotnoInvFill;
            $knownAs    = $request->knownasInvFill;
            $landUseType    = $request->landUseInvFill;
            $landUseSubType    = $request->landUseSubtypeInvFill;
        } else {
            $locality   = $request->localityInv;
            $block      = $request->blockInv;
            $plot       = $request->plotInv;
            $knownAs    = $request->knownasInv;
            $landUseType    = $request->landUseInv;
            $landUseSubType    = $request->landUseSubtypeInv;
        }
        $saleDeedDoc  = $request->saleDeedDocInv;
        $builAgreeDoc = $request->BuilAgreeDocInv;
        $leaseDeedDoc = $request->leaseDeedDocInv;
        $subMutLtrDoc = $request->subMutLtrDocInv;
        $otherDocDoc = $request->otherDocInv;
        $ownerLessDocInv = $request->ownerLessDocInv;

        //Check existing property for applicant
        $userPropertyQuery = UserProperty::where([
            ['user_id', '=', $userId],
            ['locality', '=', $locality],
            ['block', '=', $block],
            ['plot', '=', $plot],
        ]);
        if (isset($request->flat)) {
            $userPropertyQuery->where('flat_id', '=', $request->flat);
        }
        $userPropertyExist = $userPropertyQuery->first();
        if ($userPropertyExist) {
            if (isset($request->flat_no)) {
                return redirect()->back()->with('failure', 'Property already exists with Property ID ' . $propertyExists->new_property_id . ' & Flat ID ' . $request->flat_no);
            } else {
                return redirect()->back()->with('failure', 'Property already exists with Property ID ' . $propertyExists->new_property_id);
            }
        }

        //Check property alredy exist for this user or not
        $newPropertyQuery = NewlyAddedProperty::where([
            ['user_id', '=', $userId],
            ['locality', '=', $locality],
            ['block', '=', $block],
            ['plot', '=', $plot],
        ]);
        if (isset($request->flat)) {
            $newPropertyQuery->where('flat_id', '=', $request->flat);
        }
        $newPropertyExist = $newPropertyQuery->first();
        if ($newPropertyExist) {
            if (isset($request->flat_no)) {
                return redirect()->back()->with('failure', 'Property already exists with Property ID ' . $newPropertyExist->new_property_id . ' & Flat ID ' . $request->flat_no);
            } else {
                return redirect()->back()->with('failure', 'Property already exists with Property ID ' . $newPropertyExist->new_property_id);
            }
        }

        //Fetch Suggested Property Id from Property Master
        $property = PropertyMaster::where('new_colony_name', $locality)->where('block_no', $block)->where('plot_or_property_no', $plot)->first();
        if (!empty($property['id'])) {
            $oldPropertyId = $property['old_propert_id'];
            $suggestedPropertyId = $property['id'];
        } else {
            $oldPropertyId = null;
            $suggestedPropertyId = null;
        }

        $getApplicantNumber = ApplicantUserDetail::where('user_id', $userId)->first();
        if (!empty($getApplicantNumber['id'])) {
            $applicantNumber = $getApplicantNumber['applicant_number'];
        } else {
            $applicantNumber = '';
        }


        $section = PropertySectionMapping::where('colony_id', $locality)
            ->where('property_type', $landUseType)
            ->where('property_subtype', $landUseSubType)
            ->pluck('section_id')->first();

        if (!isset($section)) {
            $section  = 0;
        }

        //get unique registration number
        // $registrationNumber = GeneralFunctions::generateRegistrationNumber();
        $registrationNumber = 'NEW_PROPERTY';
        $date = now()->format('Y-m-d');
        $colony = OldColony::find($locality);
        $colonyCode = $colony->code;
        if (isset($saleDeedDoc)) {
            $saleDeedDoc = GeneralFunctions::uploadFile($saleDeedDoc, $applicantNumber . '/' . $colonyCode . '/other_property/' . $block . '_' . $plot, 'saledeed');
        }
        if (isset($builAgreeDoc)) {
            $builAgreeDoc = GeneralFunctions::uploadFile($builAgreeDoc, $applicantNumber . '/' . $colonyCode . '/other_property/' . $block . '_' . $plot, 'BuilderAgreement');
        }
        if (isset($leaseDeedDoc)) {
            $leaseDeedDoc = GeneralFunctions::uploadFile($leaseDeedDoc, $applicantNumber . '/' . $colonyCode . '/other_property/' . $block . '_' . $plot, 'leaseDeed');
        }
        if (isset($subMutLtrDoc)) {
            $subMutLtrDoc = GeneralFunctions::uploadFile($subMutLtrDoc, $applicantNumber . '/' . $colonyCode . '/other_property/' . $block . '_' . $plot, 'subsMutLetter');
        }
        if (isset($otherDocDoc)) {
            $otherDocDoc = GeneralFunctions::uploadFile($otherDocDoc, $applicantNumber . '/' . $colonyCode . '/other_property/' . $block . '_' . $plot, 'other');
        }
        if (isset($ownerLessDocInv)) {
            $ownerLessDocInv = GeneralFunctions::uploadFile($ownerLessDocInv, $applicantNumber . '/' . $colonyCode . '/other_property/' . $block . '_' . $plot, 'ownerLessee');
        }

        $newProperyAdded = NewlyAddedProperty::create([
            'old_property_id' => $oldPropertyId,
            'suggested_property_id' => $suggestedPropertyId,
            'user_id' => $userId,
            'applicant_number' => $applicantNumber,
            'locality' => $locality,
            'block' => $block,
            'plot' => $plot,
            'flat_id' => !empty($request->flat) ? $request->flat : null,
            'is_property_flat' => !empty($request->isPropertyFlat) ? $request->isPropertyFlat : 0,
            'flat_no' => !empty($request->flat_no) ? $request->flat_no : null,
            'known_as' => !empty($knownAs) ? $knownAs : null,
            'land_use_type' => $landUseType,
            'land_use_sub_type' => $landUseSubType,
            'section_id' => $section,
            'sale_deed_doc' => $saleDeedDoc,
            'builder_buyer_agreement_doc' => $builAgreeDoc,
            'lease_deed_doc' => $leaseDeedDoc,
            'substitution_mutation_letter_doc' => $subMutLtrDoc,
            'other_doc' => $otherDocDoc,
            'owner_lessee_doc' => $ownerLessDocInv,
            'status' => getStatusName('RS_PEN')
        ]);

        if ($newProperyAdded) {
            return redirect()->back()->with('success', 'Your property added successfully. Waiting for administrator approval');
        } else {
            return redirect()->back()->with('failure', 'Property not added successfully. Something went wrong');
        }
    }

    public function appointment($applicationId, $tiestamp)
    {
        $applicationNo = base64_decode($applicationId);
        $application = Application::where('application_no', $applicationNo)->first();

        if (empty($application)) {
            return redirect()->route('dashboard')->with('failure', config('messages.application.error.appNotfound'));
        }
        if ($application->created_by != Auth::id()) {
            return redirect()->route('dashboard')->with('failure', config('messages.general.error.accessDenied'));
        }
        $data['application'] = $application;
        $appointmentLink = url()->current();
        $appointmentCount = ApplicationAppointmentLink::where('link', $appointmentLink)->count();
        /* if ($appointmentCount > 1) {
            return redirect()->route('dashboard')->with('failure', config('messages.application.error.rescheduleLimitExceeded'));
        } */
        $appointmentData = ApplicationAppointmentLink::where('link', $appointmentLink)->latest()->first();
        // case when link not fouund
        if (empty($appointmentData)) {
            return redirect()->route('dashboard')->with('failure', config('messages.application.error.appointmentLinkNotFound'));
        }
        if (strtotime('today') > strtotime($appointmentData->valid_till)) {
            return redirect()->route('dashboard')->with('failure', config('messages.application.error.linkExpired'));
        }
        $data['appointmentData'] = $appointmentData;

        /** show which  dates are available in calendar */
        $minDate = date('Y-m-d', strtotime('+2 days', strtotime($appointmentData->created_at)));
        $maxDate = $appointmentData->valid_till;
        $bookedDates = ApplicationAppointmentLink::whereDate('schedule_date', '>=', $minDate)
            ->whereDate('schedule_date', '<=', $maxDate)
            ->where('link', '<>', $appointmentLink)
            ->where('is_active', 1)
            ->pluck('schedule_date')
            ->toArray();
        $holidays = Holiday::whereDate('date', '>=', $minDate)
            ->whereDate('date', '<=', $maxDate)
            ->pluck('date')
            ->toArray();

        // Calculate weekend offs (Saturday and Sunday)
        $weekendOff = [];
        $period = new DatePeriod(
            new DateTime($minDate),
            new DateInterval('P1D'),
            (new DateTime($maxDate))->modify('+1 day')
        );

        foreach ($period as $date) {
            if (in_array($date->format('N'), [6, 7])) { // 6 = Saturday, 7 = Sunday
                $weekendOff[] = $date->format('Y-m-d');
            }
        }

        $calendarData = [
            "dateFormat" => "Y-m-d",
            'minDate' => $minDate,
            'maxDate' => $maxDate,
            'disable' => array_merge($bookedDates, $holidays, $weekendOff),
            'defaultDate' => !is_null($appointmentData->schedule_date) ? [$appointmentData->schedule_date] : [],
            'bookedDates' => $bookedDates,
            'holidays' => $holidays
        ];
        $data['calendarData'] = $calendarData;

        return view('applicant.appointment', $data);
    }

    public function bookAppointment(Request $request)
    {
        $appointmentId = $request->appointmentId;
        $appointmentDate = $request->appointmentDate;
        //check if date is alrady booked
        $dateBooked = ApplicationAppointmentLink::where('schedule_date', $appointmentDate)->where('is_active', 1)->exists();
        if ($dateBooked) {
            return response()->json(['status' => false, 'message' => config('messages.application.error.appointmentTaken')]);
        }

        //check if resceduing the appointment. inactive previous appointment
        $appointmentData = ApplicationAppointmentLink::find($appointmentId);
        $applicationNo = $appointmentData->application_no;
        $rescheduleLimitExceeded = (ApplicationAppointmentLink::where('link', $appointmentData->link)->count() > 1);
        if ($rescheduleLimitExceeded) {
            return response()->json(['status' => false, 'message' => config('messages.application.error.rescheduleLimitExceeded')]);
        }

        if (!is_null($appointmentData->schedule_date)) { //reschedule appointment
            $appointmentData->update(['is_active' => 0]);
            //make new entry
            $newAppointmentData = $appointmentData->toArray();
            unset(
                $newAppointmentData['id'],
                $newAppointmentData['created_at'],
                $newAppointmentData['updated_at'],
                $newAppointmentData['is_active'],
                $newAppointmentData['schedule_date']
            );
            $newAppointment = ApplicationAppointmentLink::create(array_merge($newAppointmentData, ['schedule_date' => $appointmentDate, 'is_active' => 1]));
            $action = "APP_RE_MEET_ACK";
        } else {
            // enter appointment date in alreay given link
            $appointmentData->update(['schedule_date' => $appointmentDate, 'is_active' => 1]);
            $action = "APP_MEETING_ACK";
        }
        //for sending notification to applicant for scheduled appointment - SOURAV CHAUHAN (24 FEB 2025)
        $application = Application::where('application_no', $applicationNo)->first();
        $model = '\\App\\Models\\' . $application->model_name;
        $getApplicationDetails = $model::where('id', $application->model_id)->first();
        if ($application->model_name == 'MutationApplication') {
            $mailServiceType = 'Mutation';
        } else if ($application->model_name == 'ConversionApplication') {
            $mailServiceType = 'Conversion';
        } else if ($application->model_name == 'DeedOfApartmentApplication') {
            $mailServiceType = 'Deed Of Apartment';
        } else if ($application->model_name == 'LandUseChangeApplication') {
            $mailServiceType = 'Land Use Change';
        } else {
            $mailServiceType = '';
        }

        $oldPropertyId = $getApplicationDetails->old_property_id;
        $propertyMasterId = $getApplicationDetails->property_master_id;
        $newPropertyId = $getApplicationDetails->new_property_id;
        $propertyKnownAs = PropertyLeaseDetail::where('property_master_id', $propertyMasterId)
                            ->pluck('presently_known_as')
                            ->first();

        //for send notification - SOURAV CHAUHAN (24/FEB/2025)
        $user = User::find($application->created_by);
        $data = [
            'application_no' => $applicationNo,
            'application_type' => $mailServiceType,
            'property_details' => $propertyKnownAs . " [" . $oldPropertyId . " (" . $newPropertyId . ") ]",
            'date' => Carbon::parse($appointmentDate)
                    ->setTimezone('Asia/Kolkata')
                    ->format('d M Y'),
            'time' => Carbon::now('Asia/Kolkata')->setTime(14, 0, 0)->format('H:i:s')
        ];
        $checkEmailTemplateExists = checkTemplateExists('email', $action);
        if (!empty($checkEmailTemplateExists)) {
            // Apply mail settings and send notifications
            $this->settingsService->applyMailSettings($action);
            Mail::to($user['email'])->send(new CommonMail($data, $action));
        }

        $mobileNo = $user['mobile_no'];
        $checkSmsTemplateExists = checkTemplateExists('sms', $action);
        if (!empty($checkSmsTemplateExists)) {
            $this->communicationService->sendSmsMessage($data, $mobileNo, $action);
        }
        $checkWhatsappTemplateExists = checkTemplateExists('whatsapp', $action);
        if (!empty($checkWhatsappTemplateExists)) {
            $this->communicationService->sendWhatsAppMessage($data, $mobileNo, $action);
        }
        return response()->json(['status' => true, 'message' => config('messages.application.success.appointmentScheduled')]);
    }

    //For deleting the document and all the keys if user unchecked the checkbox at step first in mtation - SOURAV CHAUHAN (07 March 2025)
    public function deleteValuesForUncheckedDocument(Request $request){
        $documentType = $request->id;
        $modelId = $request->updatedId;
        $modelName = 'TempSubstitutionMutation';
        $documentAvailable =  TempDocument::where('model_name',$modelName)->where('model_id',$modelId)->where('document_type',$documentType)->first();
        // dd($documentAvailable);
        if($documentAvailable){
            if($documentAvailable->delete()){
                $tempDocumentKeys = TempDocumentkey::where('temp_document_id',$documentAvailable->id)->get();
                if($tempDocumentKeys){
                    foreach($tempDocumentKeys as $tempDocumentKey){
                        $tempDocumentKey->delete();
                    }
                }
                return response()->json(['status' => true, 'message' => config('messages.application.success.documentDelete')]);
            } else {
                return response()->json(['status' => false, 'message' => config('messages.application.error.documentNotDelete')]);
            }
        } else {
            return response()->json(['status' => 2]);
        }
    }
}
