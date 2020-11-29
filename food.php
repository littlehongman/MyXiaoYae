<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <title>買宵夜</title>
        <style>
        </style>
        <script>
            //vue
            window.onload = function () {
                var foodData = new Vue({
                    el: '#food',
                    data: {
                        foods:'',
                        storeID:"<?php  echo $_GET['store_ID']; ?>",
                        storeName:''
                    },
                    methods:{
                        fetchFoodData:function(){
                            axios.post('function/condb.php',{action:'fetchFood',id:this.storeID
                            }).then(function(response){
                                foodData.foods = response.data;
                                console.log(response.data);
                            });
                        },
                        fetchStoreName:function(){
                            axios.post('function/condb.php',{action:'fetchStoreName',id:this.storeID
                            }).then(function(response){
                                foodData.storeName = response.data;
                                console.log(response.data);
                            });
                        }
                    },
                    created:function(){
                        this.fetchFoodData();
                        this.fetchStoreName();
                    }
                });
            }

        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand " href="index.php">      
                <h1  class="mb-0"><strong>買宵夜</strong></h1>
                <h6><strong>&nbsp;&nbsp;&nbsp;&nbsp;MyXiaoYae</strong></h6>       
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="btn-group btn-group-toggle mx-auto col-sm-7 " data-toggle="buttons">
                    <label class="btn btn-primary btn-lg">
                        <input type="radio" name="options" id="option1" autocomplete="off" checked>首頁
                    </label>
                    <label class="btn btn-primary btn-lg">
                        <input type="radio" name="options" id="option2" autocomplete="off"> 編輯店家
                    </label>
                    <label class="btn btn-primary btn-lg">
                        <input type="radio" name="options" id="option3" autocomplete="off"> 編輯食物
                    </label>
                </div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div id="food">
            <div class="row ml-5 mr-0 my-2" style="white-space:nowrap">
                <h1 class=" col-sm-11"><strong>{{storeName.store_name}}</strong></h1>
                <img class="" src="https://imgur.com/8bnWpa0.png" alt="cart" style="width:6%;"> 
            </div>
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">食物</th>
                            <th scope="col">價錢</th>
                            <th scope="col">數量</th>
                            <th scope="col">姓名</th>
                            <th scope="col">送單</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in foods">
                            <td>{{i.food_name}}</td>
                            <td>{{i.price}}</td>
                            <td><input type="number" id="quantity" name="quantity" min="1" max="5"></td>
                            <td>               
                                <input type="text" class="form-control" id="example1" placeholder="">
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary" value="Submit">加入</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>