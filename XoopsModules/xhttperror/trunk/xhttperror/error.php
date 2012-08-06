<?php
ob_start();
@set_time_limit(5);
@ini_set('memory_limit', '64M');
@ini_set('display_errors', 'Off');
error_reporting(0);
 
function print_error_page() {
    $status_reason = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Reserved',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        510 => 'Not Extended'
        );
 
    $status_msg = array(
        400 => "Your browser sent a request that this server could not understand.",
        401 => "This server could not verify that you are authorized to access the document requested.",
        402 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
        403 => "You don't have permission to access %U% on this server.",
        404 => "We couldn't find <acronym title='%U%'>that uri</acronym> on our server, though it's most certainly not your fault.",
        405 => "The requested method is not allowed for the URL %U%.",
        406 => "An appropriate representation of the requested resource %U% could not be found on this server.",
        407 => "An appropriate representation of the requested resource %U% could not be found on this server.",
        408 => "Server timeout waiting for the HTTP request from the client.",
        409 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
        410 => "The requested resource %U% is no longer available on this server and there is no forwarding address. Please remove all references to this resource.",
        411 => "A request of the requested method GET requires a valid Content-length.",
        412 => "The precondition on the request for the URL %U% evaluated to false.",
        413 => "The requested resource %U% does not allow request data with GET requests, or the amount of data provided in the request exceeds the capacity limit.",
        414 => "The requested URL's length exceeds the capacity limit for this server.",
        415 => "The supplied request data is not in a format acceptable for processing by this resource.",
        416 => 'Requested Range Not Satisfiable',
        417 => "The expectation given in the Expect request-header field could not be met by this server. The client sent <code>Expect:</code>",
        422 => "The server understands the media type of the request entity, but was unable to process the contained instructions.",
        423 => "The requested resource is currently locked. The lock must be released or proper identification given before the method can be applied.",
        424 => "The method could not be performed on the resource because the requested action depended on another action and that other action failed.",
        425 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
        426 => "The requested resource can only be retrieved using SSL. Either upgrade your client, or try requesting the page using https://",
        500 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
        501 => "This type of request method to %U% is not supported.",
        502 => "The proxy server received an invalid response from an upstream server.",
        503 => "The server is temporarily unable to service your request due to maintenance downtime or capacity problems. Please try again later.",
        504 => "The proxy server did not receive a timely response from the upstream server.",
        505 => 'The server encountered an internal error or misconfiguration and was unable to complete your request.',
        506 => "A variant for the requested resource <code>%U%</code> is itself a negotiable resource. This indicates a configuration error.",
        507 => "The method could not be performed.  There is insufficient free space left in your storage allocation.",
        510 => "A mandatory extension policy in the request is not accepted by the server for this resource."
        );
 
    // Get the Status Code
    if (isset($_SERVER['REDIRECT_STATUS']) && ($_SERVER['REDIRECT_STATUS'] != 200))
        $sc = $_SERVER['REDIRECT_STATUS'];
    elseif (isset($_SERVER['REDIRECT_REDIRECT_STATUS']) && ($_SERVER['REDIRECT_REDIRECT_STATUS'] != 200)) 
        $sc = $_SERVER['REDIRECT_REDIRECT_STATUS'];
    $sc = (!isset($_GET['error']) ? 404 : $_GET['error']);
 
  $sc=abs(intval($sc));
 
    // Redirect to server home if called directly or if status is under 400
    if ( ( (isset($_SERVER['REDIRECT_STATUS']) && $_SERVER['REDIRECT_STATUS'] == 200) && (floor($sc / 100) == 3) )
        || (!isset($_GET['error']) && $_SERVER['REDIRECT_STATUS'] == 200)  ) {
        @header("Location: http://{$_SERVER['SERVER_NAME']}",1,302);
        die();
    }

    // Check range of code or issue 500
    if (($sc < 200) || ($sc > 599)) $sc = 500;
 
    // Check for valid protocols or else issue 505
    if (!in_array($_SERVER["SERVER_PROTOCOL"], array('HTTP/1.0','HTTP/1.1','HTTP/0.9')))
        $sc = 505;

    // Get the status reason
    $reason = (isset($status_reason[$sc]) ? $status_reason[$sc] : '');

    // Get the status message
    $msg = (isset($status_msg[$sc]) ? str_replace('%U%', htmlspecialchars(strip_tags(stripslashes($_SERVER['REQUEST_URI']))), $status_msg[$sc]) : 'Error');

    // issue optimized headers (optimized for your server)
    @header("{$_SERVER['SERVER_PROTOCOL']} {$sc} {$reason}", 1, $sc);
    if( @php_sapi_name() != 'cgi-fcgi' ) 
        @header("Status: {$sc} {$reason}", 1, $sc);

    // A very small footprint for certain types of 4xx class errors and all 5xx class errors
    if (in_array($sc, array(400, 403, 405)) || (floor($sc / 100) == 5)) {
        @header("Connection: close", 1);
        if ($sc == 405) 
            @header('Allow: GET,HEAD,POST,OPTIONS', 1, 405);
    }

    echo "<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html>";
    echo "<head>\n<title>{$sc} {$reason}</title>\n<h1>{$reason}</h1>\n<p>{$msg}<br />\n</p>\n";
}
 
