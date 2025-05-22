<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Auth;
use Illuminate\Support\Facades\Log;
use App\Services\SettingsService;

class SmsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(){
        $sms = Configuration::where('type','sms')->paginate(10);
        return view('settings.sms.index',compact(['sms']));
    }

    public function create(){
        return view('settings.sms.create');
    }

    public function store(Request $request){
        try {
            $configuration = Configuration::create([
                'type' => 'sms',
                'action' => $request->smsAction,
                'vendor' => $request->smsVendor,
                'sms_number' => $request->smsNumber,
                'key' => $request->secretId,
                'auth_token' => $request->secretToken,
                'api' => $request->api,
                'status' => 0,
                'created_by' => Auth::user()->id,
            ]);
            if($configuration){
                return redirect()->back()->with('success', 'Sms Settings Saved successfully.');
            } else {
                return redirect()->back()->with('failure', 'Sms Settings Not Saved.');
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('failure', $e->getMessage());
        }

    }

    public function updateStatus($id){
        $configuration = Configuration::find($id);
        $type = $configuration->type;
        $action = $configuration->action;
        $status = $configuration->status;
        if($status == 0){
            $configurations = Configuration::where('type', $type)
                                ->where('action', $action)
                                ->where('id', '!=', $id)
                                ->get();
    
            // Update the status for the filtered records
            foreach ($configurations as $config) {
                $config->status = 0;
                $config->save();
            }

            $configuration->status = 1;
            $configuration->save();
            return redirect()->back()->with('success', 'status updated successfully');
        } else {
            return redirect()->back()->with('failure', "status can't be updated");
        }
    }



    public function edit($id){
        $configuration = Configuration::find($id);
        if($configuration){
            return view('settings.sms.edit',compact(['configuration']));

        } else {
            return redirect()->back()->with('failure', "Details not available.");
        }
    }

    public function update($id, Request $request){
        $configuration = Configuration::find($id);
        if($configuration){
            if($configuration->status == 0){
                $configuration->action = $request->smsAction;
                $configuration->vendor = $request->smsVendor;
                $configuration->sms_number = $request->smsNumber;
                $configuration->key = $request->secretId;
                $configuration->auth_token = $request->secretToken;
                $configuration->api = $request->api;
                if($configuration->save()){
                    return redirect()->back()->with('success', 'Sms Settings updated successfully');
                } else {
                    return redirect()->back()->with('failure', "Sms Settings can't be updated, Please try after some time.");
                }
            } else {
                return redirect()->back()->with('failure', "Can't be updated as sms already activated.");
            }
        } else {
            return redirect()->back()->with('failure', "Can't be updated as details not available.");
        }
    }


    public function smsTest($id){
       
        try {
            $mobile = Auth::user()->mobile_no;
            if($mobile){
                $smsSent = $this->settingsService->testSmsSettings($id,$mobile);
                 if($smsSent){
                    return response()->json(['success' => true, 'message' => 'success']);
                } else {
                    return response()->json(['success' => false, 'message' => 'failed']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'failed']);
            }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                return response()->json(['success' => false, 'message' => 'failed']);
        }

    }
}
