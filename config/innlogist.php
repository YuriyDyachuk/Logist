<?php

return [

	/**
	 * Disable or enable SMS sending
	 */
	'twilio_send' => env('TWILIO_SEND', true),

    'email_feedback'  => env('EMAIL_FEEDBACK', 'inn.logist.service@gmail.com'),

    /*
     * Progress
     */
    'progress_date_default' => '__/__/____',


	/**
	 * Clear notifications and offers after in min
	 * Using: cron
	 */
	'clear_interval' => 180, // min

	/**
	 * Payment remind
	 */
	'payment_remind' => 5, // days

	/**
	 * Mobile Id signature settings
	 */

	'signature_test' => env('SIGNATURE_TEST', false),
	'signature_ip' => env('SIGNATURE_IP', ''),
	'signature_provider' => env('SIGNATURE_PROVIDER', ''),
	'signature_password' => env('SIGNATURE_PASSWORD', ''),

	'signature_check_first' => 15, // sec
	'signature_check_second' => 10, // sec
	'signature_check_other' => 15, // sec
	'signature_check_max_attempt' => 5, // sec

	'driver_report_start_period' => 10, // day of month
	'driver_report_period' => 'month', // day of month
];