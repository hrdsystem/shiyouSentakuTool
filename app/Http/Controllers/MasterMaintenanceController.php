<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\imageMaster;
use App\Models\MasterMaintenance;

class MasterMaintenanceController extends Controller
{
    public function getCategories () {  
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                CODE,
                category_name
            FROM m_category"
        ));
    }

    
    public function getData () {  
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                *
            FROM master_maintenance
            
            "
        ));
    }


    public function getItem1 () {
        // return'sample';
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                id,
                CODE as main_code,
                category_code,
                item_name
            FROM m_main_items
            ORDER BY id DESC
            "
        )); 
    }


    public function getItem2 (Request $req) {
        // return $req; 
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                id,
                category_code,
                main_items_code,
                CODE as sub_item_code,
                item_name as sub_item_name
            FROM m_sub_items
            -- WHERE main_items_code = '$req->main_items_code'
            WHERE main_items_code = '$req->item1'
            ORDER BY id DESC
            "
        ));
    }

    public function products () {
        // return $req; 
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT 
                id,
                category_code,
                main_items_code,
                sub_items_code,
                CODE,
                product_name,
                maker_code,
                color_code,
                image_path
            FROM m_products
            "
        ));
    }


    public function colors () {
        // return $req; 
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT 
                id,
                color_code,
                color_name,
                image_path
            FROM m_colors
            "
        )); 
    }

    // public function saveData(Request $request){
    //     return $request; 
    //     return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
    //         ->table('m_main_items')
    //         ->insert([
    //             'category_code' => $request->category_code,
    //             'code' => $request->CODE,
    //             'item_name' => $request->item_name,
    //             'Created_at' => date("Y-m-d H:i:s"),
    //             'Updated_by' => 'Gatz'
    //         ]);
    // }

    ////////////////////////////////////////////////////////
    //    *   *   *   *   * FUNTCTION1 *   *   *   *   *  //
    ////////////////////////////////////////////////////////
    public function saveItem1(Request $request){
        if($request->action == 'ADD NEW'){
            $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_main_items')
            ->where('category_code',$request->category_code)
            ->where('code',$request->CODE)
            ->get();
            if(count($data) > 0){
                return 'Existing';
            }else{
                $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
                ->table('m_main_items')
                ->insert([
                    'category_code' => $request->category_code,
                    'code' => $request->CODE,
                    'item_name' => $request->item_name,
                    'Updated_by' => 'Gatz'
                ]);
                return 'SAVED';
            }
        }
    }
    public function saveItem2(Request $request){
        $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_sub_items')
        ->where('category_code',$request->category_code)
        ->where('main_items_code', $request->main_items_code)
        ->where('code',$request->code)
        ->get();

        if(count($data) > 0){
            return 'Existing';
        }else{
            $data =  DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_sub_items')
            ->insert([
                'category_code' => $request->category_code,
                'main_items_code' => $request->main_items_code,
                'code' => $request->code,
                'item_name' => $request->item_name,
                'Created_at' => date("Y-m-d H:i:s"),
                'Updated_by' => 'Gatz'
            ]);
            return 'SAVED';
        }
    }


    public function editItems(Request $id){
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_main_items')
        ->find($id->id); 
    }
    public function editItem2(Request $id){
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_sub_items')
        ->find($id->id); 
    }


    public function updateItem1(Request $request){
        $data= DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_main_items')
        ->where('id', $request->id)
        ->get();
        if(count($data) > 0){
            DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_main_items')
            ->where('id',$request->id)
            ->update([
                'item_name' => $request->item_name,
                'Updated_Date'=> date('Y-m-d H:i:s'),
                'Updated_by' => 'Gatz'
            ]);
            return 'EDITED';
        }
    }
    public function updateItem2(Request $request, $id){
        $data= DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_sub_items')
        ->where('id', $request->id)
        ->get();
        if(count($data) > 0){
            DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_sub_items')
            ->where('id',$request->id)
            ->update([
                'item_name' => $request->item_name,
                'Updated_Date'=> date('Y-m-d H:i:s'),
                'Updated_by' => 'Gatz'
            ]);
            return 'EDITED';
        }
    }
    

    public function deleteItem1(Request $request){
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_main_items')
        ->where('id',$request->id)
        ->delete();
    }
    public function deleteItem2(Request $request){
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_sub_items')
        ->where('id',$request->id)
        ->delete();


    }

}
