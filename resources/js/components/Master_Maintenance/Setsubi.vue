<template>
    <div class="pa-8" style="transform-origin: center top 0px;">
        <v-row dense>

            <!-- ========== -->
            <!-- ===ITEM1=== -->
            <!-- ========== -->
            <v-col  v-for="(item, i) in ITEMS" :key="i" cols="3" >
                <v-card class="pa-1" rounded width="" flat>
                    <v-toolbar>
                        <v-row align="center" justify="center" >
                            <v-col cols="8">
                                <v-list>
                                    <v-list-item-title style="font-size: 12px; cursor: default;" >
                                        {{item.kanji }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle style="font-size: 12px; cursor: default;" >
                                        {{ item.title }}
                                    </v-list-item-subtitle>
                                </v-list>
                            </v-col>
                            <v-col cols="4">
                                <div class="d-flex justify-end">
                                    <v-btn :to="item.path"  rounded x-small outlined color="primary">
                                        <span>View</span>
                                        <v-icon>mdi-arrow-right-thin</v-icon>
                                    </v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-toolbar>
                </v-card>
            </v-col>

            <!-- ========== -->
            <!-- =PRODUCTS= -->
            <!-- ========== -->
            <v-col  v-for="(item, i) in PRODUCTS" :key="'A'+ i" cols="3" >
                <v-card class="pa-1" rounded width="" flat>
                    <v-toolbar>
                        <v-row align="center" justify="center" >
                            <v-col cols="8">
                                <v-list>
                                    <v-list-item-title style="font-size: 12px; cursor: default;" >
                                        {{item.kanji }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle style="font-size: 12px; cursor: default;" >
                                        {{ item.title }}
                                    </v-list-item-subtitle>
                                </v-list>
                            </v-col>
                            <v-col cols="4">
                                <div class="d-flex justify-end">
                                    <v-btn :to="item.path"  rounded x-small outlined color="primary">
                                        <span>View</span>
                                        <v-icon>mdi-arrow-right-thin</v-icon>
                                    </v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-toolbar>
                </v-card>
            </v-col>

            <!-- ========== -->
            <!-- =COLORS= -->
            <!-- ========== -->
            <!-- <v-col  v-for="(item, i) in COLORS" :key="'C'+ i" cols="3" >
                <v-card class="pa-1" rounded width="" flat>
                    <v-toolbar>
                        <v-row align="center" justify="center" >
                            <v-col cols="8">
                                <v-list>
                                    <v-list-item-title style="font-size: 12px; cursor: default;" >
                                        {{item.kanji }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle style="font-size: 12px; cursor: default;" >
                                        {{ item.title }}
                                    </v-list-item-subtitle>
                                </v-list>
                            </v-col>
                            <v-col cols="4">
                                <div class="d-flex justify-end">
                                    <v-btn :to="item.path"  rounded x-small outlined color="primary">
                                        <span>View</span>
                                        <v-icon>mdi-arrow-right-thin</v-icon>
                                    </v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-toolbar>
                </v-card>
            </v-col> -->

            <!-- ========== -->
            <!-- =SPECIFICATION= -->
            <!-- ========== -->
            <!-- <v-col  v-for="(item, i) in SPECIFICATION" :key="'B'+ i" cols="3" >
                <v-card class="pa-1" rounded width="" flat>
                    <v-toolbar>
                        <v-row align="center" justify="center" >
                            <v-col cols="8">
                                <v-list>
                                    <v-list-item-title style="font-size: 12px; cursor: default;" >
                                        {{item.kanji }}
                                    </v-list-item-title>
                                    <v-list-item-subtitle style="font-size: 12px; cursor: default;" >
                                        {{ item.title }}
                                    </v-list-item-subtitle>
                                </v-list>
                            </v-col>
                            <v-col cols="4">
                                <div class="d-flex justify-end">
                                    <v-btn :to="item.path"  rounded x-small outlined color="primary">
                                        <span>View</span>
                                        <v-icon>mdi-arrow-right-thin</v-icon>
                                    </v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-toolbar>
                </v-card>
            </v-col> -->
        </v-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ITEMS : [
                    {
                        title : 'Item',
                        kanji : "項目分類マスタ保守",
                        path : '/setsubi_master/setsubi_master_item1'
                    }
                ],
                PRODUCTS : [
                    {
                        title : 'Product',
                        kanji : "製品",
                        path : '/setsubi_master/setsubi_master_products'
                    }
                ],
                SPECIFICATION : [
                    {
                        title : 'Specifications',
                        kanji : "仕様",
                        path : '/setsubi_master/setsubi_master_specification'
                    }
                ],
                COLORS : [
                    {
                        title : 'Color',
                        kanji : "色",
                        path : '/setsubi_master/setsubi_master_colors'
                    }
                ],
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