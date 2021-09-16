<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\slideModel;
use App\csrModel;
use App\csrimgModel;
use App\newsModel;
use App\industryModel;
use App\industryinteractiveModel;
use App\typeuseModel;
use App\contactmapModel;
use App\productcatagoryModel;
use App\productlistModel;
use App\productminorModel;
use App\productsubminorModel;
use App\technicalpaperModel;
use App\typeproModel;
use DB;
class HomeController extends Controller
{
    public function index(){
        $slide = slideModel::paginate(10);
        return view('fontend.index')->with('slide',$slide);
    }
    public function aboutus(){
        return view('fontend.aboutus');
    }
    public function contactus(){
        return view('fontend.contactus',[
            'cont'=>contactmapModel::orderby('ctm_id','asc')->paginate(),
        ]);
    }
    public function csr(){
        $csr=csrModel::paginate(12);
        return view('fontend.csr')->with('csr',$csr);
    }
    public function csr_detail(){
        return view('fontend.csr-detail');
    }
    public function howDoWeDoIt(){
        return view('fontend.howDoWeDoIt');
    }
    public function industries_sub($id){
        $indus=industryModel::find($id);
        $ina=industryinteractiveModel::where('in_id','=',$id)->paginate(10);
        $type=typeuseModel::where('in_id','=',$id)->paginate();
        $typepro=DB::table('typeuse')
        ->join('industry_producttype','typeuse.in_id','=','industry_producttype.in_id')
        ->select('industry_producttype.*','typeuse.*')
        ->where('in_id')
        ->paginate();
        return view('fontend.industries-sub')
        ->with('indus',$indus)
        ->with('ina',$ina)
        ->with('type',$type)
        ->with('typepro',$typepro);
    }
    public function industries(){
        return view('fontend.industries',[
            'indus'=>industryModel::paginate(10)
        ]);
    }
    public function interactivedraw_detail($id){
/*         $inaa=industryinteractiveModel::find($id); */
        $ina=DB::table('industry_interactive')
        ->join('industry','industry_interactive.in_id','=','industry.in_id')
        ->select('industry_interactive.*','industry.*')
        ->where('in_id','=',$id);
        
        return view('fontend.interactiveDraw-detail')->with('ina',$ina);
    }
    public function nav(){
        return view('fontend.nav');
    }
    public function news_detail(){
        return view('fontend.news-detail');
    }
    public function news(){
        $news=newsModel::paginate(10);
        return view('fontend.news')->with('news',$news);
    }
    public function privacyPolicy(){
        return view('fontend.privacyPolicy');
    }
    public function product_list($id){
        $prominor=productminorModel::find($id);
        $pro=productcatagoryModel::paginate();
        $prosub=productsubminorModel::where('pm_id','=',$id)->paginate();
        $prolist=productlistModel::paginate();
        return view('fontend.product-lists')->with('prominor',$prominor)->with('pro',$pro)->with('prosub',$prosub)->with('prolist',$prolist);
    }
    public function products(){
        $pro=productcatagoryModel::paginate();
        $prominor=productminorModel::paginate();
        $prosub=productsubminorModel::paginate();
        return view('fontend.products')->with('pro',$pro)->with('prominor',$prominor)->with('prosub',$prosub);
    }
    public function resource(){
        return view('fontend.resource');
    }
    public function resultSearch(){
        return view('fontend.resultSearch');
    }
    public function specialPaper(){
        return view('fontend.specialPaper');
    }
    public function technicalPaper(){
        return view('fontend.technicalPaper',[
            'tech'=>technicalpaperModel::paginate()
        ]);
    }
    public function termOfUse(){
        return view('fontend.termOfUse');
    }
    public function whatWeDo(){
        return view('fontend.whatWeDo');
    }


}
