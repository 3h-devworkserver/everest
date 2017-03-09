<?php 
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
// use Kris\LaravelFormBuilder\FormBuilder;
use Laracasts\Flash\Flash;
use Datatable;
use Input;
use File;
use Validator;
use App\Models\Packages;
// use App\Models\StaticBlock;
// use App\Models\PackageGallery;
use App\Models\PackageCategory;
use App\Models\PackageOption;
use App\Models\PackageItinerary;
use App\Models\PackageGallery;
use App\Models\PackageDatePrice;
use App\Http\Requests\Backend\Package\CreatePackageCategoryRequest;
use App\Http\Requests\Backend\Package\CreatePackageDatePriceRequest;
use App\Http\Requests\Backend\Package\CreatePackageGalleryRequest;
use App\Http\Requests\Backend\Package\CreatePackageItineraryRequest;
use App\Http\Requests\Backend\Package\CreatePackageOptionRequest;
use App\Http\Requests\Backend\Package\CreatePackageRequest;

use App\Http\Requests\Backend\Package\UpdatePackageCategoryRequest;
use App\Http\Requests\Backend\Package\UpdatePackageDatePriceRequest;
use App\Http\Requests\Backend\Package\UpdatePackageGalleryRequest;
use App\Http\Requests\Backend\Package\UpdatePackageItineraryRequest;
use App\Http\Requests\Backend\Package\UpdatePackageOptionRequest;
use App\Http\Requests\Backend\Package\UpdatePackageRequest;

use App\Http\Requests\Backend\Package\DeletePackageCategoryRequest;
use App\Http\Requests\Backend\Package\DeletePackageDatePriceRequest;
use App\Http\Requests\Backend\Package\DeletePackageGalleryRequest;
use App\Http\Requests\Backend\Package\DeletePackageItineraryRequest;
use App\Http\Requests\Backend\Package\DeletePackageOptionRequest;
use App\Http\Requests\Backend\Package\DeletePackageRequest;


class PackageController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorys = PackageCategory::all();
        // $category = $cat->pluck('title', 'id');
        $pack = Packages::where('pack_type', 'addon')->where('status', 1)->get();
        $addon = $pack->pluck('title', 'id');
        // $addon->prepend('-- Select Package --','');

       // return $addon;
        return view('backend.packages.create', compact('categorys', 'addon'));
    }

    public function index(){
        $table = $this->PackageDatatable();
        return view('backend.packages.index', compact('table'));
    }
    public function PackageDatatable()
    {
        // $pacakges = Packages::select('id','title'); 
        $route = route('api.table.package');              
        return Datatable::table()
        ->addColumn(trans('Id'), trans('Title'), trans('Slug'), trans('Package Type'), trans('Created At'), trans('Updated At'))
        ->addColumn(trans('Actions'))
        ->setUrl($route)
        ->render();
    }

      private function generateUniqueUrl($title){
        $temp = str_slug($title, '-');
        if (empty($temp)) {
            $temp= 'package';
        }
        if(!Packages::where('slug',$temp)->get()->isEmpty()){
        $i = 1;
        $newslug = $temp . '-' . $i;
        while(!Packages::where('slug',$newslug)->get()->isEmpty()){
            $i++;
            $newslug = $temp . '-' . $i;
        }
        $temp =  $newslug;
    }
    return $temp;
}

    public function store(CreatePackageRequest $request){
      //   $validator =  Validator::make($request->all(), [
      //           // 'title_it.*'=>'required',
      //           'title' => 'required',
      //           'cat' => 'required',
      //           'price' => 'required',
      //       ],[
      //           'cat.required' => 'Please select Package Category',
      //           'price.required' => 'Package Price per person is required',
      //           // 'title_it.*.required' => 'Itinerary title is required',
      //       ]);
      //    if ($validator->fails()) {
      //   return redirect()->back()->withErrors($validator);
      // }


        // return $request->all();
       $this->validate($request, [
        'title' => 'required',
        'cat' => 'required',
        'price' => 'required',
        // 'title_it.*' => 'required'
        ], [
        'cat.required' => 'Please select Package Category',
        'price.required' => 'Package Price per person is required',

        ]);

       if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        $destination_path = 'images/packages-new';
        $filename = time() . '-' . $file->getClientOriginalName();
            // $filename = time() . '-' . $file->getClientOriginalExtension();
        $file->move($destination_path, $filename);
        $request->request->add(['feat_img' => $filename]);
    }
    if ($request->hasFile('upload-map')) {
        $file = $request->file('upload-map');
        $destination_path = 'images/packages-new/maps';
        $filename = time() . '-' . $file->getClientOriginalName();
            // $filename = time() . '-' . $file->getClientOriginalExtension();
        $file->move($destination_path, $filename);
        $request->request->add(['map_image' => $filename]);
    }

    // $category = implode(",", $request->input('cat'));
    // $request->request->add(['category' => $category]);
    $request->request->add(['slug' => $this->generateUniqueUrl($request->title)]);
    if ($request->pack_type == 'main') {
      if (!empty($request->addon_pack)) {
        $string = implode(', ', $request->addon_pack);
        $request->request->add(['addon_package' => $string ]);
      }
    }
    $package = Packages::create($request->all());
    $package->packageCategory()->attach($request->input('cat'));

        // return $request->all();
    return redirect('admin/packages')->withFlashSuccess('Package Created Successfully');

}

