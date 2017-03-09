<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserContract;
use Datatable;
use App\Models\Video;

class VideoController extends Controller {

    public function __construct(UserContract $user) {
        $this->user = $user;
    }

    public function getVideos() {
        $pages = \DB::table('inner_pages')->get();
        return view('backend.videos.videoUpload')->with('pages', $pages);
    }

    public function postVideos(Request $request) {
        // dd($request->page);

        $userid = access()->user()->id;
        $url = $request->url;
        if (strlen($request->url) > 11) {
            $pages_id = implode(',', $request->page);
            //if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match))
            if (preg_match("/https?:\/\/(?:www\.)?vimeo\.com\/\d{8}/", $url, $match)) {
                //dd($match);
                $video = new Video;
                $video->user_id = $userid;
                $video->pages_id = $pages_id;
                $video->video = $match[0];
                $video->save();
            } else
                return redirect()->back()->withFlashSuccess('Something Went Wrong.');
        }

        return redirect()->to('admin/videos/management')->withFlashSuccess('Successfully Uploaded Video.');
    }

    public function getAllVideos() {
        $table = $this->setDatatableVideo(); //role of users
        
        return view('backend.videos.videos', compact('table'));
    }

    /**
     * Create DataTable HTML
     *
     * @return mixed
     * @throws \Exception
     */
    private function setDatatableVideo() {
        $route = route('api.table.videos');

        return Datatable::table()
                        ->addColumn(trans('ID'), trans('Username'), trans('Video'), trans('Pages Title'), trans('Created'))
                        ->addColumn(trans('crud.actions'))
                        ->setUrl($route)
                        ->render();
    }

    public function deleteVideos($id) {

        $video = Video::find($id);
        if ($video) {
            $video->delete();
        }
        return redirect()->back()->withFlashSuccess('Video Successfully Deleted.');
    }

    public function editVideos($id) {
        $video = Video::find($id);
        if ($video) {
            $pages = \DB::table('inner_pages')->get();
            return view('backend.videos.edit', compact('video'))->with('pages', $pages);
        } else {
            return redirect()->back()->withFlashError('No Video Found.');
        }
    }

    public function updateVideos($id, Request $request) {

        // if($request->hasFile('video')){
        //       $video = $request->file('video');
        //       $destination_path = 'images/video';
        //       $videoname = uniqid(time()). '.' . $video->getClientOriginalExtension();
        //       $video->move($destination_path, $videoname);
        //       Video::where('id', $id)->update(array('video' => $videoname));
        //   }
        $url = $request->url;
        $pages_id = implode(',', $request->page);
        if (strlen($request->url) > 11) {
            //if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            if (preg_match("/https?:\/\/(?:www\.)?vimeo\.com\/\d{8}/", $url, $match)) {
                // dd($match[1]);
                Video::where('id', $id)->update(array('video' => $match[0], 'pages_id' => $pages_id));
            } else {
                return redirect()->back()->withFlashError('Something Went Wrong.');
            }
        } else {
            Video::where('id', $id)->update(array('pages_id' => $pages_id));
        }
        return redirect()->back()->withFlashSuccess('Updated successfully.');
    }

}
