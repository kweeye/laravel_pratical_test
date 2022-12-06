<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\FormRender;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactInfoController extends Controller
{
    
    public function formField()
    {
        try {

            $result = FormRender::where('status',1)->get()->pluck('form_name')->toArray();

            return response()->json([
                'data' => $result,
                'status' => true,
                'message' => 'Form Fields Success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function contactStore(ContactRequest $request)
    {
        try {

            $form_field = $request->get('form_field');

            $data = new ContactInfo;
            if(in_array('name', $form_field)) {
                $data['name'] = $request->get('name');
            }
            if(in_array('phone_number', $form_field)) {
                $data['phone_number'] = $request->get('phone_number');
            }
            if(in_array('dob', $form_field)) {
                $data['dob'] = $request->get('dob');
            }
            if(in_array('gender', $form_field)) {
                $data['gender'] = $request->get('gender');
            }

            $data->save();

            $send = $this->emailSend($data);

            return response()->json([
                'status' => true,
                'message' => 'Contact Info Store Success'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Email Sending
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emailSend($data)
    {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions
        try {
            $email = "yeyintaunt.it@gmail.com";
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'yeyintaunt.it@gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'yeyintaunt.it@gmail.com';   //  sender username
            $mail->Password = 'xxxxxxxx';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('yeyintaunt.it@gmail.com', 'yeyintaunt.it@gmail.com');
            $mail->addAddress($email);

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = "Contact Info Mail";
            $mail->Body    = "Name : ".$data['name']." Phone Number : ".$data['phone_number']." Date Of Birth : ".$data['dob']." Gender : ".$data['gender'] ;

            if( !$mail->send() ) {
                // $message = 'Email not sent.';
                return false;
            }
            else {
                return true;
                // $message = 'Email has been sent.';
            }

        } catch (Exception $e) {
            // $message = 'Message could not be sent.';

            return false;
        }
    }
}
