<?php
namespace App\Services;
use Illuminate\Support\Facades\Config;

use Illuminate\Http\Request;
use App\Models\Configuration;
use Illuminate\Support\Facades\Http;
 
class SettingsService
{
    public function applyMailSettings($action)
    {
       // Retrieve the mail settings from the database
       $sameMailSettings = Configuration::where('type', 'email')->where('action', $action)->where('status', 1)->first();
       if($sameMailSettings){
           $mailSettings = $sameMailSettings;
       } else {
           $defaultmailSettings = Configuration::where('type', 'email')->where('action', 'DEFAULT')->where('status', 1)->first();
           $mailSettings = $defaultmailSettings;
       }
        
        if ($mailSettings) {
            // Set mail configuration dynamically
            Config::set('mail.mailers.smtp.host', $mailSettings->host);
            Config::set('mail.mailers.smtp.port', $mailSettings->port);
            Config::set('mail.mailers.smtp.username', $mailSettings->key);
            Config::set('mail.mailers.smtp.password', $mailSettings->auth_token);
            Config::set('mail.mailers.smtp.encryption', $mailSettings->encryption);
            Config::set('mail.from.address', $mailSettings->email);
            // Config::set('mail.from.name', 'eDharti');
        }
    }


    public function testMailSettings($id)
    {
        // Retrieve the mail settings from the database
        $mailDetails = Configuration::find($id);
        
        if ($mailDetails) {
            // Set mail configuration dynamically
            Config::set('mail.mailers.smtp.host', $mailDetails->host);
            Config::set('mail.mailers.smtp.port', $mailDetails->port);
            Config::set('mail.mailers.smtp.username', $mailDetails->key);
            Config::set('mail.mailers.smtp.password', $mailDetails->auth_token);
            Config::set('mail.mailers.smtp.encryption', $mailDetails->encryption);
            Config::set('mail.from.address', $mailDetails->email);
            // Config::set('mail.from.name', 'eDharti');
        }
    }


    public function testSmsSettings($id,$mobile)
    {
        $smsDetails = Configuration::find($id);
        $vendor = $smsDetails->vendor;
        if($vendor == 'Twilio'){
            $response = Http::withBasicAuth($smsDetails->key, $smsDetails->auth_token)
                ->asForm()
                ->post($smsDetails->api, [
                    'To' => "+91{$mobile}",
                    'From' => $smsDetails->sms_number,
                    'Body' => 'Test Sms from eDharti Portal',
                ]); 
        } else if($vendor == 'Nexmo'){
            $response = Http::post($smsDetails->api, [
                'to' => "+91{$mobile}",
                'from' => 'EDHARTI',
                'text' => 'Test Sms from eDharti Portal',
                'api_key' => $smsDetails->key,
                'api_secret' => $smsDetails->auth_token
            ]);
        }
        if ($response->successful()) {
            return true;
        } elseif ($response->failed()) {
            return false;
        } else {
            return false;
        }
            
    }


    public function testWhatsappSettings($id,$number)
    {
        $whatsappDetails = Configuration::find($id);
        $vendor = $whatsappDetails->vendor;
        switch ($vendor) {
            case 'Twilio':
                // dd($vendor);
                $response = Http::withBasicAuth($whatsappDetails->key, $whatsappDetails->auth_token)
                ->asForm()
                ->post($whatsappDetails->api, [
                    'To' => "whatsapp:+91{$number}",
                    'From' => $whatsappDetails->whatsapp_number,
                    'Body' => "Test Sms from eDharti Portal"
                ]);
                break;

                case 'Nexmo':
                $response = Http::withBasicAuth($whatsappDetails->key, $whatsappDetails->auth_token)
                            ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                            ->post($whatsappDetails->api, [
                                'from' => $whatsappDetails->whatsapp_number,
                                'to' => "91{$number}",
                                'message_type' => 'text',
                                'text' => 'Test Sms from eDharti Portal',
                                'channel' => 'whatsapp',
                            ]);
                break;
        
            default:
                // Handle unsupported vendor or throw an exception
                throw new \Exception("Unsupported vendor: {$vendor}");
        }
        if ($response->successful()) {
            return true;
        } elseif ($response->failed()) {
            return false;
        } else {
            return false;
        }
            
    }
}