<?php

namespace App\Http\Controllers\Admin;

use App\Mail\NewFeedback;
use App\Models\Feedback;
use App\Http\Requests\Feedback as FeedbackRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    protected $toEmail;

    public function __construct()
    {
        $this->toEmail = config('innlogist.email_feedback');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeedbackRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FeedbackRequest $request)
    {
        try {
            $feedback = Feedback::create($request->only('name', 'email', 'subject', 'message'));

            Mail::to($this->toEmail)->send(new NewFeedback($feedback));

            return response()->json(['status' => 'success']);
        } catch (\Exception $exc) {
            return response()->json(['status' => 'error', 'msg' => $exc->getMessage()], 400);
        }
    }
}
