<template>
    <div>
    <v-container fluid v-resize="onResize">
        <v-row>
            <v-col>
                <v-btn rounded small outlined class="text-none mt-2" color="grey" to="/setsubi_master">
                    <v-icon>mdi-arrow-left-bold</v-icon>
                    <span>Back</span>
                </v-btn>
            </v-col>
        </v-row>
        <v-row>
            <!-- = 1st Table = -->
            <v-col>
                <v-row>
                    <v-col>
                        <v-toolbar flat>
                            <v-spacer/>
                            <v-tooltip left color="warning">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn fab  style="float: right; margin-bottom: 5px" outlined x-small class="text-none mt-2" color="primary" v-bind="attrs" v-on="on" @click="addItem1('ADD')"
                                    >
                                        <v-icon dark>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                    <span>Add New</span>
                            </v-tooltip>
                        </v-toolbar>
                    </v-col>
                </v-row>

                <v-data-table  hide-default-header :headers="headers" :items="mastersData" :items-per-page="15" class="elevation-1" @dblclick:row="($event, {item})=>getItem2(item)">
                    <template v-slot:header="{ props: { headers } }">
                        <thead style="background-color: #1E88E5;">
                            <tr>
                                <th style="background-color: #4c7cc8; color: white; font-weight: normal"
                                id="border" v-for="h in headers" >
                                    <span class="header-text-color">{{h.text}}</span>
                                </th>
                            </tr>
                        </thead>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon color="primary" class="mr-2" @click="editItem1(item)">
                            mdi-pencil
                        </v-icon>
                        <v-icon color="error" @click="deleteItem(item)">
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
            </v-col>

            <!-- = Sub Table = -->
            <v-col>
                <v-row>
                    <v-col>
                        <v-toolbar flat>
                            <v-spacer/>
                            <v-tooltip left color="warning">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn fab :disabled="disabledItem2btn" style="float: right; margin-bottom: 5px" outlined x-small class="text-none mt-2" color="primary" v-bind="attrs" v-on="on" @click="openDialogItem2('ADD')"
                                    >
                                        <v-icon dark>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                    <span>Add New</span>
                            </v-tooltip>
                        </v-toolbar>
                    </v-col>
                </v-row>

                <v-data-table  hide-default-header :headers="subheaders" :items="mastersSubData" class="elevation-1" >
                    <template v-slot:header="{ props: { headers } }">
                        <thead style="background-color: #1E88E5;">
                            <tr>
                                <th style="background-color: #4c7cc8; color: white; font-weight: normal"
                                id="border" v-for="h in headers" >
                                    <span class="header-text-color">{{h.text}}</span>
                                </th>
                            </tr>
                        </thead>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon color="primary" class="mr-2" @click="editItem2(item)">
                            mdi-pencil
                        </v-icon>
                        <v-icon color="error" @click="deleteItem(item)">
                            mdi-delete
                        </v-icon>
                    </template>
                    <template v-slot:item.image="{ item }">
                        <div class="pt-2">
                            <img width="40px" @click="imageDialog(item)" :src="item.image" alt="alt">
                        </div>
                    </template>
                </v-data-table>
            </v-col>
        </v-row>

        <!-- DIALOG FOR ADD AND EDIT -->
        <!-- <v-dialog v-model="item1Dialog " max-width="20%" persistent>
                <v-card>
                    <v-card-title style="background-color: #1E88E5; color: #ffffff;">{{ action }} DATA
                    <v-spacer/>
                    <v-icon color="#ffffff" @click="close()">mdi-close</v-icon>
                    </v-card-title>
                    <v-card-text>
                        <br/>
                        <v-text-field outlined dense rounded label="Category" v-model="category"></v-text-field>
                        <v-text-field outlined dense rounded label="Code" v-model="code"></v-text-field>
                        <v-text-field outlined dense rounded label="Item Name" v-model="itemName"></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                    <v-btn
                        @click="saveItem1()" block dense color="primary" style="height: 35px !important"
                    >
                        <v-icon>mdi-content-save</v-icon>
                        SAVE
                    </v-btn>
                    </v-card-actions>
                </v-card>
        </v-dialog> -->
    </v-container>
    <item1
    :dialog="item1Dialog"></item1>
</div>
</template>

