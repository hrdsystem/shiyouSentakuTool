<template>
    <div class="pa-8" style="transform-origin: center top 0px;">
        <v-row dense>
            <v-col  v-for="(item, x) in naibuMaintance" :key="x"   cols="4" >
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
        </v-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                naibuMaintance : [
                    {
                        title : 'Item',
                        kanji : "項目分類マスタ保守",
                        path : '/naibu_master_item1'
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