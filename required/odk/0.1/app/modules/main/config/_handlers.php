<?php return
[

	//froent page of website
	'index' 			=> '\\_modules\\main\\nodes\\index\\Handler',

	//Lists forms to download for odk colect
	'form_list' 		=> '\\_modules\\main\\nodes\\form\\listing\\Handler',

	//handles form submission from odk collect
	'form_submit'		=> '\\_modules\\main\\nodes\\form\\submit\\Handler',

	//handle form download request from odk collect
	'form_download' 		=> '\\_modules\\main\\nodes\\form\\download\\Handler',

	//Handles user submitted data
	'data'		=> '\\_modules\\main\\nodes\\data\\Handler',

];