public function edit($id){
    $package = Packages::findOrFail($id);
        $pack = Packages::where('pack_type', 'addon')->where('status', 1)->get();
        $addon = $pack->pluck('title', 'id');
        // $addon->prepend('-- Select Package --','');
    
    $categorys = PackageCategory::all();
    $addonSelected = explode(', ', $package->addon_package);
    return view('backend.packages.edit', compact('package', 'categorys', 'addon', 'addonSelected'));
}

public function update($id, UpdatePackageRequest $request){
        // return "heres";
        // return $request->all();

      //    $validator =  Validator::make($request->all(), [
      //           // 'title_it.*'=>'required',
      //           'title' => 'required',
      //           'cat' => 'required',
      //           'price' => 'required',
      //       ],[
      //           'cat.required' => 'Please select Package Category',
      //           'price.required' => 'Package Price per person is required',
      //       ]);
      //    if ($validator->fails()) {
      //   return redirect()->back()->withErrors($validator);
      // }


   $this->validate($request, [
    'title' => 'required',
    'cat' => 'required',
    'price' => 'required',
    ], [
    'cat.required' => 'Please select Package Category',
    'price.required' => 'Package Price per person is required',

    ]);

   $package = Packages::findOrFail($id);
   $featImage = $package->feat_img;
   $mapImage = $package->map_image;

   if ($request->hasFile('upload')) {
    $file = $request->file('upload');
    $destination_path = 'images/packages-new';
    $filename = time() . '-' . $file->getClientOriginalName();
            // $filename = time() . '-' . $file->getClientOriginalExtension();
    $move = $file->move($destination_path, $filename);
    if ($move) {
      if (!empty($featImage)) {
        if (File::exists('images/packages-new/'. $featImage)) {
          unlink('images/packages-new/'.$featImage);
      }
  }            
}

$request->request->add(['feat_img' => $filename]);
}
if ($request->hasFile('upload-map')) {
    $file = $request->file('upload-map');
    $destination_path = 'images/packages-new/maps';
    $filename = time() . '-' . $file->getClientOriginalName();
            // $filename = time() . '-' . $file->getClientOriginalExtension();
    $move = $file->move($destination_path, $filename);
    if ($move) {
      if (!empty($mapImage)) {
        if (File::exists('images/packages-new/maps/'. $mapImage)) {
          unlink('images/packages-new/maps/'.$mapImage);
      }
  }            
}
$request->request->add(['map_image' => $filename]);
}

// $category = implode(",", $request->input('cat'));
// $request->request->add(['category' => $category]);

//commented for valentines package, fixed slug is required
    if ($package->title != $request->title || $package->slug == '') {
     $request->request->add(['slug'=>$this->generateUniqueUrl($request->title)]);
    }
  //end of commenting
    
    //updating addon package
    if ($request->pack_type == 'main') {
      if (!empty($request->addon_pack)) {
        $string = implode(', ', $request->addon_pack);
        $request->request->add(['addon_package' => $string ]);
      }
    }

$package->update($request->all());
$package->packageCategory()->sync($request->input('cat'));

        // return $request->all();
return redirect('admin/packages/'.$id.'/edit')->withFlashSuccess('Package Updated Successfully');

}

