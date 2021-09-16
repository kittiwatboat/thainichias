<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\resourceModel;
use Intervention\Image\ImageManagerStatic as Image;
class ResourceController extends Controller
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
        $reso=resourceModel::paginate(10);
        return view('admin.resource.index')->with('reso',$reso);
    }
    public function add(){
        return view('admin.resource.add');
    }
    public function addsub(Request $request){
        $reso = new resourceModel;
        $reso->re_nameen=$request->re_nameen;
        $reso->re_nameth=$request->re_nameth;
        $reso->re_detailen=$request->re_detailen;
        $reso->re_detailth=$request->re_detailth;


        $filename = 're_coverimg_' . date('dmY-His');
        $file = $request->re_coverimg;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/resource/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $reso->re_coverimg = $newLG;
            }
        }
        
        $filename1 = 're_img_' . date('dmY-His');
        $file1 = $request->re_img;
        if($file1){ 
            $ima = $file1->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg1 = image::make($file1->getRealPath());
            $ext1 = explode("/", $lg1->mime())[1];
            $size1 = $this->imageSize();
            $lg1->resize($size1['cover']['lg']['x'], $size1['cover']['lg']['y'])->stream();
            $newLG1 = 'upload/resource/' . $filename1 . '.' . $ext1;
            $store = Storage::disk('public')->put($newLG1, $lg1);
            $reso->re_img = $newLG1;
            }
        }
        $reso->save();
        return redirect('/resource');
    }
    public function edit($id){
        $re=resourceModel::find($id);
        return view('admin.resource.edit')->with('re',$re);
    }
    public function editsub(Request $request){
        $re = resourceModel::find($request->re_id);
        $re->re_nameen=$request->re_nameen;
        $re->re_nameth=$request->re_nameth;
        $re->re_detailen=$request->re_detailen;
        $re->re_detailth=$request->re_detailth;


        $filename = 're_coverimg_' . date('dmY-His');
        $file = $request->re_coverimg;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){         
                if($re->re_coverimg != null){
                    Storage::disk('public')->delete($re->re_coverimg);
                }    
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/resource/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $re->re_coverimg = $newLG;
            }
        }
        
        $filename1 = 're_img_' . date('dmY-His');
        $file1 = $request->re_img;
        if($file1){ 
            $ima = $file1->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){  
                if($re->re_img != null){
                    Storage::disk('public')->delete($re->re_img);
                }           
            $lg1 = image::make($file1->getRealPath());
            $ext1 = explode("/", $lg1->mime())[1];
            $size1 = $this->imageSize();
            $lg1->resize($size1['cover']['lg']['x'], $size1['cover']['lg']['y'])->stream();
            $newLG1 = 'upload/resource/' . $filename1 . '.' . $ext1;
            $store = Storage::disk('public')->put($newLG1, $lg1);
            $re->re_img = $newLG1;
            }
        }
        $re->save();
        return redirect("/resource/edit/$re->re_id");
    }
    public function deleteresource($id){
        $re=resourceModel::find($id);

        if($re->re_coverimg!=null){Storage::disk('public')->delete($re->re_coverimg);}
        if($re->re_img!=null){Storage::disk('public')->delete($re->re_img);}
        
        $r=resourceModel::destroy($re->re_id);
        if($r){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    
}
