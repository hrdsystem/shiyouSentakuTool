<template>
    <div>
        <!-- <v-card elevation="0" style="display: flex; padding-left: 50px; padding-right: 50px;"> -->
        <v-card elevation="0" style="display: flex; padding-left: 50px; padding-right: 50px;">
            <h1 style="font-weight: 800;">トイレ</h1>
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
                                                <th class="text-center s-header-title">
                                                    No.
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Type
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Images
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Item
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Product
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Color
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Price
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Description
                                                </th>
                                                <th class="text-center s-header-title">
                                                    Actions
                                                </th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item,i) in cartItems" :key="i">
                                                <!-- {{ item }} -->
                                                <td class="text-center s-mid-header">{{ i + 1 }}</td> 
                                                <td class="text-center s-mid-header" style="width: 100px;">{{ item.type }}</td>
                                                <td class="text-center s-mid-header" style="width: 20px;">
                                                    <!-- <img style="width: 80px; height: 80px;" :src="item.image" alt="">  -->
                                                    <!-- {{ item.image }} -->
                                                    <v-img max-height="100" max-width="100" :src="require(`../../images/toilet/${item.image}`)"></v-img>
                                                </td>
                                                <td class="text-center s-mid-header">{{ item.item }}</td>
                                                <td class="text-center s-mid-header">{{ item.product }}</td>
                                                <td class="text-center s-mid-header">{{ item.color ? item.color : 'default'}}</td>
                                                <td class="text-center s-mid-header">{{ item.price }}</td>
                                                <td class="text-center s-mid-header" style="width: 300px;">{{ item.description }}</td>
                                                <td class="text-center s-mid-header">
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
                        <v-list-item-title class="s-sub-header" >
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
                                <v-list-item-action style="display: block: !important;">
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
                        <v-card v-for="(item, i) in products" :key="i" style="border: 1px solid #ddd; flex-wrap: wrap; justify-content: center; gap: 10px; position: relative !important; " width="520" height="350" elevation="0">
                            <v-card @click="selectItem(item)" width="520" height="348" elevation="0">
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

                                            <p class="s-sub-header"
                                            style="display: -webkit-box;
                                            max-width: 200px;
                                            -webkit-line-clamp: 2;
                                            -webkit-box-orient: vertical;
                                            overflow: hidden;"
                                            >
                                                {{ item.description ? item.description : 'No Indicated Description' }}  
                                            </p>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-card>
                            <div style="position: absolute !important; top: 60%; left: 53%;">
                                
                                    <!-- <v-text-field 
                                    v-model="item.qty"
                                    type="number" 
                                    min="1"
                                    max="8"
                                    >
                                    </v-text-field> -->
                                    <!-- {{ item.qty }} -->
                                <div style="display: flex;">
                                    <v-btn
                                    class="s-sub-header"
                                    elevation="0"
                                    outlined>
                                        <v-icon>
                                            mdi-image-frame
                                        </v-icon>プレビュー
                                    </v-btn>
                                    <v-btn 
                                    class="s-sub-header"
                                    elevation="0"
                                    outlined 
                                    @click="addToCart(item)">
                                        <v-icon>
                                            mdi-cart
                                        </v-icon>add
                                    </v-btn>
                                </div>
                                
                            </div>
                            
                        </v-card >    
                            
                        </div>
                        <div v-if="!products[0]">
                            <p>no items available as of the moment</p>
                        </div>
                </v-list-group>

                <template>
                    <div class="text-center">
                        <v-dialog
                        persistent
                        v-model="itemDialog"
                        width="500"
                        >

                        <v-card>
                            <v-col>
                                <v-row>
                                    <v-card-title class="text-left s-title">
                                        {{itemSelected.product_name}}
                                    </v-card-title>
                                </v-row>
                                <v-row>
                                    <v-col>
                                        <v-card-text>
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </v-card-text>
                                    </v-col>
                                    <v-col>
                                        <v-img v-if="itemSelected.image_path != undefined" max-height="250" max-width="250" :src="require(`../../images/toilet/${itemSelected.image_path}`)"></v-img>
                                        <v-img v-else max-height="250" max-width="250" :src="require(`../../images/No_Image_Available.jpg`)"></v-img>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    
                                </v-row>
                            </v-col>
                            

                            <v-divider></v-divider>

                            <v-divider></v-divider>

                            <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn 
                                style="width: 100px;" 
                                outlined
                                @click="addToCart(itemSelected)">
                                <v-icon>
                                    mdi-cart
                                </v-icon>add
                            </v-btn>
                            <v-btn
                                color="primary"
                                text
                                @click="closeSelectedItem()"
                            >
                            <v-icon>
                                mdi-close
                            </v-icon>
                                close
                            </v-btn>
                            </v-card-actions>
                        </v-card>
                        </v-dialog>
                    </div>
                </template>
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
            itemDialog: false,
            qty: 0,

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
                qty: 1,
                }
            ],
            itemSelected: [],
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
            this.products = []

            console.log(this.products, 'product status')

            axios({
                method: 'post',
                url: 'api/getProducts',
                data: item
            }).then (res => {
                this.products = res.data;
                console.log(res.data, 'productss')
            })
            
        },

        selectItem(item){
            console.log(item,'clicked!!')
            this.itemSelected = item;
            this.itemDialog = true;
        },

        closeSelectedItem(){
            this.itemSelected = [];
            this.itemDialog = false;
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
                r.qty = item.qty;
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
        // this.getProducts();
        this.getData();
        console.log(this.itemSelected, 'itemSelected');

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