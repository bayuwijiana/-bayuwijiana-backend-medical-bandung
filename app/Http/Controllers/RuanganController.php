<?php

namespace App\Http\Controllers;;

use App\Helpers\ApiFormatter;
use App\Models\Ruangan;
use App\Models\Pasien;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RuanganController extends Controller
{
    public function index()
    {
        $data = Ruangan::all();

        if ($data) {
            return ApiFormatter::createApi(200, 'Succes', $data);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_Ruangan'   => 'required',
                'spesialis' => 'required'
            ]);

            $data = Ruangan::create($request->all());
            if ($data) {
                return ApiFormatter::createApi(200, 'Succes', $data);
            } else {
                return ApiFormatter::createApi(400, 'Data Not Created');
            }
        } catch (Exception $error) {
            $nounc = $error->getMessage();

            return ApiFormatter::createApi(400, $nounc);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama_Ruangan'   => 'required',
                'spesialis' => 'required',
            ]);

            $data = Ruangan::find($id);
            if ($data) {
                return ApiFormatter::createApi(200, 'Succes', $data);
            } else {
                return ApiFormatter::createApi(400, 'Data by id not found in database');
            }
        } catch (Exception $error) {
            $nounc = $error->getMessage();

            return ApiFormatter::createApi(400, $nounc);
        }
    }


    public function show($id)
    {
        try {

            $data = Ruangan::find($id);
            if ($data) {
                return ApiFormatter::createApi(200, 'Succes search data', $data);
            } else {
                return ApiFormatter::createApi(400, 'Data by id not found in database');
            }
        } catch (Exception $error) {
            $nounc = $error->getMessage();

            return ApiFormatter::createApi(400, $nounc);
        }
    }

    public function destroy($id)
    {
        try {

            $data = Ruangan::find($id);
            Pasien::where('id_ruangan', $id)->delete();
            if ($data) {
                $data->delete();
                return ApiFormatter::createApi(200, 'Succes delete data', $data);
            } else {
                return ApiFormatter::createApi(400, 'Data by id not found in database');
            }
        } catch (Exception $error) {
            $nounc = $error->getMessage();

            return ApiFormatter::createApi(400, $nounc);
        }
    }
}
