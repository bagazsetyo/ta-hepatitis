<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\User;
use App\Models\HasilPakar;
use App\Models\PivotHasilPakar;

class PasienController extends Controller
{
    public function index()
    {
        $pasien             = Pasien::join('users','users.id','id_user')
                                    ->select('pasiens.*','users.email')
                                    ->get();

        return view('pasien.index', compact('pasien'));
    }

    public function store(Request $request)
    {
        $cpasien                    = Pasien::where('nik', $request->nik)->first();

        if ($cpasien) 
        {
            toastr()->error('Pasien Sudah Terdaftar');
            return back();
        }
        else
        {
            $cuser                      = User::where('email', $request->email)
                                                ->first();

            if($cuser)
            {
                toastr()->error('Email sudah terdaftar');

                return back();
            }
            else
            {
                $user                       = new User();
                $user->id_role              = 3;
                $user->nama                 = $request->nama;
                $user->email                = $request->email;
                $user->username             = $request->nik;
                $user->password             = bcrypt($request->password);
                $user->status               = 1;
                if($user->save())
                {
                    $pasien                     = new Pasien();
                    $pasien->id_user            = $user->id;
                    $pasien->nama_lengkap       = $request->nama;
                    $pasien->nik                = $request->nik;
                    $pasien->handphone          = $request->hp;
                    $pasien->jenis_kelamin      = $request->jeniskelamin;
                    $pasien->tempat_lahir       = $request->tempatlahir;
                    $pasien->tanggal_lahir      = date('Y-m-d', strtotime($request->tanggallahir));
                    $pasien->alamat_ktp         = $request->alamat;
                    $pasien->agama              = $request->agama;
                    $pasien->pekerjaan          = $request->pekerjaan;
                    $pasien->status_pernikahan  = $request->menikah;
                    $pasien->save();

                    toastr()->success('Berhasil Menyimpan Data Pasien');

                    return back();

                }

                else
                {
                    toastr()->error('Gagal Menyimpan Data Pasien');

                    return back();
                }

            }


        }
    }

    public function update(Request $request, $id)
    {
        $cpasien                        = Pasien::where('id', $id)
                                                ->first();

        if ($cpasien) 
        {
            $user                       = User::where('id', $cpasien->id_user)->first();
            $user->nama                 = $request->nama;
            $user->email                = $request->email;
            $user->username             = $request->nik;
            if($request->password)
            {
                $user->password             = bcrypt($request->password);
            }
            if($user->save())
            {
                $pasien                     = Pasien::find($id);
                $pasien->id_user            = $user->id;
                $pasien->nama_lengkap       = $request->nama;
                $pasien->nik                = $request->nik;
                $pasien->handphone          = $request->hp;
                $pasien->jenis_kelamin      = $request->jeniskelamin;
                $pasien->tempat_lahir       = $request->tempatlahir;
                $pasien->tanggal_lahir      = date('Y-m-d', strtotime($request->tanggallahir));
                $pasien->alamat_ktp         = $request->alamat;
                $pasien->agama              = $request->agama;
                $pasien->pekerjaan          = $request->pekerjaan;
                $pasien->status_pernikahan  = $request->menikah;
                $pasien->save();

                toastr()->success('Berhasil Menyimpan Data Pasien');

                return back();

            }
            else
            {
                toastr()->error('Gagal Menyimpan Data Pasien');

                return back();
            }


        }
    }

    public function show($id)
    {
        $pasien                                 = Pasien::find($id);
        $diagnosa                               = HasilPakar::where('id_pasien', $id)->get();
        

        return view('pasien.show', compact('pasien','diagnosa'));
    }
}
