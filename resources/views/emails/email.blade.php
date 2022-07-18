<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: email.blade.php
# Created on : 19th July by Ankita
# Purpose: Email Template for sending mail

#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/
?>

<html>
    <head></head>
    <body style="margin:0; padding:0">
      <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-left:1px solid #3A3B3B; border-right:1px solid #3A3B3B;border-top:1px solid #3A3B3B;">
          <tr>
                <td style="padding:15px; font-size:12px; line-height:10px;">
                    {!! $strMailCont !!}
                </td>
          </tr>
          <tr>
                <td style="padding:9px; font-size:12px; line-height:5px;">
                    Regards, <p style="padding-top: 7px;">{{ config('app.name') }}</p>
                </td>
          </tr>
          <tr>
            <td style="padding:1px 5px 1px 5px;color:#a9a9a9;">------------------------------------------------------------------------------------------------------------------------</td>
          </tr>
          <tr>
            <td>
              <p style="padding:3px 10px 9px 10px; color:#a9a9a9"><em><span style="font-size:11px">This message (including any attachments) may contain and privileged information. It is intended only for the use of the person(s) to whom it is addressed ("Intended Recipient"). Any unauthorized use or dissemination of this message in whole or in part is strictly prohibited. If you have received it by mistake please notify the sender by return e-mail and delete this message from your system. </span></em></p>
            </td>
          </tr>
          <tr>
              <td bgcolor="#014a94" height="40" style="color:#c8ddf3; font-size:12px; border-top-style:solid; border-top-color:#3A3B3B; border-top-width:1px; text-align:center; line-height:40px;">&copy; {{ date('Y') }} 
                    <a href="{{ URL::to('/') }}" style="color:#FFFFFF">{{ config('app.name') }} </a>.
                    All Rights Reserved.
              </td>
          </tr>
      </table>
    </body>
</html>