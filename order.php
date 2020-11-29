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
            #cart{
                    width: 6%;
                    
                }
            @media (max-width: 600px) {
                #cart{
                    width: 12%;
                }
            }
        </style>
        <script>
            //vue
            window.onload = function () {
                var orderData = new Vue({
                    el: '#food',
                    data: {
                        orders:'',
                        sum: 0,
                    },
                    methods:{
                        fetchOrderData:function(){
                            axios.post('function/condb.php',{action:'fetchOrder'
                            }).then(function(response){
                                orderData.orders = response.data;
                                console.log(response.data);
                            });
                        },
                        fetchOrderSum:function(){
                            axios.post('function/condb.php',{action:'fetchSum'
                            }).then(function(response){
                                orderData.sum = response.data;
                                console.log(response.data);
                            });
                        }
                    },
                    created:function(){
                        this.fetchOrderData();
                        this.fetchOrderSum();
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
                    <a href="index.php" class="btn btn-primary btn-lg">首頁</a>
                    <a href="index.php" class="btn btn-primary btn-lg">編輯店家</a>
                    <a href="index.php" class="btn btn-primary btn-lg">編輯食物</a>
                </div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div id="food">
            <div class="row ml-5 mr-0 my-1" style="white-space:nowrap;display:inline">
                <h1 class=" col-sm-11">
                    <strong>訂單統計</strong> 
                    <button type="button" class="btn btn-info">每個人金額統計</button>
                    <button type="button" class="btn btn-info">每家店金額統計</button>
                    <button type="button" class="btn btn-info">每種食物金額統計</button>              
                </h1>
                
            </div>
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">名字</th>
                            <th scope="col">食物名稱</th>
                            <th scope="col">數量</th>
                            <th scope="col">單價</th>
                            <th scope="col">店名</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(order,index) in orders">
                            <td>{{order.cus_name}}</td>
                            <td>{{order.food_name}}</td>
                            <td>{{order.numbers}}</td>
                            <td>{{order.price}}</td>
                            <td>{{order.store_ID}}</td>
                        </tr>
                        <tr>
                            <td colspan="1">總共: {{sum.order_sum}}元</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>