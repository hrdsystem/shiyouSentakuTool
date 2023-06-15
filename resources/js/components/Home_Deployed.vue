<template>
    <v-app>
        <center>
            <div style="margin: 10px;">

                <template>
                    <div>
                        <v-alert
                        :value="alert"
                        border="left"
                        close-text="Close Alert"
                        color="deep-purple accent-4"
                        dark
                        dismissible
                        >
                        When using <b>Laptops</b>, UI is much better using <b>80% of the screen</b> and
                        <br>
                        When using <b>Computers</b>, UI is much better using <b>100% of the screen</b>.
                        <br>
                        This is an Initial Design for Shiyousho Catalog but Responsiveness will also be a priority someday, Thank you.
                        </v-alert>
                    </div>
                </template>
                
                <v-card id="header-container" max-width="1280" elevation="0">
                    <v-row>
                        <v-col id="sub-header-container">
                            <!-- <img src="../images/toire.png" alt="" width="60px" height="60px"> -->
                            <img src="storage/images/left_top_icon.jpg" alt="" width="60px" height="60px">
                            <div id="sub-header-text-container">
                                <p>REST ROOM</p>    
                                <h2>トイレ</h2>    
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
                                                        Image
                                                    </th>
                                                    <th class="text-center">
                                                        Item
                                                    </th>
                                                    <th class="text-center">
                                                        Color
                                                    </th>
                                                    <th class="text-center">
                                                        Kind
                                                    </th>
                                                    <th class="text-center">
                                                        Type
                                                    </th>
                                                    <th class="text-center">
                                                        Actions
                                                    </th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,i) in cartItems" :key="i"
                                                    >
                                                    <td class="text-center">{{ i + 1 }}</td> 
                                                    <td class="text-center">
                                                        <img style="width: 80px; height: 80px;" :src="item.image" alt=""> 
                                                    </td>
                                                    <td class="text-center">{{ item.type }}</td>
                                                    <td class="text-center">{{ item.color }}</td>
                                                    <td class="text-center">{{ item.kind }}</td>
                                                    <td class="text-center">{{ item.item }}</td>
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
                        background-color="#77d2ff"
                        color="black"
                        v-model="tab"
                        centered
                        icons-and-text
                        height="50"
                    >
                        <v-tab ripple @click="toggleFunctionBowl()">
                            <p style="font-size: 13px;">便器</p>
                            <v-icon style="padding-top: 8px;">mdi-toilet</v-icon>
                        </v-tab>
                        <v-tab ripple @click="toggleFunctionTowel()">
                            <p style="font-size: 13px;">タオル掛け</p>
                            <v-icon style="padding-top: 8px;">mdi-hanger</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;">リモコン</p>
                            <v-icon style="padding-top: 8px;">mdi-remote</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;">リモコン便器洗浄ユニット</p>
                            <v-icon style="padding-top: 8px;">mdi-remote-tv</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;">紙巻器</p>
                            <v-icon style="padding-top: 8px;">mdi-paper-roll</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;">低流動圧対応ユニット</p>
                            <v-icon style="padding-top: 8px;">mdi-car-brake-low-pressure</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;">トイレ収納</p>
                            <v-icon style="padding-top: 8px;">mdi-database</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;">トイレ手摺</p>
                            <v-icon style="padding-top: 8px;">mdi-fence</v-icon>
                        </v-tab>
                        <v-tab ripple>
                            <p style="font-size: 13px;"> 床パネル穴位置</p>
                            <v-icon style="padding-top: 8px;">mdi-solar-panel-large</v-icon>
                        </v-tab>

                        <v-tab-item style="box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.75) 0px 4px 8px !important;">
                            <!-- //////////////////////////////////////////////////////////////////////
                            ////////////////////////       TOILET BOWL        /////////////////////////
                            /////////////////////////////////////////////////////////////////////// -->

                            <!-- <v-card v-if="this.toShow == 'bowl'" max-width="1280" style="display:flex; margin-top: 10px; background-color: rgba(255, 255, 255, .5) !important;" elevation="0" > -->
                            <v-card max-width="1280" style="display:flex; background-color: rgba(255, 255, 255, 0.01) !important;" elevation="0" >
                                <v-card id="main-container" height="650" width="1000" elevation="0">
                                    <v-row>
                                        <!-- <v-col cols="1" style="margin-left: 20px !important; padding-top: 30px;"> -->
                                            <!-- <img style="border: 3px dotted #005e8d; cursor: pointer;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKxxqwaBSWhFEr42gKaZvca_zN39UZlz1ur0ufnwiSkHcjFnVGs0w1Z_yc1kS439QQIcM&usqp=CAU" alt="toilet bowl" width="50">
                                            <img @click="toggleFunctionTowel()" style="border: 1px solid #cccccc; cursor: pointer;" src="https://images.thdstatic.com/productImages/7f072ab9-59c6-4ac1-8c51-d9797ba2a29e/svn/matte-black-glacier-bay-towel-racks-20173-0710h-64_300.jpg" alt="Towel Rack" width="50"> -->
                                            <!-- <img style="border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/エボニー (ebony)/TBC002.jpg" alt="" width="50">
                                            <img style="border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/エボニー (ebony)/TBC002.jpg" alt="" width="50"> -->
                                        <!-- </v-col> -->
                                        <v-col cols="" style="margin-right: 20px; margin-bottom: 20px;">
                                            <v-card style="box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.75) 0px 4px 8px !important;" height="540" width="400">
                                                <img style="width: 100%; height: 100%; object-fit: cover;" :src="image" :alt="image" v-if="image" />
                                                <!-- <inner-image-zoom :height=440 :width=440 hasSpacer :src="image" :zoomSrc="image" /> -->
                                            </v-card>
                                        </v-col>

                                        <v-col cols="" style="margin-right: 15px; margin-top: 5px;">
                                            <h1 style="text-align: left; margin-left: -7px; font-family: 'Klee One'; font-size: 50px;">便器</h1>
                                            <p style="text-align: left; font-family: 'Klee One'; font-weight: 600;">これは長い長い説明です</p>
                                            <h2 style="text-align: left; font-family: 'Klee One'; font-weight: 600;  margin-bottom: 10px;">¥:00000</h2>

                                            <p style="text-align: left; margin: auto; font-family: 'Comic Neue'; font-weight: 600;"> 
                                                <b>Kind</b>
                                            </p>

                                            <div class="select-size" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">
                                                
                                                <div v-for="(img,i) in images" :key="i" >
                                                    <!-- <input type="radio" name="s-size" id="faucet" checked/>
                                                    <input type="radio" name="s-size" id="remote" />
                                                    <input type="radio" name="s-size" id="cover" />

                                                    <label class="label" for="faucet">faucet</label>
                                                    <label class="label" for="remote">remote</label>
                                                    <label class="label" for="cover">cover</label> -->

                                                    <input @click="getKind(img.name)" :id="img.id" type="radio" name="image" v-model="image" :value="img.image"/>

                                                    <label style="font-family: 'Klee One'; font-size: 15px;" class="label" :for="img.id">
                                                            {{img.name}}
                                                    </label>
                                                </div>
                                            </div> 

                                            <p v-if="kindValue == 'リモート'" style="text-align: left; margin-bottom: 0; margin-top: 20px; font-family: 'Comic Neue'; font-weight: 600;"><b>Type</b></p> 

                                            <div v-if="kindValue == 'リモート'" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">
                                                
                                                <v-card v-for="(remote,i) in bowlRemote" :key="i"  style="border: 1px solid #ddd; cursor: pointer; text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;" width="50" elevation="0">

                                                    <!-- <input style="display: none;" :id="remote.id" type="radio" name="remote" v-model="remotee" :value="remote.remoteImage"/> -->
                                                    
                                                    <!-- <label style="font-family: 'Klee One'; font-size: 15px;" class="label2" :for="remote.id"> -->
                                                        <!-- {{ remote.remoteName }} -->
                                                        <v-img style="width: 100%; height: 100%; object-fit: cover;" :src="remote.remoteImage" @click="getBowlType(remote.remoteName, remote.remoteImage)" width="50" height="50"></v-img>
                                                        <!-- <v-img></v-img> -->
                                                    <!-- </label> -->

                                                </v-card> 
                                            </div>

                                            <p v-if="kindValue == '蛇口'" style="text-align: left; margin-bottom: 0; margin-top: 20px; font-family: 'Comic Neue'; font-weight: 600;"><b>Type</b></p> 

                                            <div v-if="kindValue == '蛇口'" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">

                                                <v-card v-for="(faucet,f) in faucetType" :key="f" style="border: 1px solid #ddd; text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;" width="50" elevation="0">
                                                    <v-img style="width: 100%; height: 100%; object-fit: cover; padding:5px; cursor: pointer;" :id="faucet.id" v-model="image" :src="faucet.faucetImage" @click="getBowlType(faucet.faucetName, faucet.faucetImage)" width="50"></v-img>
                                                </v-card>
                                            </div>

                                            <p v-if="kindValue == 'カバー'" style="text-align: left; margin-bottom: 0; margin-top: 20px; font-family: 'Comic Neue'; font-weight: 600;"><b>Type</b></p> 

                                            <div v-if="kindValue == 'カバー'" style=" text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">

                                                <v-card v-for="(cover,i) in coverType" :key="i" style="border: 1px solid #ddd; text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;" width="50" elevation="0"> 
                                                    <v-img style="width: 100%; height: 100%; object-fit: cover; padding:5px; cursor: pointer;" :id="cover.id" v-model="image" :src="cover.coverImage" @click="getBowlType(cover.coverName, cover.coverImage)" width="50"></v-img>
                                                </v-card>
                                            </div>
            
                                            <p v-if="kindValue == 'カバー'" style="text-align: left; margin-bottom: 0; margin-top: 20px; font-family: 'Comic Neue'; font-weight: 600;"><b>Color</b></p> 

                                            <div v-if="kindValue == 'カバー'" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">  
                                                
                                                <v-card v-for="(color,i) in bowlColors" :key="i"  style="padding:3px; border: 1px solid #ddd; cursor: pointer; text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;" width="50" elevation="0">
                                                    <v-img style="width: 100%; height: 100%; object-fit: cover;" :id="color.id" v-model="image" :src="color.bowlImage" @click="toGetColor(color.color, color.bowlImage)" width="50" height="50"></v-img> 
                                                    <!-- <img style="padding:5px; border: 2px dotted #005e8d; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/ホワイト(white)/TBC001.jpg" alt="" width="50">
                                                    <img style="padding:5px; border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/エボニー (ebony)/TBC002.jpg" alt="" width="50">
                                                    <img style="padding:5px; border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/沙金 (sand_gold)/TBC004.jpg" alt="" width="50">
                                                    <img style="padding:5px; border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/紅殻色 (crimson_color)/TBC003.jpg" alt="" width="50">
                                                    <img style="padding:5px; border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/銅 (copper)/TBC005.jpg" alt="" width="50"> -->
                                                </v-card>  
                                            </div>

                                            <v-btn @click="addtoCart()" color="#77d2ff" elevation="0" style="margin-top: 25px; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important; font-family: 'Comic Neue';" block><v-icon>mdi-cart</v-icon>&nbsp; カートに追加</v-btn>
                                            <v-btn outlined elevation="0" style="margin-top: 10px; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important; font-family: 'Comic Neue';" block><v-icon>mdi-heart-outline</v-icon>&nbsp; ほしい物リストに追加する</v-btn>
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
                                        <!-- <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://www.youtube.com/channel/UCGiaiTXTbCWPkcvEWRw69VA"><v-icon>mdi-youtube</v-icon></a>
                                        </v-btn>
                                        <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://www.facebook.com/ichijokomuten/"><v-icon>mdi-facebook</v-icon></a>
                                        </v-btn>
                                        <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://twitter.com/joekun_ichijo"><v-icon>mdi-twitter</v-icon></a>
                                        </v-btn> -->
                                    </div>
                                                        
                                    <p style="font-family: 'Comic Neue'; font-weight: 600; margin-bottom: 0; padding-top: 50px;">Any Concerns? ></p>
                                    <a style="font-family: 'Klee One'; text-decoration: none" target="_blank" href="https://www.ichijo.co.jp/inquiry/#inquiry01"><b>Inquiry Here</b></a>
                                </v-card>
                            </v-card>

                        </v-tab-item>
                        <v-tab-item>
                        
                            <!-- //////////////////////////////////////////////////////////////////////
                            /////////////////////////////        TOWEL        /////////////////////////
                            /////////////////////////////////////////////////////////////////////// -->
                        
                            <v-card max-width="1280" style="display:flex; background-color: rgba(255, 255, 255, .5) !important;" elevation="0">

                                <v-card id="main-container" height="650" width="1000" elevation="0">
                                    <v-row>
                                        <!-- <v-col cols="1" style="margin-left: 20px !important; padding-top: 30px;"> -->
                                            <!-- <img @click="toggleFunctionBowl()" style="border: 1px solid #cccccc; cursor: pointer;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKxxqwaBSWhFEr42gKaZvca_zN39UZlz1ur0ufnwiSkHcjFnVGs0w1Z_yc1kS439QQIcM&usqp=CAU" alt="toilet bowl" width="50">
                                            <img style="border: 3px dotted #005e8d; cursor: pointer;" src="https://images.thdstatic.com/productImages/7f072ab9-59c6-4ac1-8c51-d9797ba2a29e/svn/matte-black-glacier-bay-towel-racks-20173-0710h-64_300.jpg" alt="Towel Rack" width="50"> -->
                                            <!-- <img style="border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/エボニー (ebony)/TBC002.jpg" alt="" width="50">
                                            <img style="border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/エボニー (ebony)/TBC002.jpg" alt="" width="50"> -->
                                        <!-- </v-col> -->
                                        <v-col cols="" style="margin-right: 20px; margin-bottom: 20px;">
                                            <v-card style="box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.75) 0px 4px 8px !important;" height="540" width="400">
                                                <img style="width: 100%; height: 100%; object-fit: cover;" :src="towel" :alt="towel"/> 
                                                <!-- <inner-image-zoom :height=440 :width=440 hasSpacer :src="towel" :zoomSrc="towel" /> -->
                                            </v-card> 
                                        </v-col>

                                        <v-col cols="" style="margin-right: 15px; margin-top: 5px;">
                                            <h1 style="margin-left: -8px; text-align: left; font-family: 'Klee One'; font-size: 50px;">タオル掛け</h1>
                                            <p style="text-align: left; font-family: 'Klee One'; font-weight: 600;">これは長い長い説明です</p>
                                            <h2 style="text-align: left; font-family: 'Klee One'; font-weight: 600;  margin-bottom: 10px;">¥:00000</h2>
                                            <p style="text-align: left; margin: auto; font-family: 'Comic Neue'; font-weight: 600;"> 
                                                <b>Kind</b>
                                            </p>

                                            <div class="select-size" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">

                                                <div v-for="(c,i) in towels" :key="i" >
                                                    <!-- <input type="radio" name="s-size" id="faucet" checked/>
                                                    <input type="radio" name="s-size" id="remote" />
                                                    <input type="radio" name="s-size" id="cover" />

                                                    <label class="label" for="faucet">faucet</label>
                                                    <label class="label" for="remote">remote</label>
                                                    <label class="label" for="cover">cover</label> -->

                                                    <input @click="getKind(c.name,c.towel,c.id)" :id="c.id" type="radio" name="towel" v-model="towel" :value="c.towel"/>

                                                    <label style="font-family: 'Klee One'; font-size: 15px;" class="labels" :for="c.id">
                                                            {{c.name}}
                                                    </label>
                                                </div>
                                            </div>
                                            
                                            <!-- <p style="text-align: left; margin-bottom: 0; margin-top: 20px; font-family: 'Comic Neue'; font-weight: 600;"><b>Color</b></p>
                                            <div style="text-align: left; flex-wrap: wrap; justify-content: center; gap: 10px;">
                                                <img style="border: 3px dotted #005e8d; cursor: pointer;" src="../images/Shiyousho_Catalog/towel_rack/タオルリング.png" alt="" width="50">
                                                <img style="border: 1px solid #cccccc; cursor: pointer;" src="../images/Shiyousho_Catalog/towel_rack/バスタオル掛け.png" alt="" width="50">
                                            </div> --> 
                                                <v-btn @click="addtoCart()" color="#77d2ff" elevation="0" style="margin-top: 25px; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important; font-family: 'Comic Neue';" block><v-icon>mdi-cart</v-icon>&nbsp; カートに追加</v-btn>
                                                <v-btn outlined elevation="0" style="margin-top: 10px; box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important; font-family: 'Comic Neue';" block><v-icon>mdi-heart-outline</v-icon>&nbsp; ほしい物リストに追加する</v-btn>
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
                                        <!-- <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://www.youtube.com/channel/UCGiaiTXTbCWPkcvEWRw69VA"><v-icon>mdi-youtube</v-icon></a>
                                        </v-btn>
                                        <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://www.facebook.com/ichijokomuten/"><v-icon>mdi-facebook</v-icon></a>
                                        </v-btn>
                                        <v-btn icon>
                                            <a style="text-decoration: none; color: gray;" target="_blank" href="https://twitter.com/joekun_ichijo"><v-icon>mdi-twitter</v-icon></a>
                                        </v-btn> -->
                                    </div>
                                                        
                                    <p style="font-family: 'Comic Neue'; font-weight: 600; margin-bottom: 0; padding-top: 50px;">Any Concerns? ></p>
                                    <a style="font-family: 'Klee One'; text-decoration: none" target="_blank" href="https://www.ichijo.co.jp/inquiry/#inquiry01"><b>Inquiry Here</b></a>
                                </v-card>
                            </v-card>

                        </v-tab-item>  
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item>
                            <v-card elevation="0">
                                <p>this section is undermaintenance</p>
                            </v-card>
                        </v-tab-item>
                    </v-tabs>
                </v-card>

                <!-- ************************************************************ -->
                <!-- ************************************************************ -->
                <!-- ************************************************************ -->

                
            </div>
        </center>
    </v-app>    
