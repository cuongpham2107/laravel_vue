<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Cast;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = Request::input('perPage') ?: 5;

        return Inertia::render('Casts/Index', [
            'casts'     => Cast::query()
                                ->when(Request::input('search'), function($query, $search){
                                    $query->where('name', 'like', "%{$search}%");
                                })
                                ->paginate($perPage)
                                ->withQueryString(),
            'fillters'  => Request::only(['search', 'perPage'])                   
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cast = Cast::where('tmdb_id', Request::input('castTMDBId'))->first();
        if($cast){
            return Redirect::route('admin.casts.index')->with('flash.banner', 'Cast Exists.');
        }

        $tmdb_cast = Http::get(config('services.tmdb.endpoint').'person/'. Request::input('castTMDBId') .'?api_key='.config('services.tmdb.secret'). '&language=en-US' );
        // dd($tmdb_cast['poster_path']);
        if($tmdb_cast->ok()){
            Cast::create([
                'tmdb_id'       => $tmdb_cast['id'],
                'name'          => $tmdb_cast['name'],
                'slug'          => Str::slug($tmdb_cast['name']),
                'poster_path'   => $tmdb_cast['profile_path'],
            ]);
            return Redirect::route('admin.casts.index')->with('flash.banner','Cast Created');
        }
        else{
            return Redirect::route('admin.casts.index')->with('flash.banner', 'Cast Exists');
        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
