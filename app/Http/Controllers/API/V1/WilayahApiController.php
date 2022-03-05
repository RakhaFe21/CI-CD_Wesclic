<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahApiController extends Controller
{
  public function getProvinsi()
  {
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi');
    $data = $response->json();
    $data = isset($data['provinsi']) ? $data['provinsi'] : [];
    $result = [];
    foreach ($data['provinsi'] as $key => $provinsi) {
      if (strpos($provinsi['nama'], 'Di Yogyakarta') !== false) {
        $result[$key]['nama'] = 'DI Yogyakarta';
      } elseif (strpos($provinsi['nama'], 'Dki Jakarta') !== false) {
        $result[$key]['nama'] = 'DKI Jakarta';
      }
    }
    return response()->json(['success' => true, 'message' => 'get province data', 'data' => $result]);
  }

  public function getDetailProvinsi($id_provinsi)
  {
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/provinsi/' . $id_provinsi);
    $data = $response->json();
    $result = $data;
    if (strpos($data['nama'], 'Di Yogyakarta') !== false) {
      $result['nama'] = 'DI Yogyakarta';
    } elseif (strpos($data['nama'], 'Dki Jakarta') !== false) {
      $result['nama'] = 'DKI Jakarta';
    }
    return response()->json(['success' => true, 'message' => 'get detail province data', 'data' => $result]);
  }

  public function getKota(Request $request)
  {
    $id_provinsi = $request->input('id_provinsi');
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=' . $id_provinsi);
    $data = $response->json();
    $result = isset($data['kota_kabupaten']) ? $data['kota_kabupaten'] : [];
    return response()->json(['success' => true, 'message' => 'get kota / kabupaten data', 'data' => $result]);
  }

  public function getDetailKota($id_kota)
  {
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kota/' . $id_kota);
    $result = $response->json();
    return response()->json(['success' => true, 'message' => 'get detail kota / kabupaten data', 'data' => $result]);
  }

  public function getKecamatan(Request $request)
  {
    $id_kota = $request->input('id_kota');
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan?id_kota=' . $id_kota);
    $data = $response->json();
    $result = isset($data['kecamatan']) ? $data['kecamatan'] : [];
    return response()->json(['success' => true, 'message' => 'get kecamatan data', 'data' => $result]);
  }

  public function getDetailKecamatan($id_kecamatan)
  {
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kecamatan/' . $id_kecamatan);
    $result = $response->json();
    return response()->json(['success' => true, 'message' => 'get detail kecamatan data', 'data' => $result]);
  }

  public function getKelurahan(Request $request)
  {
    $id_kecamatan = $request->input('id_kecamatan');
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan?id_kecamatan=' . $id_kecamatan);
    $data = $response->json();
    $result = isset($data['kelurahan']) ? $data['kelurahan'] : [];
    return response()->json(['success' => true, 'message' => 'get kelurahan data', 'data' => $result]);
  }

  public function getDetailKelurahan($id_kelurahan)
  {
    $response = Http::get('https://dev.farizdotid.com/api/daerahindonesia/kelurahan/' . $id_kelurahan);
    $result = $response->json();
    return response()->json(['success' => true, 'message' => 'get detail kelurahan data', 'data' => $result]);
  }

  //END
}
