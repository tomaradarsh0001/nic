<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\CodeIgniterCache;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


class ChatBotController extends Controller
{
    public function handle()
    {
       dd(request()->route());
        $config = [
            'conversation_cache_time' => 40,

            'user_cache_time' => 30,
            'matchingData' => [
                'driver' => 'web',
            ],
        ];
        $botman = app('botman');
        $botman->hears('{message}', function($botman, $message) {
            if (in_array(strtolower($message), ['hi', 'hello', 'hey'])) {
                $this->askName($botman);
            } else {
                $botman->reply('Invalid Input! or type <b>Hi</b> to start again.');
            }
        });
        $botman->hears('(?i)register', function ($bot) {
            $bot->reply('You selected registration. <a href="http://edhartiv3.eu-north-1.elasticbeanstalk.com/public-register" target="_blank">Click here to Register</a>');
        });
        $botman->hears('(?i)login', function ($bot) {
            $bot->reply('You selected login. <a href="https://ldo.gov.in/edharti/SSL/Login.aspx" target="_blank">Click here to Login</a>');
        });
        $botman->hears('(?i)payment', function ($bot) {
            $bot->reply('You Selected Payment Help. <a href="https://ldo.gov.in/WriteReadData/UserFiles/file/Payment%20Procedure%20on%20eDharti%20Version.pdf" target="_blank">Click here for Help</a>');
        });
        $botman->hears('(?i)grievance', function ($bot) {
            $bot->reply('You Selected Public Grievance. <a href="https://pgportal.gov.in/" target="_blank">Click here to Open</a>');
        });
        $botman->hears('(?i)helpdesk', function ($bot) {
            $bot->reply('You Selected Complaint/Helpdesk. <a href="https://ldo.gov.in/Feedback.aspx" target="_blank">Click here to Open</a>');
        });
        $botman->hears('(?i)contact', function ($bot) {
            $bot->reply('Land and Development Office <br>Ministry of Urban Development <br>Gate #4, A Wing, 6th floor, Moulana Azad Road, Nirman Bhawan <br>New Delhi - 110 011 <br>Phone : 23062871 Fax : 23061384 <br><br><br>Information Facilitation Counter (Ground Floor) Gate #4, A Wing, Nirman Bhawan <br>Phone : 23022174 - extn:2940 <br>Email Address:ldo@nic.in');
        });
        $botman->hears('(?i)edharti', function ($bot) {
            $bot->reply('You selected eDharti. <a href="https://ldo.gov.in/edharti/" target="_blank">Click here to Redirect to eDharti</a>');
        });
        $botman->hears('(?i)email', function ($bot) {
            $bot->reply('Please contact us with email <b>ldo@nic.in</b>');
        });  
        $botman->hears('(?i)number', function ($bot) {
            $bot->reply('Please contact us with tollfree number <b>0120-23062871</b>');
        });  
        $botman->hears('(?i)address', function ($bot) {
            $bot->reply('Land and Development Office <br>Ministry of Urban Development <br>Gate #4, A Wing, 6th floor, Moulana Azad Road, Nirman Bhawan <br>New Delhi - 110 011 </b>');
        }); 
        $botman->hears('(?i)else', function ($bot) {
            $bot->reply('You selected something else. Please contact us with email <b>ldo@nic.in</b>');
        });       
        
        $botman->hears('(?i)help', function ($bot) {
            $question = Question::create("Please Choose an Option What exactly are you looking for?")
                ->fallback("Unable to help at this time, please try again later.")
                ->callbackId("choose_query")
                ->addButtons([
                    Button::create("Register as a Applicant")->value("register"),
                    Button::create("Login as a Applicant")->value("login"),
                    Button::create("Payment Help")->value("payment"),
                    Button::create("Public Grievance")->value("grievance"),
                    Button::create("Complaints/Helpdesk")->value("helpdesk"),
                    Button::create("Login to eDharti Portal")->value("edharti"),
                    Button::create("Contact Us")->value("contact"),
                    Button::create("Choose something else")->value("else"),
                ]);
        
            $bot->ask($question, function (Answer $answer) use ($bot) {
                $value = $answer->getValue();
        
                if ($value === 'register') {
                    $bot->reply('You Selected registration. http://edhartiv3.eu-north-1.elasticbeanstalk.com/public-register" target="_blank">Click here to Register</a>');
                } elseif ($value === 'login') {
                    $bot->reply('You Selected login. <a href="https://ldo.gov.in/edharti/SSL/Login.aspx" target="_blank">Click here to Login</a>');
                } elseif ($value === 'payment') {
                    $bot->reply('You Selected Payment Help. <a href="https://ldo.gov.in/WriteReadData/UserFiles/file/Payment%20Procedure%20on%20eDharti%20Version.pdf" target="_blank">Click here for Help</a>');
                } elseif ($value === 'grievance') {
                    $bot->reply('You Selected Application/Public Grievance. <a href="https://pgportal.gov.in/" target="_blank">Click here to Open</a>');
                }  elseif ($value === 'helpdesk') {
                    $bot->reply('You Selected Complaint/Helpdesk. <a href="https://ldo.gov.in/Feedback.aspx" target="_blank">Click here to Open</a>');
                }   elseif ($value === 'contact') {
                    $bot->reply('Land and Development Office <br>Ministry of Urban Development <br>Gate #4, A Wing, 6th floor, Moulana Azad Road, Nirman Bhawan <br>New Delhi - 110 011 <br>Phone : 23062871 Fax : 23061384 <br><br><br>Information Facilitation Counter (Ground Floor) Gate #4, A Wing, Nirman Bhawan <br>Phone : 23022174 - extn:2940 <br>Email Address:ldo@nic.in');
                }   elseif ($value === 'edharti') {
                    $bot->reply('You selected eDharti. <a href="https://ldo.gov.in/edharti/" target="_blank">Click here to Redirect to eDharti</a>');
                } else {
                    $bot->reply('You selected something else.');
                }
            });
        });

        
        $botman->listen();
    }
    public function askName($botman)
    {
        $botman->ask('Hello! May I know your First Name?', function(Answer $answer) {
            $name = $answer->getText();         
          if (strtolower($name) === 'no') {
              $this->say('Thanks lets end the chat.');
          } else {
              $this->say('Thanks, '.$name.'! Type <b>HELP</b> for more options.');
          }
            // $this->say('Thanks! '.$name.' Type <b>HELP</b> for Getting more Options');
        });
    }
    public function showAbout($botman)
    {
        $botman->reply('To Provide the Facility of Online Application Submission through Web-Based Online Application System for the Properties under the jurisdiction of Land and Development Office (L&DO) for the Citizens. 
        <br>
        <br>
        नागरिकों के लिए भूमि और विकास कार्यालय (एल एंड डीओ) के अधिकार क्षेत्र के तहत संपत्तियों के संदर्भ में वेब-आधारित ऑनलाइन प्रणाली के माध्यम से आवेदन की सुविधा प्रदान करना ।');
    }
}
