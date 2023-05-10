<template>
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

                <v-data-table  hide-default-header :headers="headers" :items="mastersData" class="elevation-1 processTable" style="max-width: 100%;">
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
            </v-col>
        </v-row>
    </v-container>
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
                    text: 'カラーコード', value: 'color_code', align: 'center', sortable: false 
                },
                { 
                    text: '色名', value: 'color_name', align: 'center', sortable: false 
                },
                { 
                    text: '画像パス', value: 'image_path', align: 'center', sortable: false 
                },
                { 
                    text: '行動', value: 'actions', align: 'center', sortable: false 
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
            this.getColors();
        },

        methods: {
            getColors(){
                axios({
                    method:'get',
                    url:'api/masterMaintenance/colors'
                }).then((res)=>{
                    console.log(res.data, 'COLORS')
                    this.mastersData = res.data;
                })
            }
        }
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