<script>
    import Swal from "sweetalert2";
    import axios from 'axios'
    import item1 from '../Dialog/Item1Dialog.vue'

    export default {
        components : {item1},
        data: () => ({
            headers: [              
                { 
                    text: 'カテゴリーコード', value: 'category_code', align: 'center', sortable: false 
                },
                { 
                    text: 'コード', value: 'CODE', align: 'center', sortable: false 
                },
                { 
                    text: '項目名', value: 'item_name', align: 'centered', sortable: false 
                },
                { 
                    text: '行動', value: 'actions', align: 'center', sortable: false 
                },
            ],
            subheaders: [              
                { 
                    text: 'カテゴリーコード', value: 'category_code', align: 'center', sortable: false 
                },
                { 
                    text: '本体コード', value: 'main_items_code', align: 'center', sortable: false 
                },
                { 
                    text: 'コード', value: 'sub_item_code', align: 'center', sortable: false 
                },
                { 
                    text: 'サブアイテム名', value: 'sub_item_name', align: 'centered', sortable: false 
                },
                { 
                    text: '行動', value: 'actions', align: 'center', sortable: false 
                },
            ],

            
            itemName:null,
            code:null,
            category:null,
            disabledItem2btn: true,
            windowSize: { x: 0, y: 0 },

            addEdit: {},
            item1Dialog : false,
            mastersData: [],
            action: '',

            // DIALOGS
            dialogDelete: false,

            mastersSubData: [],
            editedIndex: -1,
            editedItem: {
                id: '',
                CODE: 0,
                category_code: 0,
                item_name: 0,
            },
            editData:[],
        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
        },

        watch: {
            item1Dialog  (val) {
                val || this.close()
            },
            // dialogDelete (val) {
            //     val || this.closeDelete()
            // },
        },

        created () {
            this.getItem1();
        },

        methods: {

            close() {
                this.item1Dialog  = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            addItem1(action) {
                this.item1Dialog = true
                this.category = ""
                this.code = ""
                this.itemName = ""
                // this.item1Dialog  = true
                this.action = 'ADD NEW'
            },
            closeDialogItem1( val ){
                this.getItem1();
                this.item1Dialog  = val;
            },
            closeEditDialog1(){
                this.category = ""
                this.code = ""
                this.itemName = ""
                this.item1Dialog  = false
                this.action = 'EDIT'
            },


            editItem1(item){
                this.action = 'EDIT'
                this.item1Dialog  = true
            },
            


            saveItem1(){
                this.close()
                let data = {}
                if(this.action == "ADD NEW"){
                    data = {
                        action : this.action,
                        category_code: this.category,
                        CODE: this.code,
                        item_name: this.itemName
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
                    // {
                    //     category_code:this.category,
                    //     CODE:this.code,
                    //     item_name:this.itemName,
                    //     action:this.action
                    // }
                }).then(res=>{
                    this.getItem1()
                    console.log(res.data,'saveItem1...')
                    if(res.data == 'Existing'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Item is Already Existing!',
                            footer: 'Click OK to continue!'
                        })
                    }else if(res.data == 'EDITED'){
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Updated',
                            footer: 'Click OK to continue!'
                        })
                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Saved',
                            footer: 'Click OK to continue!'
                        })
                    }
                })
            },



            openDialogItem2() {
                //
            },

            getItem1(){
                axios({
                    method:'get',
                    url:'api/masterMaintenance/getItem1',
                }).then((res)=>{
                    this.mastersData = res.data;
                    console.log(res.data, 'getItem1...')
                })
            },

            getItem2(item){
                this.disabledItem2btn = false;

                axios({
                    method:'post',
                    url:'api/masterMaintenance/getItem2',
                    data:{main_items_code:item.CODE}
                }).then((res)=>{
                    this.mastersSubData = res.data;
                    console.log(res.data );
                })
            },

            onResize() {
                this.windowSize = { x: window.innerWidth, y: window.innerHeight };
            },
        },
    }
</script>

<style scoped>
    .processTable >>> thead th {
        /* padding: 3px;
        position: sticky;
        top: 0;
        z-index: 1;
        width: 13vw;
        font-family:sans-serif;
        border-top: 0.5px solid #e0e0e0;
        border-left: 0.5px solid #e0e0e0;
        border-right: 0.5px solid #e0e0e0;
        border-bottom: 0.5px solid #e0e0e0; */
        /* border: 0.5px solid black; */
    }

    .processTable >>> tbody td {
        /* border: 0.5px solid black; */
        /* font-size: 12px;
        font-family: arial;
        height: 4px;
        padding: 5px;
        border-left: 0.5px solid #e0e0e0;
        border-right: 0.5px solid #e0e0e0;
        border-bottom: 0.5px solid #e0e0e0; */
        /* font-family:sans-serif; */
    }

    #border {
        border: 1px solid rgba(199, 199, 199, 0.542);
        border: 1px solid rgba(199, 199, 199, 0.542);
    }
    th {
        text-align: center !important;
        padding: 0 !important;
        font-size: 13px !important;
    }
    td {
        font-size: 13px !important;
        padding: 3px !important;
        border: 1px solid rgba(199, 199, 199, 0.542);
        border: 1px solid rgba(199, 199, 199, 0.542);
    }

</style>