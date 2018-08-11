<?php
/**
 * /ezbuy/common/lib/CompressionAndCaching.php
 * $Date: 2009/03/24 08:13:39 $
 * $Revision: 1.2 $ - slechner/GDIC
 *
 * General Description:
 * This is the library class created for handling compression and caching in EzBuy. The compression and caching indicators can be set both
 * globally and locally.
 * Compression will work only if the requesting browser can handle the compressed content.
 * Caching will work only if both the local and global indicators are set to true.
 *
 * +------------------------------------------------------------------------------------------------------+
 * | Code Structure:
 * | --------------
 * | Declare and initialise variables
 * | Create constructor
 * | Set the new values for variables as per the parameters (if passed)
 * | Call the start function which is the entry point for the actual logic
 * | Generate ETag and other fields required for constructing the headers
 * | Call compression function which will compress the data based on the local indicator and the global indicator
 * | Call caching  function which will cache the content/page based on the local indicator and the global indicator
 * | Call the end function which is a placeholder
 * +------------------------------------------------------------------------------------------------------+
 */
class Cache_And_Compression
{
	// --- Private properties set as options ---
	var $_compression		= false;
	var $_caching			= true;
	var $_revalidate		= true;
	var $_debug			= false;
	var $_maxAge			= "3600";
	var $_expires			= "3600";
	var $_filename			= "../../releases/loadjs.ini";
	var $_interval			= false;

	// --- Private properties ---
	var $_filemtime			= "";
	var $_etag			= "";
	var $_d_buffer			= "";
	var $_availableOptions=array('caching','compression','revalidate','debug','expires','maxAge','filename','interval');

	// --- Public methods ---
	/**
	* Constructor
	*
	* $options is an assoc. Available options are :
	* $options = array(
	*	'caching'		=> set overall caching to true or false
	*	'compression'		=> set compression to true or false
	*	'revalidate'		=> set cache control revalidation
	*	'debug'			=> set compression to true or false
	*	'expires'		=> set an appropriate value
	*	'maxAge'		=> set an appropriate value
	*	'filename'		=> set filepath for main version file
	* );
	*
	* @param array $options options
	*/
	function Cache_And_Compression($options = array(NULL))
	{
		foreach($options as $key => $value) {
			$this->_setOption($key, $value);
		}

		if($this->_interval){
			putenv('TZ=UTC');
			$min = floor($this->_interval/60);
			$min = floor(date("i")/$min)*$min;
			$this->_filemtime = gmdate ("D, d M Y H:i:s",mktime(date("H"), $min, 0, date("m"), date("d"), date("Y")))." "."GMT";
		}else{
			if(file_exists($this->_filename))
				$filemtime=filemtime($this->_filename);
			else
				$filemtime=filemtime(__FILE__);
	
			$this->_filemtime = gmdate ("D, d M Y H:i:s",$filemtime)." "."GMT";
		}		
	}

	/**
	* Generic way to set an option
	*
	* @var string $name name of the option
	* @var mixed $value value of the option
	* @access public
	*/
	function _setOption($name, $value)
	{
		if (in_array($name, $this->_availableOptions)) {
			$property = '_'.$name;
			$this->$property = $value;
		}
	}

