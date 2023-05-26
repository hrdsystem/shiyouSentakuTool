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
        return DB::connection('mysql')
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
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT
                CODE,
                category_name
            FROM m_category"
        ));
    }

    
    public function getData () {  
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT
                *
            FROM master_maintenance
            "
        ));
    }


    public function getSetsubiItem1 () {
        return DB::connection('mysql')
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
        return DB::connection('mysql')
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
        return DB::connection('mysql')
        ->table('m_sub_items')
        ->where('category_code',2)
        ->whereNull('deleted_at')
        ->get();
    }

    public function getProducts () {
        // return $req; 
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT 
                P.id,
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
            FROM shiyou_sentaku_main_test.r_products AS P
                LEFT JOIN shiyou_sentaku_main_test.m_manufacturers AS M
                    ON P.maker_code = M.code 
                LEFT JOIN shiyou_sentaku_main_test.m_main_items AS MI
                    ON P.main_items_code = MI.code 
                LEFT JOIN shiyou_sentaku_main_test.m_sub_items AS SI
                    ON P.sub_items_code = SI.code 
            WHERE P.category_code = 2
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


    //////////////////////////////////////////////////////////////////
    //    *   *   *   *   * FUNTCTIONS FOR ITEMS *   *   *   *   *  //
    //////////////////////////////////////////////////////////////////
    public function saveItem1(Request $request){
        if($request->action == 'ADD NEW'){
            $data = DB::connection('mysql')
            ->table('m_main_items')
            ->where('category_code',$request->category_code)
            ->where('code',$request->CODE)
            ->get();
            if(count($data) > 0){
                return 'Existing';
            }else{
                $data = DB::connection('mysql')
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
        $data = DB::connection('mysql')
        ->table('m_sub_items')
        ->where('category_code',$request->category_code)
        ->where('main_items_code', $request->main_items_code)
        ->where('code',$request->code)
        ->get();

        if(count($data) > 0){
            return 'Existing';
        }else{
            $data =  DB::connection('mysql')
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
        return DB::connection('mysql')
        ->table('m_main_items')
        ->find($id->id); 
    }
    public function editItem2(Request $id){
        return DB::connection('mysql')
        ->table('m_sub_items')
        ->find($id->id); 
    }

    public function updateItem1(Request $request){
        $data= DB::connection('mysql')
        ->table('m_main_items')
        ->where('id', $request->id)
        ->get();
        if(count($data) > 0){
            DB::connection('mysql')
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
        $data= DB::connection('mysql')
        ->table('m_sub_items')
        ->where('id', $request->id)
        ->get();
        if(count($data) > 0){
            DB::connection('mysql')
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
    public function getProductList(){
        // return 'test';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT m_products.*,m_manufacturers.manufacturer_name FROM m_products AS m_products
            LEFT JOIN (
                SELECT * FROM m_manufacturers AS m_manufacturers
                WHERE m_manufacturers.Deleted_Date IS NULL 
            ) AS m_manufacturers
            ON m_manufacturers.code = m_products.maker_code
            WHERE m_products.category_code = 2
            ORDER BY m_products.code ASC
            -- AND m_products.Deleted_Date IS NULL
            "
        )); 
    }

    public function getManufacturers(){
        // return 'test';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT * FROM m_manufacturers AS m_manufacturers
            WHERE m_manufacturers.Deleted_Date IS NULL 
            "
        )); 
    }

    public function saveProduct(Request $req){
        if($req->action == 'ADD NEW'){
            $data = DB::connection('mysql')
            ->table('m_products')
            ->where('category_code',2)
            ->where('code',$req->code)
            ->get();
            if(count($data) > 0){
                return 'Existing';
            }else{
                $data = DB::connection('mysql')
                ->table('m_products')
                ->insert([
                    'category_code' => 2,
                    'code' => $req->code,
                    'product_name' => $req->product_name,
                    'maker_code' => $req->manufacture_code,
                    'image_path' => $req->image_path,
                    'has_color' => $req->has_color == true ? 1 : 0,
                    'updated_by' => 'Gatz'
                ]);
                return 'Saved';
            }
        }
    }






    ////////////////////////////////////////////////////////////////
    //  *  *  *   *   * SPECIFICATION FUNCTIONS *   *   *   *  *  //
    ////////////////////////////////////////////////////////////////
    public function getSpecifications(){
        // return 'test';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT 
                r_products.house_type_code,
                m_house_types.house_name,
                r_products.category_code,
                r_products.main_item_code,
                m_main_items.item_name AS main_item_name,
                r_products.sub_item_code,
                m_sub_items.item_name AS sub_item_name,
                r_products.product_code,
                m_products.product_name,
                m_products.maker_code,
                m_products.manufacturer_name,
                m_products.image_path,
                m_products.has_color,
                r_products.Deleted_Date
            FROM r_products AS r_products
            INNER JOIN (
                SELECT m_products.*,m_manufacturers.manufacturer_name FROM m_products AS m_products
                LEFT JOIN (
                    SELECT * FROM m_manufacturers AS m_manufacturers
                    WHERE m_manufacturers.Deleted_Date IS NULL 
                ) AS m_manufacturers
                ON m_manufacturers.code = m_products.maker_code
                WHERE m_products.category_code = 2
                AND m_products.Deleted_Date IS NULL
            ) AS m_products
            ON m_products.code = r_products.product_code
            INNER JOIN (
                SELECT * FROM m_main_items AS m_main_items
                WHERE m_main_items.deleted_at IS NULL 
                AND m_main_items.category_code = 2
            ) AS m_main_items
            ON m_main_items.code = r_products.main_item_code
            INNER JOIN (
                SELECT * FROM m_sub_items AS m_sub_items
                WHERE m_sub_items.deleted_at IS NULL 
                AND m_sub_items.category_code = 2
            ) AS m_sub_items
            ON m_sub_items.code = r_products.sub_item_code
            AND m_sub_items.main_items_code = r_products.main_item_code
            INNER JOIN (
                SELECT * FROM m_house_types AS m_house_types
                WHERE m_house_types.Deleted_Date IS NULL
            ) AS m_house_types
            ON m_house_types.code = r_products.house_type_code
            WHERE r_products.category_code = 2 
            "
        )); 
    }

    public function getHouseTypes(){
        // return 'test';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT * FROM m_house_types AS m_house_types
            WHERE m_house_types.Deleted_Date IS NULL
            "
        )); 
    }

    public function getMainItems(){
        // return 'test';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT * FROM m_main_items AS m_main_items
            WHERE m_main_items.deleted_at IS NULL 
            AND m_main_items.category_code = 2
            "
        )); 
    }

    public function getSubItems(Request $req){
        // return 'test';
        return DB::connection('mysql')
        ->select(DB::raw(
            "SELECT * FROM m_sub_items AS m_sub_items
            WHERE m_sub_items.deleted_at IS NULL 
            AND m_sub_items.category_code = 2
            AND m_sub_items.main_items_code = '$req->main_item_code'
            "
        )); 
    }




















    //////////////////////////////////////////////////////////////////
    //      *   *   *   *   * NAIBU FUNCTIONS   *   *   *   *   *  //
    ////////////////////////////////////////////////////////////////
    public function getNaibuItem1 () {
        return DB::connection('mysql')
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
}
