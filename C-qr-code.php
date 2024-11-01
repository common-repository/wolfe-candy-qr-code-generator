<?php

#######################################################################
#
# The class object for creating a simple QR code
#
#######################################################################
# Part of the Wolfe Candy Creations (C) 2022 plugins

class WlfC_QRCode {

	var $qrdata="";
	var $file=null;
	var $ecc="H";
	var $pixel_size="2";
	var $frame_size="5";
	var $uri="true";
	
	var $HTML_out="";	
	var $current_url=""; 

#----------------------------------------------------------------------

	function Build_QRCode($_atts){
	// returns html for QR code

		$defaults=$this->GetDefaults();
		$atts = shortcode_atts( $defaults, $_atts );

		// get url of current page
		global $wp;
		
		$current_url = home_url( add_query_arg( array(), $wp->request ) );
		
		// check if using calling URI instead of building the current_url
		if (strtolower($this->uri)=="true"){
			$current_url = isset($_SERVER["HTTPS"]) ? "https://" : "http://";
			$current_url .= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
			$current_url = esc_url($current_url);
		}
				
		// get data from shortcode argument	
		$shid= $atts['qrdata'];
		$gid=$shid; 

		// get data from POST - superceeds shortcode
		$urlid = $_REQUEST['qrdata'];
		if ($urlid != ''){$gid= $urlid; }
		
		// if no arg is passed via the URL or the shortcode then use the current URL
		if ($gid==''){ $gid= $current_url; }

		$current_url= urlencode($current_url);
		$this->current_url= $current_url;

		// Include the qrlib file
		include 'phpqrcode/qrlib.php';
		  
		 // build args
		$qr_render = plugin_dir_url(__FILE__)."qr-render.php";
		$qr_arg = "?qrdata=".$gid;		
		if($this->file != ""){ $qr_arg .= "&file=".urlencode($this->file);}
		if($this->ecc != ""){ $qr_arg .= "&ecc=".urlencode($this->ecc);}
		if($this->pixel_size != ""){ $qr_arg .= "&pixel_size=".urlencode($this->pixel_size);}
		if($this->frame_size != ""){ $qr_arg .= "&frame_size=".urlencode($this->frame_size);}
		
		//build alternative params		
		$html_out = '<img src="'.$qr_render.$qr_arg. '">';

		$this->HTML_out = $html_out;
		return $html_out;
	
	}

#----------------------------------------------------------------------

	function SetDefaults($_atts){
	// import the arguments from shortcode and/or POST/REQUEST

		// get args from URL POST (1st precedent) or shortcode argument	(2nd precedent) or settings (3rd precedent) or factory default (4th precedent)
		// set the default option in case shortcode is not populated
		$defaults = $this->GetDefaults();

		$atts = shortcode_atts( $defaults, $_atts );

		$this->qrdata=sanitize_text_field($atts["qrdata"]);	
		$this->file=sanitize_text_field($atts["file"]);
		$this->ecc=sanitize_text_field($atts["ecc"]);	
		$this->pixel_size=sanitize_text_field($atts["pixel_size"]);	
		$this->frame_size=sanitize_text_field($atts["frame_size"]);	
		$this->uri=sanitize_text_field($atts["uri"]);	
		
		// POST / REQUEST takes precendence over shortcode
		if (isset($_REQUEST["qrdata"])){ $this->root=urldecode(sanitize_text_field($_REQUEST["qrdata"]));	}
		if (isset($_REQUEST["file"])){ $this->style_template=urldecode(sanitize_text_field($_REQUEST["file"]));	}
		if (isset($_REQUEST["ecc"])){ $this->icon_home=urldecode(sanitize_text_field($_REQUEST["ecc"]));	}
		if (isset($_REQUEST["pixel_size"])){ $this->icon_middle=urldecode(sanitize_text_field($_REQUEST["pixel_size"]));	}
		if (isset($_REQUEST["frame_size"])){ $this->icon_endpoint=urldecode(sanitize_text_field($_REQUEST["frame_size"]));	}
		if (isset($_REQUEST["uri"])){ $this->icon_endpoint=urldecode(sanitize_text_field($_REQUEST["uri"]));	}

	}
//------------------------------------------------------------------

	function GetDefaults(){
	// returns the factory default array

		// Factory defaults
		$defaults = array(
			'qrdata' => '',
			'ecc'=>"H",
			'pixel_size'=>"2",
			'frame_size'=>"5",
			'uri'=>"true"
		);
		return $defaults;
}

	//----------------------------------------
	




}

//------------------------------------------------------------------

?>