	/**
	* Start of caching/compression
	*
	* @access public
	*/
	function Start(){
		$etagkey=(isset($_SERVER['SCRIPT_FILENAME'])?$_SERVER['SCRIPT_FILENAME']:"").(isset($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:"").$this->_filemtime;
		$this->_etag = md5($etagkey);

		header('Vary: Accept-Encoding');
		header('Last-Modified:'.$this->_filemtime);
		header('Expires:'.gmdate("D, d M Y H:i:s", time() + $this->_expires )." "."GMT");
		header('Etag: '.$this->_etag);
		
		$this->_Caching();
		
		ob_start(array(&$this ,'_BufferCallBack'));
	}

	/**
	* BufferCallBack
	*
	* @var string $buffer as buffer
	* @access private
	*/
	function _BufferCallBack($buffer){
		
		if($this->_debug == "true" ) {
			foreach($this->_availableOptions as $key) {
				$property = '_'.$key;
				$value=$this->$property;
				$this->_d_buffer.="<!-- $key set to $value -->\n";
			}
			$this->_d_buffer.= "<!-- filemtime set to $this->_filemtime -->\n";
			$this->_d_buffer.= "<!-- Beginning of headers printing  -->\n";
			$this->_d_buffer.= "<!-- Etag is: $this->_etag-->\n";
			$this->_d_buffer.= "<!-- Last-Modified is: ".$this->_filemtime."-->\n";
			$this->_d_buffer.= "<!-- Expires is: ".gmdate("D, d M Y H:i:s", time() + $this->_expires )." "."GMT"."-->\n";
		}
		
		$buffer=$this->_Compress($buffer);

		header('Content-Length: '.strlen($buffer));

		return $buffer;
	}




	/**
	* Caching processing:
	*
	* @var string $buffer as buffer
	* @access private
	*/
	function _Caching() {
		if($this->_caching == "true") {
			$CacheHeader="max-age=".$this->_maxAge;
			if($this->_revalidate == "true")
				$CacheHeader.=", "."must-revalidate";
			header("Cache-Control: " . $CacheHeader);

			if($this->_debug == "true" ){
				$this->_d_buffer.= "<!-- Cache-Control: " .$CacheHeader."-->\n";

			}
			if(!isset($_SERVER['HTTP_IF_NONE_MATCH'])){
				if($this->_debug == "true" )
					$this->_d_buffer.= "<!-- HTTP_IF_NONE_MATCH: " ."NOT SET"."-->\n";
			}else{
				if($_SERVER['HTTP_IF_NONE_MATCH'] == $this->_etag){
					header('HTTP/1.1 304 Not Modified');
					exit;
				}
			}
			
			if(!isset($_SERVER['HTTP_IF_NONE_MATCH']) && isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
				$ifModifiedSince = explode(';', $_SERVER['HTTP_IF_MODIFIED_SINCE']);
				if($ifModifiedSince[0] == $this->_filemtime){
					header('HTTP/1.1 304 Not Modified');
					exit;
				}else{
					if($this->_debug == "true" ){
						$this->_d_buffer.= "<!-- HTTP_IF_MODIFIED_SINCE: " .$ifModifiedSince[0]."-->\n";
					}
				}
			}
			if(!isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $this->_debug == "true" ){
				$this->_d_buffer.= "<!-- HTTP_IF_MODIFIED_SINCE: " ."NOT SET"."-->\n";
			}
		}
	}

	/**
	* Compression processing: headers returned and compressed content returned
	*
	* @var string $buffer as current buffer
	* @access private
	*/
	function _Compress($buffer){
		$enc = false;
		if($this->_compression == "true" && isset($_SERVER['HTTP_ACCEPT_ENCODING']) && extension_loaded('zlib') && function_exists('gzencode')){
			if($this->_debug == "true" ){
				$this->_d_buffer.="<!-- Compression Available: Set On-->\n";
			}
			if(strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'x-gzip')===false){
				if(strpos($_SERVER['HTTP_ACCEPT_ENCODING'],'gzip')===false){
				}else{
					$enc='gzip';
				}
			}else{
				$enc='x-gzip';
			}

			if($enc){
				if($this->_debug == "true"){
					$this->_d_buffer.= "<!-- Content-Encoding: ". $enc ."-->\n";
				}
				header('Content-Encoding: '.$enc);
				$buffer=$this->_d_buffer . $buffer;
				$buffer = gzencode($buffer);
			}else{
				if($this->_debug == "true"){
					$this->_d_buffer.="<!-- Content could not be compressed-->\n";
				}
			}	
		} else {
			if($this->_debug == "true"){
				$this->_d_buffer.="<!-- Compression Available: Not set -->\n";
			}
		}
		return($enc ? $buffer : $this->_d_buffer . $buffer);
	}
	
	/**
	* End of caching/compression
	*
	* @access public
	*/
	function End(){
		ob_end_flush();
	}
	
}
?>