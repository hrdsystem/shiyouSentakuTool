<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use App\Models\imageMaster;
// use App\Models\MasterMaintenance;
use App\Models\MSubItem;
use App\Models\MMainItem;

class MasterMaintenanceController extends Controller
{


    //////////////////////////////////////////////////////////////////
    //    *   *   *   *   * GAIBU FUNCTIONS   *   *   *   *   *  //
    ////////////////////////////////////////////////////////////////
    public function getGaibuItem1 () {
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                id,
                CODE as main_code,
                category_code,
                item_name
            FROM m_main_items
            WHERE deleted_at IS NULL
            AND category_code = '1'
            ORDER BY id DESC
            "
        )); 
    }
    //////////////////////////////////////////////////////////////////
    //    *   *   *   *   * SETSUBI FUNCTIONS   *   *   *   *   *  //
    ////////////////////////////////////////////////////////////////
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


    public function getSetsubiItem1 () {
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                id,
                CODE as main_code,
                category_code,
                item_name
            FROM m_main_items
            WHERE deleted_at IS NULL
            AND category_code = '2'
            ORDER BY id DESC
            "
        )); 
    }


    public function getSetsubiItem2 (Request $req) {
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
            AND deleted_at IS NULL
            ORDER BY id DESC
            "
        ));
    }

    public function getSubItem2 () {
        // return $req; 
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->table('m_sub_items')
        ->where('category_code',2)
        ->whereNull('deleted_at')
        ->get();
    }

    public function getProducts () {
        // return $req; 
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT 
                -- P.id,
                P.category_code,
                P.main_items_code,
                P.sub_items_code,
                MI.item_name,
                SI.item_name,
                MI.item_name AS Main_Item,
                SI.item_name AS Sub_Item,
                P.CODE,
                P.product_name,
                P.maker_code,
                M.manufacturer_name,
                P.color_code,
                C.color_name
            FROM shiyou_sentaku_main_test.m_products AS P
                LEFT JOIN shiyou_sentaku_main_test.m_colors AS C
                    ON P.color_code = C.color_code
                LEFT JOIN shiyou_sentaku_main_test.m_manufacturers AS M
                    ON P.maker_code = M.code 
                LEFT JOIN shiyou_sentaku_main_test.m_main_items AS MI
                    ON P.main_items_code = MI.code 
                LEFT JOIN shiyou_sentaku_main_test.m_sub_items AS SI
                    ON P.sub_items_code = SI.code 
            WHERE P.category_code = 2
                
            -- SELECT 
            --     P.id,
            --     P.category_code,
            --     P.main_items_code,
            --     P.sub_items_code,
            --     MI.item_name AS Main_Item,
            --     SI.item_name AS Sub_Item,
            --     P.CODE,
            --     P.product_name,
            --     P.maker_code,
            --     M.manufacturer_name,
            --     P.color_code
            -- FROM shiyou_sentaku_main_test.m_products AS P
            --     LEFT JOIN shiyou_sentaku_main_test.m_main_items AS MI
            --             ON P.main_items_code = MI.code 
            --     LEFT JOIN shiyou_sentaku_main_test.m_sub_items AS SI
            --         ON P.sub_items_code = SI.code 
            --         AND MI.code = SI.main_items_code
            --     LEFT JOIN shiyou_sentaku_main_test.m_manufacturers AS M
            --             ON P.maker_code = M.code 
            --     -- LEFT JOIN shiyou_sentaku_main_test.m_colors AS C
            --     --     ON P.color_code = C.color_code
            -- WHERE P.category_code = 2
            "
        ));
    }

    // public function getSpecifications () {
    //     // return $req; 
    //     return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
    //     ->select(DB::raw(
    //         "SELECT 
    //             id,
    //             category_code,
    //             main_items_code,
    //             sub_items_code,
    //             CODE,
    //             product_name,
    //             maker_code,
    //             color_code,
    //             image_path
    //         FROM m_products
    //         "
    //     ));
    // }

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
    //             'created_at' => date("Y-m-d H:i:s"),
    //             'updated_by' => 'Gatz'
    //         ]);
    // }

    //////////////////////////////////////////////////////////////////
    //    *   *   *   *   * FUNTCTIONS FOR ITEMS *   *   *   *   *  //
    //////////////////////////////////////////////////////////////////
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
                    'updated_by' => 'Gatz'
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
                'created_at' => date("Y-m-d H:i:s"),
                'updated_by' => 'Gatz'
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
                'updated_at'=> date('Y-m-d H:i:s'),
                'updated_by' => 'Gatz'
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
                'updated_at'=> date('Y-m-d H:i:s'),
                'updated_by' => 'Gatz'
            ]);
            return 'EDITED';
        }
    }

    /////////////////////////////////////////////////////////////////////
    //    *   *   *   *   * FUNTCTIONS FOR PRODUCTS *   *   *   *   *  //
    /////////////////////////////////////////////////////////////////////
    public function saveProducts(Request $request){
        return $request; 
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
                    'updated_by' => 'Gatz'
                ]);
                return 'SAVED';
            }
        }
    }










    //////////////////////////////////////////////////////////
    //    *   *   *   *   * Soft Deletes *   *   *   *   *  //
    //////////////////////////////////////////////////////////
    public function deleteItem1(Request $request){
        return MMainItem::where('id',$request->id)
        ->delete();
    }
    public function deleteItem2(Request $request){
        return MSubItem::where('id',$request->id)
        ->delete();
    }
    // }---------->  <----------{ \\


    //////////////////////////////////////////////////////////////////
    //    *   *   *   *   * NAIBU FUNCTIONS   *   *   *   *   *  //
    ////////////////////////////////////////////////////////////////


    public function getNaibuItem1 () {
        return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        ->select(DB::raw(
            "SELECT
                id,
                CODE as main_code,
                category_code,
                item_name
            FROM m_main_items
            WHERE deleted_at IS NULL
            AND category_code = '3'
            ORDER BY id DESC
            "
        )); 
    }

}
