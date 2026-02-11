<?php

use App\Models\Extern;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    //    {{vault_v1}}/auth/userpass/login/orchestuser
    Route::post('/auth/userpass/login/orchestuser', function (Request $request) {
        $request->validate(['username' => 'required|string', 'password' => 'required|string']);

        return response()->json([
            'auth' => [
                'client_token' => 'client_token_test'
            ]
        ]);
    });

    //    {{vault_v1}}/auth/approle/role/appauthrole/role-id
    //    {{vault_v1}}/auth/approle/role/appcertrole/role-id
    Route::get('auth/approle/role/{role}/role-id', function (Request $request) {

        return response()->json([
            'data' => [
                'role_id' => $request->route('role') . '_role_id_test'
            ]
        ]);
    });

    //    {{vault_v1}}/auth/approle/role/appauthrole/secret-id
    //    {{vault_v1}}/auth/approle/role/appcertrole/secret-id
    Route::post('auth/approle/role/{role}/secret-id', function (Request $request) {
        return response()->json([
            'data' => [
                'secret_id' => $request->route('role') . '_secret_id_test'
            ]
        ]);
    });

    ///////
//    {{vault_v1}}/auth/approle/login
//    {
//        "role_id":"{{vault_role_id}}",
//        "secret_id":"{{vault_secret_id}}"
//    }
    ///////
    Route::post('auth/approle/login', function (Request $request) {
        $request->validate(['role_id' => 'required|string', 'secret_id' => 'required|string']);

        return response()->json([
            'auth' => [
                'client_token' => 'client_token_for_' . $request->input('secret_id'),
//                'lease_duration' => 900,
//                'num_uses' => 100
//
                'lease_duration' => 30,
                'num_uses' => 30
            ]
        ]);
    });

//    {{vault_v1}}/apikey/intern/Cheie_interna123
    Route::post('{type}/intern/{key}', function (Request $request) {
        Intern::query()->updateOrCreate(
            [
                'type' => $request->route('type'),
                'key' => $request->route('key'),
            ], [
                'value' => json_encode($request->all())
            ]
        );

        return response(status: 204);
    });

    Route::get('{type}/intern/{key}', function (Request $request) {
        return response()->json(
            [
                'data' => json_decode(Intern::query()
                    ->where('key', $request->route('key'))
                    ->where('type', $request->route('type'))
                    ->firstOrFail()->value
                )
            ]);
    });

//    {{vault_v1}}/apikey/extern/123455/Cheie_externa
    Route::post('{type}/extern/{parent}/{key}', function (Request $request) {
        Extern::query()->updateOrCreate(
            [
                'type' => $request->route('type'),
                'key' => $request->route('key'),
                'parent' => $request->route('parent'),
            ], [
                'value' => json_encode($request->all())
            ]
        );

        return response(status: 204);
    });

    Route::get('{type}/extern/{parent}/{key}', function (Request $request) {
        return response()->json([
            'data' => json_decode(Extern::query()
                ->where('type', $request->route('type'))
                ->where('key', $request->route('key'))
                ->where('parent', $request->route('parent'))
                ->firstOrFail()->value)
        ]);
    });
});