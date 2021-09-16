<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\csrModel;
use App\csrimgModel;
use Intervention\Image\ImageManagerStatic as Image;


class CsrController extends Controller
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
        $csr = csrModel::paginate(10);
        return view('admin.csractivitis.index')->with('csr',$csr);
    }
    public function add(){
        return view('admin.csractivitis.add');
    }
    public function addsub(Request $request){
        $csr = new csrModel;
        $csr->csr_nameen=$request->csr_nameen;
        $csr->csr_nameth=$request->csr_nameth;
        $csr->csr_detailen=$request->csr_detailen;
        $csr->csr_detailth=$request->csr_detailth;
        $csr->csr_type=$request->csr_type;
        $filename = 'csr_coverimg_' . date('dmY-His');
        $file = $request->csr_coverimg;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/csr/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $csr->csr_coverimg = $newLG;
            }
        }
        $csr->save();
        return redirect("/csr&activities/add/img/$csr->csr_id");
    }
    public function edit($id){
        return view('admin.csractivitis.edit',[
            'csr'=>csrModel::find($id),
            'csrimg'=>csrimgModel::where('csr_id','=',$id)->paginate(10)
        ]);
    }
    public function editsub(Request $request){
        $csr =csrModel::find($request->csr_id);
        $csr->csr_name=$request->csr_name;
        $csr->csr_detail=$request->csr_detail;
        $csr->csr_type=$request->csr_type;
        $filename = 'csr_coverimg_' . date('dmY-His');
        $file = $request->csr_coverimg;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){ 
                if($csr->csr_coverimg != null){
                    Storage::disk('public')->delete($csr->csr_coverimg);
                }          
            $lg = Image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/csr/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $csr->csr_coverimg = $newLG;
            }
        }
        $csr->save();
        return redirect("/csr&activities/edit/$csr->csr_id");
    }
    public function addimg($id){
        $csr=csrModel::find($id);
        $csrimg=csrimgModel::where('csr_id','=',$id)->paginate(10);
        return view('admin.csractivitis.addimg')->with('csr',$csr)->with('csrimg',$csrimg);
    }
    public function addimgsub(Request $request){
        $csr = new csrimgModel;
        $csr->csr_id=$request->csr_id;
        $filename = 'ic_image_' . date('dmY-His');
        $file = $request->ic_image;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/csr/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $csr->ic_image = $newLG;
            }
        }
        $csr->save();
        return redirect("/csr&activities/add/img/$csr->csr_id");
    }
    public function deleteimg($id){
        $csr=csrimgModel::find($id);

        if($csr->ic_image!=null){Storage::disk('public')->delete($csr->ic_image);}
        $ic=csrimgModel::destroy($csr->ic_id);
        if($ic){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
    public function delete($id){
        $csr=csrModel::find($id);

        if($csr->csr_image!=null){Storage::disk('public')->delete($csr->csr_image);}
        $cs=csrModel::destroy($csr->csr_id);
        if($cs){
            return response()->json(true);
        }else{
            return response()->json(false);
        }
    }
}

