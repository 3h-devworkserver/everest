<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use File;
use Input;
use Datatable;
use App\Models\Ad;

class AdController extends Controller {

    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    public function getAds() {
        #exit;
        $pages = \DB::table('inner_pages')->get();
        return view('backend.ads.adsCreate')->with('pages', $pages);
    }

    public function postAds(Request $request) {
        // dd($request->page);

        $userid = access()->user()->id;
        $url = $request->link;

        $pages_id = implode(',', $request->page);

        $ad = new Ad;
        $ad->user_id = $userid;
        $ad->pages_id = $pages_id;
        $ad->link = $url;
        $ad->save();

        $ad_id = $ad->id;

        if ($request->hasFile('ads')) {
            $file = $request->file('ads');
            $destination_path = 'images/';
            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            Ad::where('id', $ad_id)->update(array('ads' => $filename));
        }


        return redirect()->to('admin/ads/management')->withFlashSuccess('Successfully Uploaded Ad.');
    }

    public function getAllAds() {
        // $abcd = Ad::getAllAds();
        //print_r($abcd);
        // exit;
        $table = $this->setDatatableAd(); //role of users
        return view('backend.ads.ads', compact('table'));
    }

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableAd() {
        $route = route('api.table.ads');

        return Datatable::table()
                        ->addColumn(trans('ID'), trans('Username'), trans('Ads'), trans('Pages Title'), trans('Created'))
                        ->addColumn(trans('crud.actions'))
                        ->setUrl($route)
                        ->render();
    }

    public function deleteAds($id) {

        $ad = Ad::find($id);
        if ($ad) {
            $ad->delete();
        }
        return redirect()->back()->withFlashSuccess('Ad Successfully Deleted.');
    }

    public function editAds($id) {
        $ad = Ad::find($id);
        if ($ad) {
            $pages = \DB::table('inner_pages')->get();
            return view('backend.ads.edit', compact('ad'))->with('pages', $pages);
        } else {
            return redirect()->back()->withFlashError('No Ad Found.');
        }
    }

    public function updateAds($id, Request $request) {

        if ($request->hasFile('ads')) {
            $image = Ad::where('id', $id)->first();
            $blockImage = $image->ads;
            File::delete($blockImage);
            $file = $request->file('ads');
            $destination_path = 'images/';
            $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
            $file->move($destination_path, $filename);
            Ad::where('id', $id)->update(array('ads' => $filename));
        }

        $url = $request->link;
        $pages_id = implode(',', $request->page);

        Ad::where('id', $id)->update(array('link' => $url, 'pages_id' => $pages_id));

        return redirect()->back()->withFlashSuccess('Updated successfully.');
    }

}
