<?php

namespace App\Http\Controllers;
use App\Models\lists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;
class listController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = Auth::user()->lists;
        return view('contents.lists')->with(['header' => 'lists','lists' => $lists]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pesanError = $request->validate([
            'title' => 'required|min:3|max:35',
        ],[
            'title.required' => 'title cannot be empty',
            'title.min' => 'title min 3 character',
            'title.max' => 'title max 35 character',
        ]);

        lists::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id
        ]);

        if($pesanError){
            return redirect('/list');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $list = lists::where('id',$id)->first();
     return view('contents.listdetail')->with(['header' => 'list','list' => $list]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lists = lists::where('id', $id)->firstOrFail(); // Cari berdasarkan UUID

        $lists->delete(); // Hapus task

        return redirect('/list');
    }
}
