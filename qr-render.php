<?php
####################################################################################################
# This is a standalone to be used in an IMG tag                                                    #
####################################################################################################

# plugin specific functions
require( 'phpqrcode.php' ); # this is the merged library from Dominik Dzienia 
	
//------------------------------------------------------------------

include 'phpqrcode/qrlib.php';

$qrdata="Wolfe Candy";
$file=null;
$ecc="H";
$pixel_size="2";
$frame_size="5";
  
// $text variable has data for QR 
if (isset($_REQUEST["qrdata"])){$qrdata = filter_var(urldecode($_REQUEST["qrdata"]), FILTER_SANITIZE_STRING) ;}
if (isset($_REQUEST["file"])){$file = filter_var(urldecode($_REQUEST["file"]), FILTER_SANITIZE_STRING) ;}
if (isset($_REQUEST["ecc"])){$ecc = filter_var(urldecode($_REQUEST["ecc"]), FILTER_SANITIZE_STRING) ;}
if (isset($_REQUEST["pixel_size"])){$pixel_size = filter_var(urldecode($_REQUEST["pixel_size"]), FILTER_SANITIZE_STRING) ;}
if (isset($_REQUEST["frame_size"])){$frame_size = filter_var(urldecode($_REQUEST["frame_size"]), FILTER_SANITIZE_STRING) ;}
  
// QR Code generation using png()
// When this function has only the text parameter it directly outputs QR in the browser
	QRcode::png($qrdata,$file,$ecc,$pixel_size,$frame_size);

/*
QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size);
Parameters: This function accepts five parameters as mentioned above and described below:

$qrdata: This parameter gives the message which needs to be in QR code. It is a mandatory parameter.
$file: It specifies the place to save a generated QR media file.
$ecc: This parameter specifies the error correction capability of QR. It has 4 levels L, M, Q and H.
$pixel_Size: This specifies the pixel size of QR.
$frame_Size: This specifies the size of Qr. It is from level 1-10.
*/

?>