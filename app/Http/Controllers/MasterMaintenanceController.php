<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\imageMaster;
use App\Models\MasterMaintenance;

class MasterMaintenanceController extends Controller
{
    public function getCategories () {  
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
        ->select(DB::raw(
            "SELECT
                CODE,
                category_name
            FROM m_category"
        ));
    }

    
    public function getData () {  
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
        ->select(DB::raw(
            "SELECT
                *
            FROM master_maintenance
            
            "
        ));
    }


    public function getItem1 () {
        // return'sample';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT
                id,
                CODE as main_code,
                category_code,
                item_name
            FROM m_main_items
            "
        )); 
    }


    public function getItem2 (Request $req) {
        // return $req; 
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT
            id,
            category_code,
            main_items_code,
            CODE as sub_item_code,
            item_name as sub_item_name
        FROM m_sub_items
        WHERE main_items_code = '$req->main_items_code'
            "
        ));

    }

    public function products () {
        // return $req; 
        return DB::connection('mysql')
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
        return DB::connection('mysql')
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
        // return $id; 
        return DB::connection('mysql')
        ->table('m_main_items')
        ->find($id->id); 
    }


    public function updateData(Request $request){
            // info($data);
            // return $request;
        if($request->action == 'ADD NEW'){
            //        *     *     *      SAVE     *     *     *        //
            $data = DB::connection('mysql')
            ->table('m_main_items')
            ->where('category_code',$request->category_code)
            ->where('code',$request->CODE)
            ->where('item_name',$request->item_name)
            ->get();
            if(count($data) > 0){
                // info($data);
                return 'Existing';
            }else{
                $data = DB::connection('mysql')
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
            $data = DB::connection('mysql')
            ->table('m_main_items')
            ->where('category_code',$request->category_code)
            ->where('code',$request->CODE)
            ->where('item_name',$request->item_name)
            ->get();
            if(count($data) > 0){
                return 'Existing';
            }else{
                DB::connection('mysql')
                ->table('m_main_items')
                ->insert([
                    'category_code' => $request->category_code,
                    'code' => $request->CODE,
                    'item_name' => $request->item_name,
                    'Updated_Date'=> date('Y-m-d H:i:s'),
                    'Updated_by' => 'Gatz'
                ]);
                DB::connection('mysql')
                ->table('m_main_items')
                ->where('id',$request->productId)
                ->delete();
                return 'EDITED';
            }
        }
    }


    public function saveData(Request $request){
        return $request; 
        return DB::connection('mysql')
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
        return DB::connection('mysql')
        ->table('master_maintenance')
        ->where('id',$request->id)
        // ->get();
        ->delete();
    }

    //update function for item 1
    public function updateItem1(Request $request, $id){
        // return $id;
        return DB::connection('mysql')
        ->table('m_main_items')
        ->where('id', $request->id)
        ->update([
            'category_code' => '2',
            'code' => $request->code,
            'item_name' => $request->item_name,
            'Updated_Date' => $request-> date("Y-m-d H:i:s"),
            'Updated_by' => 'Uary'
        ]);
    }

    public function saveItem2(Request $request){
        // return $request;

        $data = DB::connection('mysql')
            ->table('m_sub_items')
            ->where('category_code',$request->category_code)
            ->where('main_items_code', $request->main_items_code)
            ->where('code',$request->code)
            ->where('item_name',$request->item_name)
            ->get();
            if(count($data) > 0){
                // info($data);`
                return 'Existing';
            }else{
                $data =  DB::connection('mysql')
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

        // if
    }

    public function editItem2(Request $id){
        // return $id; 
        return DB::connection('mysql')
        ->table('m_sub_items')
        ->find($id->id); 
    }
}
