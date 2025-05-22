<?php

namespace App\Helpers;

use App\Models\UserActionLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Support\Str;


class UserActionLogHelper
{
    public static function UserActionLog($action, $url, $moduleName, $description = null)
    
{
        $fullUrl = $url; 
        $baseUrl = rtrim(url('/'), '/'); 

        $relativeUrl = Str::after($fullUrl, $baseUrl . '/'); 
        $newUrl = $baseUrl . "/edharti/" . ltrim($relativeUrl, '/');

        $baseUrl2 = url('/'); 
        $baseUrl2 = rtrim($baseUrl2, '/');
        $description = preg_replace_callback('/href=["\'](.*?)["\']/', function ($matches) use ($baseUrl2) {
            $originalUrl = $matches[1];
            if (strpos($originalUrl, $baseUrl2) === 0) {
                $newUrl = str_replace($baseUrl2, $baseUrl2 . '/edharti', $originalUrl);
                return 'href="' . $newUrl . '"';
            }
    
            return $matches[0];
        }, $description);
    //did by adarsh for applying /edharti with base url for action logs
  
        $module = Module::where('name', $moduleName)->first();
        if (empty($module)) {
            $newModule =  Module::create(['name' => $moduleName, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
            $moduleId = $newModule->id;
        } else {
            $moduleId = $module->id;
        }
        // Check if a similar log entry already exists for the same user, module, and action
        // $existingLog = UserActionLog::where('user_id', Auth::id())
        // ->where('module_id', $moduleId)
        // ->where('action', $action)
        // ->first();

        // if (!$existingLog) {
            // Create a new log entry if no similar entry exists
            $log = new UserActionLog();
            $log->user_id = Auth::id();
            $log->module_id = $moduleId;
            $log->action = $action;
            $log->url = $newUrl;
            $log->description = $description;
            $log->save();
        // }
    }
}