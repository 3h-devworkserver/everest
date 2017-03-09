<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use File;
use Input;
use Datatable;
use App\Models\LinkSearch;

class LinkSearchController extends Controller {

    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    public function getLinkSearch() {
        return view('backend.linksearch.create');
    }

    public function postLinkSearch(Request $request) {
        // dd($request->page);

        $userid = access()->user()->id;
        $keyword = $request->keyword;
        $url = $request->url;
        if ($keyword) {
            $linksearch = new LinkSearch;
            $linksearch->user_id = $userid;
            $linksearch->keyword = $keyword;
            $linksearch->url = $url;
            $linksearch->save();
        } else {
            return redirect()->back()->withFlashError('Please add Keyword.');
        }

        return redirect()->to('admin/linksearch/management')->withFlashSuccess('Successfully Uploaded Search Link.');
    }

    public function getAllLinkSearch() {
        // $abcd = LinkSearch::getAllLinkSearchs();
        //print_r($abcd);
        // exit;
        $table = $this->setDatatableLinkSearch(); //role of users
        return view('backend.linksearch.linksearch', compact('table'));
    }

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableLinkSearch() {
        $route = route('api.table.linksearch');

        return Datatable::table()
                        ->addColumn(trans('ID'), trans('Username'), trans('Keyword'), trans('Url'), trans('Created'))
                        ->addColumn(trans('crud.actions'))
                        ->setUrl($route)
                        ->render();
    }

    public function deleteLinkSearch($id) {

        $linksearch= LinkSearch::find($id);
        if ($linksearch) {
            $linksearch->delete();
        }
        return redirect()->back()->withFlashSuccess('LinkSearch Successfully Deleted.');
    }

    public function editLinkSearch($id) {
        $linksearch = LinkSearch::find($id);
        if ($linksearch) {
            return view('backend.linksearch.edit', compact('linksearch'));
        } else {
            return redirect()->back()->withFlashError('No Search Link Found.');
        }
    }

    public function updateLinkSearch($id, Request $request) {
        $url = $request->url;
        $keyword = $request->keyword;
        if ($keyword) {
            LinkSearch::where('id', $id)->update(array('keyword' => $keyword, 'url' => $url));
        } else {
            return redirect()->back()->withFlashError('Please add Keyword.');
        }
        return redirect()->back()->withFlashSuccess('Updated successfully.');
    }

}
