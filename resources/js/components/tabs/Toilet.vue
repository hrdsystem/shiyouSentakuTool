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
                            persistent
                            v-model="dialog"
                            
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
                            
                            <v-card class="d-none d-sm-block">
                                <div style="display: flex; padding-left: 25px; padding-right: 25px; padding-top: 25px;">
                                    <h2 class="text-left s-header">あなたのカート ( {{ cartItems.length }} )</h2>
                                    <v-spacer></v-spacer>
                                    <v-btn icon @click="dialog = false;" class="close" style="margin-top: 5px; margin-right: 8px;">
                                        <v-icon large>mdi-close</v-icon>
                                    </v-btn>
                                </div>

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
                                                <td class="text-center" style="width: 300px;">
                                                    <div class="s-mid-header" v-if="item.description.length > 70" style="overflow-y: scroll !important; height:90px !important; margin-top: 5px; margin-bottom: 5px;">
                                                        {{ item.description }}
                                                    </div>
                                                    <div class="s-mid-header" v-if="item.description.length < 70">
                                                        {{ item.description }}
                                                    </div>
                                                </td>
                                                <td class="text-center s-mid-header">
                                                    <v-btn tile @click="removeItem(item.id)" color="red lighten-2"> 削除
                                                        <v-icon>mdi-delete</v-icon>
                                                    </v-btn>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </template>
                                </v-simple-table>
                            </v-card>

                            <v-card class="d-block d-sm-none">
                                <div style="display: flex;">
                                    <h2 class="text-left s-header" style="padding-left: 15px; padding-top: 5px; padding-bottom: 5px;">あなたのカート ( {{ cartItems.length }} )</h2>
                                    <v-divider></v-divider>
                                    <v-btn icon @click="dialog = false;" class="close" style="margin-top: 5px; margin-right: 8px;">
                                        <v-icon large>mdi-close</v-icon>
                                    </v-btn>
                                </div>
                                
                                <v-card>
                                    <v-simple-table style="padding: 10px;">
                                        <template v-slot:default>
                                            <thead>
                                                <tr>
                                                
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="(item,i) in cartItems" :key="i" style="margin-bottom: 0 !important;" height="150">
                                                    <td style="padding: 0 8px">
                                                        <v-img max-height="140" max-width="100" :src="require(`../../images/toilet/${item.image}`)"></v-img>
                                                    </td>
                                                    <td style="padding: 0 8px">
                                                        <div>
                                                            <p class="text-left s-header" style="font-size: 15px; margin-bottom: 0 !important;">{{ item.product }}</p>
                                                            <p class="text-left s-mid-header" style="font-size: 12px; margin-bottom: 0 !important;">{{ item.item }}</p>
                                                            <p class="text-left s-mid-header" style="font-size: 12px; margin-bottom: 0 !important;">{{ item.type }}</p>
                                                            <td class="text-left s-mid-header" style="font-size: 12px; margin-bottom: 0 !important;">{{ item.price }}</td>
                                                        </div>
                                                    </td>
                                                    <!-- <td class="text-center s-mid-header">{{ item.color ? item.color : 'default'}}</td> -->
                                                    
                                                    <!-- <td class="text-center" style="width: 300px;">
                                                        <div class="s-mid-header" v-if="item.description.length > 70" style="overflow-y: scroll !important; height:90px !important; margin-top: 5px; margin-bottom: 5px;">
                                                            {{ item.description }}
                                                        </div>
                                                        <div class="s-mid-header" v-if="item.description.length < 70">
                                                            {{ item.description }}
                                                        </div>
                                                    </td> -->
                                                    <td class="text-center s-mid-header" style="padding: 0 8px">
                                                        <v-btn tile @click="removeItem(item.id)" color="red lighten-2">
                                                            <v-icon>mdi-delete</v-icon>
                                                        </v-btn>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </template>
                                    </v-simple-table>
                                    <!-- <v-btn @click="CartItems()" block color="#3fd168" class="s-header">
                                        <v-icon>mdi-cart-arrow-right</v-icon>
                                        &nbsp;
                                        チェックアウト</v-btn>
                                    &nbsp; -->
                                </v-card>
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

                    <!-- start of show SM and Above -->
                    <v-card v-if="products[0]" style="display: flex; padding-right: 40%;" class="d-none d-sm-none d-md-flex">
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
                                <v-list-item-title class="s-sub-header" style="width: 400px;">設計に相談したい</v-list-item-title>
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
                        tile
                        >メモ</v-btn>
                    </v-card>
                    <v-card v-if="!products[0]" class="d-none d-sm-none d-md-flex">
                    </v-card>

                    <!-- end of show SM and Above -->
                    <!-- start of show XS only -->

                    <v-card v-if="products[0]" class="d-block d-sm-block d-md-none" height="250">
                        <v-list-item>
                            <template v-slot:default="{ active }">
                                <v-list-item-action>
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
                                <v-list-item-action>
                                    <v-checkbox
                                        :input-value="active"
                                        color="primary"
                                    ></v-checkbox>
                                </v-list-item-action>

                                <v-list-item-content>
                                <v-list-item-title class="s-sub-header" style="width: 400px;">設計に相談したい</v-list-item-title>
                                </v-list-item-content>
                            </template>
                        </v-list-item>
                        <v-list-item>
                            <template v-slot:default="{ active }">
                                <v-list-item-action>
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
                                <v-list-item-action>
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
                        style="margin-top: 10px; margin-left: 20px; background-color: whitesmoke;"
                        class="s-title"
                        width="100"
                        small
                        outlined
                        tile
                        >メモ</v-btn>
                    </v-card>
                    <v-card v-if="!products[0]" class="d-block d-sm-block d-lg-none">
                    </v-card>
                    <!-- end of show XS only -->

                        <div id="s-d"
                        v-if="products[0]"
                        >
                            <v-card v-for="(item, i) in products" :key="i" style="border: 1px solid #ddd; flex-wrap: wrap; justify-content: center; gap: 10px; position: relative !important; " width="520" height="400" elevation="0">
                                <v-card @click="selectItem(item)" width="520" height="398" elevation="0">
                                    <!-- {{ item }} -->
                                    <v-col>
                                        <v-row>
                                            <v-col style="display: flex;">
                                                <v-list-item-title class="s-header-title" style="font-size: 20px;">{{ item.product_name }}</v-list-item-title>
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
                                            <h5 class="s-header d-flex d-sm-none" style="margin-left: 12px;">価格: 
                                                    <!-- <v-icon style="font-size: 15px; ">
                                                        mdi-currency-jpy
                                                    </v-icon> -->
                                                    {{ item.price ? item.price : 'No Indicated Value'}}
                                                </h5>
                                            <v-col style="display: flex;">
                                                <!-- {{ item.image_path }} -->
                                                <v-img class="d-flex d-sm-none" max-height="230" :src="require(`../../images/toilet/${item.image_path}`)"></v-img>
                                                <v-img class="d-none d-sm-flex" max-height="250" max-width="250"  :src="require(`../../images/toilet/${item.image_path}`)"></v-img>
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

                                                <h5 class="s-header d-none d-sm-flex">価格: 
                                                    <v-icon style="font-size: 15px; margin-bottom: 3px;">
                                                        mdi-currency-jpy
                                                    </v-icon>
                                                    {{ item.price ? item.price : 'No Indicated Value'}}
                                                </h5>

                                                &nbsp;

                                                <div class="d-none d-sm-flex" style="padding: 0 !important; margin: 0 !important;">
                                                    <p class="s-sub-header "
                                                    style="display: -webkit-box;
                                                    max-width: 200px;
                                                    -webkit-line-clamp: 2;
                                                    -webkit-box-orient: vertical;
                                                    overflow: hidden;"
                                                    >
                                                        {{ item.description ? item.description : 'No Indicated Description' }}  
                                                    </p>
                                                </div>

                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-card>

                                <!-- start of show SM and Above -->

                                <div class="d-none d-sm-flex" style="position: absolute !important; top: 60%; left: 53%;">
                                
                                        <!-- <v-text-field 
                                        v-model="item.qty"
                                        type="number" 
                                        min="1"
                                        max="8"
                                        >
                                        </v-text-field> -->
                                        <!-- {{ item.qty }} -->
                                    <div style="display: block;">
                                        <v-btn
                                        class="s-sub-header"
                                        elevation="0"
                                        outlined
                                        tile
                                        >
                                            <v-icon>
                                                mdi-image-frame
                                            </v-icon>プレビュー
                                        </v-btn>
                                        &nbsp;
                                        <v-btn 
                                        class="s-sub-header"
                                        elevation="0"
                                        outlined 
                                        tile
                                        @click="addToCart(item)"
                                        >
                                            <v-icon>
                                                mdi-cart
                                            </v-icon>add
                                        </v-btn>
                                    </div>
                                </div>

                                <!-- end of show SM and Above -->
                                <!-- start of show XS only -->

                                <div class="d-flex d-sm-none" style="margin-left: 15px; position: absolute !important; top: 85%"> 
                                
                                        <!-- <v-text-field 
                                        v-model="item.qty"
                                        type="number" 
                                        min="1"
                                        max="8"
                                        >
                                        </v-text-field> -->
                                        <!-- {{ item.qty }} -->
                                    <div style="display: block;">
                                        <v-btn
                                        class="s-sub-header"
                                        elevation="0"
                                        outlined
                                        tile
                                        >
                                            <v-icon>
                                                mdi-image-frame
                                            </v-icon>プレビュー
                                        </v-btn>
                                        &nbsp;
                                        <v-btn 
                                        class="s-sub-header"
                                        elevation="0"
                                        outlined 
                                        tile
                                        @click="addToCart(item)"
                                        >
                                            <v-icon>
                                                mdi-cart
                                            </v-icon>add
                                        </v-btn>
                                    </div>
                                </div>
                                <!-- end of show XS only -->
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
                        width="900"
                        height="700"
                        >
                            <v-card class="pr-5 pl-5">
                                <v-row>
                                    <v-col>
                                        <v-row>
                                            <v-col>
                                                <v-card-text>
                                                    <div style="display: flex; padding-top: 6px;">
                                                        <h4 class="text-left s-mid-header" style="font-size: 15px;">トイレ</h4>
                                                        <v-icon>mdi-menu-right</v-icon> 
                                                        <h4 class="text-left s-mid-header" style="font-size: 15px;">
                                                            {{itemSelected.item_name}}
                                                        </h4>
                                                    </div>
                                                    &nbsp;
                                                    <div>
                                                        <h1 class="text-left s-header-title pt-2" style="font-size: 40px; line-height: 100%;">{{itemSelected.product_name}}</h1>
                                                    </div>
                                                </v-card-text>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-card-text style="padding-top: 0;">
                                                    <p class="s-header-title">価格: {{ itemSelected.price }}</p>
                                                    <p class="s-sub-header">{{ itemSelected.description }}</p>
                                                </v-card-text>
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                    <v-col>
                                        <v-card-text class="text-right ml-2">
                                            <v-btn icon @click="closeSelectedItem()" class="close">
                                                <v-icon>mdi-close</v-icon>
                                            </v-btn>
                                        </v-card-text>
                                        <v-img v-if="itemSelected.image_path != undefined" max-height="400" max-width="400" :src="require(`../../images/toilet/${itemSelected.image_path}`)"></v-img>
                                        <v-img v-else max-height="250" max-width="250" :src="require(`../../images/No_Image_Available.jpg`)"></v-img>
                                        &nbsp;
                                        <div style="display: flex; justify-content: start;">
                                            
                                            <v-img :src="require(`../../images/No_Image_Available.jpg`)" max-height="120" max-width="120"></v-img>
                                        </div>
                                        &nbsp;
                                        <div style="display: flex; justify-content: start;">
                                            
                                            <v-img :src="require(`../../images/No_Image_Available.jpg`)" max-height="120" max-width="120"></v-img> 
                                            <v-img :src="require(`../../images/No_Image_Available.jpg`)" max-height="120" max-width="120"></v-img>
                                            <v-img :src="require(`../../images/No_Image_Available.jpg`)" max-height="120" max-width="120"></v-img>
                                        </div>
                                        &nbsp;
                                    </v-col>
                                </v-row>
                            
                                <v-divider></v-divider>

                                <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn 
                                    class="mr-1"
                                    style="width: 100px;" 
                                    outlined
                                    tile
                                    @click="addToCart(itemSelected)">
                                    <v-icon>
                                        mdi-cart
                                    </v-icon>add
                                </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>

                        <template>
                            <div class="text-center">
                                <v-dialog
                                v-model="dialog2"
                                width="500"
                                >
                                    <v-text-field></v-text-field>
                                <v-card>
                                    
                                </v-card>
                                </v-dialog>
                            </div>
                        </template>
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
            dialog2: false,
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
        CartItems(){
            console.log(this.cartItems)
        },

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