<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\imageMaster;
use App\Models\MasterMaintenance;

class MasterMaintenanceController extends Controller
{
    public function getData () {  
        // return $req; 
        // return DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
        return DB::connection('HRDSQL6')
        ->select(DB::raw(
            "SELECT 
                SCT.id,
                SCT.Shiyousho_Kbn,
                CASE 
                -- WHEN SCT.Shiyousho_Kbn = 1 THEN 'GAIBU' 
                -- WHEN SCT.Shiyousho_Kbn = 2 THEN 'SETSUBI' 
                -- WHEN SCT.Shiyousho_Kbn = 3 THEN 'NAIBU'
                WHEN SCT.Shiyousho_Kbn = 1 THEN '外部'
                WHEN SCT.Shiyousho_Kbn = 2 THEN '設備'
                WHEN SCT.Shiyousho_Kbn = 3 THEN '内部'
                END AS Category_Type,
                SCT.Item_cd_1,
                M_CDM021.ITEM_1_MEI,
                SCT.Item_cd_2,
                M_CDM022.ITEM_2_MEI,
                SCT.Goods_cd,
                M_CDM027.GOODS_MEI,
                SCT.Color,
                SCT.Img_Path
            FROM SD_SQL_TRAINING.Shiyousho_Catalog_Test.dbo.master_maintenance AS SCT
                INNER JOIN (
                    SELECT * FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM021 AS M_CDM021
                    WHERE M_CDM021.HAIBAN = 0
                ) AS M_CDM021
                ON M_CDM021.SHIYOSHO_KBN = SCT.Shiyousho_Kbn
                AND M_CDM021.ITEM_1_CD  COLLATE Japanese_CI_AS = SCT.Item_cd_1 COLLATE Japanese_CI_AS
                
                INNER JOIN (
                    SELECT * FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM022 AS M_CDM022
                    WHERE M_CDM022.HAIBAN = 0
                ) AS M_CDM022
                ON M_CDM022.SHIYOSHO_KBN = SCT.Shiyousho_Kbn
                AND M_CDM022.ITEM_1_CD  COLLATE Japanese_CI_AS = SCT.Item_cd_1 COLLATE Japanese_CI_AS
                AND M_CDM022.ITEM_2_CD  COLLATE Japanese_CI_AS = SCT.Item_cd_2 COLLATE Japanese_CI_AS
                
                INNER JOIN (
                    SELECT * FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM027 AS M_CDM027
                    WHERE M_CDM027.HAIBAN = 0
                ) AS M_CDM027
                ON M_CDM027.SHIYOSHO_KBN = SCT.Shiyousho_Kbn
                AND M_CDM027.GOODS_CD COLLATE Japanese_CI_AS = SCT.Goods_cd COLLATE Japanese_CI_AS
                ORDER BY SCT.id DESC
            "
        )); 
    }


    public function getItem1 (Request $req) {
        // return $req; 
        return DB::connection('ShiyoushoCommon_Test')
        ->select(DB::raw(
            "SELECT 
                M_CDM021.SHIYOSHO_KBN,
                M_CDM021.ITEM_1_CD AS ITEM_CD_1,
                M_CDM021.ITEM_1_MEI,
                cast(M_CDM021.DISP_ORDER AS INT) AS DISP_ORDER
                FROM dbo.M_CDM021 AS M_CDM021
                WHERE M_CDM021.HAIBAN = 0
                AND M_CDM021.SHIYOSHO_KBN = $req->Shiyousho_Kbn
            "
        )); 
    }


    public function getItem2 (Request $req) {
        // return $req; 
        return DB::connection('ShiyoushoCommon_Test')
        ->select(DB::raw(
            "SELECT
                M_CDM021.SHIYOSHO_KBN,
                M_CDM021.ITEM_1_CD,
                M_CDM021.ITEM_1_MEI,
                M_CDM022.ITEM_2_CD,
                M_CDM022.ITEM_2_MEI,
                cast(M_CDM021.DISP_ORDER AS INT) AS DISP_ORDER
                FROM dbo.M_CDM021 AS M_CDM021	
                    INNER JOIN (
                        SELECT SHIYOSHO_KBN,
                        M_CDM022.ITEM_1_CD,
                        M_CDM022.ITEM_2_CD,
                        M_CDM022.ITEM_2_MEI,
                        M_CDM022.DISP_ORDER
                        FROM dbo.M_CDM022
                        WHERE M_CDM022.DISP_ORDER NOT IN (9999)
                        AND M_CDM022.ITEM_1_CD = '$req->ITEM_CD_1'
                        AND M_CDM022.SHIYOSHO_KBN = $req->SHIYOSHO_KBN
                    ) AS M_CDM022
                    ON M_CDM022.ITEM_1_CD = M_CDM021.ITEM_1_CD
                WHERE M_CDM021.SHIYOSHO_KBN = $req->SHIYOSHO_KBN
                AND M_CDM021.ITEM_1_CD = '$req->ITEM_CD_1'
                AND M_CDM021.HAIBAN = 0
            "
        )); 
    }


