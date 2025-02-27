<?php

namespace App\Http\Controllers;

use App\Models\SubSystem;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Laravel\Passport\Client;
class SubSystemController extends Controller
{
    public function index() {
        $scopes = Passport::scopes();
        $subSystems = SubSystem::with('scopes')->get();
        // dd($scopes);
        return view('sub_systems.index', compact('subSystems','scopes'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:200|unique:oauth_clients,name',
            'description' => 'nullable|string|max:500',
            'redirect' =>'required|url',
            'sso_header'=>'required|url',
            'scope' => 'required|array',
            'scope.*' => 'required|string|max:200'
        ],[
            'name.required' => 'Sila masukkan nama sub sistem',
            'name.unique' => 'Nama sub sistem telah wujud',
            'name.max' => 'Nama sub sistem mesti kurang dari 200 aksara',
            'description.max' => 'Penerangan mesti kurang dari 500 aksara',
            'sso_header_show.required' => 'Sila masukkan URL sso header',
            'sso_header_show.url' => 'URL sso header tidak sah',
            'redirect.required' => 'Sila masukkan URL redirect',
            'redirect.url' => 'URL redirect tidak sah',
            'scope.*.required' => 'Sila pilih sekurang-kurangnya satu skop',
        ]);

        $client = Client::where('name', $request->name)->first();
        if($client) {
            return response()->json(['success'=>false,'message' => 'Sub sistem telah wujud']);
        }

        $client = Client::create([
            'name' => $request->name,
            'redirect' => $request->redirect,
            'secret' => \Str::random(40),
            'personal_access_client' => false,
            'password_client' => false,
            'revoked' => false
        ]);

        $subSystem = SubSystem::create([
            'client_id' => $client->id,
            'name' => $request->name,
            'sso_header' => $request->sso_header,
            'description' => $request->description
        ]);

        $subSystem->scopes()->createMany(
            collect($request->scope)->map(function($scope){
                return ['scope' => $scope];
            })->toArray()
        );

        return response()->json(['success'=>true,'message' => 'Sub sistem berjaya ditambah']);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name_show' => 'required|string|max:200|unique:oauth_clients,name,'.$id,
            'description_show' => 'nullable|string|max:500',
            'redirect_show' =>'required|url',
            'sso_header_show'=>'required|url',
            'scope' => 'required|array',
            'scope.*' => 'required|string|max:200'
        ],[
            'name_show.required' => 'Sila masukkan nama sub sistem',
            'name_show.unique' => 'Nama sub sistem telah wujud',
            'name_show.max' => 'Nama sub sistem mesti kurang dari 200 aksara',
            'description_show.max' => 'Penerangan mesti kurang dari 500 aksara',
            'sso_header_show.required' => 'Sila masukkan URL sso header',
            'sso_header_show.url' => 'URL sso header tidak sah',
            'redirect_show.required' => 'Sila masukkan URL redirect',
            'redirect_show.url' => 'URL redirect tidak sah',
            'scope.*.required' => 'Sila pilih sekurang-kurangnya satu skop',
        ]);

        $subSystem = SubSystem::where('client_id',$id)->first();
        if($subSystem) {
            $client = Client::find($id);
            $client->name = $request->name_show;
            $client->redirect = $request->redirect_show;
            $client->save();

            $subSystem->name = $request->name_show;
            $subSystem->description = $request->description_show;
            $subSystem->sso_header = $request->sso_header_show;
            $subSystem->save();

            $subSystem->scopes()->delete();
            $subSystem->scopes()->createMany(
                collect($request->scope)->map(function($scope){
                    return ['scope' => $scope];
                })->toArray()
            );

            return response()->json(['success'=>true,'message' => 'Sub sistem berjaya dikemaskini']);
        }else {
            return response()->json(['success'=>false,'message' => 'Sub sistem tidak wujud']);
        }

    }

    public function getPassportClient($id) {

        $subSystem = SubSystem::with('client','scopes')->where('client_id',$id)->first();
        $client = $subSystem->client;
        $client->makeVisible('secret');
        $data = $subSystem->toArray();

        if($client) {
            return response()->json(['success'=>true,'data' => $data]);
        }
        return response()->json(['success'=>false,'message' => 'Sub sistem tidak wujud']);
    }

    public function ssologin(SubSystem $subsystem) {
        //generate token for subsystem
        $scope = $subsystem->scopes->pluck('scope')->toArray();
        $token = auth()->user()->createToken($subsystem->name, $scope)->accessToken;

        return redirect($subsystem->sso_header.'?token='.$token);
    }
}
