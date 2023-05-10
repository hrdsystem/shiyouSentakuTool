<template>
    <v-app id="inspire">
        <v-app-bar 
            app 
            clipped-left
            elevation="0" 
            color="primary" 
        >
            <!-- <v-app-bar-nav-icon color="black" @click="drawer = !drawer"></v-app-bar-nav-icon> -->
            <!-- <v-toolbar-title 
                style = "text-align: left !important; display: flex; padding-top: 15px;"
                >
                
                <h3 style="font-family: 'Noto Sans JP', sans-serif;  
                font-size: 25px; 
                font-weight: 700;
                color: white;">
                <a style="text-decoration: none; color: white;" href="/home">
                    仕様選択ツール
                </a>
                <b style="color: #1976d2;">.</b></h3> 

                <p style="font-size: 25px; color: white">&nbsp;(Shiyou Sentaku Tool)</p>  
            </v-toolbar-title> -->
            <!-- <v-btn icon><v-icon>mdi-cart</v-icon></v-btn>
            <v-btn icon><v-icon>mdi-account</v-icon></v-btn> -->


            <v-toolbar-title 
                style = "text-align: left !important; display: flex; padding-top: 15px;"
                >
                <h3 style="font-family: 'Noto Sans JP', sans-serif;  
                font-size: 25px; 
                font-weight: 700;
                color: white;">仕様選択ツール</h3> 

                <p style="font-size: 25px; color: white">&nbsp;(Shiyou Sentaku Tool)</p>  
            </v-toolbar-title>
        </v-app-bar>


        <!-- expand-on-hover -->
        <v-navigation-drawer
            permanent
            v-model="drawer"
            app
            clipped
        >
            <!-- <v-list dense >  -->
                <!-- <v-subheader>LIST COMPONENTS:</v-subheader> -->
                <!-- <v-list-item
                    :to="'home'"
                    @click="selectCategory()"
                >
                    <v-list-item-title>BAWANG</v-list-item-title>
                    <v-list-item-title>PAMINTA</v-list-item-title>
                    <v-list-item-title>SIBUYAS</v-list-item-title>
                </v-list-item>
            </v-list> -->
            <v-list
                dense
                nav
            >
                <!-- <v-list-item-group
                    v-model="selectedItem"
                    
                >
                    <v-card class="mb-1" light v-for="(item, index) in items" :key="index" dense style="border: 1x solid black; border: 1px #0080ff solid; background: linear-gradient(#ffffff, #eeeeee); font-size: 12px; cursor: default;">
                        <v-list-item
                            link
                            active-class="active"
                            :to="item.to"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>  
                    </v-card>
                </v-list-item-group> -->

                <!-- <v-card class="mb-1" light dense style="border: 1x solid black; background-color: #1976d2;font-size: 12px; cursor: default;">
                    <v-list-group 
                        v-for="(category, i) in categories"
                        :key="i"
                        v-if="category.subMenu.length > 0" 
                    >
                        <template v-slot:activator>
                            <v-list-item-icon>
                                <v-icon>{{category.icon}}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>{{category.text}}</v-list-item-title>
                        </template>
                        <v-list-item
                            v-for="(item, i) in category.subMenu"
                            :key="i"
                            :to="'home'"
                            @click="selectCategory(item)"
                        >
                            <v-list-item-title v-text="item.item_name"></v-list-item-title>
                        </v-list-item>
                    </v-list-group>

                    <v-list-item link v-for="(category, i) in categories" :key="i+'a'" v-if="category.subMenu.length == 0">
                        <v-list-item-icon>
                            <v-icon>{{category.icon}}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title>{{category.text}}</v-list-item-title> 
                    </v-list-item> -->

                    <!-- <v-list-group>
                        <template v-slot:activator>
                            <v-list-item-icon>
                                <v-icon>mdi-alpha-m-box-outline</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title>マスターメンテナンス</v-list-item-title>
                        </template>
                        <v-list-item
                            v-for="(item, i) in masterCategories"
                            :key="i"
                            link
                            :to="item.to"
                        >
                            <v-list-item-title v-text="item.text"></v-list-item-title>
                        </v-list-item>
                    </v-list-group>
                </v-card> -->

                <v-list-item-group v-model="selectedItem">
                    <v-card class="mb-1" light v-for="(item, index) in items" :key="index" dense style="border: 1x solid black; border: 1px #0080ff solid; background: linear-gradient(#ffffff, #eeeeee); font-size: 12px; cursor: default;">
                        <v-list-item v-if="item.subMenu == 0" link active-class="active" :to="item.to">
                            <v-list-item-icon>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>  

                        <v-list-group v-else active-class="active">
                            <template v-slot:activator>
                                <v-list-item-icon>
                                    <v-icon>{{ item.icon }}</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title>{{ item.title }}</v-list-item-title>
                            </template>
                            <v-list-item v-for="(item1, index) in item.subMenu" :key="index" link :to="item1.to" active-class="active">
                                <v-list-item-title v-text="item1.text"></v-list-item-title>
                            </v-list-item>
                        </v-list-group>
                    </v-card>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        
        

        <v-main class="ma-2">
            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>
    import {mapActions} from 'vuex';
    export default {
        data: () => ({
            selectedItem:1,
            drawer: null,
            items: [
                // { icon:'mdi-alpha-g-box-outline', title: '選択した設備仕様を確認'},
                // { icon:'mdi-alpha-e-box-outline', title: '外観', to:'/any'},
                // { icon:'mdi-alpha-w-box-outline', title: '窓', to:'/any1'},
                // { icon:'mdi-alpha-b-box-outline', title: 'バルコニー', to:'/any2'},
                // { icon:'mdi-alpha-o-box-outline', title: '外まわり', to:'/any3'},
                // { icon:'mdi-alpha-f-box-outline', title: '玄関', to:'/any4'},
                // { icon:'mdi-alpha-r-box-outline', title: '洋室', to:'/any5'},
                // { icon:'mdi-alpha-s-box-outline', title: '階段', to:'/any6'},
                // { icon:'mdi-alpha-j-box-outline', title: '和室', to:'/any7'},
                // { icon:'mdi-alpha-k-box-outline', title: 'キッチン', to:'/any8'},
                // { icon:'mdi-alpha-u-box-outline', title: 'ユーティリティ', to:'/any9'},
                // { icon:'mdi-alpha-u-box-outline', title: '浴室', to:'/any10'},
                // { icon:'mdi-alpha-t-box-outline', title: 'トイレ', to:'/toilet'},
                // { icon:'mdi-alpha-i-box-outline',title: '玄関ホール', to:'/any12'},
                // { icon:'mdi-alpha-l-box-outline', title: 'リビング', to:'/any13'},
                // { icon:'mdi-alpha-z-box-outline', title: '収納', to:'/any14'},
                // { icon:'mdi-alpha-m-box-outline', title: 'マスターメンテナンス', to:'/master_maintenance_tool'},


                {subMenu:[], icon:'mdi-alpha-e-box-outline', title: '外観', to:'/any'},
                {subMenu:[], icon:'mdi-alpha-w-box-outline', title: '窓', to:'/any1'},
                {subMenu:[], icon:'mdi-alpha-b-box-outline', title: 'バルコニー', to:'/any2'},
                {subMenu:[], icon:'mdi-alpha-o-box-outline', title: '外まわり', to:'/any3'},
                {subMenu:[], icon:'mdi-alpha-f-box-outline', title: '玄関', to:'/any4'},
                {subMenu:[], icon:'mdi-alpha-r-box-outline', title: '洋室', to:'/any5'},
                {subMenu:[], icon:'mdi-alpha-s-box-outline', title: '階段', to:'/any6'},
                {subMenu:[], icon:'mdi-alpha-j-box-outline', title: '和室', to:'/any7'},
                {subMenu:[], icon:'mdi-alpha-k-box-outline', title: 'キッチン', to:'/any8'},
                {subMenu:[], icon:'mdi-alpha-u-box-outline', title: 'ユーティリティ', to:'/any9'},
                {subMenu:[], icon:'mdi-alpha-u-box-outline', title: '浴室', to:'/any10'},
                {subMenu:[], icon:'mdi-alpha-t-box-outline', title: 'トイレ', to:'/toilet'},
                {subMenu:[], icon:'mdi-alpha-i-box-outline',title: '玄関ホール', to:'/any12'},
                {subMenu:[], icon:'mdi-alpha-l-box-outline', title: 'リビング', to:'/any13'},
                {subMenu:[], icon:'mdi-alpha-z-box-outline', title: '収納', to:'/any14'},   
                {subMenu:[
                    {text:'外部', to: "/gaibu_master"},
                    {text:'設備', to: "/setsubi_master"},
                    {text:'内部', to: "/naibu_master"},
                ], icon:'mdi-alpha-m-box-outline', title: 'マスターメンテナンス', to:'/any156'}, 
            ],
            // masterCategories:[
            //     {text:'外部', to: "/gaibu_master"},
            //     {text:'設備', to: "/setsubi_master"},
            //     {text:'内部', to: "/naibu_master"},
            // ],
            // categories: ''
        }),

        methods: {
            
        },

        mounted() {
            
        },

        created () {
            if (this.$route.path !== '/home') {
                this.$router.push('/home');
            }
        },


    }
</script>

<style>
    .active{
        background-color: #0080ff;
        margin-bottom: 4px;
        border: 1px solid #0080ff;
        color: white !important;
    }
</style>
