<?php

namespace App\Http\Controllers;

use App\Enums\InstructionsTypes;
use App\Models\Instructions;
use Illuminate\Http\Request;
use Mail;
use App\Mail\ImproveMail;
use QrCode;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function messages()
    {
        return [
            'file.max' => trans('all.contact_form_files_limit'),
        ];
    }
    /**
     * Show the application dashboard.
     *
     /* @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('orders'));
    }


    public function faq(){

        $instructions   = Instructions::where('type', InstructionsTypes::INSTRUCTION)->where('parent_id', 0)->get();
        $faqs           = Instructions::where('type', InstructionsTypes::FAQ)->where('parent_id', 0)->get();

        return view('faq.index', compact('instructions', 'faqs'));
    }

    public function finance(){
        return view('finance.index');
    }

    public function contacts(){
        return view('home.contacts');
    }

    public function improveSystem(){
        return view('home.improve');
    }

    public function improveSubmit(Request $request){
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email',
            'subject'   => 'required|min:2',
            'message'   => 'required|min:8',
            'file'      => 'max:3',
            'file.*'    => 'file|max:2056'
        ]);

        $data = $request->all();
        $data['to'] = env('MAIL_TO_ADDRESS', 'inn.logist.service@gmail.com');
        $files = $request->file('file');


        if(count($files) > 0)
            $data['files_uploaded'] = true;
        else
            $data['files_uploaded'] = false;


        Mail::to($data['to'])->send(new ImproveMail($data, $files));

        return redirect()->back();
    }

    public function qrCodeOrder($order_id) {
        return QrCode::size(200)->format('svg')->generate(route('orders.show', $order_id));
    }

    public function design(){
		return view('pages.design');
    }

}
