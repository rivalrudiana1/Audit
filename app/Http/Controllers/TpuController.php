<?php

namespace App\Http\Controllers;

use App\Models\Tpu;
use Illuminate\Http\Request;

class TpuController extends Controller
{
    public function index()
    {
        $tpus = Tpu::withCount([
            'users',
            'dataMakam'
        ])
        ->latest()
        ->paginate(10);

        return view(
            'tpus.index',
            compact('tpus')
        );
    }

    public function create()
    {
        return view('tpus.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'nama' => 'required',

            'kode' => 'required|unique:tpus'

        ]);

        Tpu::create([

            'nama' => $request->nama,

            'kode' => $request->kode,

        ]);

        return redirect()
            ->route('tpus.index')
            ->with(
                'success',
                'TPU berhasil ditambahkan'
            );
    }

    public function edit(Tpu $tpu)
    {
        return view(
            'tpus.edit',
            compact('tpu')
        );
    }

    public function update(
        Request $request,
        Tpu $tpu
    ) {

        $request->validate([

            'nama' => 'required',

            'kode' => 'required|unique:tpus,kode,' . $tpu->id

        ]);

        $tpu->update($request->all());

        return redirect()
            ->route('tpus.index')
            ->with(
                'success',
                'TPU berhasil diperbarui'
            );
    }

    public function destroy(Tpu $tpu)
    {
        if($tpu->users()->count() > 0)
        {
            return back()->with(
                'error',
                'TPU masih digunakan oleh user.'
            );
        }
    
        $tpu->delete();

        return redirect()
            ->route('tpus.index')
            ->with(
                'success',
                'TPU berhasil dihapus'
            );
    }
}