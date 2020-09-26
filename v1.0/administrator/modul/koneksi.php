<?php
$_SESSION['domain']='http://localhost/simak/';

if(isset($_SESSION['expiretime'])) {
    if($_SESSION['expiretime'] < time()) {
        //logged out
    }
    else {
        $_SESSION['expiretime'] = time() + 600;
    }
}

function koneksi()
{
	$con = mysqli_connect("localhost","root","");
	if (!$con)
	  {
	  die('Sorry, connection failed to server ' );
	  }
	  mysqli_select_db($con,"simak");
	return $con;
}
function execquery($tabel,$query)
{
	$con=koneksi();
	mysqli_select_db($con, $tabel);
	if (!mysqli_query($con, $query))
	{
		return mysqli_error($con);
	}
	else{
		return 1;
	}
	mysqli_close($con);
}
function execqueryreturn($tabel,$query)
{
	$con=koneksi();
	//mysqli_select_db($con, $tabel);
	$x=''; 
	$result	= mysqli_query($con, $query);
	$row 	= mysqli_fetch_array($result, MYSQLI_NUM);
	$x 		= $row[0];
	
	mysqli_free_result($result);
	return $x;
	mysqli_close($con);
}
function execqueryreturnall($tabel,$query)
{
	$con=koneksi();
	mysql_select_db($tabel, $con);
	$result=mysql_query($query,$con);
	
	return $result;
	mysql_close($con);
}

function getColumns($tabel){
	$con = koneksi();
	$result = mysqli_query($con, "SHOW COLUMNS FROM ".$tabel);
	$columns = array();
	while($row = mysqli_fetch_array($result, MYSQLI_NUM))
	  {
		$columns[] = $row;
	  }
	return $columns;
}

function getTableAlias($type,$tabel)
{
	if($type == 1){
		return execqueryreturn("table_alias","select table_alias from table_alias where table_name = '".$tabel."'");
	}
	elseif($type == 0){
		return execqueryreturn("table_alias","select table_name from table_alias where table_alias = '".$tabel."'");
	}
}

function writeFile($file, $content){
	$myfile = fopen($file, "w") or die("Unable to open file!");
	fwrite($myfile, $content);
	fclose($myfile);
}

function uploadImage($image,$path)
{
	$_FILES['img']=$image;
	if ( $_FILES['img']['type'] == "image/gif" || $_FILES['img']['type'] == "image/jpg" || $_FILES['img']['type'] == "image/jpeg" || $_FILES['img']['type'] == "image/png" ) {

	 $source = $_FILES['img']['tmp_name'];
	 $target = $path;
	 move_uploaded_file( $source, $target );// or die ("Couldn't copy");
	 $size = getImageSize( $target );

	 $imgstr = "<p><img width=\"$size[0]\" height=\"$size[1]\" ";
	 $imgstr .= "src=\"$target\" alt=\"uploaded image\" /></p>";

	 return $imgstr;
 }	 
}
function reLoadCounter()
{
	$tgl=execqueryreturn("statevisitor","select tanggal from statevisitor");
	$con=koneksi();
	/*echo "<script LANGUAGE='javascript'>alert('".date('mdy',strtotime($tgl)).",".date('mdy')."');</script>";*/
	mysql_select_db(statevisitor, $con);
	if (date('mdy',strtotime($tgl))!=date('mdy'))
	{
		$query="update statevisitor set tanggal=NOW(), today=0";
		if (!mysql_query($query,$con))
		  {
		  die('Error: ' . $query . mysql_error());
		  }
	}
	if($_SESSION['visitor']==''){
		$_SESSION['visitor']='ok';
		$query="update statevisitor set today=today+1, total=total+1";
			if (!mysql_query($query,$con))
			  {
			  die('Error: ' . $query . mysql_error());
			  }
			  
		}
	
	mysql_close($con);
}

function html_cut($text, $max_length)
{
    $tags   = array();
    $result = "";

    $is_open   = false;
    $grab_open = false;
    $is_close  = false;
    $in_double_quotes = false;
    $in_single_quotes = false;
    $tag = "";

    $i = 0;
    $stripped = 0;

    $stripped_text = strip_tags($text);

    while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
    {
        $symbol  = $text{$i};
        $result .= $symbol;

        switch ($symbol)
        {
           case '<':
                $is_open   = true;
                $grab_open = true;
                break;

           case '"':
               if ($in_double_quotes)
                   $in_double_quotes = false;
               else
                   $in_double_quotes = true;

            break;

            case "'":
              if ($in_single_quotes)
                  $in_single_quotes = false;
              else
                  $in_single_quotes = true;

            break;

            case '/':
                if ($is_open && !$in_double_quotes && !$in_single_quotes)
                {
                    $is_close  = true;
                    $is_open   = false;
                    $grab_open = false;
                }

                break;

            case ' ':
                if ($is_open)
                    $grab_open = false;
                else
                    $stripped++;

                break;

            case '>':
                if ($is_open)
                {
                    $is_open   = false;
                    $grab_open = false;
                    array_push($tags, $tag);
                    $tag = "";
                }
                else if ($is_close)
                {
                    $is_close = false;
                    array_pop($tags);
                    $tag = "";
                }

                break;

            default:
                if ($grab_open || $is_close)
                    $tag .= $symbol;

                if (!$is_open && !$is_close)
                    $stripped++;
        }

        $i++;
    }

    while ($tags)
        $result .= "</".array_pop($tags).">";

    return $result;
}

function replaceTags($startPoint, $endPoint, $newText, $source) {
    return preg_replace('#('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')#si', '$1'.$newText.'$3', $source);
}

function get_between($input, $start, $end)
{
  $substr = substr($input, strlen($start)+strpos($input, $start), (strlen($input) - strpos($input, $end))*(-1));
  return $substr;
} 

function getBrowserType () {
if (!empty($_SERVER['HTTP_USER_AGENT']))
{
   $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
}
else if (!empty($HTTP_SERVER_VARS['HTTP_USER_AGENT']))
{
   $HTTP_USER_AGENT = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
}
else if (!isset($HTTP_USER_AGENT))
{
   $HTTP_USER_AGENT = '';
}
if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version))
{
   $browser_version = $log_version[2];
   $browser_agent = 'opera';
}
else if (ereg('MSIE ([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version))
{
   $browser_version = $log_version[1];
   $browser_agent = 'ie';
}
else if (ereg('OmniWeb/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version))
{
   $browser_version = $log_version[1];
   $browser_agent = 'omniweb';
}
else if (ereg('Netscape([0-9]{1})', $HTTP_USER_AGENT, $log_version))
{
   $browser_version = $log_version[1];
   $browser_agent = 'netscape';
}
else if (ereg('Mozilla/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version))
{
   $browser_version = $log_version[1];
   $browser_agent = 'mozilla';
}
else if (ereg('Konqueror/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version))
{
   $browser_version = $log_version[1];
   $browser_agent = 'konqueror';
}
else
{
   $browser_version = 0;
   $browser_agent = 'other';
}
return $browser_agent;
}

function selfURL() {
$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI'];
}
function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2));
}

function getIpAddress(){
if (!empty($_SERVER["HTTP_CLIENT_IP"]))
{
 //check for ip from share internet
 $ip = $_SERVER["HTTP_CLIENT_IP"];
}
elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
{
 // Check for the Proxy User
 $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}
else
{
 $ip = $_SERVER["REMOTE_ADDR"];
}

// This will print user's real IP Address
// does't matter if user using proxy or not.
return $ip;

}


?>