</template>

<script>
import 'vue-inner-image-zoom/lib/vue-inner-image-zoom.css';
import InnerImageZoom from 'vue-inner-image-zoom';
import Swal from 'sweetalert2'
export default {
    components: {
    'inner-image-zoom': InnerImageZoom
    },
    data: () => ({
        alert: true,
        dialog: false,
        toShow: 'bowl',
        // image: 'http://sc04.alicdn.com/kf/H974dd26d48fb4a84a39f3d23cbafad04z.jpg',
        // remote: 'https://fairness-world.com/wp-content/uploads/2019/09/The-High-Tech-Toilet-Features-FAIR-Inc.jpg',
        // towel: require('../images/Shiyousho_Catalog/towel_rack/タオルリング.png'),
        image: 'storage/images/bowl_default.png',
        remote: 'storage/images/remote_default.png',
        towel: 'storage/images/towel1.png',
        images: 
        [
            {
                id: 'cover',    
                name: 'カバー',
                // image: 'http://sc04.alicdn.com/kf/H974dd26d48fb4a84a39f3d23cbafad04z.jpg'
                image: 'storage/images/bowl_default.png'
            },
            {
                id: 'remote',
                name: 'リモート',
                // image: 'https://fairness-world.com/wp-content/uploads/2019/09/The-High-Tech-Toilet-Features-FAIR-Inc.jpg',
                image: 'storage/images/remote_default.png',
            },
            {
                id: 'faucet',
                name: '蛇口',
                // image: 'https://preview.redd.it/s5z9f6yh3cu11.jpg?auto=webp&s=e2ca669bafbea516602cf6dbdb54b360fc3ca80b',
                image: 'storage/images/faucet1.png',
            },
            
        ],


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                                                        DATA FOR BOWL                                                           //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        bowlColors: [
            {
                id: 1,
                color: 'white',
                // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/kjk_xch1500wsk'
                bowlImage: 'storage/images/white.jpg'
            },
            {
                id: 2,
                color: 'ebony',
                //bowlImage: 'https://item-shopping.c.yimg.jp/i/l/biy-japan_xch1502eyb'
                bowlImage: 'storage/images/ebony.jpg'
            },
            {
                id: 3,
                color: 'sand gold',
                // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/biy-japan_xch1501sn'
                bowlImage: 'storage/images/sand_gold.jpg'
            },
            {
                id: 4,
                color: 'crimson',
                // bowlImage: 'https://item-shopping.c.yimg.jp/i/l/kjk_xch1500bnbk'
                bowlImage: 'storage/images/crimson.jpg'
            },
            {
                id: 5,
                color: 'copper',
                // bowlImage: require('../images/Shiyousho_Catalog/item_categories/トイレ_(REST ROOM)/color/銅 (copper)/TBC005.jpg')
                bowlImage: 'storage/images/copper.jpg'
            },
        ],

        bowlRemote: [
            {
                id: 1,
                // remoteName: 'L150Kタイプ2',
                remoteName: 'Remote 1',
                // remoteImage: 'https://fairness-world.com/wp-content/uploads/2019/09/The-High-Tech-Toilet-Features-FAIR-Inc.jpg'
                remoteImage: 'storage/images/remote_default.png'
            },
            {
                id: 2,
                // remoteName: 'スティックリモコン',
                remoteName: 'Remote 2',
                // remoteImage: 'https://rimage.gnst.jp/livejapan.com/public/article/detail/a/00/03/a0003727/img/basic/a0003727_main.jpg?20200528090657'
                remoteImage: 'storage/images/remote2.png'
            },
        ],

        faucetType: [
            {
                id: 1,
                faucetName:'Faucet',
                // faucetImage:'https://preview.redd.it/s5z9f6yh3cu11.jpg?auto=webp&s=e2ca669bafbea516602cf6dbdb54b360fc3ca80b'
                faucetImage:'storage/images/faucet1.png'
            },
            {
                id: 2,
                faucetName:'Without Faucet',
                // faucetImage:'https://www.signaturehardware.com/media/catalog/product/cache/1/image/1500x/9df78eab33525d08d6e5fb8d27136e95/5/1/518149-21-elongated-two-piece-bidet.jpg'
                faucetImage:'storage/images/faucet2.png'
            }
        ],

        coverType: [
            {
                id: 1,
                coverName: 'Plain Cover',
                // coverImage: 'http://sc04.alicdn.com/kf/H974dd26d48fb4a84a39f3d23cbafad04z.jpg'
                coverImage: 'storage/images/bowl_default.png'
            },
        ],

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //                                                        DATA FOR TOWEL RACK                                                     //
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        towels:
        [
            {
                id: 'towelRing',
                // name: 'タオルリング',
                name: 'タオルリング',
                // towel: require('../images/Shiyousho_Catalog/towel_rack/タオルリング.png')
                towel: 'storage/images/towel1.png'
            },
            {
                id: 'bathTowelRack',
                // name: 'バスタオル掛け',
                name: 'バスタオル掛け',
                // towel: require('../images/Shiyousho_Catalog/towel_rack/バスタオル掛け.png')
                towel: 'storage/images/towel2.png'
            },
        ],

        Scope: ['Local', 'International'],
        tab: null,

        //Default Values

        item:'bowl',
        kindValue: 'カバー',
        getType: 'default',
        color: 'white',
        color_img: 'storage/images/white.png',

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
        cartItemCount: '',
        cartItems: [],

        // * * * * * * * * * * * MAIN DATA * * * * * * * * * * * //

        shioData: [],
        items: [],
        kind: [],
    }),

    methods:{

        //////////////////////////////////////////////////////////
        // *   *   *     GETTING OF DATA COLLECTED   *   *   *  //
        //////////////////////////////////////////////////////////

        getDataSentakuTool(){ 
            axios({ 
                method: 'get',
                url: 'api/getDataSentakuTool'
            }).then((res) => { 

                // * * * Category * * * //
                res.data.filter((item)=>{  
                    this.shioData.push(item.Item_2_mei); 
                    this.items = [...new Set(this.shioData)] 
                })
                console.log(this.items, 'items');
                
                // * * * Toilet Bowl * * * //
                res.data.filter((item)=>{ 
                    
                    if(item.Item_2_mei == '便器'){
                        console.log(item.Goods_mei)
                    }  
                })
            })
                
        },

        //Changing divs (static)
        toggleFunctionBowl(){
            this.toShow = '',
            this.toShow = 'bowl'

            console.log('bowl')

            this.item = 'bowl'
        },
        toggleFunctionTowel(){
            this.toShow = '',
            this.toShow = 'towel' 
            
            console.log('Towel')

            this.item = 'towel'
        },
         

        //Changing kinds (dynamic)
        getKind(name, imagetowel, nametowel){
            console.log(this.kindValue);

            if(name == 'リモート'){
                this.kindValue = name;
                this.color = 'default';
                console.log(name)

            }else if(name == '蛇口'){
                this.kindValue = name;
                console.log(name)
                this.color = 'default';

            }else if(name == 'カバー'){
                this.kindValue = name;
                console.log(name)
                this.color = 'default';

                //TO CHAAAAAAANGE!!!!

            }else if(name == 'タオルリング'){
                this.getType = nametowel; // to change
                this.image = imagetowel; // to change
                this.kindValue = name;
                console.log(name, imagetowel, nametowel)
                this.color = 'default';

            }else if(name == 'バスタオル掛け'){
                this.getType = nametowel; // to change
                this.image = imagetowel; // to change
                this.kindValue = name;
                console.log(name , imagetowel, nametowel)
                this.color = 'default';

            }
        },

        //Changing bowl Types (dynamic)
        getBowlType(id, img){
            console.log(id, img)

            this.getType = id
            console.log(this.getType)
            this.image = img;
        },

        //Changing colors (dynamic)
        toGetColor(color, img){
            this.image = img;
            this.color = color;
            this.color_img = img;
            console.log(color, img)
        },


        //////////////////////////////////////////////////////////
        // *   *   *     SUMMARY OF DATA COLLECTED   *   *   *  //
        //////////////////////////////////////////////////////////

        addtoCart(){

            this.cart.filter(r =>{

                r.item = this.item;
                r.image = this.image;
                r.kind = this.kindValue;
                r.type = this.getType;
                r.color = this.color;
                r.color_img = this.color_img;
            })

            console.log(this.cart[0] , 'updated cart')

            axios({
                method: 'post',
                url: 'api/save',
                    data: {
                        item : this.item,
                        image : this.image,
                        kind : this.kindValue,
                        type : this.getType,
                        color : this.color                    
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
                this.cartItemCount = res.data.length
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
        }
    },

    mounted() {
        // this.getData();
    },

    created(){
        this.getDataSentakuTool();

        setTimeout(()=>{
            this.alert=false
        },10000)
    }
}
</script>

<style scoped>
/* html { overflow-y: hidden } */

.swal2-popup {
  font-family: 'Comic Neue' !important;
}

/* #app{
    background: url('https://img.freepik.com/free-vector/white-abstract-background_23-2148810113.jpg?w=1380&t=st=1677717031~exp=1677717631~hmac=c872caef3e223b52dea907ac40c5c5cdb3a10046714e90a9623caac08b671a68') 
    no-repeat center center
    fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
} */

#header-container{
    /* background-color: #f8f8fa; */
    box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.07) 0px 4px 8px !important;
    background-color: rgba(255, 255, 255, .9);
    padding-top: 10px;
    padding-left: 10px;
    padding-right: 20px;
    margin-top: 30px;
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
  border: 1px solid #ddd;
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
  border: 3px dotted #005e8d;
  background: white;
  color: #000000;
}
/* type */
#remote1:checked ~ label[for="remote1"],
#remote2:checked ~ label[for="remote2"] {
  border: 3px dotted #005e8d;
  background: white;
  color: #000000;
}

#towelRing:checked ~ label[for="towelRing"],
#bathTowelRack:checked ~ label[for="bathTowelRack"]{
  border: 3px dotted #005e8d;
  background: white;
  color: #000000;
}

@import url('https://fonts.googleapis.com/css2?family=Klee+One:wght@400;600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Comic+Neue:wght@300;400;700&display=swap');
</style>

                
                
               

