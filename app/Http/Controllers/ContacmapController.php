<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\contactmapModel;
use Intervention\Image\ImageManagerStatic as Image;
class ContacmapController extends Controller
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
        return view('admin.contactmap.index',[
            'cont'=>contactmapModel::paginate()
        ]);
    }
    public function add(){
        return view('admin.contactmap.add');
    }
    public function addsub(Request $request){
        $cont=new contactmapModel;
        $cont->ctm_countyen=$request->ctm_countyen;
        $cont->ctm_countyth=$request->ctm_countyth;
        $cont->ctm_companyen=$request->ctm_companyen;
        $cont->ctm_companyth=$request->ctm_companyth;
        $cont->ctm_detailen=$request->ctm_detailen;
        $cont->ctm_detailth=$request->ctm_detailth;
        $cont->ctm_linkmap=$request->ctm_linkmap;
        $filename = 'ctm_imgmap_' . date('dmY-His');
        $file = $request->ctm_imgmap;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/map/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $cont->ctm_imgmap = $newLG;
            }
        }
        $cont->save();
        return redirect("/contact/map");

    }
    public function edit($id){
        return view('admin.contactmap.edit',[
            'cont'=>contactmapModel::find($id),
        ]);
    }
    public function editsub(Request $request){
        $cont=contactmapModel::find($request->ctm_id);
        $cont->ctm_countyen=$request->ctm_countyen;
        $cont->ctm_countyth=$request->ctm_countyth;
        $cont->ctm_companyen=$request->ctm_companyen;
        $cont->ctm_companyth=$request->ctm_companyth;
        $cont->ctm_detailen=$request->ctm_detailen;
        $cont->ctm_detailth=$request->ctm_detailth;
        $cont->ctm_linkmap=$request->ctm_linkmap;
        $filename = 'ctm_imgmap_' . date('dmY-His');
        $file = $request->ctm_imgmap;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){  
                if($cont->ctm_imglink != null){
                    Storage::disk('public')->delete($cont->ctm_imglink);
                }          
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/map/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $cont->ctm_imgmap = $newLG;
            }
        }
        $cont->save();
        return redirect("/contact/map/edit/$cont->ctm_id");
    }
    public function delete($id){
        $cont=contactmapModel::find($id);

        if($cont->ctm_imgmap!=null){Storage::disk('public')->delete($cont->ctm_imgmap);}
        $cm=contactmapModel::destroy($cont->ctm_id);
        if($cm){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
}