public function deleteMapImage(Request $request){
  // return "here";

  $package = Packages::findorFail($request->id);
  $img = $package->map_image;
  $package->map_image = '';
  $package->save();

  if (!empty($img)) {
        if (File::exists('images/packages-new/maps/'.$img)) {
            unlink('images/packages-new/maps/'.$img);
        }
    }

}


public function destroy($id, DeletePackageRequest $request){
    $package = Packages::findOrFail($id);
    $featImage= $package->feat_img;
    $mapImage = $package->map_image;
    $package->delete();
    if (!empty($featImage)) {
        if (File::exists('images/packages-new/'.$featImage)) {
            unlink('images/packages-new/'.$featImage);
        }
    }
    if (!empty($mapImage)) {
        if (File::exists('images/packages-new/maps/'.$mapImage)) {
            unlink('images/packages-new/maps/'.$mapImage);
        }
    }
    return redirect('admin/packages')->withFlashSuccess('Package Deleted Successfully');
}

//for package dates and prices

public function datesPricesCreate(CreatePackageDatePriceRequest $request){
  $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --','');
    return view('backend.packages.dateprice.create', compact('packages'));
}

public function checkDatesPricesPackage(Request $request){
    if($request->ajax()){
        $packageId= $request->input('packageId');
        $datePrice = PackageDatePrice::where('package_id', $packageId)->first();
        if (empty($datePrice)) {
          return 'allow';
      }else{
          return 'dontallow';
      }
  }
}

public function datesPricesStore(CreatePackageDatePriceRequest $request){
  // return "here";
    // return $request->all();

          $validator =  Validator::make($request->all(), [
                // 'price.*'=>'required',
                'package_id' => 'required',
                // 'price'=>'required',
            ]);
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
          }
//extra validation
          $msg = '';
          $prices = $request->price;
          foreach ($prices as $key => $price) {
            if(empty($price)){
              $msg = $msg ."Invalid Price Entered";
            }
          }
          $dateranges = $request->daterange;
          foreach ($dateranges as $key => $daterange) {
            if(empty($daterange)){
              if(empty($msg)){
                $msg = $msg ."Invalid Date range Entered ";
              }else{
              $msg = $msg ."<br>Invalid Date range Entered ";
              }
            }
          }
          $status = $request->status;
          foreach ($status as $key => $st) {
            if(empty($st)){
              if(empty($msg)){
                $msg = $msg ."Invalid Status Selected ";
              }else{
              $msg =$msg . "<br>Invalid Status Selected";
              }
            }
          }
// return $msg;

          if(!empty($msg)){
              return redirect()->back()->withErrors($msg);
          }
//end of extra validation





      // return "validated";
           $i = 0;
    while($i < count($request->daterange)){
        PackageDatePrice::create([
            'description' =>$request->description,
            'daterange' =>$request->daterange[$i],
            'short_description' =>$request->short_description[$i],
            'price' =>$request->price[$i],
            'status' =>$request->status[$i],
            'package_id' =>$request->package_id,
            ]);
        $i++;
    }
    return redirect('admin/packages/datesprices')->withFlashSuccess('Packages Dates & Prices Created Successfully');
}

public function datesPricesView(){
    $datesPrices = PackageDatePrice::select('package_id')->distinct()->get();
  return view('backend.packages.dateprice.index', compact('datesPrices'));
}


public function datesPricesEdit($id, UpdatePackageDatePriceRequest $request){
    $package = Packages::findOrFail($id);
    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --','');
    return view('backend.packages.dateprice.edit', compact('package', 'packages'));
}

public function datesPricesUpdate($id, UpdatePackageDatePriceRequest $request){

          $validator =  Validator::make($request->all(), [
                'package_id' => 'required',
            ]);
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
          }
//extra validation
          $msg = '';
          $prices = $request->price;
          foreach ($prices as $key => $price) {
            if(empty($price)){
              $msg = $msg ."Invalid Price Entered";
            }
          }
          $dateranges = $request->daterange;
          foreach ($dateranges as $key => $daterange) {
            if(empty($daterange)){
              if(empty($msg)){
                $msg = $msg ."Invalid Date range Entered ";
              }else{
              $msg = $msg ."<br>Invalid Date range Entered ";
              }
            }
          }
          $status = $request->status;
          foreach ($status as $key => $st) {
            if(empty($st)){
              if(empty($msg)){
                $msg = $msg ."Invalid Status Selected ";
              }else{
              $msg =$msg . "<br>Invalid Status Selected";
              }
            }
          }
