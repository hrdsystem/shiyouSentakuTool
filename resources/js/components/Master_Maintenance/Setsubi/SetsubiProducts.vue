<template>
    <div>
        <center>
            <v-overlay :value="loading" color="white">
                <v-progress-circular color="#74b1ed" indeterminate size="100" width="10" >
                    <v-row class="d-flex align-center">
                        <h1 class="blink" style="font-size: 10px; color: black;">LOADING<br>DATA</h1>
                    </v-row>

                </v-progress-circular>
            </v-overlay> 
        </center>
        <div>
            <v-btn rounded x-small outlined color="primary" to="/setsubi_master">
                <v-icon>mdi-arrow-left-bold</v-icon>
                <span>Back</span>
            </v-btn>
        </div>
        <v-data-table  hide-default-header :headers="headers" :items="mastersData" class="elevation-1 processTable" style="max-width: 100%;">
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
                <v-row>
                    <v-col cols="4"></v-col>
                    <v-col cols="4">
                    </v-col>
                    <v-col cols="4">
                        <v-toolbar flat>
                            <v-spacer/>
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
                        </v-toolbar>
                    </v-col>
                </v-row>
            </template>
            
            <template v-slot:item.actions="{ item }">
                <v-icon color="primary" class="mr-2" @click="editItem(item)">
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
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data: () => ({
            loading: false,
            dialog: false,
            dialogDelete: false,
            headers: [
                { 
                    text: 'カテゴリーコード', value: 'category_code', align: 'centered', sortable: false 
                },
                { 
                    text: '本体コード', value: 'main_items_code', align: 'centered', sortable: false 
                },
                { 
                    text: 'サブアイテムコード', value: 'sub_items_code', align: 'centered', sortable: false 
                },
                { 
                    text: 'コード', value: 'CODE', align: 'centered', sortable: false 
                },
                { 
                    text: '商品名', value: 'product_name', align: 'centered', sortable: false 
                },
                { 
                    text: 'メーカーコード', value: 'maker_code', align: 'centered', sortable: false 
                },
                { 
                    text: 'カラーコード', value: 'color_code', align: 'centered', sortable: false 
                },
                { 
                    text: '画像パス', value: 'image_path', align: 'centered', sortable: false 
                },
                { 
                    text: '行動', value: 'actions', align: 'centered', sortable: false 
                },
            ],
            mastersData: [],
            editedIndex: -1,
            editedItem: {

            },
            defaultItem: {
            },
        }),

        computed: {
        
        },

        created () {
            this.getProducts();
        },

        methods: {
            getProducts(){
                axios({
                    method:'get',
                    url:'api/masterMaintenance/products'
                }).then((res)=>{
                    console.log(res.data, 'PRODUCTS')
                    this.mastersData = res.data;
                })
            }
        }
    }
</script>

<style scoped>
    .processTable >>> thead th {
        padding: 3px;
        position: sticky;
        top: 0;
        z-index: 1;
        width: 13vw;
        font-family:sans-serif;
        border-top: 0.5px solid #e0e0e0;
        border-left: 0.5px solid #e0e0e0;
        border-right: 0.5px solid #e0e0e0;
        border-bottom: 0.5px solid #e0e0e0;
        /* border: 0.5px solid black; */
    }

    .processTable >>> tbody td {
        /* border: 0.5px solid black; */
        font-size: 12px;
        font-family: arial;
        height: 4px;
        padding: 5px;
        border-left: 0.5px solid #e0e0e0;
        border-right: 0.5px solid #e0e0e0;
        border-bottom: 0.5px solid #e0e0e0;
        /* font-family:sans-serif; */
    }
</style>