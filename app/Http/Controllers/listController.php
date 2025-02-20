<?php

namespace App\Http\Controllers;
use App\Models\tag;
use App\Models\lists;
use App\Models\ListTag;
use Laravel\Prompts\error;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class listController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pinnedLists = Auth::user()->lists()->where('pin', 'pinned')->get();
$notPinnedLists = Auth::user()->lists()->where('pin', 'not_pinned')->get();
$tags = Auth::user()->tags;

return view('contents.lists')->with([
    'header' => 'lists',
    "pinnedLists" => $pinnedLists,
    "notPinnedLists" => $notPinnedLists,
    'tags' => $tags
]);

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
            'title' => 'required|min:3|max:35',
        ],[
            'title.required' => 'title cannot be empty',
            'title.min' => 'title min 3 character',
            'title.max' => 'title max 35 character',
        ]);

        $list = lists::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
            'expired' => $request->expired
        ]);


        if($request->tag){
            ListTag::create([
                'user_id' => Auth::user()->id,
                'tag_id' => $request->tag,
                'list_id' => $list->id
            ]);
        }

            return redirect('/list');

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

        $list = Lists::where('id', $id)->firstOrFail();

        // Cek apakah ada input yang dikirim
        $data = [];

        if ($request->has('title')) {
            $data['title'] = $request->title;
        }

        if ($request->has('description')) {
            $data['description'] = $request->description;
        }
        if ($request->has('expired')) {
            $data['expired'] = $request->expired;
        }

        // Kalau ada data yang diupdate, baru jalanin update()
        if (!empty($data)) {
            $list->update($data);
        }

        return redirect()->back();
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


    public function searching(Request $request){
        $listsName = $request->lists;

        // Ambil hanya data lists milik user yang sedang login
        $lists = Lists::where('user_id', Auth::id())
                      ->where('title', 'like', "%$listsName%")
                      ->get();

        return view('contents.search')->with([
            'header' => 'lists',
            'lists' => $lists
        ]);
    }


    public function ondeadline(Request $request){
        $lists = Lists::where('user_id', Auth::id())
            ->whereNotNull('expired')
            ->where('expired', '<', now()->toDateTimeString()) // Pastikan format cocok
            ->get(); // Eksekusi query

        return view('contents.ondeadline')->with([
            'header' => 'lists',
            'lists' => $lists
        ]);
    }


    public function ontime(Request $request){
        $lists = Lists::where('user_id', Auth::id())
            ->whereNotNull('expired')
            ->whereNotNull('expired')
            ->whereDate('expired', now()->toDateString())  // Ambil yang masih on-time
            ->get();

        return view('contents.ontime')->with([
            'header' => 'lists',
            'lists' => $lists
        ]);
    }
    public function onedaybefore(Request $request){
        $lists = Lists::where('user_id', Auth::id())
            ->whereNotNull('expired')
            ->whereDate('expired', now()->addDay()->toDateString())  // Ambil yang deadline besok
            ->get();

        return view('contents.onedaybefore')->with([
            'header' => 'lists',
            'lists' => $lists
        ]);
    }


    public function trash()
    {
        $lists = Auth::user()->lists()->onlyTrashed()->paginate(10);

        return view('contents.trash')->with([
            'header' => 'lists',
            'lists' => $lists
        ]);
    }

    public function restore($id)
    {
        $list = Auth::user()->lists()->onlyTrashed()->where('id', $id)->firstOrFail();

        $list->restore();

        return redirect('/trash')->with('status', 'Task berhasil direstore');
    }


    public function forceDelete($id)
{
    $list = Auth::user()->lists()->onlyTrashed()->where('id', $id)->firstOrFail();

    $list->forceDelete(); // Hapus permanen dari database

    return redirect('/trash')->with('status', 'Task berhasil dihapus permanen');
}



public function restoreAll()
{
    $lists = Auth::user()->lists()->onlyTrashed()->get();

    if ($lists->isEmpty()) {
        return redirect('/trash')->with('status', 'Tidak ada data untuk dikembalikan.');
    }

    foreach ($lists as $list) {
        $list->restore();
    }

    return redirect('/trash')->with('status', 'Semua task berhasil dikembalikan.');
}

public function forceDeleteAll()
{
    $lists = Auth::user()->lists()->onlyTrashed()->get();

    if ($lists->isEmpty()) {
        return redirect('/trash')->with('status', 'Tidak ada data untuk dihapus permanen.');
    }

    foreach ($lists as $list) {
        $list->forceDelete();
    }

    return redirect('/trash')->with('status', 'Semua task berhasil dihapus permanen.');
}



public function togglePin($id)
{
    $list = lists::where('id', $id)->firstOrFail();

    // Toggle status pin
    $list->pin = $list->pin === 'pinned' ? 'not_pinned' : 'pinned';
    $list->save();

    return redirect()->back()->with('success', 'List updated successfully!');
}


}