function askapache_global_debug() {
    # http://www.php.net/manual/en/function.array-walk.php#100681
    global $_GET,$_POST,$_ENV,$_SERVER;  $g=array('_ENV','_SERVER','_GET','_POST');
    array_walk_recursive($g, create_function('$n','global $$n;if( !!$$n&&ob_start()&&(print "[ $"."$n ]\n")&&array_walk($$n,
    create_function(\'$v,$k\', \'echo "[$k] => $v\n";\'))) echo "<"."p"."r"."e>".htmlspecialchars(ob_get_clean())."<"."/"."pr"."e>";') );
}
 
print_error_page();
//if($_SERVER['REMOTE_ADDR']=='youripaddress')askapache_global_debug();
echo "</body>\n</html>";
echo ob_get_clean();
exit;

/*
###
# ErrorDocument: In the event of a problem or error, what the server will return to the client. URLs
# can begin with a / for local web-paths (relative to DocumentRoot), or be a full URL which the client
# can resolve. Alternatively, a message can be displayed.  If a malformed request is detected, normal
# request processing will be immediately halted and the internal error message returned.
#
# Prior to version 2.0, messages were indicated by prefixing them with a
# single unmatched double quote character.
#
# The special value default can be used to specify Apache's simple hardcoded message and
# will restore Apache's simple hardcoded message.
#
ErrorDocument 400 /error.php?error=400
ErrorDocument 401 /error.php?error=401
ErrorDocument 402 /error.php?error=402
ErrorDocument 403 /error.php?error=403
ErrorDocument 404 /error.php?error=404
ErrorDocument 405 /error.php?error=405
ErrorDocument 406 /error.php?error=406
ErrorDocument 407 /error.php?error=407
ErrorDocument 408 /error.php?error=408
ErrorDocument 409 /error.php?error=409
ErrorDocument 410 /error.php?error=410
ErrorDocument 411 /error.php?error=411
ErrorDocument 412 /error.php?error=412
ErrorDocument 413 /error.php?error=413
ErrorDocument 414 /error.php?error=414
ErrorDocument 415 /error.php?error=415
ErrorDocument 416 /error.php?error=416
ErrorDocument 417 /error.php?error=417
ErrorDocument 422 /error.php?error=422
ErrorDocument 423 /error.php?error=423
ErrorDocument 424 /error.php?error=424
ErrorDocument 426 /error.php?error=426
ErrorDocument 500 /error.php?error=500
ErrorDocument 501 /error.php?error=501
ErrorDocument 502 /error.php?error=502
ErrorDocument 503 /error.php?error=503
ErrorDocument 504 /error.php?error=504
ErrorDocument 505 /error.php?error=505
ErrorDocument 506 /error.php?error=506
ErrorDocument 507 /error.php?error=507
ErrorDocument 510 /error.php?error=510
*/
