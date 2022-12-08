<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {
        $totalImages = 0;
        $albums = Album::all();
        foreach($albums as $a){ $totalImages += $a->images->count(); }
        return view("albums", compact('albums','totalImages'));
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name' => 'required',
        ]);

        $album = new Album();
        $album->name = $request->name;
        if($album->save()){
            return back()->with('success', 'Album saved successfully.');
        }else{
            return back()->with('error', 'Album not saved!.');
        }
    }

    public function delete(Request $request){

        $validated = $request->validate([
            'album' => 'required',
        ]);

        $album = Album::find($request->album);

        if($album->images->count()==0){
            if($album->delete()){
                return back()->with('success', 'Album deleted successfully.');
            }else{
                return back()->with('error', 'Album not deleted!.');
            }
        }else{
            if($request->action==null){
                return back()->with('error', 'You must select an action!.');
            }else if($request->action=='move'&&$request->moveto==null){
                return back()->with('error', 'You must select an album!.');
            }else{
                foreach($album->images as $i){
                    if($request->action=="delete"){
                        $file = storage_path('app/'.$i->media);
                        if(isset($file)){ unlink($file); }
                        $i->delete();
                    }else if($request->action=="move"){
                        $i->album = $request->moveto;
                        $i->update();
                    }
                }
                if($album->delete()){
                    return back()->with('success', 'Album deleted successfully.');
                }else{
                    return back()->with('error', 'Album not deleted!.');
                }
            }
        }
    }
}
