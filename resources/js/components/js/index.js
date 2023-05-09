const axios = require("axios")

const getCategory = (category) => {
    return new Promise(resolve=>{
        axios({
            method : 'post',
            url : 'api/masterMaintenance/getItem1',
            data : category,
        }).then( ({data}) => {
            console.log(data,'index.js/getCategory')
            resolve(data)
        })
    })
}

const getItem2 = (category) => {
    return new Promise(resolve=>{
        axios({
            method : 'post',
            url : 'api/masterMaintenance/getItem2',
            data : category,
        }).then( ({data}) => {
            console.log(data,'index.js/getItem2')
            resolve(data)
        })
    })
}

const getProducts = (category) => {
    return new Promise(resolve=>{
        axios({
            method : 'post',
            url : 'api/masterMaintenance/products',
            data : category,
        }).then( ({data}) => {
            console.log(data,'index.js/getProducts')
            resolve(data)
        })
    })
}

const getColors = (color) => {
    return new Promise(resolve=>{
        axios({
            method : 'post',
            url : 'api/masterMaintenance/colors',
            data : color,
        }).then( ({data}) => {
            console.log(data,'index.js/getColors')
            resolve(data)
        })
    })
}










module.exports = {getCategory,getItem2,getProducts,getColors}