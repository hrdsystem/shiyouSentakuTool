<template>
    <div>
        <!-- <v-card elevation="0" style="display: flex; padding-left: 50px; padding-right: 50px;"> -->
        <v-card elevation="0" style="display: flex; padding-left: 50px; padding-right: 50px;">
            <h1 class="s-title">トイレ</h1>
            <v-spacer></v-spacer>
            <v-badge
                style="margin-top: 10px;"
                color="red lighten-2"
                :content="cartItemCount ? cartItemCount : '0'"
                overlap
            >
                <!-- <v-btn
                    icon
                >
                    <v-icon dark>mdi-cart</v-icon>
                </v-btn> -->
                <template>
                    <div class="text-right">
                        <v-dialog
                            v-model="dialog"
                            width="1280"
                            heigth="700"
                        >
                            <template v-slot:activator="{ on, attrs } ">
                                <v-badge
                                    color="red lighten-2"
                                    :content="cartItemCount"
                                    overlap
                                >
                                    <v-btn
                                        icon
                                        v-bind="attrs"
                                        v-on="on"
                                    >
                                        <v-icon dark>mdi-cart</v-icon>
                                    </v-btn>
                                </v-badge>
                            </template>

                            <v-card>
                                <v-simple-table style="padding: 25px;">
                                    <template v-slot:default>
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    No.
                                                </th>
                                                <th class="text-center">
                                                    Type
                                                </th>
                                                <th class="text-center">
                                                    Images
                                                </th>
                                                <th class="text-center">
                                                    Item
                                                </th>
                                                <th class="text-center">
                                                    Product
                                                </th>
                                                <th class="text-center">
                                                    Color
                                                </th>
                                                <th class="text-center">
                                                    Price
                                                </th>
                                                <th class="text-center">
                                                    Description
                                                </th>
                                                <th class="text-center">
                                                    Actions
                                                </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,i) in cartItems" :key="i">
                                                <!-- {{ item }} -->
                                                <td class="text-center">{{ i + 1 }}</td> 
                                                <td class="text-center" style="width: 100px;">{{ item.type }}</td>
                                                <td class="text-center" style="padding-left: 50px;">
                                                    <!-- <img style="width: 80px; height: 80px;" :src="item.image" alt="">  -->
                                                    <!-- {{ item.image }} -->
                                                    <v-img max-height="100" max-width="100" :src="require(`../../images/toilet/${item.image}`)"></v-img>
                                                </td>
                                                <td class="text-center">{{ item.item }}</td>
                                                <td class="text-center">{{ item.product }}</td>
                                                <td class="text-center">{{ item.color ? item.color : 'default'}}</td>
                                                <td class="text-center">{{ item.price }}</td>
                                                <td class="text-center" style="width: 35px;">{{ item.description }}</td>
                                                <td class="text-center">
                                                    <v-btn @click="removeItem(item.id)" color="red lighten-2"> 削除
                                                        <v-icon>mdi-delete</v-icon>
                                                    </v-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-card>
                        </v-dialog>
                    </div>
                </template>
            </v-badge>
        </v-card>
        
        <template>
            <v-list dense >
                
                <v-list-group
                no-action
                dense
                v-for="(item, i) in sub_items"
                :key="i"
                @click="getProducts(item)"
                >
                <!-- {{ item }} -->
                    <template v-slot:activator>
                        <v-list-item-icon class="pt-1">
                            <v-icon>{{item.icon}}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-title class="s-sub-header" style="color: black;">
                            <h3>{{item.item_name}}</h3>
                        </v-list-item-title>
                    </template>

                    <!-- <v-card v-show="item.products[0] != undefined" style="display: flex; padding-right: 50%;">-->
                    <v-card v-if="products[0]" style="display: flex; padding-right: 50%;">
                        <v-list-item>
                            <template v-slot:default="{ active }">
                                <v-list-item-action style="display: block:  !important;">
                                    <v-checkbox
                                        :input-value="active"
                                        color="primary"
                                    ></v-checkbox>
                                </v-list-item-action>

                                <v-list-item-content>
                                <v-list-item-title class="s-sub-header">要</v-list-item-title>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            <template v-slot:default="{ active }">
                                <v-list-item-action style="display: block:  !important;">
                                    <v-checkbox
                                        :input-value="active"
                                        color="primary"
                                    ></v-checkbox>
                                </v-list-item-action>

                                <v-list-item-content>
                                <v-list-item-title class="s-sub-header">設計に相談したい</v-list-item-title>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            <template v-slot:default="{ active }">
                                <v-list-item-action style="display: block:  !important;">
                                    <v-checkbox
                                        :input-value="active"
                                        color="primary"
                                    ></v-checkbox>
                                </v-list-item-action>

                                <v-list-item-content>
                                <v-list-item-title class="s-sub-header">不要</v-list-item-title>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            <template v-slot:default="{ active }">
                                <v-list-item-action style="display: block:  !important;">
                                    <v-checkbox
                                        :input-value="active"
                                        color="primary"
                                    ></v-checkbox>
                                </v-list-item-action>

                                <v-list-item-content>
                                <v-list-item-title class="s-sub-header">追加</v-list-item-title>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                        <v-btn
                        style="margin-top: 10px; background-color: whitesmoke;"
                        class="s-title"
                        width="100"
                        small
                        outlined
                        >メモ</v-btn>
                    </v-card>
                    <v-card v-if="!products[0]">
                    </v-card>
                    

                        <div id="s-d"
                        v-if="products[0]"
                        >
                        <!-- <div id="s-d"> -->
                            <v-card @click="selectItem(item)" v-for="(item, i) in products" :key="i" style="border: 1px solid #ddd; flex-wrap: wrap; justify-content: center; gap: 10px;" width="520" height="350" elevation="0">
                                <!-- {{ item }} -->
                                <v-col>
                                    <v-row>
                                        <v-col style="display: flex;">
                                            <v-list-item-title class="s-title" style="font-size: 20px;">{{ item.product_name }}</v-list-item-title>
                                            <v-spacer/>
                                            <template>
                                                <div class="text-left">
                                                    <v-menu
                                                    :close-on-content-click="false"
                                                    :nudge-width="50"
                                                    offset-y
                                                    location="start"
                                                    style="background-color: white;"
                                                    >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        icon
                                                        >
                                                        <v-icon color="#FF8F00">mdi-crown</v-icon>
                                                        </v-btn>
                                                    </template>
                                                        <v-card style="background-color: white;" elevation="0">
                                                            <p class="s-header">"I want to put a mark of popularity.
                                                            <br> Gold, silver, copper, etc. in the crown mark."</p>
                                                        </v-card>
                                                    </v-menu>
                                                </div>
                                            </template>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col style="display: flex;">
                                            <!-- {{ item.image_path }} -->
                                            <v-img  max-height="250" max-width="250" :src="require(`../../images/toilet/${item.image_path}`)"></v-img>
                                            <!-- <v-img  max-height="250" max-width="250" :src="require(`../../images/toilet/${item.image_path}`)"></v-img> -->
                                            <!-- <v-img v-else="img.image_path == undefined" max-height="250" max-width="250" :src="require('../images/No_Image_Available.jpg')"></v-img> -->
                                        </v-col>
                                        <v-col>
                                            <template>
                                                <div class="text-left">
                                                    <!-- <v-menu
                                                    :close-on-content-click="false"
                                                    offset-x
                                                    >
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-btn
                                                        small
                                                        color="indigo"
                                                        dark
                                                        v-bind="attrs"
                                                        v-on="on"
                                                        > 
                                                        採用
                                                        </v-btn>
                                                    </template>
                                                        <div v-if="item.color_content[0] != undefined" id="s-s">
                                                            <v-card v-for="(item, a) in item.color_content" :key="a" style="text-align:center; cursor:pointer; border: 1px solid #ddd; flex-wrap: wrap; justify-content: center; gap: 10px;" width="100" height="100" elevation="0">
                                                                <v-img style="width: 100%; height: 100%; object-fit: cover;" :src="item.color_img" :alt="item.name" id="s-s-h"/>
                                                            </v-card>
                                                        </div>   
                                                        <div v-if="item.color_content[0] == undefined" id="s-s">
                                                            <v-card style="text-align:center; cursor:pointer; border: 1px solid #ddd; flex-wrap: wrap; justify-content: center; gap: 10px;" width="100" height="100" elevation="0">
                                                                <v-img style="width: 100%; height: 100%; object-fit: cover;" src="../../images/default.jpg" alt="default image" id="s-s-h"/>
                                                            </v-card>
                                                        </div>   
                                                    </v-menu> -->
                                                </div>
                                            </template>
                                            
                                            &nbsp;

                                            <h5 class="s-header">価格: 
                                                <v-icon style="font-size: 15px; margin-bottom: 3px;">
                                                    mdi-currency-jpy
                                                </v-icon>
                                                {{ item.price ? item.price : 'No Indicated Value'}}
                                            </h5>

                                            &nbsp;

                                            <p class="s-sub-header">
                                                {{ item.description ? item.description : 'No Indicated Description' }}  
                                            </p>
                                            <v-btn class="s-header" block @click="addToCart(item)">
                                                <v-icon>
                                                    mdi-cart
                                                </v-icon>add
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-card>
                        </div>
                        <div v-if="!products[0]">
                            <p>no items available as of the moment</p>
                        </div>
                </v-list-group>
            </v-list>
        </template>
    </div>
