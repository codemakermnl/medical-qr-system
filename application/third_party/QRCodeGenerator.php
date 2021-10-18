<?php 

require_once('phpqrcode/qrlib.php');

Class QRCodeGenerator{

	public function __construct() {

	}

	public function generate ( $qrtext )
    {   
        if(isset($qrtext))
        {
 
            //file path for store images
            $SERVERFILEPATH = './assets/qrcodeci/images/';
            $text = $qrtext;
            $text1= substr($text, 0, 4);
            
            $folder = $SERVERFILEPATH;
            $file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
            $file_name = $folder.$file_name1;
            QRcode::png($text,$file_name);
            
            // echo"<center><img src=".base_url().'images/'.$file_name1."></center";
            return $file_name1;
        }

        return null;
    }
}



?>