<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseNotificationController extends Controller
{
    protected $firebase;
    protected $messaging;

    public function __construct()
    {
        $this->firebase = (new Factory)
            ->withServiceAccount(storage_path('logistic-notifications-app-firebase-adminsdk-3o8f3-b660cd953d.json'));

        $this->messaging = $this->firebase->createMessaging();
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'firebase_token' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
            'image' => 'nullable|url', 
        ]);

        $message = CloudMessage::new()
            ->withTarget('token', $request->input('firebase_token'))
            ->withNotification([
                'title' => $request->input('title'),
                'body' => $request->input('message'),
                'image' => $request->input('image')  // Add the image to the notification
            ])
            ->withData([
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ]);

        // Send the notification
        try {
            $this->messaging->send($message);
            return response()->json(['success' => true, 'message' => 'Notification sent successfully!']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
