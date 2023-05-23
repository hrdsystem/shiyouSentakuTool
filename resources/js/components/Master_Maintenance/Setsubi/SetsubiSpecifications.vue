<template>
    <v-container fluid v-resize="onResize">
        <v-row no-gutter>
            <v-col>
                <v-btn rounded small outlined class="text-none mt-2" color="grey" to="/setsubi_master">
                    <v-icon>mdi-arrow-left-bold</v-icon>
                    <span>Back</span>
                </v-btn>
            </v-col>
            <v-col>
                <v-text-field hide-details outlined dense v-model="search" placeholder="Search . . ."
                    append-icon="mdi-magnify" color="gray">
                </v-text-field>
            </v-col>
            <v-col>
                <v-tooltip left color="warning">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn fab style="float: right; margin-bottom: 5px" outlined x-small class="text-none mt-2"
                            color="primary" v-bind="attrs" v-on="on" @click="addProduct('ADD')">
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
                <v-data-table hide-default-header :headers="headers" :items="specifications" :items-per-page="10"
                    class="elevation-1" style="max-width: 100%;" :search="search">
                    <template v-slot:header="{ props: { headers } }">
                        <thead style="background-color: #1E88E5;">
                            <tr>
                                <th style="background-color: #4c7cc8; color: white; font-weight: normal"
                                    v-for="(h, i) in headers" :key="i + 'a'">
                                    <span class="header-text-color">{{ h.text }}</span>
                                </th>
                            </tr>
                        </thead>
                    </template>
                    <template v-slot:item.has_color="{ item }">
                        <v-checkbox hide-details dense :input-value="item.has_color == 0 ? false : true" readonly
                            v-model="item.has_color">
                        </v-checkbox>
                    </template>

                    <template v-slot:item.color_list="{ item }">
                        <v-btn hide-details dense :disabled="item.has_color == 0 ? true : false" icon>
                            <v-icon color="success">mdi-arrow-right</v-icon>
                        </v-btn>
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

        <v-dialog v-model="ProductDialog" width="500px" persistent>
            <v-card>
                <v-card-title style="background-color: #4c7cc8 !important; color: white !important;">
                    {{ action }} DATA
                    <v-spacer />
                    <v-icon color="#ffffff" @click="closeProduct()">mdi-close</v-icon>
                </v-card-title>
                <v-card-text>
                    <br />
                    <v-autocomplete style="margin-bottom: 10px;" hide-details :items="houseTypes" item-text="house_name"
                        item-value="code" outlined dense rounded label="House Type"
                        v-model="obj.house_type_code"></v-autocomplete>
                    <v-autocomplete @change="selectMainItem(obj.main_item_code)" style="margin-bottom: 10px;" hide-details
                        :items="mainItems" item-text="item_name" item-value="code" outlined dense rounded label="Main Item"
                        v-model="obj.main_item_code"></v-autocomplete>
                    <v-autocomplete style="margin-bottom: 10px;" hide-details :items="subItems" item-text="item_name"
                        item-value="code" outlined dense rounded label="Sub Item"
                        v-model="obj.sub_item_code"></v-autocomplete>
                    <v-autocomplete style="margin-bottom: 10px;" hide-details
                        :items="productItems" item-text="product_name" item-value="code" outlined dense rounded
                        label="Product" v-model="obj.product_code"></v-autocomplete>
                    <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded
                        label="Image Path" v-model="obj.img_path"></v-text-field>
                    <!-- <v-text-field style="margin-bottom: 10px;" hide-details outlined dense rounded readonly
                    label="Manufacturer" v-model="obj.maker"></v-text-field>
                    <v-row style="margin: 10px; margin-bottom: -10px;">
                        <v-simple-checkbox v-model="obj.has_color" dense hide-details readonly></v-simple-checkbox>
                        <span style="padding: 3px;">彼の色</span>
                    </v-row> -->

                </v-card-text>
                <v-card-actions>
                    <v-btn @click="saveSpecifications()" dark block dense
                        style="height: 35px !important; background-color: #4c7cc8 !important;">
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
                text: '住宅タイプコード', value: 'house_name', align: 'left', sortable: false
            },
            {
                text: '本体コード', value: 'main_item_name', align: 'center', sortable: false
            },
            {
                text: 'サブアイテムコード', value: 'sub_item_name', align: 'center', sortable: false
            },
            {
                text: 'コード', value: 'product_code', align: 'center', sortable: false
            },
            {
                text: '商品名', value: 'product_name', align: 'left', sortable: false
            },
            // {
            //     text: 'メーカーコード', value: 'manufacturer_name', align: 'left', sortable: false
            // },
            // {
            //     text: 'HAS COLOR', value: 'has_color', align: 'center', sortable: false
            // },
            // {
            //     text: '', value: 'color_list', align: 'center', sortable: false
            // },
            {
                text: '画像パス', value: 'image_path', align: 'left', sortable: false
            },
            {
                text: '行動', value: 'actions', align: 'center', sortable: false
            },
        ],

        search: '',
        obj: {},
        action: '',
        image: null,
        ProductDialog: false,
        specifications: [],
        id: -1,
        mainItem: [],
        subItem: [],
        subItemTemp: [],
        houseTypes: [],
        mainItems: [],
        subItems: [],
        productItems: [],
        selectedProduct: {},
    }),

    computed: {
        //
    },

    watch: {
        //
    },

    created() {
        axios({
            method: 'get',
            url: '/api/masterMaintenance/getSpecifications'
        }).then(res => {
            if (res.data.length > 0) {
                this.specifications = res.data
            }
        })

        axios({
            method: 'get',
            url: '/api/masterMaintenance/getHouseTypes'
        }).then(res => {
            this.houseTypes = res.data
        })

        axios({
            method: 'get',
            url: '/api/masterMaintenance/getMainItems'
        }).then(res => {
            this.mainItems = res.data
        })

        axios({
            method: 'get',
            url: '/api/masterMaintenance/getProductList'
        }).then(res => {
            this.productItems = res.data
        })
        // this.getProducts();
    },

    methods: {
        async selectMainItem(main_item_code) {
            await axios({
                method: 'post',
                url: '/api/masterMaintenance/getSubItems',
                data: { main_item_code: main_item_code }
            }).then(res => {
                this.subItems = res.data
            })
        },
        
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
        //         this.specifications = res.data;
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
            this.obj.house_type_code = ''
            this.obj.main_item_code = ''
            this.obj.sub_item_code = ''
            this.obj.product_code = ""
            // this.ProductObj.itemName = ""
            // this.ProductObj.manufacturer_name = ""
            // this.ProductObj.color_name = ""
            // this.ProductObj.imagePath = ""
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

        saveSpecifications() {
            console.log(this.obj);

        },





        onResize() {
            this.windowSize = { x: window.innerWidth, y: window.innerHeight };
        },
    }
}
</script>

<style scoped>
.v-data-table ::v-deep th {
    font-size: 11px !important;
    background-color: #4c7cc8 !important;
    color: white !important;
    font-weight: normal;
    border: 1px solid rgba(199, 199, 199, 0.542);
    border: 1px solid rgba(199, 199, 199, 0.542);
    border-collapse: collapse;
    text-align: center !important;
}

.v-data-table ::v-deep td {
    border: 1px solid rgba(199, 199, 199, 0.542);
    border: 1px solid rgba(199, 199, 199, 0.542);
    border-collapse: collapse;
    font-size: 10.5px !important;
}
</style>