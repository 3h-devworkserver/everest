<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;

class StaticBlock extends Model
{
   protected $table = 'static_blocks';
    protected $fillable = ['title','content','url', 'image'];

    public static function poststaticblock($inputs, $pId, $block_type){

        // dd($inputs);
        $images = $inputs['simage'];
        $count = count($inputs['counter']);
        $staticInputs = array();
        foreach($_POST['stitle'] as $key => $data){
           if (empty($_FILES['simage']['name'][$key])){
                 $filename = '';          
            }else{
                $file = $images[$key];
                $destination_path = 'images/staticimages';
                $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                $file->move($destination_path, $filename);
            }
            StaticBlock::insert(array('pid' => $pId, 'uniqueid' => $_POST['uniqueId'][$key], 'block_type' => $block_type, 'title' => $_POST['stitle'][$key], 'content' => $inputs['scontent'][$key], 'url' => $inputs['surl'][$key], 'image' => $filename));
        }

        // for($i=0; $i<$count; $i++){
        // 	if (empty($_FILES['simage']['name'][$i])){
        //          $filename = '';          
        //     }else{
        //         $file = $images[$i];
        //         $destination_path = 'images/';
        //         $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
        //         $file->move($destination_path, $filename);
        //     }
        //     array_push($staticInputs, array(
        //         'pid' => $pId,
        //         'uniqueid' => $inputs['uniqueId'][$i],
        //         'block_type' => $block_type,
        //         'title' => $inputs['stitle'][$i], 
        //         'content' => $inputs['scontent'][$i], 
        //         'url' => $inputs['surl'][$i],
        //         'image' => $filename
        //     ));
        // }

        // StaticBlock::insert($staticInputs);
        return true;
    }

    public static function postupdate($inputs, $pId, $block_type){
 
        $images = $inputs['simage'];
        $count = count($inputs['counter']);
        $staticInputs = array();
        $filename  = '';
            if (!empty($inputs['simage'])){
                $file = $images;
                $destination_path = 'images/staticimages';
                $filename = rand(11111, 99999) . '.' . $file->getClientOriginalExtension();
                $file->move($destination_path, $filename);
            }
            array_push($staticInputs, array(
                'pid' => $pId,
                'uniqueid' => $inputs['uniqueId'],
                'block_type' => $block_type,
                'title' => $inputs['stitle'], 
                'content' => $inputs['scontent'], 
                'url' => $inputs['surl'],
                'image' => $filename
            ));

        StaticBlock::insert($staticInputs);
        return true;
    }
}
