<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\spacailModel;
use App\technicalpaperModel;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
class SpacailfocusController extends Controller
{
    public function imageSize($find = null)
    {
        $arr = [
            'cover' => [
                'lg' => ['x' => "100%", 'y' => "100%"],
            ],
            'gallery' => [
                'lg' => ['x' => "100%", 'y' => "100%"],
            ]
        ];
        if ($find == null) {
            return $arr;
        } else {
            switch ($find) {
                case 'cover':
                    return $arr['cover'];
                    break;
                case 'gallery':
                    return $arr['gallery'];
                    break;
                default:
                    return [];
                    break;
            }
        }
    }
    public function index(){
        $specail=DB::table('spacailfocus')
        ->join('technicalpaper','spacailfocus.tp_id','=','technicalpaper.tp_id')
        ->select('spacailfocus.*','technicalpaper.tp_nameen')
        ->paginate(10);
        return view('admin.spacail.index')->with('specail',$specail);
    }
    public function add(){
        return view('admin.spacail.add',[
            'tech'=>technicalpaperModel::paginate(10),
        ]);
    }
    public function addsub(Request $request){
        $spacail=new spacailModel;
        $spacail->sf_nameen=$request->sf_nameen;
        $spacail->sf_nameth=$request->sf_nameth;
        $spacail->sf_detailen=$request->sf_detailen;
        $spacail->sf_detailth=$request->sf_detailth;
        $spacail->tp_id=$request->tp_id;
        $filename = 'sf_img_' . date('dmY-His');
        $file = $request->sf_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/spacail/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $spacail->sf_img = $newLG;
            }
        }
        $spacail->save();
        return redirect('/spacailfucus');
    }
    public function edit($id){
        
        return view('admin.spacail.edit',[
            'specail'=>spacailModel::find($id),
            'tech'=>technicalpaperModel::paginate(10),
        ]);
    }
    public function editsub(Request $request){
        $spacail=spacailModel::find($request->sf_id);
        $spacail->sf_nameen=$request->sf_nameen;
        $spacail->sf_nameth=$request->sf_nameth;
        $spacail->sf_detailen=$request->sf_detailen;
        $spacail->sf_detailth=$request->sf_detailth;
        $spacail->tp_id=$request->tp_id;
        $filename = 'sf_img_' . date('dmY-His');
        $file = $request->sf_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){
                if($spacail->sf_img != null){
                    Storage::disk('public')->delete($spacail->sf_img);
                }           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/spacail/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $spacail->sf_img = $newLG;
            }
        }
        $spacail->save();
        return redirect("/spacailfucus/edit/$spacail->sf_id");
    }
    public function deletespecail($id)
    {
        $specail=spacailModel::find($id);

        if($specail->sf_img!=null){Storage::disk('public')->delete($specail->sf_img);}
        
        $spe=spacailModel::destroy($specail->sf_id);
        if($spe){
            return response()->json(true);
        }else{
            return response()->json(false);
        }

    }
}
