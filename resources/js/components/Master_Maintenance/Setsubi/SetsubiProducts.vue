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
                <v-data-table hide-default-header :headers="headers" :items="productItems" :items-per-page="10"
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
                        <v-icon color="primary" class="mr-2" @click="editProducts(item)">
                            mdi-pencil-outline
                        </v-icon>
                        <v-icon color="error" @click="deleteItem(item)">
                            mdi-trash-can-outline
                        </v-icon>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <v-dialog v-model="ProductDialog" width="500px" persistent>
            <v-card>
                <v-card-title style="background-color: #4c7cc8 !important; color: white !important;">
                    {{ obj.action }} DATA
                    <v-spacer />
                    <v-icon color="#ffffff" @click="closeProduct()">mdi-close</v-icon>
                </v-card-title>
                <v-card-text>
                    <br />
                    <v-text-field :error-messages="checkProductCodeIfExist" @input="test()" type="number" outlined dense rounded
                        label="Code" v-model="obj.code"></v-text-field>

                    <v-text-field outlined dense rounded
                        label="Product Name" v-model="obj.product_name"></v-text-field>

                    <v-select 
                        :items="manufacturers" item-text="manufacturer_name" item-value="code" outlined dense rounded label="Manufacturer" v-model="obj.manufacture_code"></v-select>

                    <v-text-field  outlined dense rounded
                        label="Image Path" v-model="obj.image_path"></v-text-field>
                    
                    <v-row style="margin: 10px; margin-bottom: -10px; margin-top: -10px;">
                        <v-simple-checkbox v-model="obj.has_color" dense  readonly></v-simple-checkbox>
                        <span style="padding: 3px;">彼の色</span>
                    </v-row>

                </v-card-text>
                <v-card-actions>
                    <v-btn @click="save()" dark block dense :disabled="validateFields"
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
import Swal from "sweetalert2";
import axios from 'axios';
import {orderBy} from 'lodash';
export default {
    data: () => ({
        headers: [
            {
                text: 'コード', value: 'code', align: 'center', sortable: false
            },
            {
                text: '商品名', value: 'product_name', align: 'left', sortable: false
            },
            {
                text: 'メーカーコード', value: 'manufacturer_name', align: 'left', sortable: false
            },
            {
                text: 'HAS COLOR', value: 'has_color', align: 'center', sortable: false
            },
            {
                text: '', value: 'color_list', align: 'center', sortable: false
            },
            {
                text: '画像パス', value: 'image_path', align: 'left', sortable: false
            },
            {
                text: '行動', value: 'actions', align: 'center', sortable: false
            },
        ],

        search: '',
        obj: {
            action : ''
        },
        image: null,
        ProductDialog: false,
        specifications: [],
        id: -1,
        productItems: [],
        manufacturers:[],
        selectedProduct: {},
    }),

    computed: {
        checkProductCodeIfExist(){
            let data = this.productItems.filter(r=> {
                return r.code == this.obj.code
            } )
            if(data.length > 0){
                return 'Code Already Exist'
            }else{
                return ''
            }
        },

        validateFields(){
            if(this.checkProductCodeIfExist == 'Code Already Exist' || 
            !this.obj.code || !this.obj.product_name){
                return true
            }
        }
    },

    watch: {
        //
    },

    created() {
        this.getProductList()


    },

    methods: {
        ///////////////////////////////////////////////////////
        //    *   *   *   *   *           *   *   *   *   *  //
        ///////////////////////////////////////////////////////
        test(){
            this.obj = {...this.obj}
        },

        getProductList(){
            axios({
                method: 'get',
                url: '/api/masterMaintenance/getProductList'
            }).then(res => {
                this.productItems = res.data
                console.log(res.data,'getProductList');
            })

            axios({
                method: 'get',
                url: '/api/masterMaintenance/getManufacturers'
            }).then(res => {
                this.manufacturers = res.data
                console.log(res.data,'getManufacturers');
            })
        },



        //    *   *   *   *   *      ADD     *   *   *   *   *  //
        addProduct() {
            // console.log(this.ProductObj,'hello world')
            this.ProductDialog = true
            this.obj.code = ''
            this.obj.product_name = ''
            this.obj.manufacture_code = ''
            this.obj.image_path = ''
            this.obj.action = 'ADD NEW'
        },
        //    *   *   *   *   *      CLOSE     *   *   *   *   *  //
        closeProduct() {
            this.obj = {}
            this.ProductDialog = false
        },
        //    *   *   *   *   *      CLOSE     *   *   *   *   *  //
        editProducts() {
            // this.id = item.id
            // this.item1Dialog = true
            // this.action = 'EDIT'
            // this.item1Obj1.category = item.category_code
            // this.item1Obj1.code = item.main_code
            // this.item1Obj1.itemName = item.item_name
        },
        
        Preview_image() {
            // 
        },

        save() {
            if(this.obj.action == "ADD NEW"){
                axios({
                    method : 'post',
                    url : '/api/masterMaintenance/saveProduct',
                    data : this.obj
                }).then(res => {
                    this.obj.manufacturer_name = this.manufacturers.find(r => r.code == this.obj.manufacture_code).manufacturer_name 
                        console.log(this.obj,'Save');
                    this.productItems.push(this.obj)
                    this.productItems = orderBy(this.productItems,['code','asc'])
                        // console.log(this.obj);
                    Swal.fire({
                        showConfirmButton:false,
                        icon: 'success',
                        title: 'Successfully Saved!',
                        timer: 2000,
                    })
                        // this.getProductList()
                        this.closeProduct()
                })
            }
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