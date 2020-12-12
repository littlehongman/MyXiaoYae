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
            window.onload = function() {
                var storeData = new Vue({
                    el: '#storeEdit',
                    data: {
                        stores:'',
                    },
                    methods:{
                        fetchAllData:function(){
                            axios.post('function/condb.php',{action:'fetchStore'
                            }).then(function(response){
                                storeData.stores = response.data;
                                console.log(response.data);
                            });
                        },
                        deleteStore:function(store_name){
                            var select = confirm("確定要刪除嗎?");
                            if(select == true){
                                axios.post('function/condb.php',{action:'deleteStore',store_name:store_name,
                                }).then(function(response){
                                    alert(response.data);
                                });
                            }
                        }
                    },
                    created:function(){
                        this.fetchAllData();
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
                    <a href="store_edit.php" class="btn btn-primary btn-lg">編輯店家</a>
                    <a href="index.php" class="btn btn-primary btn-lg">編輯食物</a>
                </div>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>
        <div id ="storeEdit">
            <div class="card mx-auto mt-4 w-75">
                <div class="card-header">
                    <h3 class="d-inline-block">店家資料</h3>
                    <button type="button" class="btn btn-success float-right">新增</button>
                </div>
                <table class="table" id="storeTable" >
                    <thead>
                        <tr>
                            <th scope="col">店名</th>
                            <th scope="col">地址</th>
                            <th scope="col">營業時間</th>
                            <th scope="col">電話</th>
                            <th scope="col">動作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in stores">
                            <th>{{i.store_name}}</th>
                            <td>{{i.address}}</td>
                            <td>{{i.business_hour}}</td>
                            <td>{{i.phone}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning"  data-toggle="modal" data-target="#editModal">編輯</button>
                                <button type="button" class="btn btn-outline-danger" @click="deleteStore(i.store_name)">刪除</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class = "mx-4">
                            <div class="form-group">
                                <label>店名</label>
                                <input type="text" class="form-control" id="editName">
                            </div>
                            <div class="form-group">
                                <label>地址</label>
                                <input type="text" class="form-control" value="hello">
                            </div>
                            <div class="form-group">
                                <label>營業時間</label>
                                <input type="text" class="form-control" id="editName">
                            </div>
                            <div class="form-group">
                                <label>電話</label>
                                <input type="text" class="form-control" id="editName">
                            </div>
                            
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>