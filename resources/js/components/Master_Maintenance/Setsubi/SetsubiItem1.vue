<template>
    <v-container fluid v-resize="onResize">
        <v-row>
            <v-col>
                <v-btn 
                    rounded 
                    small 
                    outlined 
                    class="text-none mt-2" 
                    color="grey" 
                    to="/setsubi_master"
                >
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
                                    <v-btn 
                                        fab  
                                        style="
                                            float: right; 
                                            margin-bottom: 5px"
                                        outlined 
                                        x-small 
                                        class="text-none mt-2" 
                                        color="primary" 
                                        v-bind="attrs" 
                                        v-on="on" 
                                        @click="addItem1('ADD')"
                                    >
                                        <v-icon dark>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                    <span>Add New</span>
                            </v-tooltip>
                        </v-toolbar>
                    </v-col>
                </v-row>

                <v-data-table  
                    hide-default-header
                    :headers="headers" 
                    :items="mastersData" 
                    :items-per-page="15" 
                    class="elevation-1" 
                    @dblclick:row="($event, {item})=>getItem2(item)"
                >
                    <template v-slot:header="{ props: { headers } }">
                        <thead style="background-color: #1E88E5;">
                            <tr>
                                <th 
                                    style="
                                        background-color: #4c7cc8; 
                                        color: white; 
                                        font-weight: normal
                                    "
                                    id="border" 
                                    v-for="h in headers" 
                                >
                                    <span class="header-text-color">{{h.text}}</span>
                                </th>
                            </tr>
                        </thead>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon color="primary" class="mr-2" @click="editItem1(item.id)">
                            mdi-pencil
                        </v-icon>
                        <v-icon disabled color="error" @click="deleteItem1(item)">
                            mdi-delete
                        </v-icon>
                    </template>
                    <template v-slot:item.image="{ item }">
                        <div class="pt-2">
                            <img width="40px" @click="imageDialog(item)" :src="item.image" alt="alt">
                        </div>
                        <v-dialog v-model="imgDialog" width="330px" height="330px">
                            <v-card style="padding: 0;" class="align-items-end">
                                <v-img 
                                    style="
                                        margin: 0; 
                                        height: 350px; 
                                        max-width: 330px;
                                    " 
                                    :src="Dialogimg" 
                                    hide-details 
                                    alt=""/>
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
                                    <v-btn 
                                        fab 
                                        :disabled="disabledItem2btn" 
                                        style="
                                            float: right; 
                                            margin-bottom: 5px
                                        " 
                                        outlined 
                                        x-small 
                                        class="text-none mt-2" 
                                        color="primary" 
                                        v-bind="attrs" 
                                        v-on="on" 
                                        @click="addItem2('ADD')"
                                    >
                                        <v-icon dark>mdi-plus</v-icon>
                                    </v-btn>
                                </template>
                                    <span>Add New</span>
                            </v-tooltip>
                        </v-toolbar>
                    </v-col>
                </v-row>

                <v-data-table  
                    hide-default-header 
                    :headers="subheaders" 
                    :items="mastersSubData" 
                    class="elevation-1" 
                >
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
                        <v-icon color="primary" class="mr-2" @click="editItem2(item.id)">
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

        <!-- DIALOG FOR ADD AND EDIT FOR ITEM1-->
        <v-dialog v-model="dialog" max-width="20%" persistent>
                <v-card>
                    <v-card-title style="background-color: #1E88E5; color: #ffffff;">{{action}} DATA
                        <v-spacer/>
                        <v-icon color="#ffffff" @click="close()">mdi-close</v-icon>
                    </v-card-title>
                    <v-card-text>
                        <br/>
                        <!-- <span> -->
                            <v-text-field  outlined dense rounded readonly label="Category Code" v-model="category"
                            ></v-text-field>
                            <!-- <v-text-field v-else-if="this.category == null" outlined dense rounded readonly label="Category Code" v-model="category"
                            ></v-text-field>
                        </span> -->
                        <v-text-field outlined dense rounded label="Code" v-model="code" type="number"
                        onKeyPress="if(this.value.length==4)return false;"
                        ></v-text-field>
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
        </v-dialog>

        <!-- DIALOG FOR ADD AND EDIT FOR ITEM2 -->.
        <v-dialog v-model="item2Dialog" max-width="20%" persistent>
            <v-card>
                <v-card-title style="background-color: #1E88E5; color: #ffffff">
                    {{ action2 }} DATA
                    <v-spacer/>
                    <v-icon color="#ffffff" @click="close2()">mdi-close</v-icon>
                </v-card-title>
                <v-card-text>
                    <br/>
                    <v-text-field outlined dense rounded readonly label="Category Code" v-model="category2"></v-text-field>
                    <v-text-field outlined dense rounded readonly label="Main Item Code" v-model="mainCode"></v-text-field>
                    <v-text-field outlined dense rounded label="Code" type="number" v-model="code2" onKeyPress="if(this.value.length==4)return false;">
                    </v-text-field>
                    <v-text-field outlined dense rounded label="Item Name" v-model="itemName2"></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="saveItem2()" block dense color="primary" style="height:35px !important">
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
    import axios from 'axios'

    export default {
        data: () => ({
            headers: [              
                { 
                    text: 'カテゴリーコード', value: 'category_code', align: 'center', sortable: false 
                },
                { 
                    text: 'コード', value: 'main_code', align: 'center', sortable: false 
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

            addEdit: {},
            id: -1,
            mainCode: null,
            itemName: null,
            itemName2: null,
            code: null,
            code2: null,
            category: null,
            category2: null,
            disabledItem2btn: true,
            windowSize: { x: 0, y: 0 },
            loading: false,
            action: '',
            action2: '',

            // DIALOGS
            dialog: false,
            item2Dialog: false,
            dialogDelete: false,

            mastersData: [],
            mastersSubData: [],
            editedIndex: -1,
            editData:[],
        }),

        computed: {
            formTitle () {
                return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
            },
        },

        watch: {
            dialog (val) {
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
            close2() {
                this.item2Dialog = false
            },
            close() {
                this.dialog = false
            },

            addItem1() {
                this.category = 2
                this.code = ""
                this.itemName = ""
                this.dialog = true
                this.action = 'ADD NEW'
            },
            closeDialogItem1(){
                this.dialog = false
            },
            closeEditDialog1(){
                this.category = ""
                this.code = ""
                this.itemName = ""
                this.dialog = false
                this.action = 'EDIT'
            },


            editItem1(id){
                // console.log(id, 'IDDDD')
                this.id = id
                this.dialog = true
                this.action = 'EDIT'
                axios({
                    method:'get',
                    url: `api/masterMaintenance/editItems/${id}`,
                }).then((res)=>{
                    // console.log(res.data, 'ID')
                    this.category = res.data.category_code
                    this.code = res.data.code
                    this.itemName = res.data.item_name
                })
            },
            


            saveItem1(){
                // console.log(this.category, this.code, this.itemName)
                // console.log(this.action)
                this.id
                console.log(this.id)
                this.close()
                let data = {}
                if(this.action == "ADD NEW"){
                    data = {
                        action : this.action,
                        category_code: this.category,
                        CODE: this.code,
                        item_name: this.itemName
                    }
                    axios({
                    method : 'post',
                    url: 'api/masterMaintenance/updateData',
                    data: data
                }).then(res=>{
                    this.getItem1()
                    console.log(res.data,'saveItem1...')
                    if(res.data == 'Existing'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Item is Already Existing!',
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
                }else if(this.action == "EDIT"){
                    Swal.fire({
                        title:'Are you sure you want update this data?',
                        icon:'question',
                        showCancelButton:true,
                        confirmButtonColor:'grey',
                        cancelButtonColor:'#d33',
                        confirmButtonText:'Yes'
                    }).then((result) => {
                        if (result.isConfirmed){
                            axios({
                                method: 'post',
                                url: `api/masterMaintenance/updateItem1/${this.id}`,
                                data:{
                                    code:this.code,
                                    item_name:this.itemName
                                    }
                            }).then((res)=>{
                                console.log(res.data, 'updated')
                                this.getItem1()
                            })
                        }
                    })
                }
            },

            addItem2() {
                // console.log(this.mastersSubData[0].main_code)
                this.category2 = 2
                this.mainCode = this.mastersSubData[0].main_items_code
                this.code2 = ""
                this.itemName2 = ""
                this.item2Dialog = true
                this.action2 = 'ADD NEW'
            },

            saveItem2(){
                if(this.action2 == 'ADD NEW')
                axios({
                    method: 'post',
                    url: 'api/mastermaintenance/saveItem2',
                    data:{
                        category_code: this.category2,
                        main_items_code: this.mainCode,
                        code: this.code2,
                        item_name:this.itemName2
                    }
                }).then((res)=>{
                    this.getItem2();
                    if(res.data == 'Existing'){
                        Swal.fire({
                            icon: 'error',
                            title: 'Item is Already Existing!',
                            footer: 'Click OK to continue!'
                        })
                    }else{
                        Swal.fire({
                            icon: 'success',
                            title: 'Item Saved',
                            footer: 'Click OK to continue!'
                        })
                    }
                    this.item2Dialog = false
                })
            },

            editItem2(id){
                console.log(id, 'IDDDD')
                this.id = id
                this.item2Dialog = true
                this.action2 = 'EDIT'
                axios({
                    method:'get',
                    url: `api/masterMaintenance/editItem2/${id}`,
                }).then((res)=>{
                    console.log(res.data, 'ID')
                    this.category2 = res.data.category_code
                    this.mainCode = res.data.main_items_code
                    this.code2 = res.data.code
                    this.itemName2 = res.data.item_name
                })
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
                console.log(item)
                this.disabledItem2btn = false;

                axios({
                    method:'post',
                    url:'api/masterMaintenance/getItem2',
                    data:{main_items_code:item.main_code}
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