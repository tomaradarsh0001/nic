<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralFunctions;
use App\Models\ApplicationCharge;
use App\Models\Country;
use App\Models\Demand;
use App\Models\Payment;
use App\Models\PropertyMaster;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function paymentResponse(Request $request)
    {
        // dd(Auth::user());
        $returned = $request->BharatkoshResponse;
        // $returned = 'PD94bWwgdmVyc2lvbj0iMS4wIj8%2BPHBheW1lbnRTZXJ2aWNlIHZlcnNpb249IjEuMCIgbWVyY2hhbnRDb2RlPSJNRVJDSEFOVCI%2BPHJlcGx5PjxvcmRlclN0YXR1cyBvcmRlckNvZGU9IlBBQzIwMjUwMTMwMTc0NjQwIiBzdGF0dXM9IlNVQ0NFU1MiPjxyZWZlcmVuY2UgaWQ9IjMwMDEyNTAxMjgyNTAiIEJhbmtUcmFuc2Fjc3Rpb25EYXRlPSIwMS8zMC8yMDI1IDE3OjQ3OjMwIiBUb3RhbEFtb3VudD0iMjAwMC4wMCI%2BPC9yZWZlcmVuY2U%2BPC9vcmRlclN0YXR1cz48L3JlcGx5PjxTaWduYXR1cmUgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvMDkveG1sZHNpZyMiPjxTaWduZWRJbmZvPjxDYW5vbmljYWxpemF0aW9uTWV0aG9kIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvVFIvMjAwMS9SRUMteG1sLWMxNG4tMjAwMTAzMTUiIC8%2BPFNpZ25hdHVyZU1ldGhvZCBBbGdvcml0aG09Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvMDkveG1sZHNpZyNyc2Etc2hhMSIgLz48UmVmZXJlbmNlIFVSST0iIj48VHJhbnNmb3Jtcz48VHJhbnNmb3JtIEFsZ29yaXRobT0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wOS94bWxkc2lnI2VudmVsb3BlZC1zaWduYXR1cmUiIC8%2BPC9UcmFuc2Zvcm1zPjxEaWdlc3RNZXRob2QgQWxnb3JpdGhtPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwLzA5L3htbGRzaWcjc2hhMSIgLz48RGlnZXN0VmFsdWU%2BeEdNbTZDNFdwZmJZb2xhMGRHblpDY1lReExRPTwvRGlnZXN0VmFsdWU%2BPC9SZWZlcmVuY2U%2BPC9TaWduZWRJbmZvPjxTaWduYXR1cmVWYWx1ZT5xS3V4UWJnTWZ4QS9KRngrZEd5bGpsbTNZbFV3bk5xOHZ0WTlhR1FKdHJ6Y2lXYy8vTUh2bmFOVzJ3WU9GbGsvMGhMLzVtWGZiVkxaQ0V2dnBqakZvY0FTK3E0ZUNEdnJ0UmZFeDl0SC8rUHVJd1BZeGVYcCtZc01GdytqMk9KU0FQdXBOeXovRlFzR0pPcGRIVjlLM1V0dmhkcTVYR0VzS29mNHR1ZExqaUJFL3g3UDNacmlvTTZBT0VReDZBMlVQMkN6cFdlNjJuQkNyT3VTa2VOcUg5REQ1SGdDWTArMzFjaDlZaWZhc21LZWpwQWhLZktyQVp1N1IxbHgxQzdORno1VjNxa0RPcUgxbVpWRzYrK0x0bTA5TUczZm13UENZYlVBMFJNZ0YrVVRuMmpIMEV5YTV2Uy9OTThjY2xIWTBiY2dqa0ZqU25pMXVCcndydlpyWkE9PTwvU2lnbmF0dXJlVmFsdWU%2BPEtleUluZm8%2BPFg1MDlEYXRhPjxYNTA5SXNzdWVyU2VyaWFsPjxYNTA5SXNzdWVyTmFtZT5DTj1HZW9UcnVzdCBUTFMgUlNBIENBIEcxLCBPVT13d3cuZGlnaWNlcnQuY29tLCBPPURpZ2lDZXJ0IEluYywgQz1VUzwvWDUwOUlzc3Vlck5hbWU%2BPFg1MDlTZXJpYWxOdW1iZXI%2BMTI3NDE2Mzk1NjkyOTg3Njc0ODY1NzUxMTEzMjQyMzk2ODM5MzA8L1g1MDlTZXJpYWxOdW1iZXI%2BPC9YNTA5SXNzdWVyU2VyaWFsPjxYNTA5Q2VydGlmaWNhdGU%2BTUlJR2dUQ0NCV21nQXdJQkFnSVFDWlh6VlRHMmMwQ3FFeG4rWnRSaFdqQU5CZ2txaGtpRzl3MEJBUXNGQURCZ01Rc3dDUVlEVlFRR0V3SlZVekVWTUJNR0ExVUVDaE1NUkdsbmFVTmxjblFnU1c1ak1Sa3dGd1lEVlFRTEV4QjNkM2N1WkdsbmFXTmxjblF1WTI5dE1SOHdIUVlEVlFRREV4WkhaVzlVY25WemRDQlVURk1nVWxOQklFTkJJRWN4TUI0WERUSTBNRFV5TWpBd01EQXdNRm9YRFRJMU1EWXlNakl6TlRrMU9Wb3djREVMTUFrR0ExVUVCaE1DU1U0eERqQU1CZ05WQkFnVEJVUmxiR2hwTVJJd0VBWURWUVFIRXdsT1pYY2dSR1ZzYUdreEp6QWxCZ05WQkFvVEhrTnZiblJ5YjJ4c1pYSWdSMlZ1WlhKaGJDQnZaaUJCWTJOdmRXNTBjekVVTUJJR0ExVUVBeE1MY0dadGN5NXVhV011YVc0d2dnRWlNQTBHQ1NxR1NJYjNEUUVCQVFVQUE0SUJEd0F3Z2dFS0FvSUJBUUN1L2ppd1h4N2lzaC9ud1NJdUQzM2hKaUt2cUpuNE8rTXpVeWtCOWhCUkErL0Jsci9CZmpVTERBdmdBd2YwbHBSTEMyaTZBTC9Yblp0b0p3OEhDaVEvNUhnRVRKU2NRTUpvbDFQZnJnSUpaZGlYUGswZXFyVW1EVWtmYmpWT3hWUmRwRjA5ellvdDZuZG1nS2pMR1VBVzAvcDQvdjlEbkExRXBlUVo0NFNrUWs0aUlKallBTUdZTHgzaGZVK3U5Ym1waEs2TnZOZ1ptUThQeDhZcm94M2pPaG5KT3MxMkRCV3F5eHRnQkZnQWt1QmtSV3oxa3UvNnNweU5BaUtobDQ1Q0RVMHhRM0pWSzd4MDdmNFpWS0RnbndvSng0UnM4a3FtUzMzWFM3ajdwTnVNRjZIS25rQlZDK0pDOXBEQkY3R1FiVmZwREduQzdtWXR0bW5QS1V2ZEFnTUJBQUdqZ2dNbE1JSURJVEFmQmdOVkhTTUVHREFXZ0JTVVQ5UmRpK1NrNHFhQS92M1krUUR2bzc0Q1Z6QWRCZ05WSFE0RUZnUVU0aUF4WWZmVU11MDZULzZOcjJvUnFDSTdmVEV3SndZRFZSMFJCQ0F3SG9JTGNHWnRjeTV1YVdNdWFXNkNEM2QzZHk1d1ptMXpMbTVwWXk1cGJqQStCZ05WSFNBRU56QTFNRE1HQm1lQkRBRUNBakFwTUNjR0NDc0dBUVVGQndJQkZodG9kSFJ3T2k4dmQzZDNMbVJwWjJsalpYSjBMbU52YlM5RFVGTXdEZ1lEVlIwUEFRSC9CQVFEQWdXZ01CMEdBMVVkSlFRV01CUUdDQ3NHQVFVRkJ3TUJCZ2dyQmdFRkJRY0RBakEvQmdOVkhSOEVPREEyTURTZ01xQXdoaTVvZEhSd09pOHZZMlJ3TG1kbGIzUnlkWE4wTG1OdmJTOUhaVzlVY25WemRGUk1VMUpUUVVOQlJ6RXVZM0pzTUhZR0NDc0dBUVVGQndFQkJHb3dhREFtQmdnckJnRUZCUWN3QVlZYWFIUjBjRG92TDNOMFlYUjFjeTVuWlc5MGNuVnpkQzVqYjIwd1BnWUlLd1lCQlFVSE1BS0dNbWgwZEhBNkx5OWpZV05sY25SekxtZGxiM1J5ZFhOMExtTnZiUzlIWlc5VWNuVnpkRlJNVTFKVFFVTkJSekV1WTNKME1Bd0dBMVVkRXdFQi93UUNNQUF3Z2dGK0Jnb3JCZ0VFQWRaNUFnUUNCSUlCYmdTQ0FXb0JhQUIzQUU1MW95ZGNtaERET0Z0czFOOC9VdXNkOE9DT0c0MXB3TEg2WkxGaW1qbmZBQUFCajZEZWRUTUFBQVFEQUVnd1JnSWhBUDQ0VXRMSFMyUW9NVVJCalY5TTdZQzRqczlRZmVGQ0x4dm1KejZYNU5CNkFpRUExdFVteHJGRWx3KzdTOVByaFhuMDdNcUxyOWJGZ1AwOGZralBSSmpKdmo0QWRnQjlXUjRTNFhncWV4eGhaM3hlL2ZqUWgxd1VvRTZWbnJrREw5a09qQzU1dUFBQUFZK2czblMzQUFBRUF3QkhNRVVDSVFESk5jSTlQQ2lYdUx1ZUthcEZKeEZPdUJVeE4wMGNLZHl2MDl1K0lTZERLd0lnSUlyUk5YcUhHcS9nNmJWcTRqWks3KzFUblFWNGIwLy84bEdoaTUxV2xiRUFkUURtMGpGalFIZU13UkJCQnRkeHVjN0Iwa0QybG9TRys3cUhNaDM5SGplT1VBQUFBWStnM25URkFBQUVBd0JHTUVRQ0lDeWFSRWtmSWx4bXBaNS9jc3ZhcmYyakczZTFqMy8wOGoybG91eE5YcGNoQWlBRzBWd3V3S0pNb1FrVFNzUzVJclBRVTA3U1pqMlRiQ011TlZhZXJtSkw0ekFOQmdrcWhraUc5dzBCQVFzRkFBT0NBUUVBajFyN1p2U1I2R095cUxXN3hzNTN3bktZZFp1T21zc0pReUIyWmVseFBVVk1oUWp3cUZBQXdMMnlLTUNnbndBb0RzNjFsRkM5c01tZlFsYXNLWWdkSkJjVi9wcWEyeUd4QlpOV2FtaU9rbWNGaUlwSU5WalJKV0FqelRFWkY3RUJiS3d6SFBFcjE5TGNBZVdLalFyWlhWRXQ4QlFjeDZNSFFEYldkTm5qSmxrTUVlWGtjVkIzMm0vczZhOEpYUitxSEx0alZmOVpCeGJpT1VheTE5cC8wK1ZxQVJ5Mk9kb3daRk9KWjZJQlRGc3JkNjl5Qjl4TFNtK0o2c0FXK0pUbFF2emx6QXFlMUQ0WWhSRlplNUliZzk2V25SMWU1OG5tWXBvVGYwemQwWGtSUUc0M3VvWEl5cGtucTIvVS95TnczZ2IzTU1YYi8vd2dtRkhiVldsbjZRPT08L1g1MDlDZXJ0aWZpY2F0ZT48L1g1MDlEYXRhPjwvS2V5SW5mbz48L1NpZ25hdHVyZT48L3BheW1lbnRTZXJ2aWNlPg%3D%3D';
        $decoded = base64_decode($returned); //urldecode($returned)
        $xml = simplexml_load_string($decoded);
        $orderStatusData = $xml->reply->orderStatus;
        $orderCode = $orderStatusData['orderCode'];
        $orderStatus = $orderStatusData['status'];
        $orderStatus = strpos("FAIL",$orderStatus) != false? "FAILED": $orderStatus; // found  "FAIL" in responsed insted of "FAILED"
        $orderRefId = $orderStatusData->reference['id'];

        $paymentRecord = Payment::where('unique_payment_id', $orderCode)->first();
        if (!empty($paymentRecord)) {
            if (!is_null($paymentRecord->created_by)) {
                $authUser = User::find($paymentRecord->created_by);
                if (!empty($authUser)) {
                    Auth::login($authUser);
                }
            }
            $paymentRecord->update([
                'status' => getServiceType('PAY_' . $orderStatus) ?? getServiceType('PAY_PENDING') ,
                'response' => $request->BharatkoshResponse,
                'transaction_id' => $orderRefId,
            ]);
        } else {
            return redirect()->route('paymentStatusDisplay', 'Something went wrong. Payment data is not found');
        }

        if ($orderStatus == "SUCCESS") {
            $payemntService = new PaymentService();
            $payemntService->processSuccessfulPayment($paymentRecord);
        }
        return redirect()->route('paymentStatusDisplay', $orderStatus);
    }

    public function paymentInputForm()
    {
        $data['paymentTypes'] = getItemsByGroupId(17011);
        $data['guestUser'] = true; // flag to indicate this page is for guest user
        return view('payment.input-form', $data);
    }

    public function getPaymentDetails(Request $request)
    {
        $paymentType = $request->paymentType;
        $inputName = $request->inputName;
        $inputValue = $request->inputValue;
        switch ($paymentType) {
            case 'PAY_DEMAND':
                if ($inputName != "demand_id") {
                    return response()->json(['status' => false, 'details' => 'Data not available for this input']);
                }
                $demandId = $inputValue;
                $demand = Demand::where('unique_id', $demandId)->whereIn('status', [getServiceType('DEM_PENDING'), getServiceType('DEM_PART_PAID')])->first();
                if (empty($demand)) {
                    return response()->json(['status' => false, 'details' => 'Data not available for given demannd id']);
                }
                $countries = Country::all();
                $states = DB::table('states')->where('country_id', 101)->get();
                $view =  view('include.parts.demand-details', ['demand' => $demand, 'countries' => $countries, 'states' => $states])->render();
                return response()->json(['status' => true, 'html' => $view]);
                break;

            default:
                return response()->json(['status' => false, 'details' => 'Invalid payment type']);
                break;
        }
    }

    public function paymentStatusDisplay($status)
    {
        $statusMessage = 'Status of payemnt is <b>' . $status . '</b>';
        return view('payment.payment-response', ['data' => $statusMessage]);
    }

    public function checkUpdatedPaymentStatus($paymentId)
    {
        $payment = Payment::find($paymentId);
        $orderId = $payment->unique_payment_id;
        $purposeId = '23092';
        // $url = "http://164.100.129.32/bharatkosh/getstatus";
        $url = config('constants.paymentStatusURL');
        $data = array("OrderId" => $orderId, "PurposeId" => $purposeId);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            $curl_output = trim(curl_exec($ch), '"');
            $apiResponse = explode('|', $curl_output);
            curl_close($ch);
            if (count($apiResponse) > 1) {
                list($orderId, $orderStatus, $transactionId) = $apiResponse;
                if (strtoupper($orderStatus) == "SUCCESS") {
                    $paymentData = Payment::where('unique_payment_id', $orderId)->first();
                    if (!empty($paymentData)) {
                        $paymentService = new PaymentService();
                        $paymentService->processSuccessfulPayment($paymentData);
                    }
                } else {
                }
            } else {
                dd($curl_output, $apiResponse);
                /* print_r($response_api);
                echo "</pre>"; */
            }
        }
    }

    public function applicationPayment($modelName, $modelId)
    {
        $modelClassName = base64_decode($modelName);
        $data['model'] = $modelClassName;
        $id = base64_decode($modelId);
        $data['id'] = $id;
        if ($modelClassName && $id) {
            $model = '\\App\\Models\\' . $modelClassName;
            $row = $model::find($id);
            if ($data) {
                $serviceType = $row->service_type->id;
                $applicationChargesData = ApplicationCharge::where('service_type', $serviceType)->where(function ($query) {
                    return $query->whereNull('effective_date_from')->orWhereDate('effective_date_from', '<=', date('Y-m-d'));
                })->where(function ($query) {
                    return $query->whereNull('effective_date_to')->orWhereDate('effective_date_to', '>=', date('Y-m-d'));
                })->first();
                $data['applicationCharges'] = $applicationChargesData->amount;
                $addressDropdownData = getAddressDropdownData();
                $data = $data + $addressDropdownData;
                return view('payment.application-input', $data);
            }
        } else {
            return back()->with(' failure', "Something went worong!!");
        }
    }

    public function applicationPaymentSubmit(Request $request, PaymentService $paymentService)
    {
        $model = $request->model_name;
        $modelId = $request->id;
        $amount = $request->applicationCharges;
        if ($model && $modelId && $amount > 0) {
            $modelClass = '\\App\\Models\\' . $model;
            $application = $modelClass::find($modelId);
            if (!empty($application)) {
                $propertyMasterId = $application->property_master_id;
                if (is_null($application->splited_property_detail_id)) {
                    $master_old_property_id = $application->old_property_id;
                    $splited_old_property_id = null;
                } else {
                    $masterProperty = PropertyMaster::find($propertyMasterId);
                    $master_old_property_id = $masterProperty->old_propert_id;
                    $splited_old_property_id = $application->old_property_id;
                }
            } else {
                return redirect()->back()->with('failue', 'Something went wrong. Application data not found');
            }
            $uniquePayemntId = 'PAC' . date('YmdHis');
            $payment = Payment::create([
                'property_master_id' => $propertyMasterId,
                'type' => getServiceType('PAY_APP_CHG'),
                'model' => $model,
                'model_id' => $modelId,
                'payment_mode' => getServiceType($request->payment_mode),
                'unique_payment_id' => $uniquePayemntId,
                'splited_property_detail_id' => $application->splited_property_detail_id,
                'master_old_property_id' => $master_old_property_id,
                'splited_old_property_id' => $splited_old_property_id,
                'amount' => $amount,
                'status' => getServiceType('PAY_PENDING'),
                'created_by' => Auth::id()
            ]);
            if ($payment) {

                //save payer details
                GeneralFunctions::savePayerDetails($request->all(), $payment->id);

                // Payment 
                list($countryName, $stateName, $cityName) =  GeneralFunctions::getAddressNames($request->only('country', 'state', 'city'));

                $orderCode = $uniquePayemntId;
                // $orderCode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);
                $paymentData = [
                    'order_code' => $orderCode,
                    'merchant_batch_code' => $orderCode,
                    'installation_id' => '11136',
                    'amount' => $amount,
                    'currency_code' => "INR",
                    'order_content' => '23092',
                    'payemnt_type_id' => config('constants.payment_type_id'),
                    'email' => $request->payer_email,
                    'first_name' => $request->payer_first_name,
                    'last_name' => $request->payer_last_name,
                    'mobile' => $request->payer_mobile,
                    'address_1' => $request->address_1,
                    'address_2' => $request->address_2,
                    'postal_code' => $request->postal_code,
                    'region' => $request->region,
                    'city' => $cityName,
                    'state' => $stateName,
                    'country' => $countryName,
                ];
                // dd($paymentData);
                $transaction = $paymentService->makePayemnt($paymentData);
                // return redirect()->back()->with('success', 'Data saved successfully');
            }
        }
    }
}