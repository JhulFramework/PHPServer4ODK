<?php return
[

/* 1XX
+=====================================================================================================================*/

	100 => 'Continue',

	101 => 'Switching Protocols',

	// RFC2518
	102 => 'Processing',



/* 2XX
+=====================================================================================================================*/

	200 => 'OK',

	201 => 'Created',

	202 => 'Accepted',

	203 => 'Non-Authoritative Information',

	204 => 'No Content',

	205 => 'Reset Content',

	206 => 'Partial Content',

	// (WebDAV; RFC 4918)
	207 => 'Multi-Status',

	// RFC5842
	208 => 'Already Reported',

	// (WebDAV; RFC 5842)
	226 => 'IM Used',



/* 3XX
+=====================================================================================================================*/

	300 => 'Multiple Choices',

	301 => 'Moved Permanently',

	302 => 'Found',

	303 => 'See Other',

	// RFC 7232
	304 => 'Not Modified',

	305 => 'Use Proxy',

	307 => 'Temporary Redirect',

	// RFC7238
	308 => 'Permanent Redirect',



/* 4XX
+=====================================================================================================================*/

	400 => 'Bad Request',

	// RFC 7235
	401 => 'Unauthorized',

	402 => 'Payment Required',

	403 => 'Forbidden',

	404 => 'Not Found',

	405 => 'Method Not Allowed',

	406 => 'Not Acceptable',

	//RFC 7235
	407 => 'Proxy Authentication Required',

	408 => 'Request Timeout',

	409 => 'Conflict',

	410 => 'Gone',

	411 => 'Length Required',

	// RFC 7232
	412 => 'Precondition Failed',

	// RFC 7231
	413 => 'Payload Too Large',

	// RFC 7231
	414 => 'URI Too Long',

	415 => 'Unsupported Media Type',

	// RFC 7233
	416 => 'Range Not Satisfiable',

	417 => 'Expectation Failed',

	// RFC 2324
	418 => 'I\'m a teapot',

	// RFC 7540
	421 => 'Misdirected Request',

	// WebDAV; RFC 4918
	422 => 'Unprocessable Entity',

	// WebDAV; RFC 4918
	423 => 'Locked',

	// WebDAV; RFC 4918
	424 => 'Failed Dependency',

	426 => 'Upgrade Required',

	// RFC 6585
	428 => 'Precondition Required',

	// RFC 6585
	429 => 'Too Many Requests',

	// RFC 6585
	431 => 'Request Header Fields Too Large',

	// RFC 7725
	451 => 'Unavailable For Legal Reasons',


/* 5XX
+=====================================================================================================================*/

	500 => 'Internal Server Error',

	501 => 'Not Implemented',

	502 => 'Bad Gateway',

	503 => 'Service Unavailable',

	504 => 'Gateway Timeout',

	505 => 'HTTP Version Not Supported',

	// RFC 2295
	506 => 'Variant Also Negotiates (Experimental)',

	// WebDAV; RFC4918
	507 => 'Insufficient Storage',

	// WebDAV; RFC5842
	508 => 'Loop Detected',

	// RFC2774
	510 => 'Not Extended',

	// RFC6585
	511 => 'Network Authentication Required',

];