    public function products (Request $req) {
        // return $req; 
        return DB::connection('ShiyoushoCommon_Test')
        ->select(DB::raw(
            "SELECT DISTINCT
                M_CDM031.SHIYOSHO_KBN,
                M_CDM031.ITEM_CD_1,
                M_CDM031.ITEM_CD_2,
                M_CDM027.GOODS_CD,
                M_CDM027.GOODS_MEI,
                M_CDM027.MAKER_CD,
                M_CDM027.MAKER_MEI,
                M_CDM027.SURYO_KANRI_KBN,
                M_CDM027.LIMITED_KANRI_KBN,
                M_CDM027.LIMITED_SURYO
            FROM dbo.M_CDM031 AS M_CDM031
                INNER JOIN (
                    SELECT
                        M_CDM027.SHIYOSHO_KBN,
                        M_CDM027.GOODS_CD,
                        M_CDM027.GOODS_MEI,
                        M_CDM027.MAKER_CD,
                        M_CDM027.SURYO_KANRI_KBN,
                        M_CDM027.LIMITED_KANRI_KBN,
                        M_CDM027.LIMITED_SURYO,
                        M_CDM002.MAKER_MEI
                    FROM dbo.M_CDM027 AS M_CDM027
                        LEFT JOIN(
                            SELECT
                                M_CDM002.MAKER_CD,
                                M_CDM002.MAKER_MEI,
                                M_CDM002.PREPARED_DATE,
                                M_CDM002.RENEWAL_DATE,
                                M_CDM002.RENEWAL_ID
                            FROM dbo.M_CDM002 AS M_CDM002
                        ) AS M_CDM002
                        ON M_CDM027.MAKER_CD = M_CDM002.MAKER_CD
                    WHERE M_CDM027.SHIYOSHO_KBN = $req->SHIYOSHO_KBN
                    AND M_CDM027.HAIBAN = 0
                ) AS M_CDM027
                ON M_CDM027.GOODS_CD = M_CDM031.GOODS_CD
            WHERE M_CDM031.SHIYOSHO_KBN = $req->SHIYOSHO_KBN
            AND M_CDM031.ITEM_CD_1 = '$req->ITEM_1_CD'
            AND M_CDM031.ITEM_CD_2 = '$req->ITEM_2_CD'
            AND M_CDM031.GOODS_CD NOT IN ('7777777', '7777778', '8888888', '9999999')
            "
        )); 
    }


    public function colors (Request $req) {
        // return $req; 
        return DB::connection('ShiyoushoCommon_Test')
        ->select(DB::raw(
            "SELECT 
                M_CDM028.SHIYOSHO_KBN,
                M_CDM028.GOODS_CD,
                M_CDM028.COLOR,
                M_CDM028.COLOR_CUST,
                M_CDM028.HAIBAN,
                M_CDM028.DISP_ORDER
            FROM dbo.M_CDM028 AS M_CDM028
            WHERE M_CDM028.HAIBAN = 0
            AND M_CDM028.SHIYOSHO_KBN = $req->SHIYOSHO_KBN
            AND M_CDM028.GOODS_CD = '$req->GOODS_CD'
            "
        )); 
    }


    public function editItems(Request $id){
        // return $req; 
        return $data1 = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        // return $data1 = DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
        ->table('master_maintenance')->find($id->id); 
    }


    public function updateData(Request $request){
        if($request->action == 'ADD NEW'){
            // return $request;
            //        *     *     *      SAVE     *     *     *        //
            // $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            $data = DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
            ->table('master_maintenance')
            ->where('Shiyousho_Kbn',$request->Shiyousho_Kbn)
            ->where('Item_cd_1',$request->Item_cd_1)
            ->where('Item_cd_2',$request->Item_cd_2)
            ->where('Goods_cd',$request->Goods_cd)
            ->where('Color',$request->Color)
            ->get();

            if(count($data) > 0){
                return 'Existing';
            }else{
                // $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
                $data = DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
                ->table('master_maintenance')
                ->insert([
                    'Shiyousho_Kbn' => $request->Shiyousho_Kbn,
                    'Item_cd_1' => $request->Item_cd_1,
                    'Item_cd_2' => $request->Item_cd_2,
                    'Goods_cd' => $request->Goods_cd,
                    'Color' => $request->Color,
                ]);
                return 'SAVED';
            }

        }else{
            // return $request;
            //        *     *     *      UPDATE     *     *     *        //
            // $data = DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
            $data = DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
            ->table('master_maintenance')
            ->where('Shiyousho_Kbn',$request->Shiyousho_Kbn)
            ->where('Item_cd_1',$request->Item_cd_1)
            ->where('Item_cd_2',$request->Item_cd_2)
            ->where('Goods_cd',$request->Goods_cd)
            ->where('Color',$request->Color)
            ->get();

            if(count($data) > 0){
                return 'Existing';
            }else{
                // DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
                DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
                ->table('master_maintenance')
                ->insert([
                    'Shiyousho_Kbn' => $request->Shiyousho_Kbn,
                    'Item_cd_1' => $request->Item_cd_1,
                    'Item_cd_2' => $request->Item_cd_2,
                    'Goods_cd' => $request->Goods_cd,
                    'Color' => $request->Color,
                    'updated_at'=> date('Y-m-d H:i:s')
                ]);

                // DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
                DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
                ->table('master_maintenance')
                ->where('id',$request->productId)
                ->delete();

                return 'EDITED';
            }
        }
    }


    //        *     *     *      DELETE     *     *     *        //
    public function deleteData(Request $request){
        // return $request;
        // return DB::connection('HRDAPPS31(shiyou_sentaku_main_test)')
        return DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
        ->table('master_maintenance')
        ->where('id',$request->id)
        // ->get();
        ->delete();
    }


}
