<template>
    <v-container fluid v-resize="onResize">
        <v-row no-gutter>
            <v-col >
                <v-btn rounded small outlined class="text-none mt-2" color="grey" to="/setsubi_master">
                    <v-icon>mdi-arrow-left-bold</v-icon>
                    <span>Back</span>
                </v-btn>
            </v-col>
            <v-col>
                <v-text-field hide-details outlined dense v-model="search" placeholder="Search . . ." append-icon="mdi-magnify" color="gray">
                </v-text-field>
            </v-col>
            <v-col>
                <v-tooltip left color="warning">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn fab  style="float: right; margin-bottom: 5px" outlined x-small class="text-none mt-2" color="primary" v-bind="attrs" v-on="on" @click="addProduct('ADD')">
                            <v-icon dark>mdi-plus</v-icon>
                        </v-btn>
                    </template>
                        <span>Add New</span>
                </v-tooltip>
            </v-col>
        </v-row>
        
        <v-row>
            <v-col>
                <!-- = Table = -->
                <v-data-table  hide-default-header :headers="headers" :items="mastersProductsData" :items-per-page="10" class="elevation-1" style="max-width: 100%;" :search="search">
                    <template v-slot:header="{ props: { headers } }">
                        <thead style="background-color: #1E88E5;">
                            <tr>
                                <th style="background-color: #4c7cc8; color: white; font-weight: normal"
                                v-for="(h, i) in headers" :key="i + 'a'" >
                                    <span class="header-text-color">{{h.text}}</span>
                                </th>
                            </tr>
                        </thead>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon color="primary" class="mr-2" @click="editItem(item)">
                            mdi-pencil-outline
                        </v-icon>
                        <v-icon color="error" @click="deleteItem(item)">
                            mdi-trash-can-outline
                        </v-icon>
                    </template>
                    <!-- <template v-slot:item.image="{ item }">
                        <div class="pt-2">
                            <img width="40px" @click="imageDialog(item)" :src="item.image" alt="alt">
                        </div>
                        <v-dialog v-model="imgDialog" width="330px" height="330px">
                            <v-card style="padding: 0;" class="align-items-end">
                                <v-img style="margin: 0; height: 350px; max-width: 330px;" :src="Dialogimg" hide-details alt=""/>
                            </v-card>
                        </v-dialog>
                    </template> -->
                </v-data-table>
            </v-col>
        </v-row>

        <v-dialog v-model="ProductDialog" max-width="20%" persistent>
            <v-card>
                <v-card-title style="background-color: #1E88E5; color: #ffffff;">
                        {{ action }} DATA
                    <v-spacer/>
                    <v-icon color="#ffffff" @click="closeProduct()">mdi-close</v-icon>
                </v-card-title>
                <v-card-text>
                    <br/>
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded readonly label="Category Code" v-model="ProductObj.category"></v-text-field> -->
                    <!-- <v-autocomplete style="margin-bottom: 10px;" hide-details @change="setSubItem2(ProductObj.mainCode)" :items="mainItem" item-text="item_name" item-value="main_code" outlined dense rounded  label="Main Items Code" v-model="ProductObj.mainCode"></v-autocomplete> -->
                    <!-- <v-autocomplete style="margin-bottom: 10px;" hide-details :items="subItem" item-text="item_name" item-value="code" outlined dense rounded  label="Sub Items" v-model="ProductObj.subCode"></v-autocomplete> -->
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Main Items Code" v-model="ProductObj.mainItem"></v-text-field>
                    <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Sub Items Code" v-model="ProductObj.subCode"></v-text-field> -->
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Code" v-model="ProductObj.code"></v-text-field> -->
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Product Name" v-model="ProductObj.itemName"></v-text-field> -->
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Maker Code" v-model="ProductObj.manufacturer_name"></v-text-field> -->
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Color Code" v-model="ProductObj.color_name"></v-text-field> -->
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded label="Image Path" v-model="ProductObj.imagePath"></v-text-field> -->
                    <!-- <v-file-input dense @change="Preview_image" v-model="ProductObj.imagePath">
                    </v-file-input> -->
                        <!-- <v-img :src="url"></v-img> -->
                </v-card-text>
                <v-card-actions>
                    <v-btn
                        @click="saveProducts()" block dense color="primary" style="height: 35px !important"
                    >
                        <v-icon>mdi-content-save</v-icon>
                        SAVE
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import axios from 'axios';
    export default {
        data: () => ({
            headers: [
                {
                    // text: 'カテゴリーコード', value: 'house_type_code', align: 'center', sortable: false 
                // },
                // { 
                    // text: 'カテゴリーコード', value: 'category_code', align: 'center', sortable: false 
                // },
                // { 
                    // text: '本体コード', value: 'main_items_code', align: 'center', sortable: false 
                // },
                // { 
                    // text: 'サブアイテムコード', value: 'sub_items_code', align: 'center', sortable: false 
                // },
                // { 
                    // text: 'コード', value: 'CODE', align: 'center', sortable: false 
                // },
                // { 
                    // text: '商品名', value: 'product_name', align: 'left', sortable: false 
                // },
                // { 
                    // text: 'メーカーコード', value: 'manufacturer_name', align: 'center', sortable: false 
                // },
                // { 
                    // text: 'カラーコード', value: 'color_name', align: 'center', sortable: false 
                // },
                // { 
                //     text: '画像パス', value: 'image_path', align: 'left', sortable: false 
                // },
                // { 
                    // text: '行動', value: 'actions', align: 'center', sortable: false 
                },
            ],
            
            search:'',
            ProductObj : {},
            action : '',
            image: null,
            ProductDialog : false,
            mastersProductsData : [],
            id: -1,
            mainItem : [],
            subItem: [],
            subItemTemp :[]
        }),

        computed: {
            //
        },

        watch : {
            //
        },

        created () {
            // this.getProducts();
        },

        methods: {
            ///////////////////////////////////////////////////////
            //    *   *   *   *   *           *   *   *   *   *  //
            ///////////////////////////////////////////////////////
            // setSubItem2(item){
            //     this.subitem = []
            //     let a = this.subItemTemp.filter(r=>{
            //         return r.main_items_code == item
            //     })
            //     this.subItem = a
            // },    
            // getProducts(){
            //     axios({
            //         method:'get',
            //         url:'api/masterMaintenance/getProducts',
            //     }).then((res)=>{
            //         this.mastersProductsData = res.data;
            //         axios({
            //             method:'get',
            //             url:'api/masterMaintenance/getSetsubiItem1',
            //         }).then((r)=>{
            //             this.mainItem = r.data;
            //             axios({
            //                 method:'get',
            //                 url:'api/masterMaintenance/getSubItem2',
            //             }).then((rec)=>{
            //                 this.subItemTemp = rec.data;
            //             })
            //         })
            //     })
            // },
            //    *   *   *   *   *      ADD     *   *   *   *   *  //
            addProduct() {
                // console.log(this.ProductObj,'hello world')
                this.ProductDialog = true
                this.ProductObj.category = 2
                this.ProductObj.mainCode = ''
                this.ProductObj.subCode  = ''
                this.ProductObj.code = ""
                this.ProductObj.itemName = ""
                this.ProductObj.manufacturer_name = ""
                this.ProductObj.color_name = ""
                this.ProductObj.imagePath = ""
                this.action = 'ADD NEW'
            },
            //    *   *   *   *   *      CLOSE     *   *   *   *   *  //
            closeProduct() {
                this.ProductObj = {}
                this.ProductDialog = false
            },
            Preview_image() {
                // 
            },

            saveProducts(){
                console.log('Productsssssssssssssss');

            },



            

            onResize() {
                this.windowSize = { x: window.innerWidth, y: window.innerHeight };
            },
        }
    }
</script>

<style scoped>
    .v-data-table ::v-deep th{
        font-size: 11px !important;
        background-color: #4c7cc8 !important;
        color: white !important;
        font-weight: normal;
        border: 1px solid rgba(199, 199, 199, 0.542);
        border: 1px solid rgba(199, 199, 199, 0.542);
        border-collapse: collapse;
        text-align: center !important;
    }
    .v-data-table ::v-deep td{
        border: 1px solid rgba(199, 199, 199, 0.542);
        border: 1px solid rgba(199, 199, 199, 0.542);
        border-collapse: collapse;
        font-size: 10.5px !important;
    }
    
</style>