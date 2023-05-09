<template>

    <v-card>
        <v-toolbar elevation="0">
            <v-toolbar-title style="text-align: center !important;">Shiyousho Catalog</v-toolbar-title>
                <v-spacer/>
            <v-btn icon><v-icon>mdi-cart</v-icon></v-btn>
            <v-btn icon><v-icon>mdi-account</v-icon></v-btn>
        </v-toolbar>

        <v-card style="box-shadow: rgba(0, 0, 0, 0.07) 0px 8px 16px, rgba(0, 0, 0, 0.75) 0px 4px 8px !important;" height="540" width="400">
            <img style="width: 100%; height: 100%; object-fit: cover;" :src="image" :alt="image" />
        </v-card>

        <div class="select-size" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">
                                        
            <div v-for="(img,i) in images" :key="i" >

                <input @click="addKind(img.id,img.image)" :id="img.id" type="radio" name="image" v-model="image" :value="img.image"/>

                <label style="font-family: 'Klee One'; font-size: 15px;" class="label" :for="img.id"> 
                        {{img.name}}
                </label>
            </div>
        </div>
        <div class="select-size2" style="text-align: left !important; display: flex; flex-wrap: wrap; gap: 10px;">    
            <p>select a behavior</p>
            
            <div v-for="(b,i) in behaviors" :key="i">
                <!-- <input @click="addBehaviour()" :id="b.id" type="radio" name="behaviors" v-model="behaviors" :value="b"/>
                {{ b.name }} -->
                <h1 @click="addBehaviour(b.name)">{{ b.name }}</h1>
                <!-- <label style="font-family: 'Klee One'; font-size: 15px;" class="label2" :for="b.id">
                        {{b.name}}  
                </label> -->
            </div>
        </div>
        
        <v-btn @click="addtoCartDog()"></v-btn> 
    </v-card>  

</template> 

<script>

export default {
    data() {
        return {
            any:[],
            id: 'doggo',
            image:'https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/ca/wp-content/uploads/2022/05/dogecoin.jpeg.jpg',
            images: 
            [
                {
                    id: 'doggo',    
                    name: 'doggo',
                    image: 'https://thumbor.forbes.com/thumbor/fit-in/x/https://www.forbes.com/advisor/ca/wp-content/uploads/2022/05/dogecoin.jpeg.jpg'
                },
                {
                    id: 'dogdog',
                    name: 'dogdog',
                    image: 'https://i.pinimg.com/736x/29/81/09/298109d14b5f5748ddca66bbbc207321.jpg'
                },
                {
                    id: 'doggy',
                    name: 'doggy',
                    image: 'https://i.pinimg.com/736x/57/01/cd/5701cdd8fd54f412313e5d3c9f8ea421.jpg'
                },
                
            ],
            behavior: '',
            behaviors:[
                {
                    id: 'calm',    
                    name: 'calm', 
                },
                {
                    id: 'aggression',    
                    name: 'aggression', 
                },
                {
                    id: 'anxiety',    
                    name: 'anxiety', 
                },
            ],
            addToCartDog: [
                {
                    photo: '',
                    image: '',
                    behavior: ''
                }
            ],
            cart: [] 
        }
    },

    methods: {
        addKind(dog, dogIMG){
            // console.log(dog, ' - dog', dogIMG, ' - img')
            this.photo = dog;
            this.image = dogIMG;
        },

        addBehaviour(behavior){
            // console.log( behavior, '- behavior')
            this.behavior = behavior;
        },

        addtoCartDog(){
            console.log(this.photo)
            console.log(this.image)
            console.log(this.behavior)

            this.any = this.addToCartDog.filter(r =>{
                r.photo = this.photo;
                r.image = this.image;
                r.behavior = this.behavior;
                return r;
                // this.cart.push(r)
                // console.log(this.cart,'???')
            })

            axios({
               method: 'post',
               url: 'api/saveCart',
               data: {
                  photo : this.photo,
                  image : this.image,
                  behavior : this.behavior,
               }
            }).then((res)=>{
               console.log(res)

            }).catch(function (err) {
               console.log(err);
            });

            
            //try to save to db
            
        }    
    },
}
</script>

<style>
    .select-size  input{
        display: none;
    }

    .select-size2  input{
        display: none;
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
        width: 80px;
        height: 50px;
        text-align: center;
        border: 1px solid #ddd;
        line-height: 50px;
        cursor: pointer
    }

    #doggo:checked ~ label[for="doggo"],
    #dogdog:checked ~ label[for="dogdog"],
    #doggy:checked ~ label[for="doggy"] {
        border: 3px dotted #005e8d;
        background: white;
        color: #000000;
    }

    #calm:checked ~ label[for="calm"],
    #aggression:checked ~ label[for="aggression"],
    #anxiety :checked ~ label[for="anxiety"] {
        border: 3px dotted #005e8d;
        background: white;
        color: #000000;
    }
</style>

