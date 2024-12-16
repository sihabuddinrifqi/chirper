<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Hashtag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response 
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(),
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
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'message' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('chirps', 'public');
    }

    // Simpan Chirp
    $chirp = $request->user()->chirps()->create($validated);

    // Tangkap hashtags dari pesan
    preg_match_all('/#(\w+)/', $validated['message'], $hashtags);

    // Simpan hashtags ke tabel dan hubungkan dengan chirp
    foreach ($hashtags[1] as $hashtag) {
        $hashtagModel = Hashtag::firstOrCreate(['name' => $hashtag]);
        $chirp->hashtags()->attach($hashtagModel); // Hubungkan chirp dengan hashtag
    }

    return redirect(route('chirps.index'));
}

    

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp);
 
        $validated = $request->validate([
            'message' => 'required|string',
        ]);
 
        $chirp->update($validated);
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete', $chirp);
 
        $chirp->delete();
 
        return redirect(route('chirps.index'));
    }

    public function showHashtag($hashtag)
{
    // Ambil chirps yang mengandung hashtag
    $chirps = Chirp::with('user') // Pastikan eager load relasi user
        ->where('message', 'LIKE', "%#{$hashtag}%")
        ->latest()
        ->get();

    // Kirim data ke frontend
    return inertia('HashtagPage', [
        'chirps' => $chirps,
        'hashtag' => $hashtag,
    ]);
}


// Di dalam ChirpController.php
public function showHashtagChirps($hashtag)
{
    // Mengambil chirps yang mengandung hashtag yang dipilih
    $chirps = Chirp::whereHas('hashtags', function ($query) use ($hashtag) {
        $query->where('name', $hashtag);
    })->with('user:id,name')->latest()->get();

    return Inertia::render('Chirps/Hashtag', [
        'chirps' => $chirps,
        'hashtag' => $hashtag,
    ]);
}




}
