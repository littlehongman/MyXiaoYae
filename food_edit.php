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
            @media (max-width: 600px) {
                .hide{
                    display: none;
                }
            }
        </style>
        <script>
            window.onload = function() {
                var foodData = new Vue({
                    el: '#foodEdit',
                    data: {
                        foods:[],
                        stores:[], //prevent empty store
                        foodArray:[],
                        modalTitle :'',
                        actionName: '',
                        name:'',
                        price:'',
                        store_name:'',
                        food_ID:'',
                        keyword:'',
                    },
                    methods:{
                        fetchAllData:function(){
                            axios.post('function/condb.php',{action:'fetchAllFood'
                            }).then(function(response){
                                foodData.foods = response.data;
                                console.log(response.data);
                                for(const i in foodData.foods){
                                    if(foodData.stores.includes(foodData.foods[i]['store_name']) == false){
                                        foodData.stores.push(foodData.foods[i]['store_name']);
                                    }
                                }
                            });
                            
                            console.log(this.stores)
                        },
                        openModal:function(action,edit){
                           
                            if(action == 'edit'){
                                this.modalTitle = '編輯食物';
                                this.actionName = '儲存變更';
                                this.name = edit[0];
                                this.price = edit[1];
                                this.store_name = edit[2];
                                this.food_ID = edit[3];

                                for(const i in this.foods){
                                    if(this.foods[i]['store_name'] == this.store_name){
                                        this.foodArray.push(this.foods[i]['food_name']);
                                    }
                                }
                                const index = this.foodArray.indexOf(this.name);
                                if (index > -1) {
                                    this.foodArray.splice(index, 1);
                                }
                                console.log(this.foodArray)
                            }
                            else if(action == 'add'){
                                this.modalTitle = '新增食物';
                                this.actionName = '新增';
                                this.name = '';
                                this.price = '';
                                this.store_name = '';
                            }
                        },
                        deleteFood:function(food_ID){
                            var select = confirm("確定要刪除嗎?");
                            if(select == true){
                                axios.post('function/condb.php',{action:'deleteFood',food_ID:food_ID,
                                }).then(function(response){
                                    alert(response.data);
                                    window.location.reload();
                                });
                            }
                        },
                        submitModal:function(){
                            if(this.name == '' || this.price == '' || this.store_name == ''){
                                alert("任一個不得為空");
                            }
                            else if(this.modalTitle == '編輯食物'){
                                if(this.stores.includes(this.store_name) == false){
                                    alert("此店家不存在");
                                }
                                else if (this.foodArray.includes(this.name)) {
                                    alert("此食物已存在於此店家");
                                }
                                else{
                                    axios.post('function/condb.php',{action:'editFood',
                                        food_ID:this.food_ID,
                                        food_name:this.name,
                                        price:this.price,
                                        store_name:this.store_name,
                                    }).then(function(response){
                                        alert(response.data);
                                        window.location.reload();
                                    });
                                }
                            }
                            else if(this.modalTitle == '新增食物'){
                                if(this.stores.includes(this.store_name) == false){
                                    alert("此店家不存在");
                                }
                                else{
                                    axios.post('function/condb.php',{action:'addFood',
                                        food_name:this.name,
                                        price:this.price,
                                        store_name:this.store_name,
                                    }).then(function(response){
                                        alert(response.data);
                                        window.location.reload();
                                    });
                                }
                            }
                        },
                        search:function(){
                            axios.post('function/condb.php',{action:'search',
                                keyword:this.keyword,
                                ui:'food',
                            }).then(function(response){
                                foodData.foods = response.data;
                            })
                        }
                    },
                    created:function(){
                        this.fetchAllData();
                    },
                });
            }
        </script>
    </head>
    <body>
        <div id ="foodEdit">
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
                        <a href="store_edit.php" class="btn btn-primary btn-lg">編輯店家</a>
                        <a href="food_edit.php" class="btn btn-primary btn-lg">編輯食物</a>
                    </div>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" v-model="keyword"  placeholder="搜尋食物、店名" aria-label="Search" @keyup="search()">
                    </form>
                </div>
            </nav>
        
            <div class="card mx-auto mt-4 w-75">
                <div class="card-header">
                    <h3 class="d-inline-block">食物資料</h3>
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#Modal" @click="openModal('add')">新增</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">食物名稱</th>
                            <th >價錢</th>
                            <th class="hide">店名</th>
                            <th scope="col">動作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in foods">
                            <th>{{i.food_name}}</th>
                            <td >{{i.price}}</td>
                            <td class="hide">{{i.store_name}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning"  data-toggle="modal" data-target="#Modal" @click="openModal('edit',[i.food_name,i.price,i.store_name,i.food_ID])">編輯</button>
                                <button type="button" class="btn btn-outline-danger" @click="deleteFood(i.food_ID)">刪除</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">{{modalTitle}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class = "mx-4">
                            <div class="form-group">
                                <label>食物名稱</label>
                                <input type="text" class="form-control" v-model="name">
                            </div>
                            <div class="form-group">
                                <label>價錢</label>
                                <input type="text" class="form-control" v-model="price">
                            </div>
                            <div class="form-group">
                                <label>店名</label>
                                <select class="custom-select" v-model="store_name">
                                    <option v-for="i in stores">{{i}}</option>
                                </select>   
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                            <button type="button" class="btn btn-primary" @click="submitModal()">{{actionName}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>