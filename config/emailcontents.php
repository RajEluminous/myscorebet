<?php
//Email contents

return [
    'emails' => [
        # Member Registration
        '1' => [
            'subject'  => config('app.name') . ' Signup | Verification',
            'message'  => '<p>Hello [USER_NAME], </p><p>Thank you for registering with '.env('APP_NAME').'.</p><p><br/>Your account is registered with the e-mail address: [USER_EMAIL] </p><p>Use password that you entered during registration.</p><p><br/>Please click on the link below to activate your account.</p><p><a style="font-family:Avenir,Helvetica,sans-serif;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1; border-right:18px solid #3097d1;border-bottom:10px solid #3097d1; border-left:18px solid #3097d1;" href="[USER_ACTIVATION_URL]">Activate</a></p>',
        ],
        # Member Reset Password
        '2' => [
            'subject'  => config('app.name') . ' Reset Password',
            'message'  => '<p>Hello [USER_NAME], </p><p>You are receiving this email because we received a password reset request for your account.</p><p><br/><a style="font-family:Avenir,Helvetica,sans-serif;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1; border-right:18px solid #3097d1;border-bottom:10px solid #3097d1; border-left:18px solid #3097d1;" href="[USER_PWRESET_URL]">Reset Password</a></p><p>If you did not request a password reset, no further action is required.</p>',
        ],
        # Member Score Submission
        '3' => [
            'subject'  => config('app.name') . ' Score Submission',
            'message'  => '<p>Hello [USER_NAME], </p><p>Thank you for submitting your score predictions with '.config('app.name').'.</p><p><br/>Here is your score prediction:</p><p>Event name: [EVENT_NAME]</p>
                <p>Match details: [SUBEVENTS]</p><p><br/><br/>If you have any questions, just email at '.env('MAIL_FROM_ADDRESS').'</p>',
        ],
        # Admin - Winner mail
        '4' => [
            'subject'  => config('app.name') . ' Winner',
            'message'  => '<p>Congratulations [USER_NAME], </p><p>Your prediction on <strong>[SUBEVENTS], [EVENT_NAME] </strong>was perfect.</p><p><br/>Here is your prediction detail:</p><p>Event name: [EVENT_NAME]</p><p>Match details: [SUBEVENTS] </p><p>Your score: [USER_SCORE]</p><p>Actual score: [ADMIN_SCORE]</p><p><br/><br/>If you have any questions, just email at '.env('MAIL_FROM_ADDRESS').'</p>',
        ],
        # Member - Myaccount change password mail
        '5' => [
            'subject'  => config('app.name') . ' Password Changed',
            'message'  => '<p>Hello [USER_NAME], </p><p>Your password has successfully changed.</p><p>Clck here to login : <a style="font-family:Avenir,Helvetica,sans-serif;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#3097d1;border-top:10px solid #3097d1; border-right:18px solid #3097d1;border-bottom:10px solid #3097d1; border-left:18px solid #3097d1;" href="[SITE_LOGIN_URL]">Login</a></p><p><br/><br/>If you have any questions, just email at '.env('MAIL_FROM_ADDRESS').'</p>',
        ],
        # Admin - Cancelled match mail
        '6' => [
            'subject'  => config('app.name') . ' Event Cancellation',
            'message'  => '<p>Hello [USER_NAME], </p><p>Event name: [EVENT_NAME]</p><p>Match: [SUBEVENTS] has been cancelled. </p><p><br/><br/>If you have any questions, just email at '.env('MAIL_FROM_ADDRESS').'</p>',
        ]
    ],
];
