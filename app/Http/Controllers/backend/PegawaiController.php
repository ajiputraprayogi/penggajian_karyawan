<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.data.pegawai.index');
    }

    public function listdata(){
        return Datatables::of(DB::table('pegawai')
        ->leftjoin('divisi','divisi.id','=','pegawai.id_divisi')
        ->leftjoin('jabatan','jabatan.id','=','pegawai.id_jabatan')
        ->select('pegawai.*','divisi.nama as divisi','jabatan.nama as jabatan')
        ->get())->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $divisi = DB::table('divisi')->orderby('nama','asc')->get();
        $jabatan = DB::table('jabatan')->orderby('nama','asc')->get();
        return view('backend.data.pegawai.create', compact('divisi','jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'divisi' => 'required',
            'jabatan' => 'required',
            'no_rekening' => 'required'
        ]);
        $tgl_lahir = Carbon::parse($request->tgl_lahir);
        DB::table('pegawai')->insert([
            'nama' => $request->nama,
            'tgl_lahir' => $tgl_lahir->format('Y-m-d'),
            'alamat' => $request->alamat,
            'id_divisi' => $request->divisi,
            'id_jabatan' => $request->jabatan,
            'no_rekening' => $request->no_rekening
        ]);
        return redirect('/backend/pegawai')->with('status','Sukses menyimpan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = DB::table('pegawai')->where('id', $id)->get();
        $divisi = DB::table('divisi')->orderby('nama','asc')->get();
        $jabatan = DB::table('jabatan')->orderby('nama','asc')->get();
        return view('backend.data.pegawai.edit', compact('data','divisi','jabatan'));
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
        $request->validate([
            'nama' => 'required',
            'tgl_lahir' => 'required',
            'alamat' => 'required',
            'divisi' => 'required',
            'jabatan' => 'required',
            'no_rekening' => 'required'
        ]);
        $tgl_lahir = Carbon::parse($request->tgl_lahir);
        DB::table('pegawai')->where('id', $id)->update([
            'nama' => $request->nama,
            'tgl_lahir' => $tgl_lahir->format('Y-m-d'),
            'alamat' => $request->alamat,
            'id_divisi' => $request->divisi,
            'id_jabatan' => $request->jabatan,
            'no_rekening' => $request->no_rekening
        ]);
        return redirect('/backend/pegawai')->with('status','Sukses merubah data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pegawai')->where('id', $id)->delete();
    }
}
