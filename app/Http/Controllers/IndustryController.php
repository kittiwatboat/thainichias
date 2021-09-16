<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\industryModel;
use App\industryinteractiveModel;
use App\typeuseModel;
use App\typeproModel;
use App\productminorModel;
use App\industryproductcatModel;
use Intervention\Image\ImageManagerStatic as Image;

class IndustryController extends Controller
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
        $indus=industryModel::paginate(10);
        return view('admin.industry.index')->with('indus',$indus);
    }
    public function add(){
        return view('admin.industry.add');
    }
    public function addsub(Request $request){
        $indus=new industryModel;
        $indus->in_nameen=$request->in_nameen;
        $indus->in_nameth=$request->in_nameth;
        $indus->in_headen=$request->in_headen;
        $indus->in_headth=$request->in_headth;
        $indus->in_detailen=$request->in_detailen;
        $indus->in_detailth=$request->in_detailth;
        $filename = 'in_coverimg_' . date('dmY-His');
        $file = $request->in_coverimg;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/industry/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $indus->in_coverimg = $newLG;
            }
        }
        $indus->save();
        return redirect("/industry/add/interactive/$indus->in_id");
    }
    public function addinter($id){
        $indus=industryModel::find($id);
        $inter=industryinteractiveModel::where('in_id','=',$id)->paginate(10);
        return view('admin.industry.addinteractive')->with('indus',$indus)->with('inter',$inter);
    }
    public function addintersub(Request $request){

        $inter= new industryinteractiveModel;
        $inter->in_id=$request->in_id;
        $inter->ina_nameen=$request->ina_nameen;
        $inter->ina_nameth=$request->ina_nameth;
        $inter->ina_detailen=$request->ina_detailen;
        $inter->ina_detailth=$request->ina_detailth;
        $filename = 'ina_img_' . date('dmY-His');
        $file = $request->ina_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/industry/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $inter->ina_img = $newLG;
            }
        }
        $inter->save();
        return redirect("/industry/add/interactive/$inter->in_id");
    }
    public function addtype($id){
        $indus=industryModel::find($id);
        $type=typeuseModel::where('in_id','=',$id)->paginate(10);
        return view('admin.industry.addtypeuse')->with('indus',$indus)->with('type',$type);
    }
    public function addtypesub(Request $request){
        $type=new typeuseModel;
        $type->tu_nameen=$request->tu_nameen;
        $type->tu_nameth=$request->tu_nameth;
        $type->in_id=$request->in_id;
        $type->save();
        return redirect("/industry/add/type/$type->in_id");

    }
    public function addtypepro($id){
        $indus=industryModel::find($id);
        $type=typeuseModel::where('in_id','=',$id)->paginate(10);
        $typepro=typeproModel::where('in_id','=',$id)->paginate(10);
        return view('admin.industry.addtypepro')
        ->with('indus',$indus)
        ->with('type',$type)
        ->with('typepro',$typepro);
    }
    public function addtypeprosub(Request $request){
        $typepro=new typeproModel;
        $typepro->inpt_nameen=$request->inpt_nameen;
        $typepro->inpt_nameth=$request->inpt_nameth;
        $typepro->inpt_detailth=$request->inpt_detailth;
        $typepro->inpt_detailen=$request->inpt_detailen;
        $typepro->inpt_link=$request->inpt_link;
        $typepro->in_id=$request->in_id;
        $typepro->tu_id=$request->tu_id;
        $filename = 'inpt_img_' . date('dmY-His');
        $file = $request->inpt_img;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/industry/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $typepro->inpt_img = $newLG;
            }
        }
        $typepro->save();
        return redirect("/industry/add/type/product/$typepro->in_id");
    }
    public function addtypeprocat($id){
        $indus=industryModel::find($id);
        $pro=productminorModel::paginate();
        $inpro=industryproductcatModel::where('in_id','=',$id)->paginate(10);
        $typepro=typeproModel::where('in_id','=',$id)->paginate(10);
        return view('admin.industry.addtypeprosub')
        ->with('indus',$indus)
        ->with('inpro',$inpro)
        ->with('typepro',$typepro)
        ->with('pro',$pro);
    }
    public function addtypeprocatsub(Request $request){
        $inpro=new industryproductcatModel;
        $inpro->in_id=$request->in_id;
        $inpro->inpt_id=$request->inpt_id;
        $inpro->pm_id=$request->pm_id;
        $inpro->save();
        return redirect("/industry/add/type/product/cat/$inpro->in_id");

    }
    public function edit($id){
        $indus=industryModel::find($id);
        $inter=industryinteractiveModel::where('in_id','=',$id)->paginate(10);
        $type=typeuseModel::where('in_id','=',$id)->paginate(10);
        return view('admin.industry.edit')
        ->with('indus',$indus)
        ->with('inter',$inter)
        ->with('type',$type);
    }
    public function editsub(Request $request){

        $indus=industryModel::find($request->in_id);
        $indus->in_nameen=$request->in_nameen;
        $indus->in_nameth=$request->in_nameth;
        $indus->in_headen=$request->in_headen;
        $indus->in_headth=$request->in_headth;
        $indus->in_detailen=$request->in_detailen;
        $indus->in_detailth=$request->in_detailth;
        $filename = 'in_coverimg_' . date('dmY-His');
        $file = $request->in_coverimg;
        if($file){ 
            $ima = $file->getClientOriginalExtension();
            if($ima=='png' || $ima=='jpg'|| $ima=='jpeg'){  
                if($indus->in_coverimg != null){
                    Storage::disk('public')->delete($indus->in_coverimg);
                }           
            $lg = image::make($file->getRealPath());
            $ext = explode("/", $lg->mime())[1];
            $size = $this->imageSize();
            $lg->resize($size['cover']['lg']['x'], $size['cover']['lg']['y'])->stream();
            $newLG = 'upload/industry/' . $filename . '.' . $ext;
            $store = Storage::disk('public')->put($newLG, $lg);
            $indus->in_coverimg = $newLG;
            }
        }
        $indus->save();
        return redirect("/industry/edit/$indus->in_id");
    }
}
