<?php

return [
	'public_key' => env('LIQPAY_PUBLIC_KEY',''),
	'private_key' => env('LIQPAY_PRIVATE_KEY',''),
	'settings' => array(
		'mode' => env('LIQPAY_MODE','sandbox'),
		'sandbox_api_url' => env('LIQPAY_SB_API_URL',''),
		'sandbox_checkout_url' => env('LIQPAY_SB_CHECKOUT_URL',''),
		'prod_api_url' => env('LIQPAY_PROD_API_URL',''),
		'prod_checkout_url' => env('LIQPAY_PROD_CHECKOUT_URL',''),
	),
];