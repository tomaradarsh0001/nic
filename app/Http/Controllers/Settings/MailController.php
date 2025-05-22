<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuration;
use Auth;
use Illuminate\Support\Facades\Log;
use App\Services\SettingsService;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use App\Helpers\GeneralFunctions;



class MailController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }


    public function index(){
        $emails = Configuration::where('type','email')->paginate(10);
        return view('settings.mail.index',compact(['emails']));
    }

    public function create(){
        $actions = GeneralFunctions::getItemsByGroupId(17002);
        return view('settings.mail.create',compact(['actions']));
        // return view('settings.mail.create');
    }

    public function store(Request $request){
        try {
            $configuration = Configuration::create([
                'type' => 'email',
                'action' => $request->mailAction,
                'key' => $request->mailUsername,
                'auth_token' => $request->mailPassword,
                'email' => $request->malFrom,
                'host' => $request->mailHost,
                'port' => $request->mailPort,
                'encryption' => $request->mailEncryption,
                'status' => 0,
                'created_by' => Auth::user()->id,
            ]);
            if($configuration){
                return redirect()->back()->with('success', 'Mail Settings Saved successfully.');
            } else {
                return redirect()->back()->with('failure', 'Mail Settings Not Saved.');
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
            return view('settings.mail.edit',compact(['configuration']));

        } else {
            return redirect()->back()->with('failure', "Details not available.");
        }
    }

    public function update($id, Request $request){
        $configuration = Configuration::find($id);
        if($configuration){
            if($configuration->status == 0){
                $configuration->action = $request->mailAction;
                $configuration->key = $request->mailUsername;
                $configuration->auth_token = $request->mailPassword;
                $configuration->email = $request->malFrom;
                $configuration->host = $request->mailHost;
                $configuration->port = $request->mailPort;
                $configuration->encryption = $request->mailEncryption;
                if($configuration->save()){
                    return redirect()->back()->with('success', 'Mail Settings updated successfully');
                } else {
                    return redirect()->back()->with('failure', "Mail Settings can't be updated, Please try after some time.");
                }
            } else {
                return redirect()->back()->with('failure', "Can't be updated as mail already activated.");
            }
        } else {
            return redirect()->back()->with('failure', "Can't be updated as details not available.");
        }
    }

    public function mailTest($id){
       
        try {
            $email = Auth::user()->email;
             // Apply the mail settings before sending the email
             $this->settingsService->testMailSettings($id);
             $mailSent = Mail::to($email)->send(new TestMail());
             if($mailSent){
                return response()->json(['success' => true, 'message' => 'success']);
            } else {
                 return response()->json(['success' => false, 'message' => 'failed']);
                }
            } catch (\Exception $e) {
                Log::info($e->getMessage());
                return response()->json(['success' => false, 'message' => 'failed']);
        }

    }
}