<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Statamic\Facades\Entry;

class MahasiswaController extends Controller
{
    public function index()
    {
        // Ambil semua entri mahasiswa
        $mahasiswas = Entry::query()
            ->where('collection', 'mahasiswas')
            ->get()
            ->map(function ($entry) {
                // Ambil ID mata kuliah
                $matkulIds = $entry->get('matkuls');

                // Ambil detail mata kuliah berdasarkan ID
                $matkuls = Entry::query()
                    ->where('collection', 'matkuls')
                    ->whereIn('id', $matkulIds)
                    ->get()
                    ->map(function ($matkul) {
                        return [
                            'id' => $matkul->id(),
                            'title' => $matkul->get('title'),
                        ];
                    });

                return [
                    'id' => $entry->id(),
                    'title' => $entry->get('title'),
                    'matkuls' => $matkuls->toArray(),
                ];
            });

             // Fetch all matkul entries
        $matkuls = Entry::query()
        ->where('collection', 'matkuls')
        ->get()
        ->map(function ($matkul) {
            return [
                'id' => $matkul->id(),
                'title' => $matkul->get('title'),
            ];
        });


        // Kirim data ke halaman Inertia
        return Inertia::render('Mahasiswa/Index', [
            'mahasiswas' => $mahasiswas,
            'matkuls' => $matkuls,
        ]);
    }


    public function destroy($id)
    {
        // Find the mahasiswa entry by ID
        $mahasiswa = Entry::find($id);

        // Check if the entry exists
        if (!$mahasiswa) {
            // Handle the case where the entry is not found (e.g., redirect with an error message)
            return redirect()->back()->with('error', 'Mahasiswa not found.');
        }

        // Delete the entry
        $mahasiswa->delete();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Mahasiswa deleted successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'matkuls' => 'required|min:1',
        ]);

        $entry = Entry::make()
            ->collection('mahasiswas')
            ->data([
                'title' => $request->name,
                'matkuls' => $request->matkuls,
            ]);

        $entry->save();

        return redirect()->back()->with('success', 'Mahasiswa berhasil ditambahkan.');
    }
}
