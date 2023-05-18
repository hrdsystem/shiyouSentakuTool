<template>
    <v-app>
        <center>
            <div style="margin: 10px;">

                <!-- <template>
                    <div>
                        <v-alert
                            :value="alert"
                            border="left"
                            close-text="Close Alert"
                            color="deep-purple accent-4"
                            dark
                            dismissible
                        >
                            <v-row>
                                <v-col cols="1" >
                                    <p style="padding-top: 25px; margin-bottom: 0; font-family: 'Comic Neue';">
                                        {{countDown}}
                                    </p>
                                </v-col>
                                <v-col cols="11">
                                    When using <b>Laptops</b>, UI is much better using <b>80% of the screen</b> and
                                    <br>
                                    When using <b>Computers</b>, UI is much better using <b>100% of the screen</b>.
                                    <br>
                                    This is an Initial Design for Shiyousho Catalog but Responsiveness will also be a priority someday, Thank you.
                                </v-col>
                            </v-row>
                        </v-alert>
                    </div>
                </template> -->
                
                <v-card id="header-container" max-width="1280" elevation="0">
                    <v-row> 
                        <v-col id="sub-header-container">
                            <img src="../images/toire.png" alt="" width="60px" height="60px">
                            <!-- <v-img max-height="60" max-width="60" :src="require('../images/No_Image_Available.jpg')"></v-img> -->
                            <!-- <img src="storage/images/left_top_icon.jpg" alt="" width="60px" height="60px"> -->
                            <div id="sub-header-text-container"> 
                                <!-- <p>カテゴリ項目</p>     --> 
                                <!-- <h2>トイレ</h2>     --> 
                                <h2 style="font-family: 'Noto Sans JP', sans-serif !important; font-weight: 500 !important; padding-top: 37px;">
                                    {{ this.items[0] == undefined ? '' : this.items[0].main_items_name}}
                                </h2>     
                            </div>
                        </v-col>
                        <v-col style="padding: 25px; text-align: right;"> 
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
                                                :content="cartItems.length == 0 ? '0' : cartItems.length"
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
                                                                Image
                                                            </th>
                                                            <th class="text-center">
                                                                Category
                                                            </th>
                                                            <th class="text-center">
                                                                Item
                                                            </th>
                                                            <th class="text-center">
                                                                Kind
                                                            </th>
                                                            <th class="text-center">
                                                                Color
                                                            </th>
                                                            <th class="text-center">
                                                                Color Image
                                                            </th>
                                                            <th class="text-center">
                                                                Actions
                                                            </th> 
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item,i) in cartItems" :key="i">
                                                            <td class="text-center">{{ i + 1 }}</td> 
                                                            <td class="text-center">
                                                                <img style="width: 100px; height: 80px;" :src="item.image" alt=""> 
                                                            </td>
                                                            <td class="text-center">{{ item.item }}</td>
                                                            <td class="text-center">{{ item.type }}</td>
                                                            <td class="text-center">{{ item.kind }}</td> 
                                                            <td class="text-center">{{ item.color == NULL ? 'default' : item.color }}</td>  
                                                            <td class="text-center">
                                                                <img style="width: 100px; height: 80px;" :src="item.color_img" alt=""> 
                                                            </td>
                                                            <!-- <td class="text-center">{{ item.type }}</td>
                                                            <td class="text-center">{{ item.color }}</td> 
                                                            <td class="text-center">{{ item.kind }}</td>
                                                            <td class="text-center">{{ item.item }}</td> -->
                                                            <td class="text-center">
                                                                <v-btn @click="removeItem(item.id)" color="red lighten-2"> 削除
                                                                    <v-icon>mdi-delete</v-icon>
                                                                </v-btn>
                                                                <!-- <v-btn> 
                                                                    <v-icon>mdi-pencil</v-icon>
                                                                </v-btn> -->
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </template>
                                            </v-simple-table>
                                        </v-card>
                                    </v-dialog>
                                </div>
                            </template>
                            <!-- <p style="text-align: right; font-family: 'Klee One';"><v-icon>mdi-medal-outline</v-icon> More Quality Products from > 
                                <a style="text-decoration: none" target="_blank" href="https://www.ichijo.co.jp/inquiry/form/catalog/"><b>Ichijo</b></a>
                            </p> -->
                        </v-col>
                    </v-row>
                </v-card>

                <v-card width="1280" style="margin-top: 20px; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important;">
                    <v-tabs
                        background-color="primary"
                        color="black"
                        v-model="tab"
                        centered
                        icons-and-text
                        height="50" 
                    >
                        <v-tab ripple 
                        v-for="(item, i) in items" 
                        :key ="i"
                        @click="selectItem2(item)">
                            <!-- <p style="font-size: 13px;">便器</p> -->
                            <p style="font-size: 13px;">{{ item.item_name }}</p> 
                            <!-- <v-icon style="padding-top: 8px;">mdi-toilet</v-icon> -->
                        </v-tab>

                        <v-tab-item
                        v-for="(item, i) in items" 
                        :key ="i"
                        style="box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.75) 0px 4px 8px !important;">
                            <!-- //////////////////////////////////////////////////////////
                                //    *     *     *      TOILET BOWL   *     *     *     //
                                ////////////////////////////////////////////////////////// -->
                            <!-- <v-card v-if="this.toShow == 'bowl'" max-width="1280" style="display:flex; margin-top: 10px; background-color: rgba(255, 255, 255, .5) !important;" elevation="0" > -->
                            <v-card max-width="1280" style="display:flex; background-color: rgba(255, 255, 255, 0.01) !important;" elevation="0" >
                                <v-card id="main-container" width="1000" elevation="0">
                                    <v-row>

                                        <v-col cols="" style="margin-right: 20px; margin-bottom: 20px;">
                                            <v-card style="position: relative; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.75) 0px 4px 8px !important;" height="555" width="500">
                                                <img style="position: relative;
                                                top: 0;
                                                left: 0; width: 100%; height: 100%; object-fit: cover;" :src="image" :alt="image" v-if="image" />
                                                <img v-show="colors != ''" style="border-radius: 5px; object-fit: cover; background-color: rgba(255, 255, 255, 0.01) !important; position: absolute; bottom: 30px; right: 30px; border: 3px #E57373 solid; width: 20%; height: 20%; object-fit: cover;" :src="color_img" :alt="color_img" v-if="color_img" />
                                                <!-- <inner-image-zoom :height=440 :width=440 hasSpacer :src="image" :zoomSrc="image" /> -->
                                            </v-card>
                                        </v-col>

                                        <v-col cols="" style="margin-right: 15px;"> 
                                            <h1 style="text-align: left; margin-left: -7px; font-family: 'Klee One'; font-size:3vw">
                                                {{ item.item_name }}
                                            </h1>
                                            <p style="text-align: left; font-family: 'Klee One'; font-weight: 600; margin: 0;">
                                                これは長い長い説明です 
                                            </p>

                                            <div style="display: flex; margin-top: 15px; padding-right: 100%; text-align: left; justify-content: left;">
                                                <p v-show="classificationStatus == 1" style="text-align: left; margin-right: 10px; font-family: 'Comic Neue'; font-weight: 600; font-size: 14px;"> 
                                                    <b>Classification</b> 
                                                </p>

                                                <template>
                                                    <div 
                                                    v-show="classificationStatus == 1" 
                                                    class="text-left" 
                                                    style="margin: 0 !important;"
                                                    >
                                                        <v-menu
                                                        
                                                        :close-on-content-click="false"
                                                        :nudge-width="200"
                                                        offset-x
                                                        >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn
                                                                @mouseover="hover = true"
                                                                @mouseleave="hover = false"
                                                                small
                                                                elevation="3"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                                >
                                                                <v-icon>mdi-filter</v-icon>
                                                            </v-btn>
                                                        </template>

                                                        <v-card>
                                                            <v-list>
                                                                <v-list-item style="background-color: #74b1ed;">

                                                                    <v-list-item-content>
                                                                        <v-list-item-title>
                                                                            <b>Maker</b>
                                                                        </v-list-item-title>
                                                                    </v-list-item-content>

                                                                    <v-icon>mdi-numeric-1-box</v-icon>
                                                                </v-list-item> 
                                                                    <template> 
                                                                        <v-data-table
                                                                            v-model="selectedClassificationOne"
                                                                            :headers="classificationOneHeader" 
                                                                            :items="filteredClassification"
                                                                            :items-per-page="999"
                                                                            :single-select="true"
                                                                            item-key="maker_code"   
                                                                            show-select
                                                                            hide-default-header
                                                                            hide-default-footer
                                                                            class="elevation-1" 
                                                                        >
                                                                        </v-data-table>  
                                                                    </template>
                                                            </v-list>

                                                            <!-- <v-list>
                                                                <v-list-item style="background-color: #74b1ed;">

                                                                    <v-list-item-content>
                                                                        <v-list-item-title>
                                                                            <b>Classification 2</b>
                                                                        </v-list-item-title>
                                                                    </v-list-item-content>

                                                                    <v-icon>mdi-numeric-2-box</v-icon>
                                                                </v-list-item> 
                                                                <template> 
                                                                    <v-card  
                                                                        :disabled="selectedClassificationOne.length == 0 || selectedClassificationThree.length >= 1"
                                                                    >         
                                                                        <v-data-table
                                                                            v-model="selectedClassificationTwo"
                                                                            :headers="classificationOneHeader" 
                                                                            :items="classificationTwo"
                                                                            :items-per-page="999"
                                                                            :single-select="true"
                                                                            item-key="BUNRUI_CD_2"   
                                                                            show-select
                                                                            hide-default-header
                                                                            hide-default-footer
                                                                            class="elevation-1" 
                                                                        >
                                                                        </v-data-table>
                                                                    </v-card>
                                                                </template>
                                                            </v-list>

                                                            <v-list>
                                                                <v-list-item style="background-color: #74b1ed;">

                                                                    <v-list-item-content>
                                                                        <v-list-item-title>
                                                                            <b>Classification 3</b>
                                                                        </v-list-item-title>
                                                                    </v-list-item-content>

                                                                    <v-icon>mdi-numeric-3-box</v-icon>
                                                                </v-list-item>
                                                                <template>  
                                                                    <v-card   
                                                                        :disabled="selectedClassificationOne.length == 0 || selectedClassificationTwo.length == 0" 
                                                                    >
                                                                        <v-data-table
                                                                            v-model="selectedClassificationThree" 
                                                                            :headers="classificationOneHeader" 
                                                                            :items="classificationThree"
                                                                            :items-per-page="999"
                                                                            :single-select="true"
                                                                            item-key="BUNRUI_CD_3"   
                                                                            show-select
                                                                            hide-default-header
                                                                            hide-default-footer
                                                                            class="elevation-1" 
                                                                        >
                                                                        </v-data-table>
                                                                    </v-card>
                                                                </template> 
                                                            </v-list> -->

                                                            <v-divider></v-divider>

                                                            <!-- <v-card-actions>
                                                            <v-spacer></v-spacer>

                                                            <v-btn
                                                                text
                                                                @click="menu = false"
                                                            >
                                                                Cancel
                                                            </v-btn>
                                                            <v-btn
                                                                color="primary"
                                                                text
                                                                @click="menu = false"
                                                            >
                                                                Save
                                                            </v-btn>
                                                            </v-card-actions> -->
                                                        </v-card>
                                                        </v-menu>
                                                    </div>
                                                </template>

                                                <div v-if="hover" style="text-align: left !important; padding-left: 20px; padding-bottom: 0; margin-bottom: 0;">
                                                    <p style="padding: 0; margin: 0; font-size: 14px;">
                                                            <b>Classification 1 :</b>  {{ selectedClassificationOne[0] === undefined ? 'none' : selectedClassificationOne[0].manufacturer_name }} 
                                                    </p> 
                                                    <!-- <p style="padding: 0; margin: 0; font-size: 14px;">
                                                            <b> 2 :</b> {{ selectedClassificationTwo[0] === undefined ? 'none' : selectedClassificationTwo[0].BUNRUI_MEI }}
                                                    </p>  
                                                    <p style="padding: 0; margin: 0; font-size: 14px;">
                                                            <b> 3 :</b> {{ selectedClassificationThree[0] === undefined ? 'none' : selectedClassificationThree[0].BUNRUI_MEI }}
                                                    </p>   -->
                                                </div> 
                                            </div>

                                            <p style="display: flex; text-align: left; margin-bottom: 0; margin-top: 10px; font-family: 'Comic Neue'; font-weight: 600;">
                                                <p v-if="filteredKinds.length >= 1" style="text-align: left; font-family: 'Comic Neue'; font-size: 14px;"> 
                                                    <b>Kinds</b> ー {{ kindSelected != '' ? kindSelected : 'select a kind' }}
                                                </p>  
                                                <p v-else style="text-align: left; font-family: 'Comic Neue'; font-size: 14px;"> 
                                                    <b>no content available</b>
                                                </p>    
                                            </p> 

                                            <div class="select-size" style="max-height: 140px !important; min-height: 50px !important; overflow-y: auto; text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">
                                                
                                                <v-card v-for="(img,i) in filterKinds" :key="i" style="padding:3px; border: 1px solid #ddd; cursor: pointer; text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;" width="50" height="50" elevation="0">

                                                    <input @click="getKind(img.name)" :id="img.id" type="radio" name="image" v-model="image" :value="img.image"/>

                                                    <v-img
                                                        class="hoverBorder"
                                                        @click="getColor(img)" style="width: 100%; height: 100%; object-fit: cover;" v-if="img.image_path != null" max-height="200" max-width="200" :src="require(`../images/toilet/${img.image_path}`)">
                                                    </v-img>
                                                    <v-img
                                                        class="hoverBorder"
                                                        @click="getColor(img)" style="width: 100%; height: 100%; object-fit: cover;" v-else="img.image_path == null" max-height="200" max-width="200" :src="require('../images/No_Image_Available.jpg')">
                                                    </v-img> 
 
                                                </v-card>
                                            </div>     

                                            <p style="display: flex;  text-align: left; margin-bottom: 0; font-family: 'Comic Neue'; font-weight: 600;">
                                                <p v-if="kindSelected != '' && colors != ''" style="text-align: left; font-family: 'Comic Neue'; font-size: 14px; margin-top: 20px;">  
                                                    <b>Colors</b> ー {{ colorSelected != '' ? colorSelected : 'select a color' }} 
                                                </p>  
                                                <p v-else style="text-align: left; font-family: 'Comic Neue'; font-size: 14px; margin-top: 20px;">  
                                                    <!-- select a kind -->
                                                </p>   
                                            </p> 

                                            <div v-show="kindSelected != '' && colors != ''" style="max-height: 140px !important; min-height: 50px !important; overflow-y: auto; text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">  
                                                <v-card v-for="(Imgcolor,i) in colors" :key="i"  style="padding:3px; border: 1px solid #ddd; cursor: pointer; text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;" width="50" height="50" elevation="0">
                                                    <!-- <v-img style="width: 100%; height: 100%; object-fit: cover;" :id="color.id" v-model="image" :src="color.bowlImage" @click="toGetColor(color.color, color.bowlImage)" width="50" height="50"></v-img>  -->
                                                    
                                                    <v-img
                                                        class="hoverBorder"
                                                        @click="selectedColor(Imgcolor)"    
                                                        style="width: 100%; height: 100%; object-fit: cover;" v-if="Imgcolor.image_path != null" max-height="200" max-width="200" :src="require(`../images/toilet/${Imgcolor.image_path}`)">
                                                    </v-img>
                                                    <v-img
                                                        class="hoverBorder"
                                                        @click="selectedColor(Imgcolor)"
                                                        style="width: 100%; height: 100%; object-fit: cover;" v-else="Imgcolor.image_path == null" max-height="200" max-width="200" :src="require('../images/No_Image_Available.jpg')">
                                                    </v-img> 
                                                </v-card>  
                                            </div>

                                            <v-btn @click="addtoCart()" color="primary" elevation="0" style="color: white; margin-top: 25px; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important; font-family: 'Comic Neue';" block><v-icon>mdi-cart</v-icon>&nbsp; カートに追加</v-btn>
                                        </v-col>
                                    </v-row>  
                                </v-card>

                                <v-card width="280" elevation="0" color="#f8f8fa" style="border: 1px dotted black; padding-top: 20px; padding-right: 25px; padding-left: 25px; 
                                background: rgba(0, 0, 0, 0.08);
                                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);  
                                backdrop-filter: blur(3.7px); 
                                -webkit-backdrop-filter: blur(3.7px);
                                border: 1px solid rgba(0, 0, 0, 0.5);
                                "> 
                                    <p style="font-family: 'Klee One'; margin-top: 10px;"><v-icon>mdi-crown-circle-outline</v-icon> 100% オリジナル商品</p>

                                    <p style=" font-family: 'Comic Neue'; font-weight: 600; text-align: left; margin-top: 10px;"><b>Order Type ></b></p>
                                    <v-select style="width: 200px; margin-bottom: 15px;" dense outlined rounded label="International" :items="Scope" hide-details></v-select>
 
                                    <p style=" font-family: 'Comic Neue'; font-weight: 600; font-size: 15px; text-align: left;"><b>Details ></b></p>
                                    <p style=" font-family: 'Klee One'; font-weight: 600; text-align: left; font-size: 13px; ">Lorem ipsum dolor sit amet.</p> 
                                        <p style=" font-family: 'Comic Neue'; font-weight: 400; text-align: left; font-size: 13px;">    
                                        Vestibulum finibus laoreet pellentesque. In ac maximus enim. Vestibulum semper lacus non sapien rutrum interdum. Vestibulum scelerisque suscipit dolor, fringilla semper ipsum elementum nec. Curabitur vitae pharetra felis. Cras euismod neque nisi. Aliquam erat volutpat. Maecenas erat libero, tincidunt at lectus non, mollis venenatis nulla. 
                                    </p>

                                    <div style="padding-top: 50px;">
                                        <v-btn icon> 
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://www.ichijo.co.jp/"><v-icon>mdi-web</v-icon></a>
                                        </v-btn>
                                        <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://www.ichijo.co.jp/sns/line/"><v-icon>mdi-phone</v-icon></a>
                                        </v-btn>
                                    </div> 
                                                         
                                    <p style="font-family: 'Comic Neue'; font-weight: 600; margin-bottom: 0; padding-top: 50px;">Any Concerns? ></p>
                                    <a style="font-family: 'Klee One'; text-decoration: none" target="_blank" href="https://www.ichijo.co.jp/inquiry/#inquiry01"><b>Inquiry Here</b></a>
                                </v-card> 
                            </v-card>

                        </v-tab-item>
                    </v-tabs>
                </v-card>

                <!-- ************************************************************ -->
                <!-- ************************************************************ -->
                <!-- ************************************************************ -->
                 <!-- <img src="../images/toilet/ToiletBowlColors/10.jpg" alt=""> -->
            </div>
        </center>
    </v-app>    
