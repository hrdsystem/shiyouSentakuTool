<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ShiyoushoCatalogController extends Controller
{
    //
    public function index(){
        return view('layouts.app');
    }

    //

    public function getData()
    {
        return DB::table('cart')->get();
        
    }

    //SAVE
    // public function saveCart(Request $req)
    // {
        // return $req->type;
    //     DB::table('cart')
    //     ->insert([
    //         "item" => $req->item,
    //         "image" => $req->image,
    //         "kind" => $req->kind,
    //         "color" => $req->color,
    //         "color_img" => $req->color_img,
    //         "type" => $req->type,
    //         "added_date" => date('Y-m-d H:i:s')
    //     ]);
    // }
    
    // DELETE
    // public function removeItem($id){ //back-end deletion
    //     $id = DB::table('cart')->where('id', $id)->delete();
    //     return response()->json($id . ' ' . 'is successfully deleted');
    // }

        // ==================== 03-15-2023 ==================== //
        //GET DATA FROM HRDSQL8
        // public function getDataHRDSQL8(){
        public function getDataHRDSQL7(){
            // return  $HRDSQL8 = DB::connection('ShiyoushoCommon_Test')
                $HRDSQL7 = DB::connection('HRDSQL7(ShiyoushoCommon)')
            // ->table('M_CDM031')
            ->select(
                DB::raw(
                    "SELECT 
                        M_CDM031.SHIYOSHO_KBN,
                        M_CDM031.ITEM_CD_1,
                        M_CDM022.ITEM_1_MEI,
                        M_CDM031.ITEM_CD_2,
                        M_CDM022.ITEM_2_MEI,
                        M_CDM031.GOODS_CD,
                        M_CDM027.GOODS_MEI,
                        -- M_CDM027.LIMITED_SURYO,
                        CASE WHEN M_CDM027.LIMITED_SURYO = '0.00' THEN 1 ELSE M_CDM027.LIMITED_SURYO END AS LIMITED_SURYO,
                        M_CDM027.COLOR,
                        M_CDM027.HAIBAN,
                        M_CDM031.DISP_ORDER
                        -- M_CDM027.CREATED_AT
                        FROM dbo.M_CDM031 AS M_CDM031
    
                        INNER JOIN (
                            SELECT 
                                M_CDM027.SHIYOSHO_KBN,
                                M_CDM027.GOODS_CD,
                                M_CDM027.GOODS_MEI,
                                M_CDM027.HAIBAN,
                                --LIMITED_KANRI_KBN,
                                M_CDM027.LIMITED_SURYO,
                                M_CDM028.COLOR,
                                M_CDM028.COLOR_CUST
                            FROM dbo.M_CDM027 AS M_CDM027
                            LEFT JOIN (
                                SELECT 
                                    M_CDM028.SHIYOSHO_KBN,
                                    M_CDM028.GOODS_CD,
                                    M_CDM028.COLOR,
                                    M_CDM028.COLOR_CUST,
                                    M_CDM028.HAIBAN,
                                    M_CDM028.DISP_ORDER
                                FROM dbo.M_CDM028 AS M_CDM028
                                WHERE M_CDM028.HAIBAN = 0
                                AND M_CDM028.SHIYOSHO_KBN = 2
                            ) AS M_CDM028
                            ON M_CDM028.GOODS_CD = M_CDM027.GOODS_CD
                            WHERE M_CDM027.SHIYOSHO_KBN = 2
                            AND M_CDM027.HAIBAN = 0
                        ) AS M_CDM027
                        ON M_CDM027.GOODS_CD = M_CDM031.GOODS_CD
                        INNER JOIN (
                            SELECT 
                                M_CDM022.SHIYOSHO_KBN,
                                M_CDM022.ITEM_1_CD,
                                M_CDM021.ITEM_1_MEI,
                                M_CDM022.ITEM_2_CD,
                                M_CDM022.ITEM_2_MEI,
                                M_CDM022.HAIBAN,
                                M_CDM022.DISP_ORDER
                            FROM dbo.M_CDM022 AS M_CDM022
                            LEFT JOIN (
                                SELECT 
                                    M_CDM021.SHIYOSHO_KBN,
                                    M_CDM021.ITEM_1_CD,
                                    M_CDM021.ITEM_1_MEI,
                                    M_CDM021.HAIBAN,
                                    M_CDM021.DISP_ORDER
                                FROM dbo.M_CDM021 AS M_CDM021
                                WHERE M_CDM021.HAIBAN = 0 
                                AND M_CDM021.SHIYOSHO_KBN = 2
                                AND M_CDM021.ITEM_1_CD = '0200'
                            ) AS M_CDM021
                            ON M_CDM021.ITEM_1_CD = M_CDM022.ITEM_1_CD
                            WHERE M_CDM022.HAIBAN = 0
                            AND M_CDM022.SHIYOSHO_KBN = 2
                            AND M_CDM022.ITEM_1_CD = '0200'
                            AND M_CDM022.ITEM_2_CD <> '9999' 
                        ) AS M_CDM022
                        ON M_CDM022.ITEM_1_CD = M_CDM031.ITEM_CD_1
                        AND M_CDM022.ITEM_2_CD = M_CDM031.ITEM_CD_2
                        WHERE M_CDM031.SHIYOSHO_KBN = 2
                        AND M_CDM031.ITEM_CD_1 = '0200'
                        -- AND M_CDM031.ITEM_CD_2 = '0605'
                        AND NOT M_CDM031.GOODS_CD IN ('8888888','0000002','9999999')
                    "
                )
            );
            return $HRDSQL7;
            // ->get();
        }
        // ==================== END ==================== //yar
    
        public function getDataShio(Request $request){
                // return $request;
                // info($request);
                $data = DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
                ->select(DB::raw($request->datas));
                // ->select(DB::raw('SELECT * FROM M_CDM031'));
                // info($data);
                return $data;
        }
        // ==================== END ==================== //
    
        public function saveToShioCatalog( Request $request ){
            // return $request;
            foreach($request->HRDSQL7 as $key => $value){
                DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)')
                ->table('sentaku_tool')
                ->insert([
                    'Shiyousho_Kbn' => $value['SHIYOSHO_KBN'],
                    'Item_cd_1' => $value['ITEM_CD_1'],
                    'Item_1_mei' => $value['ITEM_1_MEI'],
                    'Item_cd_2' => $value['ITEM_CD_2'],
                    'Item_2_mei' => $value['ITEM_2_MEI'],
                    'Goods_cd' => $value['GOODS_CD'],
                    'Goods_mei' => $value['GOODS_MEI'],
                    'Limited_Suryo' => $value['LIMITED_SURYO'],
                    'Color' => $value['COLOR'],
                    'Haiban' => $value['HAIBAN'],
                    'Disp_Order' => $value['DISP_ORDER'],
                    'Created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }


        public function getDataSentakuTool(){ 
            return DB::connection('HRDSQL_TRAINING(Shiyousho_Catalog_Test)') 
            ->table('sentaku_tool') 
            ->select( 
                'id', 
                'Shiyousho_Kbn', 
                'Item_cd_1', 
                'Item_1_mei', 
                'Item_cd_2', 
                'Item_2_mei', 
                'Goods_cd', 
                'Goods_mei', 
                'Limited_Suryo', 
                'Color', 
                'Img_Path', 
                'Haiban', 
                'Disp_Order' 
            ) ->get(); // return $data; }
        }  
        
        public function selectCategory(){
            return DB::connection('HRDAPPS31(shiyou_sentaku_main)')
            ->select(
                DB::raw("
                    SELECT 
                        CODE, 
                        category_code, 
                        item_name 
                    FROM m_main_items
                    where Deleted_Date is null
                ")
            );  
            // Request $request 
            // && M_CDM021.SHIYOSHO_KBN = $request->SHIYOSHO_KBN 
            // && M_CDM031.SHIYOSHO_KBN = $request->SHIYOSHO_KBN if post

            // return DB::connection('HRDSQL7(ShiyoushoCommon)')
            // ->select(
            //     DB::raw("
            //     SELECT DISTINCT
            //     M_CDM031.SHIYOSHO_KBN, 
            //     M_CDM031.ITEM_CD_1,
            //     M_CDM021.ITEM_1_MEI,
            //     M_CDM021.DISP_ORDER
            //         FROM dbo.M_CDM031 AS M_CDM031
            //             INNER JOIN (
            //             SELECT M_CDM021.*
            //                 FROM dbo.M_CDM021 AS M_CDM021
            //                 WHERE M_CDM021.HAIBAN = 0
            //             ) AS M_CDM021
            //     ON M_CDM021.ITEM_1_CD = M_CDM031.ITEM_CD_1
            //     WHERE M_CDM031.ITEM_CD_1 NOT IN ('0500','0600')
            //     ")
            // );    

            // return DB::connection('ShiyoushoCommon_Test')
            // return DB::connection('HRDSQL7(ShiyoushoCommon)')
            // ->select(
            //     DB::raw("
            //         SELECT M_CDM021.SHIYOSHO_KBN,
            //         M_CDM021.ITEM_1_CD AS ITEM_CD_1,
            //         M_CDM021.ITEM_1_MEI,
            //         cast(M_CDM021.DISP_ORDER AS INT) AS DISP_ORDER
            //         FROM dbo.M_CDM021 AS M_CDM021
            //         WHERE M_CDM021.HAIBAN = 0
            //     ")
            // );    
        }

        // SELECT M_CDM021.SHIYOSHO_KBN,
        //             M_CDM021.ITEM_1_CD AS ITEM_CD_1,
        //             M_CDM021.ITEM_1_MEI,
        //             cast(M_CDM021.DISP_ORDER AS INT) AS DISP_ORDER
        //             FROM dbo.M_CDM021 AS M_CDM021
        //                 INNER JOIN (
        //                     SELECT SHIYOSHO_KBN,
        //                     M_CDM022.ITEM_1_CD,
        //                     M_CDM022.ITEM_2_CD,
        //                     M_CDM022.ITEM_2_MEI,
        //                     M_CDM022.DISP_ORDER
        //                     FROM dbo.M_CDM022
        //                     WHERE M_CDM022.DISP_ORDER NOT IN (9999)
        //                     AND M_CDM022.ITEM_1_CD = $request->ITEM_CD_1
        //                     AND M_CDM022.SHIYOSHO_KBN = $request->SHIYOSHO_KBN    
        //                 ) AS M_CDM022
        //                 ON M_CDM022.ITEM_1_CD = M_CDM021.ITEM_1_CD
        //             WHERE M_CDM021.SHIYOSHO_KBN = $request->SHIYOSHO_KBN    
        //             AND M_CDM021.ITEM_1_CD = $request->ITEM_CD_1
        //             AND M_CDM021.HAIBAN = 

        // public function selectItem(Request $request){
        //     // return $request->ITEM_CD_1;
        //     $ITEM_CD_1 = $request->ITEM_CD_1;
        //     // $data = DB::connection('ShiyoushoCommon_Test')
        //     $data = DB::connection('HRDSQL7(ShiyoushoCommon)')
        //     ->select(
        //         DB::raw("
        //             SELECT
        //                 M_CDM021.SHIYOSHO_KBN,
        //                 M_CDM021.ITEM_1_CD,
        //                 M_CDM021.ITEM_1_MEI,
        //                 M_CDM022.ITEM_2_CD,
        //                 M_CDM022.ITEM_2_MEI,
        //                 cast(M_CDM021.DISP_ORDER AS INT) AS DISP_ORDER
        //             FROM dbo.M_CDM021 AS M_CDM021	
        //                 INNER JOIN (
        //                     SELECT SHIYOSHO_KBN,
        //                     M_CDM022.ITEM_1_CD,
        //                     M_CDM022.ITEM_2_CD,
        //                     M_CDM022.ITEM_2_MEI,
        //                     M_CDM022.DISP_ORDER
        //                     FROM dbo.M_CDM022
        //                     WHERE M_CDM022.DISP_ORDER NOT IN (9999)
        //                     AND M_CDM022.ITEM_1_CD = '$ITEM_CD_1'
        //                     AND M_CDM022.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
        //                 ) AS M_CDM022
        //                 ON M_CDM022.ITEM_1_CD = M_CDM021.ITEM_1_CD
        //             WHERE M_CDM021.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
        //             AND M_CDM021.ITEM_1_CD = '$ITEM_CD_1'
        //             AND M_CDM021.HAIBAN = 0
        //         ")
        //     );  
        //     return $data; 
        // }
        
        public function selectItem(Request $request){
                    // CODE
                    // : 
                    // "0200"
                    // category_code
                    // : 
                    // "2"
                    // item_name
                    // : 
                    //  "トイレ"
            // return $request;
            // return 'sample';
            // return $request->ITEM_CD_1;
            // $ITEM_CD_1 = $request->ITEM_CD_1;
            
            // $data = DB::connection('ShiyoushoCommon_Test')
            $data = DB::connection('HRDAPPS31(shiyou_sentaku_main)')
            ->select(
                DB::raw("SELECT
                m_main_items.code as main_items_code,
                m_main_items.category_code,
                m_main_items.item_name as main_items_name,
                m_sub_items.item_name,
                m_sub_items.code as sub_items_code
                FROM m_main_items
                    LEFT JOIN (
                        SELECT
                            m_sub_items.code,
                            m_sub_items.main_items_code,
                            m_sub_items.item_name,
                            m_sub_items.category_code
                        FROM m_sub_items
                        WHERE m_sub_items.main_items_code = '$request->CODE'
                        AND m_sub_items.category_code = $request->category_code
                    ) AS m_sub_items
                    ON m_main_items.category_code = m_sub_items.category_code
                WHERE m_main_items.code = '$request->CODE'
                AND m_main_items.category_code = $request->category_code
                ")
            );  
            return $data; 
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * CHECK CLASSIFICATION AVAILABILITY * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //

        private function checkIfWithClassification($request){

            // $ITEM_1_CD = $request->ITEM_1_CD;

            // return $request;
            // $data = DB::connection('ShiyoushoCommon_Test')
            // ->select(
            //     DB::raw(
            //         "SELECT 
            //             M_CDM043.SHIYOSHO_KBN,
            //             M_CDM043.ITEM_CD_1,
            //             M_CDM043.ITEM_CD_2,
            //             M_CDM043.BUNRUI_CD_1,
            //             M_CDM025.BUNRUI_MEI
            //         FROM dbo.M_CDM043 AS M_CDM043
            //         INNER JOIN (
            //             SELECT 
            //                 M_CDM025.BUNRUI_CD,
            //                 M_CDM025.BUNRUI_MEI
            //             FROM dbo.M_CDM025 AS M_CDM025
            //             WHERE M_CDM025.SHIYOSHO_KBN = 2
            //             AND M_CDM025.BUNRUI_KBN = 1
            //             AND M_CDM025.ITEM_1_CD = '$request->ITEM_1_CD'
            //             AND M_CDM025.ITEM_2_CD = '$request->ITEM_2_CD'
            //         ) AS M_CDM025
            //         ON M_CDM025.BUNRUI_CD = M_CDM043.BUNRUI_CD_1
            //         WHERE M_CDM043.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //         AND M_CDM043.ITEM_CD_1 = '$request->ITEM_1_CD'
            //         AND M_CDM043.ITEM_CD_2 = '$request->ITEM_2_CD'"
            //         )
            // );

            // if(count($data) > 0){
            //     return 1;
            // }else{
            //     return 0;
            // }

            // return $request;
            $data = DB::connection('HRDAPPS31(shiyou_sentaku_main)')
            ->select(
                DB::raw(" SELECT
                    m_main_items.code,
                    m_main_items.category_code,
                    m_main_items.item_name,
                    m_sub_items.item_name,
                    m_sub_items.product_name,
                    m_sub_items.maker_code,
                    m_sub_items.manufacturer_name,
                    m_sub_items.sub_items_code
                    FROM m_main_items as m_main_items
                        LEFT JOIN (
                            SELECT
                                m_sub_items.category_code,
                                m_sub_items.main_items_code,
                                m_sub_items.item_name,
                                m_sub_items.code,
                                products.product_name,
                                products.maker_code,
                                products.manufacturer_name,
                                products.sub_items_code
                            FROM m_sub_items
                                LEFT JOIN (
                                    SELECT
                                        products.category_code,
                                        products.main_items_code,
                                        products.sub_items_code,
                                        products.CODE,
                                        products.product_name,
                                        products.maker_code,
                                        manufacturer.manufacturer_name
                                        FROM m_products AS products
                                            LEFT JOIN (
                                                SELECT
                                                    CODE,
                                                    manufacturer_name
                                                FROM m_manufacturers 
                                            )AS manufacturer
                                        ON products.maker_code = manufacturer.code
                                        WHERE products.category_code = $request->category_code
                                        AND products.main_items_code = '$request->main_items_code'
                                        AND products.sub_items_code = '$request->sub_items_code'
                                ) AS products
                            ON m_sub_items.category_code = products.category_code
                            WHERE m_sub_items.category_code = $request->category_code
                            AND m_sub_items.main_items_code = '$request->main_items_code'
                            AND m_sub_items.code = '$request->sub_items_code'
                        ) AS m_sub_items
                        ON m_main_items.category_code = m_sub_items.category_code
                    WHERE m_main_items.code = '$request->main_items_code'
                    AND m_main_items.category_code = $request->category_code
                    AND m_sub_items.maker_code IS not null
                    "
                    )
            );

            if( count($data) > 0){
               return 1;
            }else{
                return 0;
            }
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * SPECIFICATION * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //

        public function getClassification(Request $request){
            // return $request;
            $existing = $this->checkIfWithClassification($request);

            $data = [];

            if($existing == 1){
                $data = DB::connection('HRDAPPS31(shiyou_sentaku_main)')
                ->select(
                    "SELECT
                    m_main_items.code as main_items_code,
                    m_main_items.category_code,
                    m_main_items.item_name,
                    m_sub_items.item_name as sub_item_name,
                    m_sub_items.sub_items_code,
                    m_sub_items.product_name,
                    m_sub_items.product_code,
                    m_sub_items.maker_code,
                    m_sub_items.manufacturer_name,
                    m_sub_items.image_path
                    FROM m_main_items
                        LEFT JOIN (
                            SELECT
                            m_sub_items.category_code,
                            m_sub_items.main_items_code,
                            m_sub_items.code,
                            m_sub_items.item_name,
                            products.sub_items_code,
                            products.product_name,
                            products.CODE as product_code,
                            products.maker_code,
                            products.manufacturer_name,
                            products.image_path
                            FROM m_sub_items
                                LEFT JOIN (
                                    SELECT
                                        products.category_code,
                                        products.main_items_code,
                                        products.sub_items_code,
                                        products.CODE,
                                        products.product_name,
                                        products.maker_code,
                                        manufacturer.manufacturer_name,
                                        products.image_path
                                        FROM m_products AS products
                                            LEFT JOIN (
                                                SELECT
                                                    CODE,
                                                    manufacturer_name
                                                FROM m_manufacturers 
                                            )AS manufacturer
                                        ON products.maker_code = manufacturer.code
                                        WHERE products.category_code = $request->category_code
                                        AND products.main_items_code = '$request->main_items_code'
                                        AND products.sub_items_code = '$request->sub_items_code'
                                ) AS products
                            ON m_sub_items.category_code = products.category_code
                            WHERE m_sub_items.category_code = $request->category_code
                            AND m_sub_items.main_items_code = '$request->main_items_code'
                            AND m_sub_items.code = '$request->sub_items_code'
                        ) AS m_sub_items
                        ON m_main_items.category_code = m_sub_items.category_code
                    WHERE m_main_items.code = '$request->main_items_code'
                    AND m_main_items.category_code = $request->category_code
                        "
                    );
            }else{
                // $data = 'world';
                $data = DB::connection('HRDAPPS31(shiyou_sentaku_main)')
                ->select(
                    DB::raw(" SELECT
                    m_main_items.code as main_items_code,
                    m_main_items.category_code,
                    m_main_items.item_name,
                    m_sub_items.item_name as sub_item_name,
                    m_sub_items.sub_items_code,
                    m_sub_items.product_name,
                    m_sub_items.product_code,
                    m_sub_items.maker_code,
                    m_sub_items.image_path
                    FROM m_main_items
                        LEFT JOIN (
                            SELECT
                            m_sub_items.code,
                            m_sub_items.main_items_code,
                            m_sub_items.item_name,
                            m_sub_items.category_code,
                            products.product_name,
                            products.code as product_code,
                            products.maker_code,
                            products.sub_items_code,
                            products.image_path
                            FROM m_sub_items
                                LEFT JOIN (
                                    SELECT
                                        products.category_code,
                                        products.main_items_code,
                                        products.sub_items_code,
                                        products.CODE,
                                        products.product_name,
                                        products.maker_code,
                                        products.image_path
                                    FROM m_products AS products
                                    WHERE products.category_code = $request->category_code
                                    AND products.main_items_code = '$request->main_items_code'
                                    AND products.sub_items_code = '$request->sub_items_code'
                                ) AS products
                            ON m_sub_items.category_code = products.category_code
                            WHERE m_sub_items.category_code = $request->category_code
                            AND m_sub_items.main_items_code = '$request->main_items_code'
                            AND m_sub_items.code = '$request->sub_items_code'
                        ) AS m_sub_items
                        ON m_main_items.category_code = m_sub_items.category_code
                    WHERE m_main_items.code = '$request->main_items_code'
                    AND m_main_items.category_code = $request->category_code
                        ")
                    );
            }

              $classification1 = DB::connection('HRDAPPS31(shiyou_sentaku_main)')
            ->select(
                DB::raw(
                    "SELECT
                    m_main_items.code as main_items_code,
                    m_main_items.category_code,
                    m_sub_items.sub_items_code,
                    m_sub_items.product_code,
                    m_sub_items.maker_code,
                    m_sub_items.manufacturer_name
                    FROM m_main_items
                        LEFT JOIN (
                            SELECT
                            m_sub_items.category_code,
                            m_sub_items.main_items_code,
                            m_sub_items.code,
                            m_sub_items.item_name,
                            products.sub_items_code,
                            products.product_name,
                            products.CODE as product_code,
                            products.maker_code,
                            products.manufacturer_name
                            FROM m_sub_items
                                LEFT JOIN (
                                    SELECT
                                        products.category_code,
                                        products.main_items_code,
                                        products.sub_items_code,
                                        products.CODE,
                                        products.product_name,
                                        products.maker_code,
                                        manufacturer.manufacturer_name
                                        FROM m_products AS products
                                            LEFT JOIN (
                                                SELECT
                                                    CODE,
                                                    manufacturer_name
                                                FROM m_manufacturers 
                                            )AS manufacturer
                                        ON products.maker_code = manufacturer.code
                                        WHERE products.category_code = $request->category_code
                                        AND products.main_items_code = '$request->main_items_code'
                                        AND products.sub_items_code = '$request->sub_items_code'
                                ) AS products
                            ON m_sub_items.category_code = products.category_code
                            WHERE m_sub_items.category_code = $request->category_code
                            AND m_sub_items.main_items_code = '$request->main_items_code'
                            AND m_sub_items.code = '$request->sub_items_code'
                        ) AS m_sub_items
                        ON m_main_items.category_code = m_sub_items.category_code
                    WHERE m_main_items.code = '$request->main_items_code'
                    AND m_main_items.category_code = $request->category_code
                ")
            );

            // if($existing == 1){

            //     $data = DB::connection('HRDSQL6')
            //     ->select(
            //         DB::raw(
            //             "SELECT DISTINCT
            //                 M_CDM046.SHIYOSHO_KBN,
            //                 M_CDM046.ITEM_CD_1,
            //                 M_CDM046.ITEM_CD_2,
            //                 M_CDM046.BUNRUI_CD_1,
            //                 M_CDM046.BUNRUI_CD_2,
            //                 M_CDM046.BUNRUI_CD_3,
            //                 M_CDM046.GOODS_CD,
            //                 M_CDM031.GOODS_MEI,
            //                 M_CDM031.MAKER_CD,
            //                 M_CDM031.MAKER_MEI,
            //                 SCT.Color,
            //                 SCT.Img_path AS IMG_PATH
            //             FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM046 AS M_CDM046
            //             INNER JOIN (
            //                 SELECT DISTINCT
            //                     M_CDM031.SHIYOSHO_KBN,
            //                     M_CDM031.ITEM_CD_1,
            //                     M_CDM031.ITEM_CD_2,
            //                     M_CDM027.GOODS_CD,
            //                     M_CDM027.GOODS_MEI,
            //                     M_CDM027.MAKER_CD,
            //                     M_CDM027.MAKER_MEI
            //                     --M_CDM027.SURYO_KANRI_KBN,
            //                     --M_CDM027.LIMITED_KANRI_KBN,
            //                     --M_CDM027.LIMITED_SURYO
            //                 FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM031 AS M_CDM031
            //                 INNER JOIN (
            //                     SELECT
            //                         M_CDM027.SHIYOSHO_KBN,
            //                         M_CDM027.GOODS_CD,
            //                         M_CDM027.GOODS_MEI,
            //                         M_CDM027.MAKER_CD,
            //                         M_CDM002.MAKER_MEI,
            //                         M_CDM027.SURYO_KANRI_KBN,
            //                         M_CDM027.LIMITED_KANRI_KBN,
            //                         M_CDM027.LIMITED_SURYO
            //                     FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM027 AS M_CDM027
            //                     LEFT JOIN(
            //                         SELECT
            //                             M_CDM002.MAKER_CD,
            //                             M_CDM002.MAKER_MEI,
            //                             M_CDM002.PREPARED_DATE,
            //                             M_CDM002.RENEWAL_DATE,
            //                             M_CDM002.RENEWAL_ID
            //                         FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM002 AS M_CDM002
            //                     ) AS M_CDM002
            //                     ON M_CDM027.MAKER_CD = M_CDM002.MAKER_CD
            //                     WHERE M_CDM027.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //                     AND M_CDM027.HAIBAN = 0
            //                 ) AS M_CDM027
            //                 ON M_CDM027.GOODS_CD = M_CDM031.GOODS_CD
            //                 WHERE M_CDM031.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //                 AND M_CDM031.ITEM_CD_1 = '$request->ITEM_1_CD'
            //                 AND M_CDM031.ITEM_CD_2 = '$request->ITEM_2_CD'
            //                 AND M_CDM031.GOODS_CD NOT IN ('7777777', '7777778', '8888888', '9999999')
            //             ) AS M_CDM031
            //             ON M_CDM031.GOODS_CD = M_CDM046.GOODS_CD
            //                 LEFT JOIN (
            //                   SELECT * FROM SD_SQL_TRAINING.Shiyousho_Catalog_Test.dbo.image_masters AS SCT
            //                   WHERE SCT.Shiyousho_Kbn = $request->SHIYOSHO_KBN
            //                   AND SCT.Item_cd_1 = '$request->ITEM_1_CD'
            //                   AND SCT.Item_cd_2 = '$request->ITEM_2_CD'
            //                 ) AS SCT
            //                 ON SCT.Goods_cd COLLATE Japanese_CI_AS = M_CDM031.GOODS_CD COLLATE Japanese_CI_AS
            //             WHERE M_CDM046.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //             AND M_CDM046.ITEM_CD_1 = '$request->ITEM_1_CD'
            //             AND M_CDM046.ITEM_CD_2 = '$request->ITEM_2_CD'
            //         ")
            //     );

            // }else{

            //     $data = DB::connection('HRDSQL6')
            //     ->select(
            //         DB::raw(
            //             "SELECT
            //             m_main_items.code,
            //             m_main_items.category_code,
            //             m_main_items.item_name,
            //             m_sub_items.item_name,
            //             m_sub_items.product_name,
            //             m_sub_items.maker_code,
            //             m_sub_items.manufacturer_name
            //             FROM m_main_items
            //                 LEFT JOIN (
            //                     SELECT
            //                     m_sub_items.code,
            //                     m_sub_items.main_items_code,
            //                     m_sub_items.item_name,
            //                     m_sub_items.category_code,
            //                     products.product_name,
            //                     products.maker_code,
            //                     products.manufacturer_name
            //                     FROM m_sub_items
            //                         LEFT JOIN (
            //                             SELECT
            //                                 products.category_code,
            //                                 products.main_items_code,
            //                                 products.sub_items_code,
            //                                 products.CODE,
            //                                 products.product_name,
            //                                 products.maker_code,
            //                                 manufacturer.manufacturer_name
            //                                 FROM m_products AS products
            //                                     LEFT JOIN (
            //                                         SELECT
            //                                             CODE,
            //                                             manufacturer_name
            //                                         FROM m_manufacturers 
            //                                     )AS manufacturer
            //                                 ON products.maker_code = manufacturer.code
            //                                 WHERE products.category_code = '2'
            //                                 AND products.main_items_code = '0200'
            //                                 AND products.sub_items_code = '0600'
            //                         ) AS products
            //                     ON m_sub_items.category_code = products.category_code
            //                     WHERE m_sub_items.category_code = 2
            //                     AND m_sub_items.main_items_code = '0200'
            //                     AND m_sub_items.code = '0600'
            //                 ) AS m_sub_items
            //                 ON m_main_items.category_code = m_sub_items.category_code
            //             WHERE m_main_items.code = '0200'
            //             AND m_main_items.category_code = 2
            //         ")
            //     );
            // }

            // $classification1 = DB::connection('ShiyoushoCommon_Test')
            // ->select(
            //     DB::raw(
            //         "SELECT 
            //             M_CDM043.SHIYOSHO_KBN,
            //             M_CDM043.ITEM_CD_1,
            //             M_CDM043.ITEM_CD_2,
            //             M_CDM043.BUNRUI_CD_1,
            //             M_CDM025.BUNRUI_MEI
            //         FROM dbo.M_CDM043 AS M_CDM043
            //         INNER JOIN (
            //             SELECT 
            //                 M_CDM025.BUNRUI_CD,
            //                 M_CDM025.BUNRUI_MEI
            //             FROM dbo.M_CDM025 AS M_CDM025
            //             WHERE M_CDM025.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //             AND M_CDM025.BUNRUI_KBN = 1
            //             AND M_CDM025.ITEM_1_CD = '$request->ITEM_1_CD'
            //             AND M_CDM025.ITEM_2_CD = '$request->ITEM_2_CD'
            //         ) AS M_CDM025
            //         ON M_CDM025.BUNRUI_CD = M_CDM043.BUNRUI_CD_1
            //         WHERE M_CDM043.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //         AND M_CDM043.ITEM_CD_1 = '$request->ITEM_1_CD'
            //         AND M_CDM043.ITEM_CD_2 = '$request->ITEM_2_CD'
            //     ")
            // );

            // $subItem = DB::connection('ShiyoushoCommon_Test')
            // ->select(
            //     DB::raw("
            //         SELECT
            //             M_CDM021.SHIYOSHO_KBN,
            //             M_CDM021.ITEM_1_CD,
            //             M_CDM021.ITEM_1_MEI,
            //             M_CDM022.ITEM_2_CD,
            //             M_CDM022.ITEM_2_MEI,
            //             cast(M_CDM021.DISP_ORDER AS INT) AS DISP_ORDER
            //         FROM dbo.M_CDM021 AS M_CDM021	
            //             INNER JOIN (
            //                 SELECT SHIYOSHO_KBN,
            //                 M_CDM022.ITEM_1_CD,
            //                 M_CDM022.ITEM_2_CD,
            //                 M_CDM022.ITEM_2_MEI,
            //                 M_CDM022.DISP_ORDER
            //                 FROM dbo.M_CDM022
            //                 WHERE M_CDM022.DISP_ORDER NOT IN (9999)
            //                 AND M_CDM022.ITEM_1_CD = '$request->ITEM_1_CD'
            //                 AND M_CDM022.ITEM_2_CD = '$request->ITEM_2_CD'
            //                 AND M_CDM022.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //             ) AS M_CDM022
            //             ON M_CDM022.ITEM_1_CD = M_CDM021.ITEM_1_CD
            //         WHERE M_CDM021.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //         AND M_CDM021.ITEM_1_CD = '$request->ITEM_1_CD'
            //         AND M_CDM021.HAIBAN = 0
            //     ")
            // );

            return [
                "withClassification" => $existing,
                "kinds" => $data,
                "classification1" => $classification1,
                // "subItem" => $subItem
            ];
            
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //

        public function getClassificationTwo(Request $request){
            // return $request;
            return DB::connection('HRDSQL7(ShiyoushoCommon)')
            ->select(
                DB::raw("
                SELECT 
                    M_CDM044.SHIYOSHO_KBN,
                    M_CDM044.ITEM_CD_1,
                    M_CDM044.ITEM_CD_2,
                    M_CDM044.BUNRUI_CD_1,
                    M_CDM044.BUNRUI_CD_2,
                    M_CDM025.BUNRUI_MEI
                FROM dbo.M_CDM044 AS M_CDM044
                LEFT JOIN (
                    SELECT 
                        M_CDM025.BUNRUI_CD,
                        M_CDM025.BUNRUI_MEI
                    FROM dbo.M_CDM025 AS M_CDM025
                    WHERE M_CDM025.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
                    AND M_CDM025.BUNRUI_KBN = 2
                    AND M_CDM025.ITEM_1_CD = '$request->ITEM_CD_1'
                    AND M_CDM025.ITEM_2_CD = '$request->ITEM_CD_2'
                ) AS M_CDM025
                ON M_CDM025.BUNRUI_CD = M_CDM044.BUNRUI_CD_2
                WHERE M_CDM044.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
                AND M_CDM044.ITEM_CD_1 = '$request->ITEM_CD_1'
                AND M_CDM044.ITEM_CD_2 = '$request->ITEM_CD_2'
                AND M_CDM044.BUNRUI_CD_1 = $request->BUNRUI_CD_1
                ")
            );
        }

        public function getClassificationThree(Request $request){
            // return $request;
            return DB::connection('HRDSQL7(ShiyoushoCommon)')
            ->select(
                DB::raw("
                SELECT 
                    M_CDM045.SHIYOSHO_KBN,
                    M_CDM045.ITEM_CD_1,
                    M_CDM045.ITEM_CD_2,
                    M_CDM045.BUNRUI_CD_1,
                    M_CDM045.BUNRUI_CD_2,
                    M_CDM045.BUNRUI_CD_3,
                    M_CDM025.BUNRUI_MEI
                FROM dbo.M_CDM045 AS M_CDM045
                INNER JOIN (
                    SELECT 
                        M_CDM025.BUNRUI_CD,
                        M_CDM025.BUNRUI_MEI
                    FROM dbo.M_CDM025 AS M_CDM025
                    WHERE M_CDM025.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
                    AND M_CDM025.BUNRUI_KBN = 3
                    AND M_CDM025.ITEM_1_CD = '$request->ITEM_CD_1'
                    AND M_CDM025.ITEM_2_CD = '$request->ITEM_CD_2'
                ) AS M_CDM025
                ON M_CDM025.BUNRUI_CD = M_CDM045.BUNRUI_CD_3
                WHERE M_CDM045.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
                AND M_CDM045.ITEM_CD_1 = '$request->ITEM_CD_1'
                AND M_CDM045.ITEM_CD_2 = '$request->ITEM_CD_2'
                AND M_CDM045.BUNRUI_CD_1 = $request->BUNRUI_CD_1
                AND M_CDM045.BUNRUI_CD_2 = $request->BUNRUI_CD_2
                ")
            );
        }

        public function getColor(Request $request){
            // return $request;
            return DB::connection('HRDAPPS31(shiyou_sentaku_main)')
            ->select(
                DB::raw(
                    "SELECT 
                        m_colors.id,
                        m_products.category_code,
                        m_products.main_items_code,
                        m_products.sub_items_code,
                        m_products.code AS product_code,
                        m_products.product_name,
                        m_products.maker_code,
                        m_products.color_code,
                        m_colors.color_name,
                        m_colors.image_path
                    FROM m_products
                        INNER JOIN (
                            SELECT 
                            m_colors.id,
                            m_colors.color_code,
                            m_colors.color_name,
                            m_colors.image_path
                        FROM m_colors
                        ) AS m_colors
                    ON m_colors.color_code = m_products.color_code
                    WHERE m_products.category_code = $request->category_code
                    AND m_products.main_items_code = '$request->main_items_code'
                    AND m_products.sub_items_code = '$request->sub_items_code'
                    AND m_products.code = '$request->product_code'
                ")
            );


            // return $request;
            // return DB::connection('HRDSQL6')
            // ->select(
            //     DB::raw(
            //         "SELECT DISTINCT
            //             M_CDM031.SHIYOSHO_KBN,
            //             M_CDM031.ITEM_CD_1,
            //             M_CDM031.ITEM_CD_2,
            //             M_CDM027.GOODS_CD,
            //             M_CDM027.GOODS_MEI,
            //             M_CDM027.MAKER_CD,
            //             M_CDM027.MAKER_MEI,
            //             SCT.Color,
            //             SCT.Img_path AS IMG_PATH
            //             --M_CDM027.SURYO_KANRI_KBN,
            //             --M_CDM027.LIMITED_KANRI_KBN,
            //             --M_CDM027.LIMITED_SURYO
            //         FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM031 AS M_CDM031
            //         INNER JOIN (
            //             SELECT
            //                 M_CDM027.SHIYOSHO_KBN,
            //                 M_CDM027.GOODS_CD,
            //                 M_CDM027.GOODS_MEI,
            //                 M_CDM027.MAKER_CD,
            //                 M_CDM002.MAKER_MEI,
            //                 M_CDM027.SURYO_KANRI_KBN,
            //                 M_CDM027.LIMITED_KANRI_KBN,
            //                 M_CDM027.LIMITED_SURYO
            //             FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM027 AS M_CDM027
            //             LEFT JOIN(
            //                 SELECT
            //                     M_CDM002.MAKER_CD,
            //                     M_CDM002.MAKER_MEI,
            //                     M_CDM002.PREPARED_DATE,
            //                     M_CDM002.RENEWAL_DATE,
            //                     M_CDM002.RENEWAL_ID
            //                 FROM HRDSQL8.ShiyoushoCommon_Test.dbo.M_CDM002 AS M_CDM002
            //             ) AS M_CDM002
            //             ON M_CDM027.MAKER_CD = M_CDM002.MAKER_CD
            //             WHERE M_CDM027.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //             AND M_CDM027.HAIBAN = 0
            //         ) AS M_CDM027
            //         ON M_CDM027.GOODS_CD = M_CDM031.GOODS_CD
            //         INNER JOIN (
            //             SELECT DISTINCT * FROM SD_SQL_TRAINING.Shiyousho_Catalog_Test.dbo.image_masters AS SCT
            //             WHERE SCT.Shiyousho_Kbn = $request->SHIYOSHO_KBN
            //             AND SCT.Item_cd_1 = '$request->ITEM_CD_1'
            //             AND SCT.Item_cd_2 = '$request->ITEM_CD_2'
            //         ) AS SCT
            //         ON SCT.Goods_cd COLLATE Japanese_CI_AS = M_CDM031.GOODS_CD COLLATE Japanese_CI_AS
            //         WHERE M_CDM031.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
            //         AND M_CDM027.GOODS_CD = $request->GOODS_CD
            //         AND M_CDM031.ITEM_CD_1 = '$request->ITEM_CD_1'
            //         AND M_CDM031.ITEM_CD_2 = '$request->ITEM_CD_2'
            //         AND M_CDM031.GOODS_CD NOT IN ('7777777', '7777778', '8888888', '9999999')
            //     ")
            // );
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * MAKER * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //
        // * * * * * * * * * * * * * * * * * * * * * * * * * //

        public function getMaker(Request $request){
            // return $request;
            $ITEM_1_CD = $request->ITEM_1_CD;
            $ITEM_2_CD = $request->ITEM_2_CD;

            // $maker = DB::connection('ShiyoushoCommon_Test')
            return DB::connection('HRDSQL7(ShiyoushoCommon)')
            ->select(
                DB::raw("SELECT DISTINCT
                    M_CDM031.SHIYOSHO_KBN,
                    M_CDM031.ITEM_CD_1,
                    M_CDM031.ITEM_CD_2,
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
                    INNER JOIN(
                        SELECT
                            M_CDM002.MAKER_CD,
                            M_CDM002.MAKER_MEI,
                            M_CDM002.PREPARED_DATE,
                            M_CDM002.RENEWAL_DATE,
                            M_CDM002.RENEWAL_ID
                        FROM dbo.M_CDM002 AS M_CDM002
                    ) AS M_CDM002
                    ON M_CDM027.MAKER_CD = M_CDM002.MAKER_CD
                    WHERE M_CDM027.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
                    AND M_CDM027.HAIBAN = 0
                ) AS M_CDM027
                ON M_CDM027.GOODS_CD = M_CDM031.GOODS_CD
                WHERE M_CDM031.SHIYOSHO_KBN = $request->SHIYOSHO_KBN
                AND M_CDM031.ITEM_CD_1 = '$ITEM_1_CD'
                AND M_CDM031.ITEM_CD_2 = '$ITEM_2_CD'
                AND M_CDM031.GOODS_CD NOT IN ('7777777', '7777778', '8888888', '9999999')
            ")
            );
        }

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    // * * * * * * * * * * *             NEW             * * * * * * * * * * * * * 
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

        public function getDataToilet()
        {
            // return DB::connection('HRDAPPS31(j_shiyou_sentaku_main)')
            return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
            ->table('cart')->get();
            
        }

        public function saveCart(Request $req)
        {
            // return DB::connection('HRDAPPS31(j_shiyou_sentaku_main)')
            return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
            ->table('cart')
            ->insert([
                "type" => $req[0]['type'],
                "image" => $req[0]['image'],
                "item" => $req[0]['item_name'],
                "product" => $req[0]['product_name'],
                // "color" => $req[0]['color'],
                // "color_img" => $req[0]['color_img'],
                "price" => $req[0]['price'],
                "description" => $req[0]['description'],
                "added_date" => date('Y-m-d H:i:s')
            ]);
        }

        public function getSubItems(){
            // return 'test';
            // return DB::connection('HRDAPPS31(j_shiyou_sentaku_main)')
            return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
            ->table('m_sub_items')
            ->where('main_items_code','0200')
            ->get();
        } 

        public function removeItem($id){ //back-end deletion
            
            // $id = DB::connection('HRDAPPS31(j_shiyou_sentaku_main)')
            $id = DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
            ->table('cart')
            ->where('id', $id)
            ->delete();
            return response()->json($id . ' ' . 'is successfully deleted');
        }

        public function getProducts(Request $request){
            // return DB::connection('HRDAPPS31(j_shiyou_sentaku_main)')
            return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
            ->select(
                DB::raw("SELECT 
                    m_sub_items.main_items_code,
                    m_sub_items.code,
                    m_sub_items.icon,
                    m_sub_items.item_name,
                    m_products.sub_items_code,
                    m_products.sub_items_code,
                    m_products.code,
                    m_products.product_name,
                    m_products.price,
                    m_products.maker_code,
                    m_products.color_code,
                    m_products.description,
                    m_products.image_path,
                    m_products.add_image
                from m_sub_items 
                inner join( 
                    SELECT 
                        m_products.sub_items_code,
                        m_products.code,
                        m_products.product_name,
                        m_products.price,
                        m_products.maker_code,
                        m_products.color_code,
                        m_products.description,
                        m_products.image_path,
                        m_products.add_image
                    from m_products
                    WHERE m_products.sub_items_code = '$request->code'
                ) AS m_products 
                on m_sub_items.code = m_products.sub_items_code 
                where m_sub_items.main_items_code = '0200'    
                and m_sub_items.code = '$request->code'")

            );
            // ->select(
            //     DB::raw("SELECT 
            //             m_sub_items.*, 
            //             m_products.*
            //         from m_sub_items 
            //     Inner join( 
            //         SELECT m_products.* 
            //         from m_products
            //     ) AS m_products 
            //     on m_sub_items.code = m_products.sub_items_code 
            // where m_sub_items.code = '$request->code'")
            // );
        }    

        // next up colors


        public function sampleOnly(){
            // return 'SAMPLE';
            return DB::connection('HRDAPPS31(shiyou_sentaku_main_test2)')
            ->table('m_sub_items')
            ->where('main_items_code','0200')
            ->get();
        }

}

