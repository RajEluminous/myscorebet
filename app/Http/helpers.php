<?php
/* #############################################################################
# eLuminous Technologies - Copyright (C)  http://eluminoustechnologies.com
# This code is written by eLuminous Technologies, Its a sole property of
#eLuminous Technologies and cant be used / modified without license.
#Any changes/ alterations, illegal uses, unlawful distribution, copying is strictly
#prohibhited
#############################################################################
# Name: helper.php
# Created on : JULY 2018
# Purpose: File to add common functions in the admin panel of a site
#############################################################################
//ALSO STRICTLY MAINTAINING THE LOGS OF CHANGES AND PERSON NAME
#############################################################################
*/

/**
 * @name sendEmail
 * @purpose send email
 * @return RETURN_TYPE (string)
 */
function sendEmail($recipient = '', $recipientName = '', $subject = '', $mailContent = '', $cc=''){

    // echo 'recipient=>'.$recipient;
    // echo '<br/>recipientName'.$recipientName;
    // echo '<br/>$subject'.$subject;
    // echo '<br/>$mailContent'.$mailContent;
    // echo '<br/>$cc'.$cc;
    // die;
    ini_set('xdebug.max_nesting_level', 120);

    $sender      = env('MAIL_FROM_ADDRESS');
    $senderName  = env('MAIL_FROM_NAME');
     //Get data
    $data        = array('strMailCont' => $mailContent);
    $emailData   = array('recipient' => $recipient,
                        'recipientName' => $recipientName,
                        'sender' => $sender,
                        'senderName' => $senderName,
                        'subject' => $subject,
                        'cc' => $cc);

    if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
        $response = Mail::send(['html'=>'emails.email'], $data, function($message) use ($emailData) {
                    $message->sender($emailData['sender'], $emailData['senderName']);
                    $message->from($emailData['sender'], $emailData['senderName']);
                    $message->replyTo($emailData['sender'], $emailData['senderName']);
                    $message->to($emailData['recipient'], $emailData['recipientName']);

                    if(!empty($emailData['cc'])){
                          $cc = explode(',', $emailData['cc']);
                          if(is_array($cc))
                              $message->cc($cc);
                    }
                    //$message->getQuote($emailData['subject']);
                    $message->subject($emailData['subject']);
                });
            return $response;
    }
    else {
      return false;
    }
}

//MOve image of a user
if (! function_exists('move_file')) {
    function move_file($file, $type='products.slide', $withWatermark = false)
    {
        // Grab all variables
        $path = explode('.', $type)[0];
        $destinationPath = config('variables.'.$path.'.folder');
        $width           = config('variables.' . $type . '.width');
        $height          = config('variables.' . $type . '.height');
        $full_name       = str_random(16) . '.' . $file->getClientOriginalExtension();

        if ($width == null && $height == null) { // Just move the file
            $file->storeAs($destinationPath, $full_name);
            return $full_name;
        }

        // Create the Image
        $image           = Image::make($file->getRealPath());

        if ($width == null || $height == null) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }else{
            $image->fit($width, $height);
        }

        if ($withWatermark) {
            $watermark = Image::make(public_path() . '/img/watermark.png')->resize($width * 0.5, null);

            $image->insert($watermark, 'center');
        }

        return $image->save($destinationPath . '/' . $full_name)->basename;
    }
}

