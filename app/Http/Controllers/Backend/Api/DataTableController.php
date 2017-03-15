<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Pages\PageContract;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\User\PackageContract;
use Datatable;
use App\Models\Summitteers;
use App\Models\Packages;
use App\Models\InnerPage;
use App\Models\Video;
use App\Models\Ad;
use App\Models\LinkSearch;
use Illuminate\Http\Request;
use App\Models\PackageCategory;
use App\Models\PackageOption;
use App\Models\MainTraveller;
use App\Models\Access\User\User;


class DataTableController extends Controller {

    /**
     * Abort if request is not ajax
     * @param Request $request
     */
    public function __construct(Request $request) {
        if (!$request->ajax() || !Datatable::shouldHandle())
            abort(403, 'Forbidden');
    }

    /**
     * JSON data for seeding Pages
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getPages(PageContract $pages) {

        return Datatable::collection($pages->getLimitPages())
                        ->showColumns('id', 'title')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('updated_at', function($model) {
                            return $model->updated_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('pages', $model->id, $model->status);
                        })
                        ->searchColumns('title')
                        ->make();
    }

    public function getInnerPages() {
        $innerPage = InnerPage::orderby('created_at', 'desc')->get();
        return Datatable::collection($innerPage)
                        ->showColumns('id', 'title')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('updated_at', function($model) {
                            return $model->updated_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return '<ul class="list-inline no-margin-bottom"><li>
            <a class="btn btn-xbts btn-primary" href="' . route('admin.innerpages.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           <li><a class="btn btn-xs btn-danger" href="' . route('admin.innerpages.destory', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
            </li></ul>';
                        })
                        ->searchColumns('title')
                        ->make();
    }

    public function getPackages() {
        $packages = Packages::orderby('created_at', 'desc')->get();
        return Datatable::collection($packages)
                        ->showColumns('id', 'title', 'slug', 'pack_type')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('updated_at', function($model) {
                            return $model->updated_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('packages', $model->id, 3);
                        })

           //              ->addColumn('action', function($model) {
           //                  return '<ul class="list-inline no-margin-bottom"><li>
           //  <a class="btn btn-xbts btn-primary" href="' . route('admin.packages.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           // <li><a class="btn btn-xs btn-danger" href="' . route('admin.packages.destroy', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
           //  </li></ul>';
           //              })
                        ->searchColumns('title')
                        ->make();
    }

    public function getSummitteers() {
        $summitteers = Summitteers::orderby('created_at', 'desc')->get();
        return Datatable::collection($summitteers)
                        ->showColumns('id', 'name', 'country', 'date', 'route', 'team_name')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<ul class="list-inline no-margin-bottom"><li>
            <a class="btn btn-xbts btn-primary" href="' . route('admin.summitteers.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           <li><a class="btn btn-xs btn-danger" href="' . route('admin.summitteers.delete', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
            </li></ul>';
                        })
                        ->searchColumns('name')
                        ->make();
    }

    /**
     * JSON data for seeding Deactivated Pages
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getDeactivatedPages(PageContract $pages) {

        return Datatable::collection($pages->getLimitPages('0'))
                        ->showColumns('id', 'title')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('updated_at', function($model) {
                            return $model->updated_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('pages', $model->id, $model->status);
                        })
                        ->searchColumns('title')
                        ->make();
    }

    /**
     * JSON data for seeding Users
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getUsers(UserContract $users) {

        return Datatable::collection($users->getAllUsers())
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return $model->fname . ' ' . $model->lname;
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->showColumns('certified_label')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        ->orderColumns('name', 'roles')
                        ->make();
    }

    /**
     * JSON data for seeding Deactivated Users
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getDeactivatedUsers(UserContract $users) {

        return Datatable::collection($users->getAllUsers('0'))
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return $model->fname . ' ' . $model->lname;
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->showColumns('certified_label')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        ->orderColumns('name', 'roles')
                        ->make();
    }

    public function getGuides(UserContract $users) {


        return Datatable::collection($users->getUsers('1', '2'))
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return $model->fname . ' ' . $model->lname;
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->showColumns('certified_label')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        ->orderColumns('name', 'roles')
                        ->make();
    }

    public function getTravellers(UserContract $users) {

        return Datatable::collection($users->getUsers('1', '3'))
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return $model->fname . ' ' . $model->lname;
                        })
                        ->showColumns('email')
                        ->showColumns('confirmed_label')
                        ->addColumn('roles', function($model) {
                            $data = '';
                            if ($model->roles()->count() > 0) {
                                foreach ($model->roles as $role) {
                                    $data .=$role->name . '<br/>';
                                }
                                return $data;
                            } else {
                                return 'None';
                            }
                        })
                        ->addColumn('certified_label', function() {
                            return 'No';
                        })
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('name', 'email')
                        ->orderColumns('name', 'roles')
                        ->make();
    }

    public function getLicense(UserContract $users) {
        return Datatable::collection($users->getLicense(0))
                        ->showColumns('id')
                        ->showColumns('email')
                        ->addColumn('action_button', function($model) {
                            return '<a href="' . route('backend.license', $model->id) . '">View</a>';
                        })
                        ->make();
    }

    public function getGuideReviews(UserContract $users) {

        return Datatable::collection($users->getGuideReviews(0))
                        ->showColumns('id')
                        ->showColumns('comment')
                        ->showColumns('approved_label')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->orderColumns('created_at')
                        ->make();
    }

    public function getAllReviews(UserContract $users) {
        return Datatable::collection($users->getAllReviews())
                        ->showColumns('email')
                        ->showColumns('comment')
                        ->addColumn('approved', function($model) {
                            if ($model->approved == 1)
                                return "<label class='label label-success'>Approved</label>";
                            return "<label class='label label-danger'>Unapproved</label>";
                        })
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<a href="' . route('admin.reviews.delete', $model->id) . '">Delete</a>';
                        })
                        ->make();
    }

    public function getAllSlides(UserContract $users) {
        return Datatable:: collection($users->getAllSlides())
                        ->showColumns('username')
                        ->addColumn('path', function($model) {
                            return $model->path;
                        })
                        ->showColumns('caption')
                        ->showColumns('type')
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<ul class="list-inline no-margin-bottom"><li>
            <a class="btn btn-xbts btn-primary" href="' . route('admin.slides.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           <li> <a class="btn btn-xs btn-danger" href="' . route('admin.slides.delete', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
            </li></ul>';
                        })
                        // ->showColumns('action_buttons')
                        ->searchColumns('username', 'caption')
                        ->orderColumns('type', 'created_at')
                        ->make();
    }

    public function getAllVideos(UserContract $users) {
        return Datatable:: collection(Video::getAllVideos())
                        ->addColumn('id', function($model) {
                            return $model->id;
                        })
                        ->showColumns('username')
                        ->addColumn('video', function($model) {
                            return $model->video;
                        })
                        ->addColumn('pages_id', function($model) {
                            $pages_id = explode(',', $model->pages_id);

                            if ($pages_id != '') {
                                $page_title = \DB::table('inner_pages')->select('title')->whereIn('id', $pages_id)->get();
                                $titles = '';
                                foreach ($page_title as $rows) {
                                    $titles .= $rows->title . ',';
                                }

                                return rtrim($titles, ',');
                            } else {
                                return false;
                            }

                            //return $model->pages_id;
                        })
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<ul class="list-inline no-margin-bottom"><li>
            <a class="btn btn-xbts btn-primary" href="' . route('admin.videos.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           <li> <a class="btn btn-xs btn-danger" href="' . route('admin.videos.delete', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
            </li></ul>';
                        })
                        // ->showColumns('action_buttons')
                        ->searchColumns('username')
                        ->orderColumns('created_at')
                        ->make();
    }

    public function getAllAds(UserContract $users) {   
        return Datatable:: collection(Ad::getAllAds())
                        ->addColumn('id', function($model) {
                            return $model->id;
                        })
                        ->showColumns('username')
                        ->addColumn('ads', function($model) {
                            
                            return '<img src="'.url().'/images/'.$model->ads.'" style="width:20%;" />';
                        })
                        ->addColumn('pages_id', function($model) {
                            $pages_id = explode(',', $model->pages_id);

                            if ($pages_id != '') {
                                $page_title = \DB::table('inner_pages')->select('title')->whereIn('id', $pages_id)->get();
                                $titles = '';
                                foreach ($page_title as $rows) {
                                    $titles .= $rows->title . ',';
                                }

                                return rtrim($titles, ',');
                            } else {
                                return false;
                            }

                            //return $model->pages_id;
                        })
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<ul class="list-inline no-margin-bottom"><li>
            <a class="btn btn-xbts btn-primary" href="' . route('admin.ads.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           <li> <a class="btn btn-xs btn-danger" href="' . route('admin.ads.delete', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
            </li></ul>';
                        })
                        // ->showColumns('action_buttons')
                        ->searchColumns('username')
                        ->orderColumns('created_at')
                        ->make();
    }
    
    public function getAllLinkSearch(UserContract $users) {   
        return Datatable:: collection(LinkSearch::getAllLinkSearch())
                        ->addColumn('id', function($model) {
                            return $model->id;
                        })
                        ->showColumns('username')
                        ->addColumn('keyword', function($model) {
                            
                            return $model->keyword;
                        })
                        ->addColumn('url', function($model) {
                            return $model->url;
                        })
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<ul class="list-inline no-margin-bottom"><li>
            <a class="btn btn-xbts btn-primary" href="' . route('admin.linksearch.edit', $model->id) . '"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           <li> <a class="btn btn-xs btn-danger" href="' . route('admin.linksearch.delete', $model->id) . '"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
            </li></ul>';
                        })
                        // ->showColumns('action_buttons')
                        ->searchColumns('username')
                        ->orderColumns('created_at')
                        ->make();
    }

    public function getAllGuideArea(UserContract $users) {
        return Datatable:: collection($users->getAllGuideArea())
                        ->showColumns('user_name')
                        ->showColumns('guide_area')
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('username', 'caption')
                        ->orderColumns('type', 'created_at')
                        ->make();
    }

    public function getAllLanguage(UserContract $users) {
        return Datatable:: collection($users->getAllLanguage())
                        ->showColumns('user_name')
                        ->showColumns('language')
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('username', 'caption')
                        ->orderColumns('type', 'created_at')
                        ->make();
    }

    public function getUnapprovedReviews(UserContract $users) {
        return Datatable::collection($users->getReviews(0))
                        ->showColumns('email')
                        ->showColumns('comment')
                        ->addColumn('approved', function($model) {
                            if ($model->approved == 1)
                                return "<label class='label label-success'>Approved</label>";
                            return "<label class='label label-danger'>Unapproved</label>";
                        })
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<a href="' . route('admin.reviews.status', $model->id) . '">Approve</a>';
                        })
                        ->make();
    }

    public function getApprovedReviews(UserContract $users) {
        return Datatable::collection($users->getReviews(1))
                        ->showColumns('email')
                        ->showColumns('comment')
                        ->addColumn('approved', function($model) {
                            if ($model->approved == 1)
                                return "<label class='label label-success'>Approved</label>";
                            return "<label class='label label-danger'>Unapproved</label>";
                        })
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('action', function($model) {
                            return '<a href="' . route('admin.reviews', $model->id) . '">Approve</a>';
                        })
                        ->make();
    }

    public function getApprovedBookings(UserContract $users) {
        return Datatable::collection($users->getBookings(1))
                        ->showColumns('id')
                        ->addColumn('user_email', function($model) {
                            return $model->bookedBy->email;
                        })
                        ->addColumn('guide_email', function($model) {
                            return $model->user->email;
                        })
                        ->showColumns('days')
                        ->showColumns('start_date')
                        ->showColumns('end_date')
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('id', 'user_email', 'guide_email')
                        ->make();
    }

    public function getUnapprovedBookings(UserContract $users) {
        return Datatable::collection($users->getBookings(0))
                        ->showColumns('id')
                        ->addColumn('user_email', function($model) {
                            return $model->bookedBy->email;
                        })
                        ->addColumn('guide_email', function($model) {
                            return $model->user->email;
                        })
                        ->showColumns('days')
                        ->showColumns('start_date')
                        ->showColumns('end_date')
                        ->addColumn('created', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->showColumns('action_buttons')
                        ->searchColumns('id', 'user_email', 'guide_email')
                        ->make();
    }


    // for package category
public function getPackageCategory() {
        $packageCategory = PackageCategory::orderby('created_at', 'desc')->get();
        return Datatable::collection($packageCategory)
                        ->showColumns('id', 'title')
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('updated_at', function($model) {
                            return $model->updated_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('packages.category', $model->id, 3);
                        })
           //              ->addColumn('action', function($model) {
           //                  return '<ul class="list-inline no-margin-bottom"><li>
           //  <a class="btn btn-xbts btn-primary" href="'.url('admin/packages/category/'.$model->id.'/edit').'"><i class="fa fa-pencil-square-o"></i>Edit</a></li>
           // <li><a class="btn btn-xs btn-danger" href="'.url('admin/packages/category/'.$model->id.'/delete').'"><i class="fa fa-trash" title="Delete" data-placement="top" data-toggle="tooltip"></i>Delete</a>
           //  </li></ul>';
           //              })
                        ->searchColumns('title')
                        ->make();
    }

//for package option
    public function getPackageOption(){
    $packageOption = PackageOption::orderby('created_at', 'desc')->get();
        return Datatable::collection($packageOption)
                        ->showColumns('id', 'name')
                        ->addColumn('package_id', function($model) {
                            return $model->package->title;
                        })
                        // ->addColumn('type' , function($model){
                        //     if ($model->type == 'accomodation') {
                        //         return 'First Block';
                        //     }else{
                        //         return 'Second Block';
                        //     }
                        // })
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('updated_at', function($model) {
                            return $model->updated_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('packages.option', $model->id, 3);
                        })
                        ->searchColumns('name')
                        ->make();
    }

    //  public function getPackageItinerary(){
    // $packageOption = PackageOption::$sliders = Slide::select('slideid', 'page_id')->distinct()->get(['slideid']);;
    //     return Datatable::collection($packageOption)
    //                     ->showColumns('id', 'name')
    //                     ->addColumn('package_id', function($model) {
    //                         return $model->package->title;
    //                     })
    //                     ->showColumns('type')
    //                     ->addColumn('created_at', function($model) {
    //                         return $model->created_at->diffForHumans();
    //                     })
    //                     ->addColumn('updated_at', function($model) {
    //                         return $model->updated_at->diffForHumans();
    //                     })
    //                     ->addColumn('', function($model) {
    //                         return get_ops('packages.option', $model->id, 3);
    //                     })
    //                     ->searchColumns('name')
    //                     ->make();
    // }


    //get all customers
    public function getCustomers(){
    $maintravellers = MainTraveller::orderby('created_at', 'desc')->get();
        return Datatable::collection($maintravellers)
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return ucfirst($model->profile->fname) . ' ' . ucfirst($model->profile->mname) . ' ' . ucfirst($model->profile->lname);
                        })
                        ->addColumn('email', function($model){
                            return $model->profile->email;
                        })
                        ->addColumn('customer_type', function($model) {
                            if(!empty($model->user_id)){
                                return '<label class="label label-success">Registered</label>';
                            }else{
                                return '<label class="label label-danger">Guest</label>';
                            }
                        })
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('customers', $model->id, 3);
                        })
                        ->searchColumns('name')
                        ->make();
    }

    // //get registered customers
    // public function getRegisteredCustomers(){
    // $maintravellers = User::orderby('created_at', 'desc')->where('user_id', '!=', 0)->get();
    //     return Datatable::collection($maintravellers)
    //                     ->showColumns('id')
    //                     ->addColumn('name', function($model) {
    //                         return ucfirst($model->profile->fname) . ' ' . ucfirst($model->profile->mname) . ' ' . ucfirst($model->profile->lname);
    //                     })
    //                     ->addColumn('email', function($model){
    //                        return $model->profile->email;
    //                    })
    //                     ->addColumn('customer_type', function($model) {
    //                         if(!empty($model->user_id)){
    //                             return 'Registered';
    //                         }else{
    //                             return 'Guest';
    //                         }
    //                     })
    //                     ->addColumn('created_at', function($model) {
    //                         return $model->created_at->diffForHumans();
    //                     })
    //                     ->addColumn('', function($model) {
    //                         return get_ops('customers', $model->id, 3);
    //                     })
    //                     ->searchColumns('name')
    //                     ->make();
    // }

    //get registered customers
    public function getRegisteredCustomers(){
    $customers = User::orderby('created_at', 'desc')->get();
        return Datatable::collection($customers)
                        ->showColumns('id')
                        ->addColumn('name', function($model) {
                            return ucfirst($model->profile->fname) . ' ' . ucfirst($model->profile->mname) . ' ' . ucfirst($model->profile->lname);
                        })
                        ->addColumn('email', function($model){
                            return $model->profile->email;
                        })
                        ->addColumn('customer_type', function($model) {
                                return 'Registered';
                        })
                        ->addColumn('created_at', function($model) {
                            return $model->created_at->diffForHumans();
                        })
                        ->addColumn('', function($model) {
                            return get_ops('customers', $model->id, 3);
                        })
                        ->searchColumns('name')
                        ->make();
    }



}
