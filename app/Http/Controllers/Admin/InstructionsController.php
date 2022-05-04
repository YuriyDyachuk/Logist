<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instructions;
use Illuminate\Http\Request;
use App\Services\InstructionsService;

class InstructionsController extends Controller
{

    protected $instructionsService;

    public function __construct()
    {
        $this->middleware('Admin');
        $this->instructionsService = new InstructionsService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructions = Instructions::orderBy('list', 'ASC')->where('parent_id', 0)->get();
        return view('admin.instructions.index', compact('instructions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $instruction = new Instructions();
        $instruction->id = 0;
        $instruction->type = 1;

        $instructions = Instructions::all();

        return view('admin.instructions.edit', compact('instruction', 'instructions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $instruction = Instructions::findOrFail($id);

        $this->instructionsService->getInstructionData($instruction);

        $instructions = Instructions::all();
        return view('admin.instructions.edit', compact('instruction', 'instructions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'slug' => 'slug_url|required|unique:instruction,slug,'.$id.',id',
            'type'      => 'required',
            'slug'      => 'required',
            'parent_id' => 'required',
        ]);

        $this->instructionsService->saveOrUpdate($request, $id);
        return redirect()->route('instructions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $instruction = Instructions::findOrFail($id);
        $instruction->delete();
        return redirect()->route('instructions.index');
    }
}