</template>

<script>
import Swal from 'sweetalert2'
export default{
    data() {
        return {
            cartItemCount: 0,
            dialog: false,

            sub_items: [],
            products: [],
            cartItems: [],
            cart: [
                {
                type: '',
                image: '',
                accesories_image: '',
                item_name: '',
                product_name: '',
                // color_name: '',
                price: '',
                description: '',
                }
            ],

            // sub_items :[
            //     {id: 1, category_code: 12, name: '便器', icon:'mdi-toilet', products: []},
            //     {id: 2, category_code: 12, name: 'タオル掛け', icon:'mdi-align-vertical-top', products: []},
            //     {id: 3, category_code: 12, name: 'ペーパーホルダー', icon:'mdi-paper-roll', products: []},
            //     {id: 4, category_code: 12, name: 'トイレ収納 ', icon:'mdi-archive', products: []},
            //     {id: 5, category_code: 12, name: '次の項目のサンプル', icon:'mdi-dots-horizontal-circle', products: []},
            // ],

            // products :[
            //     {id: 1, item_id: 1, color_id: 1, title: '蛇口', 
            //         img: require('../../images/toilet/toiletBowl/ベーシアハーモ(LIXIL).jpg'),
            //         add_img: require('../../images/toilet/toiletBowl/30.jpg'),
            //         price: '53,350円',
            //         description: '※オート洗浄機能',
            //         accessories_content: [],
            //     color_content: []},
            //     {id: 2, item_id: 1, color_id: 2, title: 'カバー', 
            //         img: require('../../images/toilet/toiletBowl/F3A(ｵｰﾄ便器洗浄付) .jpg'),
            //         add_img: require('../../images/toilet/toiletBowl/14.jpg'),
            //         price: '45,650円',
            //         description: '',
            //         accessories_content: [],
            //     color_content: []},
            //     {id: 3, item_id: 1, color_id: 3, title: '丼鉢', 
            //         img: require('../../images/toilet/toiletBowl/L150K.jpg'),
            //         add_img: require('../../images/toilet/toiletBowl/CA193AC30020.jpg'),
            //         price: '148,390円',
            //         description: '※オート開閉･温風乾燥･オート洗浄･やわらかライト',
            //     accessories_content: [],    
            //     color_content: []},
            //     {id: 4, item_id: 2,  title: 'タオルリング', 
            //         img: require('../../images/toilet/toiletBowl/31.jpg'),
            //         add_img: '',
            //         price: '4,070 円',
            //         description: '※標準個数: 平屋 : 2 ヵ所, ２階建て : 3 ヶ所, 3 階建て : 4 ヶ所',
            //         accessories_content: [],
            //     color_content: []},
            //     {id: 5,item_id: 2,  title: 'バスタオル掛け', 
            //         img: require('../../images/toilet/toiletBowl/33.jpg'),
            //         add_img: '',
            //         price: '4,400 円',
            //         description: '※長さは 60cm です。',
            //         accessories_content: [],
            //     color_content: []},
            //     {id: 6, item_id: 3,  title: '1連式', 
            //         img: require('../../images/toilet/toiletBowl/ペーパーホルダー1連式.jpg'),
            //         add_img: '',
            //         price: '',
            //         description: '※便器と同じメーカー品になります。（Panasonic製便器で2連式の時は TOTO製になります）',
            //         accessories_content: [],
            //     color_content: []},
            //     {id: 7, item_id: 3,  title: '2連式', 
            //         img: require('../../images/toilet/toiletBowl/ペーパーホルダー2連式.jpg'),
            //         add_img: '',
            //         price: '',
            //         description: '※便器と同じメーカー品になります。（Panasonic製便器で2連式の時は TOTO製になります）',
            //         accessories_content: [],
            //     color_content: []},
            //     {id: 8, item_id: 3,  title: 'シルバータイプ（TOTO）', 
            //         img: require('../../images/toilet/toiletBowl/ペーパーホルダー_シルバータイプ.jpg'),
            //         add_img: '',
            //         price: '2,200円',
            //         description: '※LIXIL/Panasonic製便器でも 選択可能です。',
            //         accessories_content: [],
            //     color_content: []}
            // ],

            // accessories: [
            //     {},
            // ],

            // colors :[
            //     {id: 1, color_id: 1, name: 'white', color_img: require('../../images/toilet/ToiletBowlColors/ピュアホワイト.jpg')},
            //     {id: 2, color_id: 1, name: 'white', color_img: require('../../images/toilet/ToiletBowlColors/オフホワイト.jpg')},
            //     {id: 3, color_id: 1, name: 'white', color_img: require('../../images/toilet/ToiletBowlColors/ブルーグレー.jpg')},
            //     {id: 4, color_id: 1, name: 'white', color_img: require('../../images/toilet/ToiletBowlColors/ピンク.jpg')},
            //     {id: 5, color_id: 2, name: 'white', color_img: require('../../images/toilet/ToiletBowlColors/white.jpg')},
            //     {id: 6, color_id: 2, name: 'pink', color_img: require('../../images/toilet/ToiletBowlColors/pink.jpg')},
            //     {id: 7, color_id: 2, name: 'ivory', color_img: require('../../images/toilet/ToiletBowlColors/ivory.jpg')},
            //     {id: 8, color_id: 3, name: 'white', color_img: require('../../images/toilet/ToiletBowlColors/L150K.jpg')},
            //     {id: 9, color_id: 3, name: 'ebony', color_img: require('../../images/toilet/ToiletBowlColors/ebony.jpg')},
            //     {id: 10, color_id: 3, name: 'crimson', color_img: require('../../images/toilet/ToiletBowlColors/crimson.jpg')},
            //     {id: 11, color_id: 3, name: 'gold', color_img: require('../../images/toilet/ToiletBowlColors/gold.jpg')},
            //     {id: 12, color_id: 3, name: 'copper', color_img: require('../../images/toilet/ToiletBowlColors/copper.jpg')},
            // ]
        }
    },

    methods: {
        getSubItems(){
            axios({
                method: 'get',
                url: 'api/getSubItems',
            }).then (res => {
                this.sub_items = res.data;

                console.log(res.data, 'sub-items')
            })
        },

        getProducts(item){
            axios({
                method: 'post',
                url: 'api/getProducts',
                data: item
            }).then (res => {
                this.products = res.data;
                console.log(res.data, 'products')
            })
        },

        selectItem(item){
            console.log(item,'clicked!!')
        },

        getData(){
            axios({
                method: 'get',
                url: 'api/getDataToilet'
            }).then((res)=>{
                this.cartItems = res.data;
                this.cartItemCount = res.data.length;
            })
        },

        // getToCart(item){
        //     console.log(item, 'items to be cart-ed')
        // },
        
        addToCart(item){
            console.log(item, 'item')

            this.cart.filter(r=>{
                r.type = 'トイレ';
                r.image = item.image_path;
                r.accesories_image = item.add_image;
                r.item_name = item.item_name;
                r.product_name = item.product_name;
                // r.color_name = item.color;
                r.price = item.price;
                r.description = item.description;
            })

            console.log(this.cart, 'cart')

            axios({
                method: 'post',
                url: 'api/save',
                data: this.cart
            }).then(r=>{
                console.log(r)
                Swal.fire(
                    "you're item is added!",
                    'Item successfully cart-ed!',
                    'success'
                    )
            })
            this.getData();
        },

        removeItem(id){
                console.log(id)

                Swal.fire({
                    title: 'Are you sure to remove this item?',
                    text: "You can add this anytime, anyways.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e57373',
                    cancelButtonColor: 'gray',
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, i changed my mind'
                }).then((result) => {
                if (result.isConfirmed) {

                        axios({
                            method: 'post',
                            url: `api/remove/${id}`,
                        }).then((res)=>{
                            let i = this.cartItems.map(item => item.id).indexOf(id);
                            this.cartItems.splice(i, 1);
                            console.log(i)

                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'your item is removed!',
                                showConfirmButton: false,
                                timer: 1500
                            })

                            this.getData();
                        })
                    }

                })
            },
        
    },

    mounted(){
        this.getSubItems();
        this.getProducts();
        this.getData();

        // this.products.forEach(e1 => {
        //     this.sub_items.forEach(e2 => {
        //         if(e1.item_id == e2.id){
        //             e2.products.push(e1)
        //         }
        //     })
        // });

        // this.colors.forEach(e1 => {
        //     this.products.forEach(e2 =>{
        //         if(e1.color_id == e2.color_id){
        //             e2.color_content.push(e1)
        //         }
        //     })
        // })

        // document.getElementById("colors").innerHTML = 'yci dna delacs';
        // console.log(this.products)
        // console.log(this.sub_items[0].products) 
    }
    
}
</script>

<style>

</style>