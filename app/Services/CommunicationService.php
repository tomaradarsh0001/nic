<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Configuration;
use App\Models\Template;

class CommunicationService
{
    protected $variables = [];

    public function __construct()
    {
    }

    //to send whatsapp message
    public function sendWhatsAppMessage($data,$number,$action, $countryCode = null)
    {
        $sameConfiguration = Configuration::where('type', 'whatsapp')
        ->where('action', $action)
        ->where('status', 1)
        ->first();
        if($sameConfiguration){
            $configuration = $sameConfiguration;
        } else {
            $defaultConfiguration = Configuration::where('type', 'whatsapp')->where('action','DEFAULT' )->where('status', 1)->first();
            $configuration = $defaultConfiguration;
        }
        if ($configuration) {
            $message = $this->getTemplate($data,'whatsapp',$action);
            $key = $configuration->key;
            $token = $configuration->auth_token;
            $whatsAppFrom = $configuration->whatsapp_number;
            $baseUrl = $configuration->api;
            $vendor = $configuration->vendor;
            switch ($vendor) {
                case 'Twilio':
                    $response = Http::withBasicAuth($key, $token)
                    ->asForm()
                    ->post($baseUrl, [
                        'To' => "whatsapp:+91{$number}",
                        // 'To' => "whatsapp:+{$countryCode}{$number}",
                        'From' => $whatsAppFrom,
                        'Body' => $message,
                    ]);
                    break;
                    
                    case 'Nexmo':
                    $response = Http::withBasicAuth($key, $token)
                                ->withHeaders([
                                    'Accept' => 'application/json',
                                ])
                                ->post($baseUrl, [
                                    'from' => $whatsAppFrom,
                                    'to' => "91{$number}",
                                    // 'to' => "{$countryCode}{$number}",
                                    'message_type' => 'text',
                                    'text' => $message,
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

    //to send text sms
    public function sendSmsMessage($data,$number,$action, $countryCode = null)
    {
        $sameConfiguration = Configuration::where('type', 'sms')
        ->where('action', $action)
        ->where('status', 1)
        ->first();
        if($sameConfiguration){
            $configuration = $sameConfiguration;
        } else {
            $defaultConfiguration = Configuration::where('type', 'sms')->where('action','DEFAULT' )->where('status', 1)->first();
            $configuration = $defaultConfiguration;
        }
        if ($configuration) {
            $message = $this->getTemplate($data,'sms',$action);
            $key = $configuration->key;
            $token = $configuration->auth_token;
            $smsFrom = $configuration->sms_number;
            $baseUrl = $configuration->api;
            $vendor = $configuration->vendor;
            switch ($vendor) {
                case 'Twilio':
                    $response = Http::withBasicAuth($key, $token)
                        ->asForm()
                        ->post($baseUrl, [
                            'To' => "+91{$number}",
                            // 'To'   => "+{$countryCode}{$number}", // Clean string interpolation
                            'From' => $smsFrom,
                            'Body' => $message,
                        ]);
                    break;
            
                case 'Nexmo':
                    $response = Http::post($baseUrl, [
                        'to' => "+91{$number}",
                        // 'to' => "+{$countryCode}{$number}",
                        'from' => 'EDHARTI',
                        'text' => $message,
                        'api_key' => $key,
                        'api_secret' => $token
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

    public function getTemplate($data,$type,$action)
    {
        $template = Template::where('action', $action)
                        ->where('type', $type)
                        ->where('status', 1)
                        ->value('template');
        return $this->createTemplate($template,$data);
    }


    public function createTemplate($template,$data)
    {
        foreach ($data as $key => $value) {
            $template = str_replace("@[{$key}]", $value, $template);
        }
        return $template;
    }


}