</template>

<script>
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import InnerImageZoom from 'vue-inner-image-zoom';
import Swal from 'sweetalert2'
import { mapState } from 'vuex';
    export default {

        components: {
            'inner-image-zoom': InnerImageZoom
        },

        data: () => ({
            hover: false,
            // menu: false,
            filteredClassification: [],
            selectedClassificationOne: [],
            selectedClassificationTwo: [],
            selectedClassificationThree: [],

            countDown: 8,
            alert: true,
            dialog: false,

            toShow: 'bowl',
            // image: 'http://sc04.alicdn.com/kf/H974dd26d48fb4a84a39f3d23cbafad04z.jpg',
            image: require('../images/No_Image_Available.jpg'),
            remote: require('../images/toilet/remote/J1.jpg'),
            // remote: 'https://fairness-world.com/wp-content/uploads/2019/09/The-High-Tech-Toilet-Features-FAIR-Inc.jpg',
            towel: require('../images/Shiyousho_Catalog/towel_rack/タオルリング.png'),
            // image: 'storage/images/bowl_default.png',
            // remote: 'storage/images/remote_default.png',
            // towel: 'storage/images/towel1.png',

            images: [
                {
                    id: 'cover',    
                    name: 'カバー',
                    // image: require('../images/toilet/imgColor/white.jpg'),
                    // image: 'http://sc04.alicdn.com/kf/H974dd26d48fb4a84a39f3d23cbafad04z.jpg'
                    // image: 'js/images/toilet/imgColor/white.jpg'
                    // image: 'storage/images/bowl_default.png'
                },
                {
                    id: 'remote',
                    name: 'リモート',
                    // image: require('../images/toilet/remote/J1.jpg'),
                    // image: 'https://fairness-world.com/wp-content/uploads/2019/09/The-High-Tech-Toilet-Features-FAIR-Inc.jpg',
                    // image: 'storage/images/remote_default.png',
                },
                {
                    id: 'faucet',
                    name: '蛇口',
                    // image: require('../images/toilet/standard/HWTank.jpg'),
                    // image: 'https://preview.redd.it/s5z9f6yh3cu11.jpg?auto=webp&s=e2ca669bafbea516602cf6dbdb54b360fc3ca80b',
                    // image: 'storage/images/faucet1.png',
                },
                
            ],


            //////////////////////////////////////////////////////////
            //     *    *    *      DATA FOR BOWL    *    *    *    //
            //////////////////////////////////////////////////////////

            bowlColors: [
                {
                    id: 1,
                    color: 'white',
                    // bowlImage: require('../images/toilet/imgColor/white.jpg'),
                    // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/kjk_xch1500wsk'
                    // bowlImage: 'storage/images/white.jpg'
                },
                {
                    id: 2,
                    color: 'ebony',
                    // bowlImage: require('../images/toilet/imgColor/ebony.jpg'),
                    // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/biy-japan_xch1502eyb'
                    // bowlImage: 'storage/images/ebony.jpg'
                },
                {
                    id: 3,
                    color: 'sand gold',
                    // bowlImage: require('../images/toilet/imgColor/gold.jpg'),
                    // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/biy-japan_xch1501sn'
                    // bowlImage: 'storage/images/sand_gold.jpg'
                },
                {
                    id: 4,
                    color: 'crimson',
                    // bowlImage: require('../images/toilet/imgColor/white.jpg'),
                    // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/kjk_xch1500bnbk'
                    // bowlImage: 'storage/images/crimson.jpg'
                },
                {
                    id: 5,
                    color: 'copper',
                    // bowlImage: require('../images/toilet/imgColor/copper.jpg'),
                    // bowlImage: require('../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/銅 (copper)/TBC005.jpg')
                    // bowlImage: 'storage/images/copper.jpg'
                },
            ],

            bowlRemote: [
                {
                    id: 1,
                    // remoteName: 'L150Kタイプ2',
                    remoteName: 'Remote 1',
                    remoteImage: require('../images/toilet/remote/J1.jpg'),
                    // remoteImage: 'https://fairness-world.com/wp-content/uploads/2019/09/The-High-Tech-Toilet-Features-FAIR-Inc.jpg'
                    // remoteImage: 'storage/images/remote_default.png'
                },
                {
                    id: 2,
                    // remoteName: 'スティックリモコン',
                    remoteName: 'Remote 2',
                    remoteImage: require('../images/toilet/remote/S1.jpg'),
                    // remoteImage: 'https://rimage.gnst.jp/livejapan.com/public/article/detail/a/00/03/a0003727/img/basic/a0003727_main.jpg?20200528090657'
                    // remoteImage: 'storage/images/remote2.png'
                },
                {
                    id: 3,
                    // remoteName: 'スティックリモコン',
                    remoteName: 'Remote 3',
                    remoteImage: require('../images/toilet/remote/Apricot-F1AF3.jpg'),
                    // remoteImage: 'https://rimage.gnst.jp/livejapan.com/public/article/detail/a/00/03/a0003727/img/basic/a0003727_main.jpg?20200528090657'
                    // remoteImage: 'storage/images/remote2.png'
                },
            ],
            Remotes: [
                {
                    id: 1,
                    color: 'Remote1',
                    remotesImage: require('../images/toilet/remote/S1-1.jpg'),
                    // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/kjk_xch1500wsk'
                    // bowlImage: 'storage/images/white.jpg'
                },
                {
                    id: 2,
                    color: 'Remote2',
                    remotesImage: require('../images/toilet/remote/Apricot-F1AF3-1.jpg'),
                    // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/biy-japan_xch1502eyb'
                    // bowlImage: 'storage/images/ebony.jpg'
                },

            ],

            faucetType: [
                {
                    id: 1,
                    faucetName:'Faucet',
                    faucetImage: require('../images/toilet/standard/HWTank.jpg'),
                    // faucetImage:'https://preview.redd.it/s5z9f6yh3cu11.jpg?auto=webp&s=e2ca669bafbea516602cf6dbdb54b360fc3ca80b'
                    // faucetImage:'storage/images/faucet1.png'
                },
                {
                    id: 2,
                    faucetName:'Without Faucet',
                    faucetImage: require('../images/toilet/standard/Tank.jpg'),
                    // faucetImage:'https://www.signaturehardware.com/media/catalog/product/cache/1/image/1500x/9df78eab33525d08d6e5fb8d27136e95/5/1/518149-21-elongated-two-piece-bidet.jpg'
                    // faucetImage:'storage/images/faucet2.png'
                }
            ],

            coverType: [
                {
                    id: 1,
                    coverName: 'Plain Cover',
                    // coverImage: require('../images/toilet/imgColor/white.jpg'),
                    // coverImage: 'http://sc04.alicdn.com/kf/H974dd26d48fb4a84a39f3d23cbafad04z.jpg'
                    // coverImage: 'storage/images/bowl_default.png'
                },
            ],

            //////////////////////////////////////////////////////////
            //     *   *   *     DATA FOR TOWEL RACK   *   *   *    //
            //////////////////////////////////////////////////////////

            towels:
            [
                {
                    id: 'towelRing',
                    // name: 'タオルリング',
                    name: 'タオルリング',
                    towel: require('../images/Shiyousho_Catalog/towel_rack/タオルリング.png')
                    // towel: 'storage/images/towel1.png'
                },
                {
                    id: 'bathTowelRack',
                    // name: 'バスタオル掛け',
                    name: 'バスタオル掛け',
                    towel: require('../images/Shiyousho_Catalog/towel_rack/バスタオル掛け.png')
                    // towel: 'storage/images/towel2.png'
                },
            ],

            Scope: ['Local', 'International'],
            tab: null,

            //Default Values
            item:'bowl',
            kindValue: 'カバー',
            getType: 'default',
            color: 'white',
            color_img: require('../images/No_Image_Available.jpg'),
            // color_img: 'storage/images/white.png',

            //Changed Values
            cart: [
                {
                item: '',
                image: '',
                kind: '',
                type: '',
                color: '',
                color_img: '',
    
                }
            ],
            cartItems: [],

            // * * * * * * * * * * * MAIN DATA * * * * * * * * * * * //

        shioData: [],
        items: [],
        maker: [],
        kind: [],

        classificationStatus: 0,
        classificationData: [],

        classificationOne: [],
        classificationOneHeader: [
            {
                value:'manufacturer_name', 
                sortable : false
            }
        ],

        classificationTwo: [],
        classificationThree: [],

        kinds: [],
        kindSelected: '',
        filteredKinds: [],

        colors: [],
        colorSelected: '',
    }),  
    
    
        methods:{
            // getColor(goods_mei){
            //     console.log(goods_mei,'to pass to color data')
            // },

            selectedColor(Imgcolor){

                this.color_img = require('../images/toilet/' + Imgcolor.image_path);
                // ../images/toilet/ToiletBowlColors/10.jpg
                console.log(Imgcolor.image_path, 'imgcolor')

                if(Imgcolor.color_name.length == 1){
                    if(Imgcolor.color_name == '\\N' || Imgcolor.color_name == '' || Imgcolor.color_name == null){
                        this.colorSelected = 'Default';
                    }else{
                        this.colorSelected = Imgcolor.color_name;
                    }
                }else{
                    if(Imgcolor.color_name == '\\N' || Imgcolor.color_name == '' || Imgcolor.color_name == null){
                        this.colorSelected = 'Default';
                    }else{
                        this.colorSelected = Imgcolor.color_name;
                    }
                }

                
                // this.color_img = require('../images/ToiletBowlColors/' + goods_mei.image_path);
                
            },

            getColor(goods_mei){

                console.log(goods_mei, 'img path')
                
                axios({
                    method: 'post',
                    url: 'api/getColor',
                    data: goods_mei
                }).then(r=>{
                    console.log(r,'getColor Data')

                    this.colors = r.data;
                    this.colorSelected = '';
                    
                    
                })

                // this.color_img = require('../images/toilet/' + goods_mei.image_path);

                if(goods_mei.image_path != null){
                    this.image = require('../images/toilet/' + goods_mei.image_path);
                }else{
                    this.image = require('../images/No_Image_Available.jpg');
                }

                this.kindSelected = goods_mei.product_name

                this.kind = goods_mei.product_name; // FOR SAVING KINDS
                // item: '',
                // type: '',
                // color: '',
                // color_img: '',

                this.color_img = require('../images/No_Image_Available.jpg');
            },

            selectItem2(item){

                console.log(item, 'WWWWWWWWWW')

                axios({
                    method: 'post',
                    url: 'api/getClassification',
                    data: item
                }).then(r=>{
                    console.log(r.data, 'HELLO')
                    this.classificationStatus = r.data.withClassification;
                    this.filteredClassification = [...new Map(r.data.classification1.map((m) => [m.maker_code, m])).values()];
                    this.kinds = r.data.kinds;
                    console.log(this.kinds,'kinds')
                    console.log(this.filteredClassification, 'CLASS1')
                    this.filteredKinds = [...new Map(this.kinds.map((m) => [m.product_code, m])).values()];
                    console.log(this.selectedClassificationOne, 'selected1')
                    console.log(this.filteredKinds, 'FUWAFSSHH')

                    if(r.data.kinds[0]){
                        if(r.data.kinds[0].image_path != null){
                            this.image = require('../images/toilet/' + r.data.kinds[0].image_path); // FOR SAVING IMAGE
                        }else{
                            this.image = require('../images/No_Image_Available.jpg'); // FOR SAVING IMAGE
                        }
                    }else{
                        this.image = require('../images/No_Image_Available.jpg');
                    }
                    
                    // console.log(r.data.subItem[0].sub_item_name, 'subItem')
                    // this.subItem = r.data.subItem[0].sub_item_name
                    this.subItem = item.item_name;
                })

                this.colors = [];
                this.kindSelected = '';
                this.selectedClassificationOne = [];
                
                
            },

            //////////////////////////////////////////////////////////
            // *   *   *     SUMMARY OF DATA COLLECTED   *   *   *  //
            //////////////////////////////////////////////////////////

            addtoCart(){

                this.cart.filter(r =>{

                    r.item = this.item;
                    r.image = this.image;
                    r.kind = this.kindSelected;
                    r.type = this.subItem;
                    r.color = this.colorSelected;
                    r.color_img = this.color_img;
                })

                console.log(this.cart[0] , 'updated cart')

                axios({
                    method: 'post',
                    url: 'api/save',
                        data: {
                            item : this.item,
                            image : this.image,
                            kind : this.kindSelected,
                            type : this.subItem,
                            color : this.colorSelected,
                            color_img : this.color_img                    
                        }
                }).then((res)=>{
                    console.log(res)
                    this.getData();

                Swal.fire(
                    "you're item is added!",
                    'Item successfully cart-ed!',
                    'success'
                    )

                }).catch(function (err) {
                    console.log(err);
                });

            },

            getData(){
                axios({
                    method: 'get',
                    url: 'api/getData'
                }).then((res)=>{
                    this.cartItems = res.data
                    //this.testonly
                    // this.cartItemCount = res.data.length
                    console.log(res.data.length)
                })
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

            countDownTimer() {
                if (this.countDown > 0) {
                    setTimeout(() => {
                        this.countDown -= 1
                        this.countDownTimer()
                    }, 1000)
                }
            },
        },

        computed : {
            ...mapState(['item2List']),

            filterKinds(){
                // console.log(this.selectedClassificationTwo.length , 'classification2')
                // console.log(this.selectedClassificationThree.length , 'classification3')
                let data = this.filteredKinds.filter(r=>{
                    if(this.selectedClassificationOne.length > 0){
                        return r.maker_code == this.selectedClassificationOne[0].maker_code 
                    }else{
                        return r
                    }
                })
                // .filter(r => {
                //     if(this.selectedClassificationTwo.length > 0){
                //         return r.BUNRUI_CD_2 == this.selectedClassificationTwo[0].BUNRUI_CD_2 
                //     }else{
                //         return r
                //     }
                // }).filter(r => {
                //     if(this.selectedClassificationThree.length > 0){
                //         return r.BUNRUI_CD_3 == this.selectedClassificationThree[0].BUNRUI_CD_3
                //     }else{
                //         return r
                //     }
                // })

                return data;
            }
        },

        watch : {
            item2List(val){
                this.items = val;
                console.log(this.items[0], '><><><><><><><')
                
                // this.item2List;
                // console.log(this.item2List, 'itemssssss')

                this.image = require('../images/No_Image_Available.jpg'); // FOR SAVING IMAGE DEFAULT

                this.selectItem2(val[0]); // FOR AUTOMATICALLY PICKING OF THE FIRST KIND

                console.log(this.items[0].main_items_name, 'item')
                this.item = this.items[0].main_items_name; //FOR SAVING ITEM
            },

            // selectedClassificationOne(val){
            //     if(val){
            //         if(val.length > 0){
            //             axios({
            //                 method: 'post',
            //                 url: 'api/getClassificationTwo',
            //                 data:val[0]
            //             }).then(r=>{
            //                 this.classificationTwo = r.data;
            //             })
            //         }
            //     }
            // },

            // selectedClassificationTwo(val){
            //     if(val){
            //         if(val.length > 0){
            //             axios({
            //                 method: 'post',
            //                 url: 'api/getClassificationThree',
            //                 data:val[0]
            //             }).then(r=>{
            //                 this.classificationThree = r.data;
            //                 console.log(this.classificationThree, '3!')
            //             })
            //         }
            //     }
            // }
        },

        mounted() {
            this.getData();
        },

        created(){
            // this.getDataSentakuTool();

            this.countDownTimer()

            setTimeout(()=>{
                this.alert=false
            }, 8000)
        }

        
    }
</script>

<style scoped>
    /* html { overflow-y: hidden } */

    .swal2-popup {
        font-family: 'Comic Neue' !important;
    }

    #app{
        background: url('https://img.freepik.com/free-vector/white-abstract-background_23-2148810113.jpg?w=1380&t=st=1677717031~exp=1677717631~hmac=c872caef3e223b52dea907ac40c5c5cdb3a10046714e90a9623caac08b671a68') 
        no-repeat center center
        fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
        /* background-size: cover; */
    }

    #header-container{
        /* background-color: #f8f8fa; */
        box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important;
        background-color: rgba(255, 255, 255, .9);
        padding-top: 10px;
        padding-left: 10px;
        padding-right: 20px;
        margin-top: 10px;
    }

    #sub-header-container{
        display: flex;
    }

    #sub-header-container img{
        box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important;
    }

    #sub-header-text-container{
        margin-left: 10px;
    }
    .v-tabs-slider{
        color:#ff8E00 !important;
    }

    #sub-header-text-container p{
        margin-top: 10px;
        font-size: 12px;
        font-family: 'Comic Neue'; 
        font-weight: 600;
    }

    #sub-header-text-container h2{
        margin-top: -30px !important;
        font-weight: 600 !important;
        font-family: 'Klee One' !important;
        font-size: 30px;
    }

    /* main */

    #main-container{
        /* padding-top: 50px;
        padding-left: 50px; */
        padding: 50px;
        box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important;
        background-color: rgba(255, 255, 255, .2) !important;
    }

    /* asdasdads */

    .select-size  input{
        display: none;
    }

    .labels {
        display: inline-block;
        width: 120px;
        height: 50px;
        text-align: center;
        border: 1px solid #ddd;
        line-height: 50px;
        cursor: pointer
    }

    .label {
        display: inline-block;
        width: 80px;
        height: 50px;
        text-align: center;
        border: 1px solid red;
        line-height: 50px;
        cursor: pointer
    }

    .label2 {
        display: inline-block;
        width: 100%;
        height: 100%;
        text-align: center;
        border: 1px solid #ddd;
        line-height: 50px;
        cursor: pointer
    }

    /* kind */
    #faucet:checked ~ label[for="faucet"],
    #remote:checked ~ label[for="remote"],
    #cover:checked ~ label[for="cover"] {
        border: 3px dotted red;
        /* border: 3px dotted #005e8d; */
        background: red;
        color: #000000;
    }
    /* type */
    #remote1:checked ~ label[for="remote1"],
    #remote2:checked ~ label[for="remote2"] {
        border: 3px dotted red;
        /* border: 3px dotted #005e8d; */
        background: red;
        color: #000000;
    }

    #towelRing:checked ~ label[for="towelRing"],
    #bathTowelRack:checked ~ label[for="bathTowelRack"]{
        border: 3px dotted red;
        /* border: 3px dotted #005e8d; */
        background: white;
        color: #000000;
    }

    .hoverBorder:hover{
        border: 2px dotted darkblue;
    }

    @import url('https://fonts.googleapis.com/css2?family=Klee+One:wght@400;600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@300;400;700&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@500;700;900&display=swap');
</style>
