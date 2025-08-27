<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function index() {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        if ($response->successful()) {
            $provinces = $response->json()['data'] ?? [];
        }

        return view('rajaongkir', compact('provinces'));
    }

    public function getCities($provinceId) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

        if ($response->successful()) {
            return response()->json($response->json()['data'] ?? []);
        }
    }

    public function getDistrics($cityId) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

        if ($response->successful()) {
            return response()->json($response->json()['data'] ?? []);
        }
    }

    public function checkOngkir(Request $request) {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin' => 1338, # Tebet, Jakarta Selatan
            'destination' => $request->input('district_id'),
            'weight' => $request->input('weight'),
            'courier' => $request->input('courier'),
        ]);

        if ($response->successful()) {
            return $response->json()['data'] ?? [];
        }
    }
}
