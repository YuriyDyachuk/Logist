<?php

namespace App\Http\Controllers;

use App\Mail\AdminLandingFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function landingFeedback(Request $request)
    {
        $input = json_decode($request->getContent(), true);
        $fields = [];
        foreach ($input as $field) {
            if (isset($field['id'], $field['val'])) {
                $fields[$field['id']] = $field['val'];
            }
        }

        $validator = Validator::make($fields, [
            'name' => 'required',
            'topic' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['result' => 'error', 'errors' => $validator->errors(), 422]);
        }

        Mail::to(config('innlogist.email_feedback'))->send(
            new AdminLandingFeedback(
                $fields['name'],
                $fields['topic'],
                $fields['email'],
                $fields['message'] ?? ''
            )
        );

        return response()->json(['result' => 'success', 'errors' => []]);
    }
}