// return $msg;

          if(!empty($msg)){
              return redirect()->back()->withErrors($msg);
          }
//end of extra validation


     $package = Packages::findOrFail($id);
        // for package datesPrices
    $i = 0;
    $datesPrices = $package->datesPrices;
    $pre_count = count($datesPrices);
    $count = count($request->daterange);

    if ($pre_count <= $count) {
        while ($i < $pre_count) {
            $datesPrices[$i]->update([
                'description' =>$request->description,
                'daterange' =>$request->daterange[$i],
              'short_description' =>$request->short_description[$i],
                'price' =>$request->price[$i],
                'status' =>$request->status[$i],
                'package_id' =>$id,
                ]);
            $i++;
        }
        while ($i < $count) {
            PackageDatePrice::create([
                'description' =>$request->description,
                'daterange' =>$request->daterange[$i],
            'short_description' =>$request->short_description[$i],
                'price' =>$request->price[$i],
                'status' =>$request->status[$i],
                'package_id' =>$id,
                ]);
            $i++;
        }
    }else{
        while ($i < $count) {
            $datesPrices[$i]->update([
                'description' =>$request->description,
                'daterange' =>$request->daterange[$i],
            'short_description' =>$request->short_description[$i],
                'price' =>$request->price[$i],
                'status' =>$request->status[$i],
                'package_id' =>$id,
                ]);
            $i++;
        }
        while ($i < $pre_count) {
            $datesPrices[$i]->delete();
            $i++;
        }
    }
    return redirect('admin/packages/datesprices/'.$id.'/edit')->withFlashSuccess('Packages Dates & Prices Updated Successfully');

}

public function datesPricesDestroy($id, DeletePackageDatePriceRequest $request){
    $datesPrices = PackageDatePrice::where('package_id', $id)->get();

    foreach ($datesPrices as $key => $datePrice) {
        PackageDatePrice::destroy($datePrice->id);
    }
    return redirect('admin/packages/datesprices')->withFlashSuccess('Dates & Prices deleted Successfully');
}




    // for itinerarys
public function itineraryCreate(){
    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --','');
    return view('backend.packages.itinerary.create', compact('packages'));
}

public function itineraryView(){

    $itinerarys = PackageItinerary::select('package_id')->distinct()->get();
        // return $itinerarys;

        //  $route = route('api.table.package.itinerary');              
        // $table =  Datatable::table()
        //     ->addColumn(trans('Id'), trans('Name'), trans('Package Selected'), trans('Type'), trans('Created At'), trans('Updated At'))
        //     ->addColumn(trans('Actions'))
        //     ->setUrl($route)
        //     ->render();
    return view('backend.packages.itinerary.index', compact('itinerarys'));
}

public function itineraryStore(Request $request){
  // return "here";
  //       return $request->package_id;

           $validator =  Validator::make($request->all(), [
                'package_id' => 'required',
            ]);
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
          }

          //extra validation
          $msg = '';
          $days = $request->day_it;
          foreach ($days as $key => $day_it) {
            if(empty($day_it)){
              $msg = $msg ."Day field is required";
            }
          }
          $titles = $request->title_it;
          foreach ($titles as $key => $title_it) {
            if(empty($title_it)){
              if(empty($msg)){
                $msg = $msg ."Title field is required ";
              }else{
                $msg = $msg ."<br>Title field is required ";
              }
            }
          }
         
// return $msg;

          if(!empty($msg)){
              return redirect()->back()->withErrors($msg);
          }
//end of extra validation


      // return "validated";

        // for package itinerary
    $i = 0;
    while($i < count($request->title_it)){
        PackageItinerary::create([
            'day_it' =>$request->day_it[$i],
            'title_it' =>$request->title_it[$i],
            'walk_it' =>$request->walk_it[$i],
            'content_it' =>$request->content_it[$i],
            'order_it' =>$request->order_it[$i],
            'package_id' =>$request->package_id,
            ]);
        $i++;
    }
    return redirect('admin/packages/itinerary')->withFlashSuccess('Packages Itinerary Created Successfully');
}

