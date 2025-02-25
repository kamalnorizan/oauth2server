<?php

namespace App\Http\Controllers;

use App\Models\SubSystem;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

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
            'name' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
            'scope' => 'required|array',
            'scope.*' => 'required|string|max:200'
        ],[
            'name.required' => 'Sila masukkan nama sub sistem',
            'name.max' => 'Nama sub sistem mesti kurang dari 200 aksara',
            'description.max' => 'Penerangan mesti kurang dari 500 aksara',
            'scope.*.required' => 'Sila pilih sekurang-kurangnya satu skop',
        ]);

        $subSystem = SubSystem::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        $subSystem->scopes()->createMany(
            collect($request->scope)->map(function($scope){
                return ['scope' => $scope];
            })->toArray()
        );

        return response()->json(['success'=>true,'message' => 'Sub sistem berjaya ditambah']);
    }
}
