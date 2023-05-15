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
                    @dblclick:row="($event, {item})=>getItem2(item.main_code)"
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
                        <v-icon color="primary" class="mr-2" @click="editItem1(item)">
                            mdi-pencil
                        </v-icon>
                        <v-icon  color="error" @click="deleteItem1(item)">
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
                        <v-icon color="primary" class="mr-2" @click="editItem2(item)">
                            mdi-pencil
                        </v-icon>
                        <v-icon color="error" @click="deleteItem2(item)">
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
        <v-dialog v-model="item1Dialog" max-width="20%" persistent>
                <v-card>
                    <v-card-title style="background-color: #1E88E5; color: #ffffff;">{{action}} DATA
                        <v-spacer/>
                        <v-icon color="#ffffff" @click="close1()">mdi-close</v-icon>
                    </v-card-title>
                    <v-card-text>
                        <br/>
                        <!-- <span> -->
                            <v-text-field  outlined dense rounded readonly label="Category Code" v-model="item1Obj1.category"
                            ></v-text-field>
                            <!-- <v-text-field v-else-if="this.category == null" outlined dense rounded readonly label="Category Code" v-model="category"
                            ></v-text-field>
                        </span> -->
                        <v-text-field :readonly="disabledItem1()" outlined dense rounded label="Code" v-model="item1Obj1.code"
                        onKeyPress="if(this.value.length==4)return false;"
                        ></v-text-field>
                        <v-text-field  outlined dense rounded label="Item Name" v-model="item1Obj1.itemName"></v-text-field>
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
                    <v-text-field outlined dense rounded readonly label="Category Code" v-model="item2Obj2.category2"></v-text-field>
                    <v-text-field outlined dense rounded readonly label="Main Item Code" v-model="item2Obj2.mainCode"></v-text-field>
                    <v-text-field outlined dense rounded :readonly="disabledItem2()" label="Code" v-model="item2Obj2.code2">
                    </v-text-field>
                    <v-text-field outlined dense rounded label="Item Name" v-model="item2Obj2.itemName2"></v-text-field>
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
            
            item1Obj1 : {},
            item2Obj2 : {},

            addEdit: {},
            id: -1,
            item1Code : "",


            disabledItem2btn: true,
            windowSize: { x: 0, y: 0 },
            loading: false,
            action: '',
            action2: '',

            // DIALOGS
            item1Dialog: false,
            item2Dialog: false,

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


            // item1Dialog (val) {
            //     val || this.close1()
            // },
            // dialogDelete (val) {
            //     val || this.closeDelete()
            // },
        },

        created () {
            this.getItem1();
        },

        methods: {
            ///////////////////////////////////////////////////////
            //    *   *   *   *   *           *   *   *   *   *  //
            ///////////////////////////////////////////////////////
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
                this.item1Code = item
                let obj = {
                    item1 : item
                }
                this.disabledItem2btn = false;
                axios({
                    method:'post',
                    url:'api/masterMaintenance/getItem2',
                    data : obj
                    // data:{main_items_code:item.main_code}
                }).then((res)=>{
                    this.mastersSubData = res.data;
                })
            },
            //    *   *   *   *   *      ADD     *   *   *   *   *  //
            addItem1() {
                this.item1Obj1.category = 2
                this.item1Dialog = true
                this.action = 'ADD NEW'
            },
            addItem2() {
                this.item2Obj2.category2 = 2
                this.item2Obj2.mainCode = this.item1Code

                console.log(this.item1Obj1,'asdaadsa')
                this.item2Dialog = true
                this.code2 = ""
                this.itemName2 = ""
                this.action2 = 'ADD NEW'
            },
            //    *   *   *   *   *      CLOSE     *   *   *   *   *  //
            close1() {
                this.item1Obj1 = {}
                this.item1Dialog = false
            },
            close2() {
                this.item2Obj2 = {}
                this.item2Dialog = false
            },
            //    *   *   *   *   *      EDIT     *   *   *   *   *  //
            editItem1(item){
                this.id = item.id
                this.item1Dialog = true
                this.action = 'EDIT'
                this.item1Obj1.category = item.category_code
                this.item1Obj1.code = item.main_code
                this.item1Obj1.itemName = item.item_name
            },
            editItem2(item){
                this.id = item.id
                this.item2Dialog = true
                this.action2 = 'EDIT'
                this.item2Obj2.category2 = item.category_code
                this.item2Obj2.mainCode = item.main_items_code
                this.item2Obj2.code2 = item.sub_item_code
                this.item2Obj2.itemName2 = item.sub_item_name
            },
            //    *   *   *   *   *      DISABLED     *   *   *   *   *  //
            disabledItem1(){
                if(this.action == "EDIT"){
                    return true
                }else{
                    return false    
                }
            },
            disabledItem2(){
                if(this.action2 == "EDIT"){
                    return true
                }else{
                    return false    
                }
            },
            //    *   *   *   *   *      DELETE     *   *   *   *   *  //
            deleteItem1(item){
                Swal.fire({
                    title: 'Are you sure you want to delete?',
                    text: "You wont be able to revert this Item 1!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios ({
                            method : 'POST',
                            url : `api/masterMaintenance/deleteItem1/${item.id}`,
                        }).then(r=>{
                            Swal.fire({
                                showConfirmButton:false,
                                icon: 'success',
                                title: 'Item 1 is successfully deleted',
                                timer: 1000,
                            })
                            this.getItem1()
                        })
                    }
                })
            },
            deleteItem2(item){
                Swal.fire({
                    title: 'Are you sure you want to delete?',
                    text: "You wont be able to revert this Item 2!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios ({
                            method : 'POST',
                            url : `api/masterMaintenance/deleteItem2/${item.id}`,
                        }).then(r=>{
                            Swal.fire({
                                showConfirmButton:false,
                                icon: 'success',
                                title: 'Item 2 is successfully deleted',
                                timer: 1000,
                            })
                            this.getItem2(this.item2Obj2.mainCode);
                        })
                    }
                })
            },
            //    *   *   *   *   *      SAVE and UPDATE ITEM 1     *   *   *   *   *  //
            saveItem1(){
                this.id
                let data = {}
                if(this.action == "ADD NEW"){
                    data = {
                        action : this.action,
                        category_code: this.item1Obj1.category,
                        CODE: this.item1Obj1.code,
                        item_name: this.item1Obj1.itemName
                    }
                    axios({
                        method : 'post',
                        url: 'api/masterMaintenance/saveItem1',
                        data: data
                    }).then(res=>{
                        if(res.data == 'Existing'){
                            Swal.fire({
                                showConfirmButton:false,
                                icon: 'error',
                                title: 'Item 1 is already Existing!',
                                timer: 1000,
                            })
                            this.close1()
                        }else{
                            Swal.fire({
                                showConfirmButton:false,
                                icon: 'success',
                                title: 'Item 1 Saved',
                                timer: 1000,
                            })
                            this.getItem1()
                            this.close1()
                        }
                    })
                }else if(this.action == "EDIT"){
                    Swal.fire({
                        title:'Aare you sure you want to update this item 2 data?',
                        icon:'question',
                        showCancelButton:true,
                        confirmButtonColor:'primary',
                        cancelButtonColor:'#d33',
                        confirmButtonText:'Yes'
                    }).then((result) => {
                        if (result.isConfirmed){
                            axios({
                                method: 'post',
                                url: `api/masterMaintenance/updateItem1/${this.id}`,
                                data:{
                                    // code:this.code,
                                    item_name:this.item1Obj1.itemName
                                    }
                            }).then((res)=>{
                                this.getItem1()
                                if(res.data == 'Existing'){
                                    Swal.fire({
                                        showConfirmButton:false,
                                        icon: 'error',
                                        title: 'Item 1 is already existing',
                                        timer: 1000,
                                    })
                                    this.close1()
                                }else{
                                    Swal.fire({
                                        showConfirmButton:false,
                                        icon: 'success',
                                        title: 'Item 1 Updated',
                                        timer: 1000,
                                    })
                                    this.getItem1();
                                    this.close1()
                                }
                            })
                        }
                    })
                }
            },
            //    *   *   *   *   *      SAVE and UPDATE ITEM 2     *   *   *   *   *  //
            saveItem2(){
                let data = {}
                data = {
                        action2 : this.action2,
                        category_code : this.item2Obj2.category2,
                        main_items_code : this.item2Obj2.mainCode,
                        code : this.item2Obj2.code2,
                        item_name : this.item2Obj2.itemName2
                    }
                if(this.action2 == 'ADD NEW') {
                    axios({
                        method: 'post',
                        url: 'api/mastermaintenance/saveItem2',
                        data:data
                    }).then((res)=>{
                        if(res.data == 'Existing'){
                            Swal.fire({
                                showConfirmButton:false,
                                icon: 'error',
                                title: 'Item 2 is already existing',
                                timer: 1000,
                            })
                            this.close2()
                        }else{
                            Swal.fire({
                                showConfirmButton:false,
                                icon: 'success',
                                title: 'Item 2 Saved',
                                timer: 1000,
                            })
                            this.getItem2(this.item2Obj2.mainCode)
                            this.close2()
                        }
                    })
                }else if(this.action2 == "EDIT"){
                    console.log(this.item2Obj2, 'DATAAAAAAAAAAAAAAAAAAAA');

                    Swal.fire({
                        title:'Are you sure you want to update this item 2 data?',
                        icon:'question',
                        showCancelButton:true,
                        confirmButtonColor:'primary',
                        cancelButtonColor:'#d33',
                        confirmButtonText:'Yes!'
                    }).then((result) => {
                        if (result.isConfirmed){
                            axios({
                                method: 'post',
                                url: `api/masterMaintenance/updateItem2/${this.id}`,
                                data: data
                            }).then((res)=>{
                                if(res.data == 'Existing'){
                                    Swal.fire({
                                        showConfirmButton:false,
                                        icon: 'error',
                                        title: 'Item 2 is already existing!',
                                        timer: 1000,
                                    })
                                    this.close2()
                                }else{
                                    Swal.fire({
                                        showConfirmButton:false,
                                        icon: 'success',
                                        title: 'Item 2 Updated!',
                                        timer: 1000,
                                    })
                                    this.getItem2(this.item2Obj2.mainCode);
                                    this.close2()
                                }
                            })
                        }
                    })
                }
            },
            //    *   *   *   *   *           *   *   *   *   *  //
            //    *   *   *   *   *           *   *   *   *   *  //





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