public function itineraryEdit($id){
    $package = Packages::findOrFail($id);

    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --','');
    return view('backend.packages.itinerary.edit', compact('packages', 'package'));
}

public function checkItineraryPackage(Request $request){
    if($request->ajax()){
        $packageId= $request->input('packageId');
        $itinerary = PackageItinerary::where('package_id', $packageId)->first();
        if (empty($itinerary)) {
          return 'allow';
      }else{
          return 'dontallow';
      }
  }

}


public function itineraryUpdate(Request $request, $id){

  $validator =  Validator::make($request->all(), [
                'package_id' => 'required',
            ]);
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
          }

          //extra validation
          $msg = '';
          $days = $request->day_it;
          foreach ($days as $key => $day_it) {
            if(empty($day_it)){
              $msg = $msg ."Day field is required";
            }
          }
          $titles = $request->title_it;
          foreach ($titles as $key => $title_it) {
            if(empty($title_it)){
              if(empty($msg)){
                $msg = $msg ."Title field is required ";
              }else{
                $msg = $msg ."<br>Title field is required ";
              }
            }
          }
         
// return $msg;

          if(!empty($msg)){
              return redirect()->back()->withErrors($msg);
          }
//end of extra validation

    $package = Packages::findOrFail($id);
        // for package itinerarys
    $i = 0;
    $itinerarys = $package->itinerarys;
    $pre_count = count($itinerarys);
    $count = count($request->title_it);

    if ($pre_count <= $count) {
        while ($i < $pre_count) {
            $itinerarys[$i]->update([
                'day_it' =>$request->day_it[$i],
                'title_it' =>$request->title_it[$i],
                'walk_it' =>$request->walk_it[$i],
                'content_it' =>$request->content_it[$i],
                'order_it' =>$request->order_it[$i],
                'package_id' =>$id,
                ]);
            $i++;
        }
        while ($i < $count) {
            PackageItinerary::create([
                'day_it' =>$request->day_it[$i],
                'title_it' =>$request->title_it[$i],
                'walk_it' =>$request->walk_it[$i],
                'content_it' =>$request->content_it[$i],
                'order_it' =>$request->order_it[$i],
                'package_id' =>$id,
                ]);
            $i++;
        }
    }else{
        while ($i < $count) {
            $itinerarys[$i]->update([
                'day_it' =>$request->day_it[$i],
                'title_it' =>$request->title_it[$i],
                'walk_it' =>$request->walk_it[$i],
                'content_it' =>$request->content_it[$i],
                'order_it' =>$request->order_it[$i],
                'package_id' =>$id,
                ]);
            $i++;
        }
        while ($i < $pre_count) {
            $itinerarys[$i]->delete();
            $i++;
        }
    }
    return redirect('admin/packages/itinerary/'.$id.'/edit')->withFlashSuccess('Packages Itinerary Updated Successfully');
}

public function itineraryDestroy($id){
    $itinerarys = PackageItinerary::where('package_id', $id)->get();

    foreach ($itinerarys as $key => $itinerary) {
        PackageItinerary::destroy($itinerary->id);
    }
    return redirect('admin/packages/itinerary')->withFlashSuccess('Itinerarys deleted Successfully');
}


// for category
public function categoryCreate(CreatePackageCategoryRequest $request){
    return view('backend.packages.category.create');
}

public function categoryView(){
   $table = $this->PackageCategoryDatatable();
   return view('backend.packages.category.index', compact('table'));
}

public function PackageCategoryDatatable()
{
        // $pacakges = Packages::select('id','title'); 
    $route = route('api.table.package.category');              
    return Datatable::table()
    ->addColumn(trans('Id'), trans('Title'), trans('Created At'), trans('Updated At'))
    ->addColumn(trans('Actions'))
    ->setUrl($route)
    ->render();
}

public function categoryStore(CreatePackageCategoryRequest $request){
        // return $request->all();

    $this->validate($request, [
        'title' => 'required',
        ]);

    PackageCategory::create($request->all());
    return redirect('admin/packages/category')->withFlashSuccess('Package Category Created Successfully');

}


public function CategoryEdit($id, UpdatePackageCategoryRequest $request){
    $category = PackageCategory::findOrFail($id);
    return view('backend.packages.category.edit', compact('category'));
}