//MOve image of a user
if (! function_exists('create_excel')) {
    function create_excel($file,$title,$arrContents = array(),$condition)
    {
        // File name for download
        $fp_fileName = $file.'_'.date('Ymd').'_'.time().".xlsx";
        $fp_header_col_names= array();
        $fp_cell     = 1;
        $char_cell   = 'A';
        
        // switch( $condition )
        // {
        //     case 'overall_records' :             
         $fp_header_col_names = array('A' => 'Name', 'B' => 'Email', 'C' => 'Registration Date', 'D' => 'Total Points');
                //break;
        //}
                    
        //Print Header Values
        if(!empty($fp_header_col_names))
        {
            //Get First element Key
            reset($fp_header_col_names);
            $first_col_key  =   key($fp_header_col_names);

            //Get Last element Key
            end($fp_header_col_names);
            $last_col_key   =   key($fp_header_col_names);

            $excel = new \PHPExcel();

            $excel->createSheet();
            $excel->setActiveSheetIndex(0);
            // set default font
            $excel->getDefaultStyle()->getFont()->setName('Calibri');
            // set default font size
            $excel->getDefaultStyle()->getFont()->setSize(12);
            $excel->getActiveSheet()->setTitle($title);
            $objWorksheet = $excel->getActiveSheet();

            //Style to first Column
            $styleArray = array(
                'font'      =>  array(
                    'bold'  =>  true,
                    'color' =>  array('rgb' => '3939ac'),
                    'size'  =>  12,
                    'name'  =>  'Times New Roman'
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'wrap' =>   true
                ),
                'borders' => array(
                            'allborders' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )
                )
            );
            
            // Set Cell Width 
            $nCols = 1000; //set the number of columns
            foreach (range(0, $nCols) as $col) {
                $excel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);                
            }       
            
            //If data not empty
            if($arrContents) {
                
                //For event header
                if($condition == 'eventwise_records' || $condition == 'monthwise_records') {

                    $objWorksheet->getStyle( $first_col_key. $fp_cell .':'. $last_col_key.$fp_cell )->applyFromArray($styleArray);
                    $objWorksheet->getCell( $char_cell.$fp_cell )->setValue( $title );
                    $excel->getActiveSheet()->mergeCells('A1:D1'); 
                    $fp_cell+=2;   
                }

                // let's bold and size the header font and write the header
                // as you can see, we can specify a range of cells.
                $objWorksheet->getStyle( $first_col_key. $fp_cell .':'. $last_col_key.$fp_cell )->applyFromArray($styleArray);

                //Print Header Data
                foreach($fp_header_col_names as $head_key => $fp_header_cols)
                {
                   $objWorksheet->getCell( $head_key.$fp_cell )->setValue( $fp_header_cols );
                }

                //Print Data
                $fp_cell++;
                $arrContents = $arrContents->toArray();

                foreach($arrContents as $key => $item)
                {   
                    $char_cell = 'A';
                  
                    $objWorksheet->getCell( $char_cell++.$fp_cell)->setValue( $item['first_name'].' '.$item['last_name'] );                      
                    $objWorksheet->getCell( $char_cell++.$fp_cell)->setValue( $item['email']);
                    $objWorksheet->getCell( $char_cell++.$fp_cell)->setValue(date('d-m-Y', strtotime($item['created_at'])));
                    $objWorksheet->getCell( $char_cell.$fp_cell)->setValue( $item['totalpoints']);   
                   
                    $fp_cell++;
                }
            }
            else {
                //If data empty
                return 1;
                //$objWorksheet->getCell( $char_cell.$fp_cell)->setValue( 'No records found' );   
            }
        }
        
        $writer = new \PHPExcel_Writer_Excel2007($excel);
        $writer->setIncludeCharts(TRUE);

        // Save the file.
       // $writer->save(storage_path().'/'.$fp_fileName);
       header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
       header('Content-Disposition: attachment; filename="'.$fp_fileName.'"');
       $writer->save("php://output");
       exit;
    }
}

//Declaration of assest folder path
if (! function_exists('assetPath')) {
    function assetPath($path, $secure = null)
    {
        return app('url')->asset('/public/'.$path, $secure);
    }
}

//Render boolean column to checkbox . Active and inactive status declaration 
if (! function_exists('getStatus')) {
    function getStatus($getStatus)
    {
        $strStatus = '';
        if ($getStatus == 'y') {
            $strStatus = '<div class="text-center text-success"><span class="fa fa-check-circle"></span></div>';
        }

        if ($getStatus == 'n') {
            $strStatus = '<div class="text-center text-danger"><span class="fa fa-times-circle lg"></span></div>';
        }

        if ($getStatus == 'c') {
            $strStatus = '<div class="text-center text-warning"><span>Cancelled</span></div>';
        }
        echo $strStatus;
    }
}

//Get month name according to id 
if (! function_exists('getMonth')) {
    function getMonth($monthId) {
        $arrMonths      = config('variables.months');
        $strMonthName   = '-';
        if($arrMonths) {
            foreach ($arrMonths as $key => $data) {
                if($key == $monthId) {
                    $strMonthName = $data;
                    break;
                }
            }
        }
        return $strMonthName;
    }
}

//Get month name according to id 
if (! function_exists('getSubevents')) {
    function getSubevents($eventId) {
        $intSubevents = 0;
        $arrSubevents = DB::select('SELECT count(id) as cntsubevents FROM subevents WHERE isActive = "y" AND isDeleted = "n" AND eventid = '.$eventId.'');
        $intSubevents = (isset($arrSubevents)) ?  $arrSubevents[0]->cntsubevents : 0;
        return $intSubevents;
    }
}

//Get subevents according to event id
if (! function_exists('getAllSubEvents')) {
    function getAllSubEvents($eventId) {
        $strToday = date('Y-m-d H:i:s');
        $arrSubevents = array();
        $arrSubevents = DB::table('subevents')
                     ->select(DB::raw('id,eventid, name_team1, name_team2, logo_team1, logo_team2, expiry_datetime'))
                     ->where([
                             ['isActive','=','y'],
                             ['isDeleted','=','n'],
                             ['eventid','=',$eventId]      
                   ])->where('expiry_datetime', '>=', $strToday)
                     ->orderBy('expiry_datetime', 'asc')
                     ->offset(0)->limit(20)->get();
        return $arrSubevents;
    }
}

//Get user predictions
// if (! function_exists('getUserPredictions')) {
//     function getUserPredictions($userId, $eventId, $subeventId) {
//         $arrSubevents  = array();
//         $arrData    = DB::table('user_score_prediction')
//                     ->select('pred_score_team1', 'pred_score_team2')
//                     ->where([
//                             ['uid','=',$userId],
//                             ['eventid','=',$eventId],  
//                             ['subeventid','=',$subeventId]      
//                       ])->first();
//         return  $arrData;
//     }
// }