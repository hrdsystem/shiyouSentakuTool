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
                CODE,
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
                m_main_items.CODE AS main_code, 
                m_main_items.category_code, 
                m_main_items.item_name, 
                sub_items.id, 
                sub_items.main_items_code, 
                sub_items.sub_item_code, 
                sub_items.sub_item_name 
            FROM m_main_items 
                LEFT JOIN( 
                SELECT 
                    m_sub_items.id, 
                    m_sub_items.main_items_code, 
                    m_sub_items.CODE AS sub_item_code, 
                    m_sub_items.item_name AS sub_item_name 
            FROM m_sub_items ) AS sub_items 
            ON m_main_items.CODE = sub_items.main_items_code 
            WHERE sub_items.main_items_code = '$req->main_items_code'
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


    public function editItems(Request $id){
        return $id; 
        return $data1 = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_main_items')->find($id->id); 
    }


    public function updateData(Request $request){
            // info($data);
            // return $request;
        if($request->action == 'ADD NEW'){
            //        *     *     *      SAVE     *     *     *        //
            $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_main_items')
            ->where('category_code',$request->category_code)
            ->where('code',$request->CODE)
            ->where('item_name',$request->item_name)
            ->get();
            if(count($data) > 0){
                // info($data);
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
        }else{
            //        *     *     *      UPDATE     *     *     *        //
            $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_main_items')
            ->where('category_code',$request->category_code)
            ->where('code',$request->CODE)
            ->where('item_name',$request->item_name)
            ->get();
            if(count($data) > 0){
                return 'Existing';
            }else{
                DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
                ->table('m_main_items')
                ->insert([
                    'category_code' => $request->category_code,
                    'code' => $request->CODE,
                    'item_name' => $request->item_name,
                    'Updated_Date'=> date('Y-m-d H:i:s'),
                    'Updated_by' => 'Gatz'
                ]);
                DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
                ->table('m_main_items')
                ->where('id',$request->productId)
                ->delete();
                return 'EDITED';
            }
        }
    }


    public function saveData(Request $request){
        return $request; 
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            ->table('m_main_items')
            ->insert([
                'category_code' => $request->category_code,
                'code' => $request->CODE,
                'item_name' => $request->item_name,
                'Created_at' => date("Y-m-d H:i:s"),
                'Updated_by' => 'Gatz'
            ]);
    }


    //        *     *     *      DELETE     *     *     *        //
    public function deleteData(Request $request){
        // return $request;
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('master_maintenance')
        ->where('id',$request->id)
        // ->get();
        ->delete();
    }


}