public function CategoryUpdate(UpdatePackageCategoryRequest $request, $id){
   $this->validate($request, [
    'title' => 'required',
    ]);
   $category = PackageCategory::findOrFail($id);
   $category->update($request->all());
   return redirect('admin/packages/category/'.$id.'/edit')->withFlashSuccess('Package Category Updated Successfully');
}

public function categoryDestroy($id, DeletePackageCategoryRequest $request){
    $category = PackageCategory::findOrFail($id);
    $category->delete();
    return redirect('admin/packages/category')->withFlashSuccess('Package Category Deleted Successfully');
}



    // for package option

public function optionView(){
    $route = route('api.table.package.option');              
    $table =  Datatable::table()
    ->addColumn(trans('Id'), trans('Name'), trans('Package Selected'), trans('Created At'), trans('Updated At'))
    ->addColumn(trans('Actions'))
    ->setUrl($route)
    ->render();
    return view('backend.packages.options.index', compact('table'));
}

public function optionCreate(){
    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --','');
    return view('backend.packages.options.create', compact('packages'));
}

public function optionStore(Request $request){
    $this->validate($request,[
        'name' => 'required',
        'package_id' => 'required',
        // 'type' => 'required',
        ]);

    PackageOption::create($request->all());
    return redirect('admin/packages/options')->withFlashSuccess('Package Option Created Successfully');
}

public function optionEdit($id){
    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $option = PackageOption::findOrFail($id);
    return view('backend.packages.options.edit', compact('packages', 'option'));
}

public function optionUpdate($id, Request $request){
   $this->validate($request,[
    'name' => 'required',
    'package_id' => 'required',
    // 'type' => 'required',
    ]);
   $option = PackageOption::findOrFail($id);

   $option->update($request->all());
   return redirect('admin/packages/options/'.$id.'/edit')->withFlashSuccess('Package Option Updated Successfully');
}

public function optionDestroy($id){
    $option = PackageOption::findOrFail($id);
    $option->delete();
    return redirect('admin/packages/options')->withFlashSuccess('Package Option Deleted Successfully');
}




    // for package gallery
public function galleryView(){
    $gallerys = PackageGallery::select('name','package_id')->distinct()->get();
    return view('backend.packages.gallery.index', compact('gallerys'));
}

public function galleryCreate(CreatePackageGalleryRequest $request){
    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --', '');
    return view('backend.packages.gallery.create', compact('packages'));
}

public function galleryStore(CreatePackageGalleryRequest $request){
   $this->validate($request,[
                // 'files' => 'required| image',
    'package_id' => 'required',
    'name' => 'required',
    'default'=>'required',
                // 'type' => 'required',
    ]);

        // return $request->arr[0]->getClientOriginalName();
        // return $request->arr[0]->getClientOriginalName();
        // var_dump($request->all());

        // return $request->all();

        // print_r($request->arr[0]);
        // print_r($request->all());
        // return view('backend.packages.gallery.create', compact('packages'));




   if($request->hasFile('files')){
    $count =  count($request->file('files'));
    // return $count;
    $files = $request->file('files');
    $destination_path1 = 'images/packages-new/rotator';
    $time = time();
    $i =0;
    while($i < $count){
        $filename1 = $time. '-' . $files[$i]->getClientOriginalName();
        $files[$i]->move($destination_path1, $filename1);
        $default = 0;
        if ($request->default == $files[$i]->getClientOriginalName()) {
            $default = 1;
        }
        PackageGallery::create([
            'package_id'=> $request->package_id,
            'name'=> $request->name,
            'type'=> 'rotator',
            'image'=> $filename1,
            'default'=> $default,

            ]);
        $i++;
    }
}

if($request->hasFile('files2')){
    $count =  count($request->file('files2'));
    // return $count;
    $files2 = $request->file('files2');
    $destination_path1 = 'images/packages-new/gallerylist';
    $time = time();
    $i =0;
    while($i < $count){
        $filename2 = $time. '-' . $files2[$i]->getClientOriginalName();
        $files2[$i]->move($destination_path1, $filename2);
        
        PackageGallery::create([
            'package_id'=> $request->package_id,
            'name'=> $request->name,
            'type'=> 'list',
            'image'=> $filename2,
            ]);
        $i++;
    }
}

if ((empty($request->hasFile('files'))) && (empty($request->hasFile('files2')))) {
    return redirect('admin/packages/gallery/create')->withFlashWarning('Gallery can not be created without Images');
   
}

return redirect('admin/packages/gallery')->withFlashSuccess('Gallery created successfully');


}

