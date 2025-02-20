<?php

namespace App\Http\Controllers;

use App\Models\tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class tagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

        $request->validate([
            'name' => 'required'
        ]);

        tag::create([
            'name' => $request->name,
            'user_id' => $request->user_id
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil tag berdasarkan ID yang dimiliki user
        $tag = Auth::user()->tags()->where('id', $id)->firstOrFail();

        // Ambil list yang berhubungan dengan tag ini lewat tabel pivot list_tag
        $lists = $tag->listTags()->with('list')->get()->pluck('list');

        return view('contents.liststag')->with([
            'header' => 'list',
            'lists' => $lists
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = tag::where('id',$id)->first();
        return view('contents.edittag')->with(['header' => 'edit','tag' => $tag]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tag_name' => 'required'
        ]);

        $tag = Tag::where('id', $id)->first();

        if (!$tag) {
            return redirect('/list')->with('error', 'Tag not found');
        }

        $tag->name = $request->tag_name;
        $tag->save();

        return redirect('/list')->with('success', 'Tag updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tag = tag::where('id', $id)->firstOrFail(); // Cari berdasarkan UUID
        $tag->delete(); // Hapus task

        return redirect('/list');
    }
}
