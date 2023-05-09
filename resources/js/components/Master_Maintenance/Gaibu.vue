<template>
    <div>
        <h1>Gaibu</h1>
        <div>
            <v-row dense>
                <!-- <v-col cols="4" v-for="(item,index) in masterCategories" :key="index">
                    <v-card> {{ item.text }} </v-card>
                </v-col> -->
                <v-col cols="4" >
                    <v-card class="pa-1" rounded width="" flat>
                        <v-toolbar >
                            <v-list>
                                <v-list-item-title style="font-size: 12px; cursor: default;" >
                                    項目分類マスタ保守
                                </v-list-item-title>
                                v-list-sub
                            </v-list>
                        </v-toolbar>
                    </v-card>
                </v-col>
                <!-- <v-col cols="4" >
                    <v-card> Item_2 </v-card>
                </v-col>
                <v-col cols="4" >
                    <v-card> Product </v-card>
                </v-col> -->
            </v-row>
        
            <!-- <v-row dense> -->
                <!-- <v-col cols="4" >
                    <v-card> Color </v-card>
                </v-col> -->
                <!-- <v-col cols="4" >
                    <v-card> Directory </v-card>
                </v-col> -->
            <!-- </v-row> -->
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                masterCategories:[
                    {text:'外部', to: "/gaibu_master"},
                    {text:'設備', to: "/setsubi_master"},
                    {text:'内部', to: "/naibu_master"},
                ],
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>