public function galleryEdit($id, UpdatePackageGalleryRequest $request){
    $package= Packages::findOrFail($id);
    // return $package;
    // return $package->galleryRotators;
    $pack = Packages::all();
    $packages = $pack->pluck('title', 'id');
    $packages->prepend('-- Select Package --', '');
    return view('backend.packages.gallery.edit', compact('packages','package'));
}

public function galleryUpdate(UpdatePackageGalleryRequest $request, $id){
    // return $request->all();
     $this->validate($request,[
    'package_id' => 'required',
    'name' => 'required',
    'default'=>'required',
    ]);
     // return "here";
$time = time();
     if($request->hasFile('files')){
    $count =  count($request->file('files'));
    // return $count;
    $files = $request->file('files');
    $destination_path1 = 'images/packages-new/rotator';
    
    $i =0;
    while($i < $count){
        $filename1 = $time. '-' . $files[$i]->getClientOriginalName();
        $files[$i]->move($destination_path1, $filename1);
        // $default = 0;
        // if ($request->default == $files[$i]->getClientOriginalName()) {
        //     $default = 1;
        // }

        PackageGallery::create([
            'package_id'=> $request->package_id,
            'name'=> $request->name,
            'type'=> 'rotator',
            'image'=> $filename1,
            // 'default'=> $default,

            ]);

        $i++;
    }
}

    $gallerys = PackageGallery::where('package_id', $request->package_id)->get();
    foreach ($gallerys as $gallery) {
        $gallery->default = 0;
        $gallery->name = $request->name;
        $gallery->save();
    }
    

if(!empty($request->default)){
    $default = $time . '-' . $request->default;
    $galleryDefault = PackageGallery::where('image',$default)->first();
    if (empty($galleryDefault)) {
        $galleryDefault = PackageGallery::where('image',$request->default)->first();
    }
    // return $galleryDefault;
    if(!empty($galleryDefault)){
    $galleryDefault->default = 1;
    $galleryDefault->save();
    }
}

if($request->hasFile('files2')){
    $count =  count($request->file('files2'));
    // return $count;
    $files2 = $request->file('files2');
    $destination_path1 = 'images/packages-new/gallerylist';
    $time = time();
    $i =0;
    while($i < $count){
        $filename2 = $time. '-' . $files2[$i]->getClientOriginalName();
        $files2[$i]->move($destination_path1, $filename2);
        
        PackageGallery::create([
            'package_id'=> $request->package_id,
            'name'=> $request->name,
            'type'=> 'list',
            'image'=> $filename2,
            ]);
        $i++;
    }
}

return redirect('admin/packages/gallery/'.$id.'/edit')->withFlashSuccess('Gallery Updated successfully');




}

public function deleteGalleryImage(UpdatePackageGalleryRequest $request){
    $id = $request->id;
    $count = PackageGallery::destroy($id);
    if (!empty($count)) {
        return "success";
    }else{
        return "fail";
    }
}

public function checkGalleryPackage(Request $request){
    if($request->ajax()){
        $packageId= $request->input('packageId');
        $gallery = PackageGallery::where('package_id', $packageId)->first();
        if (empty($gallery)) {
          return 'allow';
      }else{
          return 'dontallow';
      }
  }

}

public function galleryDestroy($id, UpdatePackageGalleryRequest $request){
 $gallerys = PackageGallery::where('package_id', $id)->get();

    foreach ($gallerys as $gallery) {

        $img =$gallery->image;
        if ($gallery->type == 'rotator') {
            if (!empty($img)) {
                if (File::exists('images/packages-new/rotator/'.$img)) {
                    unlink('images/packages-new/rotator/'.$img);
                }
            }
        }
        if ($gallery->type == 'list') {
            if (!empty($img)) {
                if (File::exists('images/packages-new/gallerylist/'.$img)) {
                    unlink('images/packages-new/gallerylist/'.$img);
                }
            }
        }
        PackageGallery::destroy($gallery->id);
    }
    return redirect('admin/packages/gallery')->withFlashSuccess('Gallery Images deleted Successfully');
}


}
