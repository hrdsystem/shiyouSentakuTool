<template>
    <div>
        <center>
            <v-overlay :value="loading" color="white">
                <v-progress-circular color="#74b1ed" indeterminate size="100" width="10" >
                <!-- <v-progress-circular color="black" indeterminate size="100" width="10" > -->
                    <v-row class="d-flex align-center">
                        <!-- <span class="blink" style="font-size: 10px;">Extracting <br> Data</span> -->
                        <h1 class="blink" style="font-size: 10px; color: black;">LOADING<br>DATA</h1>
                        <!-- <h1 class="blink" style="font-size: 10px; color: red;">Loading</h1> -->
                    </v-row>
                    <!-- <v-row class="d-flex align-center">
                        <h1 class="blink" style="font-size: 10px; color: black;">Data</h1>
                    </v-row> -->
                    <!-- <v-row class="d-flex align-center">
                        <h1 class="blink">.</h1><h1 class="blink1">.</h1><h1 class="blink2">.</h1>
                    </v-row> -->
                </v-progress-circular>
            </v-overlay> 
        </center>

        <v-data-table hide-default-header :headers="headers" :items="crudData" class="elevation-1" :search="search">
        <!-- <v-data-table :headers="headers" :items="crudData" sort-by="Shiyousho_Kbn" class="elevation-1" :search="search"> -->
        <!-- items-per-page="15" -->
            <template v-slot:header="{ props: { headers } }">
                <thead style="background-color: #1E88E5;">
                    <tr>
                        <th v-for="h in headers" >
                            <span class="header-text-color">{{h.text}}</span>
                        </th>
                    </tr>
                </thead>
            </template>
            <template v-slot:top>
                <!-- <v-toolbar flat> -->
                    <!-- <v-toolbar-title>Sample Crud</v-toolbar-title> -->
                    <!-- <v-text-field outlined dense label="Search" v-model="search"></v-text-field> -->
                    <v-row>
                        <v-col cols="4"></v-col>
                        <v-col cols="4">
                        </v-col>
                        <v-col cols="4">
                            <v-toolbar flat>
                                <v-text-field hide-details outlined dense label="Search" prepend-inner-icon="mdi-magnify" v-model="search"></v-text-field>
                                <v-tooltip left color="warning">
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn
                                            elevation-10 class="mx-2" fab x-small color="info" @click="addDialog('ADD')"
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            <v-icon dark>mdi-plus</v-icon>
                                        </v-btn>
                                    </template>
                                        <span>Add New</span>
                                </v-tooltip>

                                <!-- <v-dialog v-model="dialog" max-width="500px" persistent>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn elevation-10 class="mx-2" fab x-small color="info" @click="addDialog('ADD')"><v-icon dark>mdi-plus</v-icon></v-btn>
                                    </template>
                                </v-dialog> -->
                            </v-toolbar>
                        </v-col>
                    </v-row>
                <!-- </v-toolbar> -->
            </template>

            <template v-slot:item.actions="{ item }">
                <v-icon color="primary" small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon color="error" small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>

            <template v-slot:item.image="{ item }">
                <div class="pt-2">
                    <img width="40px" @click="imageDialog(item)" :src="item.image" alt="alt">
                </div>
                <v-dialog v-model="imgDialog" width="330px" height="330px">
                    <v-card style="padding: 0;" class="align-items-end">
                        <v-img style="margin: 0; height: 350px; max-width: 330px;" :src="Dialogimg" hide-details alt=""/>
                    </v-card>
                </v-dialog>
            </template>
        </v-data-table>

        <v-layout row justify-center>
            <v-dialog v-model="dialog" persistent max-width="800px">
                <v-card style="border:1px solid #42A5F5;">
                    <v-toolbar flat style="background-color: #42A5F5; border-radius: 0;" dark class="headline">
                        <span>{{ action }} DATA</span>
                        <v-spacer></v-spacer>
                        <v-btn icon @click="closeDialog()">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar>
                    <v-card-text>
                        <div class="pa-4">

                            <v-autocomplete outlined label="Category" :items="categoryItems" item-text="CATEGORY_NAME" return-value 
                            :disabled="disableITEMS()" v-model="category" item-value= "Shiyousho_Kbn" @change="selectCategory(category)"></v-autocomplete>

                            <v-autocomplete outlined label="Item 1" :items="item1Items" item-text="ITEM_1_MEI" return-value v-model="item1"
                            :disabled="disableITEMS()"  item-value= "ITEM_CD_1" @change="selectItem1(item1)"></v-autocomplete>

                            <v-autocomplete outlined label="Item 2" :items="item2Items" item-text="ITEM_2_MEI" return-value v-model="item2"
                            :disabled="disableITEMS()"  item-value= "ITEM_2_CD" @change="selectItem2(item2)"></v-autocomplete>

                            <v-autocomplete outlined label="Product" :items="productItems" item-text="GOODS_MEI" return-value v-model="product" item-value= "GOODS_CD" @change="selectProduct(product)"></v-autocomplete>

                            <v-autocomplete outlined label="Color" :items="colorItems" item-text="COLOR" return-value v-model="color" @change="setColor(color)"></v-autocomplete>

                            <v-file-input  @change="Preview_image" v-model="image"></v-file-input>
                            <v-img :src="url"></v-img>

                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="error"  @click="close()">Cancel</v-btn>
                        <v-btn color="primary" @click=" saveFunction()">Save</v-btn>
                        <!-- <v-btn color="primary" @click=" updateData()">Save</v-btn> -->
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    import axios from 'axios'
    import { getCategory, getItem2, getProducts, getColors } from './js'
    export default {
        data() {
            return {
                productId : null, // ken
                saveEdit : {},
                crudArr: [],
                search:'',
                crudData : [],

                url: null,
                image: null,

                //dialog
                dialog : false,
                editDialog : false,
                dialogDelete: false,
                imgDialog : false,

                Dialogimg : '',
                action : '',

                addEdit: {},
                loading: false,

                headers: [
                    { 
                        text: 'CATEGORY', value: 'Category_Type', align: 'left', sortable: false 
                    },
                    { 
                        text: 'ITEM_1', value: 'ITEM_1_MEI', align: 'left', sortable: false 
                    },
                    { 
                        text: 'ITEM_2', value: 'ITEM_2_MEI', align: 'left', sortable: false 
                    },
                    { 
                        text: 'PRODUCT', value: 'GOODS_MEI', sortable: false 
                    },
                    { 
                        text: 'COLOR', value: 'Color', align: 'left', sortable: false 
                    },
                    { 
                        text: 'DIRECTORY', value: 'Img_Path', align: 'left', sortable: false 
                    },
                    { 
                        text: 'ACTIONS', value: 'actions', align: 'left', sortable: false 
                    },
                ],

                editedIndex: -1,
                editedItem: {
                    id: '',
                    Shiyousho_Kbn: 0,
                    Item_cd_1: 0,
                    Item_cd_2: 0,
                    Goods_cd: 0,
                    Color: 0,
                    Img_Path: 0,
                },
                editData:[],

                //arrays
                categoryItems: [
                    {
                        Shiyousho_Kbn : '1',
                        CATEGORY_NAME : '外部',
                    }, 
                    {
                        Shiyousho_Kbn : '2',
                        CATEGORY_NAME : '設備',
                    }, 
                    {
                        Shiyousho_Kbn : '3',
                        CATEGORY_NAME : '内部',
                    }, 
                ],

                // For Front and method(axios)
                item1Items: [],
                item2Items: [],
                productItems: [],
                colorItems: [],

                //For Fields
                category : {},
                item1 : {},
                item2 : {},
                product : {},
                color : {},
            }
        },
        
        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
            
        },

        watch: {
            dialog (val) {
                val || this.close()
            },
            dialogDelete (val) {
                val || this.closeDelete()
            },
        },

        created () {
            this.initialize()
            this.getData()
        },

        methods: {
            //        *     *     *      DISSABLED     *     *     *        //
            disableITEMS(item){
                if(this.action == "EDIT"){
                    return true
                }else{
                    return false
                }
            },

            initialize () {
                // dataGathered: []
            },

            imageDialog(item){
                this.imgDialog = true
                this.Dialogimg = item.image
            },

            //        *     *     *      ADD   *     *     *        //
            addDialog(action){
                this.category = ""
                this.item1 = ""
                this.item2 = ""
                this.product = ""
                this.color = ""
                this.dialog = true
                this.action = 'ADD NEW'
            },

            closeDialog(){
                this.dialog = false
            },
            closeEditDialog(){
                this.dialog = false
            },

            Preview_image() {
                // this.url= URL.createObjectURL(this.image)
                
            },

            //        *     *     *    * FUNCTION *   *     *     *        //
            getData(){
                this.loading = true,
                axios({
                    method: 'post',
                    url: 'api/masterMaintenance/getData'
                }).then((res) =>{
                    this.crudData = res.data
                    this.loading = false
                    // console.log(res.data,'getData')
                })
            },

            //        *     *     *    * For autocomplete *   *     *     *        //
            selectCategory(category){
                this.item1 = ''
                this.item2 = ''
                this.product = ''
                this.color = ''
                axios({
                    method : 'post',
                    url : 'api/masterMaintenance/getItem1',
                    data : {Shiyousho_Kbn : category}
                }).then( ({data}) => {
                    console.log(data,'selectCategory')
                    this.item1Items = data
                }).catch( ({message}) => {
                    console.log(message, 'selectCategory_message')
                })
            },

            selectItem1(item1){
                this.item2 = ''
                this.product = ''
                this.color = ''
                let obj = {
                    SHIYOSHO_KBN : this.category,
                    ITEM_CD_1  : item1
                }
                axios({
                    method : 'post',
                    url : 'api/masterMaintenance/getItem2',
                    data : obj
                }).then( ({data}) => {
                    console.log(data,'selectItem1')
                    this.item2Items = data //TO Front End
                }).catch( ({message}) => {
                    console.log(message,'selectItem1_message')
                })
            },

            selectItem2(item2){
                this.product = ''
                this.color = ''
                let obj = {
                    ITEM_1_CD : this.item1,
                    ITEM_2_CD : item2,
                    SHIYOSHO_KBN : this.category
                }
                axios({
                    method : 'post',
                    url : 'api/masterMaintenance/products',
                    data : obj
                    // data: item2 gats
                }).then( ({data}) => {
                    console.log(data,'selectItem2')
                    this.productItems = data
                }).catch( ({message}) => {
                    console.log(message,'selectItem2_message')
                })
            },

            selectProduct(product){
                this.color = ''
                this.saveEdit.Goods_cd = product
                let kbn = ""
                if(this.action == "ADD NEW"){
                    kbn = this.category
                }else{
                    kbn = this.category.Shiyousho_Kbn
                }
                let obj = {
                    SHIYOSHO_KBN :kbn,
                    GOODS_CD : product
                }
                axios({
                    method : 'post',
                    url : 'api/masterMaintenance/colors',
                    data : obj
                }).then( ({data}) => {
                    console.log(data,'selectProduct')
                    if(data.length != 0){
                        this.colorItems = data
                    }else{
                        this.colorItems = data
                        this.saveEdit.Color = ""
                    }
                }).catch( ({message}) => {
                    console.log(message,'selectProduct_message')
                })
            },

            setColor(item){
                console.log(item,'setColor')
                this.saveEdit.Color = item
            },


            // LITS
            async editItem (item) {
                this.loading = true,
                this.action = 'EDIT',
                this.addEdit = item
                let index = this.categoryItems.findIndex(rec=> rec.Shiyousho_Kbn == item.Shiyousho_Kbn)
                    if(index != -1){
                        this.category = Object.assign({},this.categoryItems[index])
                        this.item1Items = await getCategory(this.category)
                            this.item1 = await this.item1Items.filter(rec=> rec.ITEM_CD_1 == item.Item_cd_1)[0]
                            this.item2Items = await getItem2(this.item1)
                            this.item2 = await this.item2Items.filter(rec=> rec.ITEM_2_CD == item.Item_cd_2)[0]
                            this.productItems = await getProducts(this.item2)
                        if(this.productItems.length > 0){
                            let temp =  await this.productItems.filter(rec=> rec.GOODS_CD == item.Goods_cd)
                            if(temp.length > 0){
                                this.product = temp[0]
                                this.colorItems = await getColors(this.product)
                                if(this.colorItems.length > 0){
                                    this.color = await this.colorItems.filter(rec=> rec.COLOR == item.Color)[0]
                                }
                            }
                        }

                        this.productId = item.id
                        this.saveEdit.Shiyousho_Kbn = item.Shiyousho_Kbn
                        this.saveEdit.Item_cd_1 = item.Item_cd_1
                        this.saveEdit.Item_cd_2 = item.Item_cd_2
                        this.saveEdit.Color = item.Color
                        this.saveEdit.Img_Path = item.Img_Path
                        this.saveEdit.Goods_cd = item.Goods_cd
                        this.saveEdit.action = "edit"
                        
                    }
                this.loading = false,
                this.dialog = true
            },


            saveFunction(){
                this.loading = true,
                this.close()
                let data = {}

                if(this.action == "ADD NEW"){
                    data = {
                        action : this.action,
                        Shiyousho_Kbn: this.category,
                        Item_cd_1: this.item1,
                        Item_cd_2: this.item2,
                        Goods_cd: this.product,
                        Color: this.color ?  this.color : '',
                        Img_Path: null,
                    }
                    
                }else{
                    data =  Object.assign({},this.saveEdit)
                    data.productId = this.productId
                    console.log(data,'saveFunction')
                }

                axios({
                    method : 'post',
                    url: 'api/masterMaintenance/updateData',
                    data: data
                }).then(res=>{
                    this.getData()
                    if(res.data == 'Existing'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Item Already Existing!',
                            footer: 'Click OK to continue!'
                        })
                        // Swal.fire({
                        //     toast:true,
                        //     position: 'center',
                        //     icon: 'error',
                        //     title:"<h2 style='color:white'>" + "Existing Item" + "</h2>",
                        //     // title: 'Existing Item',
                        //     showConfirmButton: false,
                        //     iconColor: 'white',
                        //     background: "#f27474",
                        //     timer: 3000
                            
                        // })
                    }else if(res.data == 'EDITED'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Updated',
                            footer: 'Click OK to continue!'
                        })
                        // Swal.fire({
                        //     toast:true,
                        //     position: 'center',
                        //     icon: 'success',
                        //     title:"<h2 style='color:white'>" + "Item Updated" + "</h2>",
                        //     showConfirmButton: false,
                        //     iconColor: 'white',
                        //     background: '#4c73fe',
                        //     timer: 3000
                        // })
                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Saved',
                            footer: 'Click OK to continue!'
                        })
                    //     Swal.fire({
                    //         toast:true,
                    //         position: 'center',
                    //         icon: 'success',
                    //         title:"<h2 style='color:white'>" + "Successfully Added" + "</h2>",
                    //         showConfirmButton: false,
                    //         iconColor: 'white',
                    //         background: "#a5dc86",
                    //         timer: 3000
                    //     })
                    }
                })
                this.loading = false
            },


            close () {
                this.dialog = false
                this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                })
            },


            deleteItem (item) {
                Swal.fire({
                    title: `Do you want to delete this Item?`,
                    icon: 'warning',
                    allowOutsideClick: false,
                    showDenyButton: true,
                    confirmButtonColor: '#3085d6',
                    denyButtonColor: '#d33',
                    confirmButtonText: 'Yes! Delete it.',
                    denyButtonText: 'No',
                    width: 400,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                            // method : 'get',
                            method : 'post',
                            url: 'api/masterMaintenance/deleteData',
                            data: item
                        }).then(res=>{
                            Swal.fire({
                                icon: 'success',
                                title: 'Item has been Deleted!',
                                footer: 'Click OK to continue!'
                            })
                            this.getData();
                        })

                    }else if (result.isDenied) {
                        Swal.fire('Item not deleted!', '', 'info')
                    }
                })
            },


        }
    }
</script>


<style   scoped>
    .blink {
        animation: blink 2s infinite alternate;
    }
    .blink1 {
        animation: blink 3s infinite alternate;
    }
    .blink2 {
        animation: blink 4s infinite alternate;
    }
    @keyframes blink {
        50% {
            opacity: 0; 
        }
    }

    .colored-toast.swal2-icon-success {
        background-color: #a5dc86 !important;
    }

    .colored-toast.swal2-icon-error {
        background-color: #f27474 !important;
    }

    .header-text-color{
        color: white;
    }
</style>
