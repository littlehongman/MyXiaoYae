<html>
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                const id = '<imgur id>';
                const token = '<imgur token>';
                var storeData = new Vue({
                    el: '#storeEdit',
                    data: {
                        stores:[],
                        store_ID:'',//for edit
                        name:'',
                        address:'',
                        business_hour:'',
                        phone:'',
                        modalTitle:'',
                        actionName:'',
                        storeArray:[],
                        isNew:false,
                        file: null,
                        keyword:'',
                        loading:''
                    },
                    methods:{
                        getFile:function(e){
                            this.file = e.target.files[0];
                        },
                        submitImage(){
                            var jsonFile;
                            let settings = {
                                async: true,
                                crossDomain: true,
                                processData: false,
                                contentType: false,
                                type: 'POST',
                                url: 'https://api.imgur.com/3/image',
                                headers: {
                                    Authorization: 'Bearer ' + token
                                },
                                mimeType: 'multipart/form-data'
                            };

                            let form = new FormData();
                            form.append('image',this.file);
                            
                            settings.data = form;

                            return new Promise(resolve => {
                                $.ajax(settings).done(function(res){
                                    jsonFile = JSON.parse(res);
                                    console.log(jsonFile);
                                    resolve(jsonFile.data.link);
                                });
                            });
                        },
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
                                    window.location.reload();
                                });
                            }
                        },
                        openModal:function(action,edit){
                            if(action == 'edit'){
                                this.isNew = false;
                                this.modalTitle = '編輯店家';
                                this.actionName = '儲存變更';
                                this.name = edit[0];
                                this.address = edit[1];
                                this.business_hour = edit[2];
                                this.phone = edit[3];
                                this.store_ID = edit[4];
                                //check Repetition
                               
                                for(const i in this.stores){
                                    this.storeArray.push(this.stores[i]['store_name']);
                                }
                                const index = this.storeArray.indexOf(this.name);
                                if (index > -1) {
                                    this.storeArray.splice(index, 1);
                                }
                                console.log(this.storeArray)
                            }
                            else if(action == 'add'){
                                this.isNew = true;
                                this.modalTitle = '新增店家';
                                this.actionName = '新增';
                                this.name = '';
                                this.address = ''
                                this.business_hour = '';
                                this.phone = '';
                            }
                        },
                        async submitModal(){
                            if(this.name == ''){
                                alert("店名不得為空");
                            }
                            else if(this.modalTitle == '編輯店家'){
                                if (this.storeArray.includes(this.name)) {
                                    alert("店名不得重複");
                                }
                                else{
                                    axios.post('function/condb.php',{action:'editStore',
                                        store_name:this.name,
                                        address:this.address,
                                        business_hour:this.business_hour,
                                        phone:this.phone,
                                        store_ID:this.store_ID
                                    }).then(function(response){
                                        alert(response.data);
                                        window.location.reload();
                                    });
                                } 
                            }
                            else if(this.modalTitle == '新增店家'){
                                this.loading = true;
                                url = ""
                                if(this.file != null){
                                    url = await this.submitImage();
                                }
                                else{
                                    url = "https://i.imgur.com/VZoeDZc.jpg"
                                }
                                //console.log(url);
                                axios.post('function/condb.php',{action:'addStore',
                                    store_name:this.name,
                                    address:this.address,
                                    business_hour:this.business_hour,
                                    phone:this.phone,
                                    url:url
                                }).then(function(response){
                                    alert(response.data);
                                    storeData.loading = false;
                                    window.location.reload();
                                });
                            }
                        },
                        search:function(){
                            axios.post('function/condb.php',{action:'search',
                                keyword:this.keyword,
                                ui:'store',
                            }).then(function(response){
                                storeData.stores = response.data;
                            })
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
        <div id ="storeEdit">
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
                        <a href="index.php" class="btn btn-outline-warning btn-lg">首頁</a>
                        <a href="store_edit.php" class="btn btn-warning btn-lg">編輯店家</a>
                        <a href="food_edit.php" class="btn btn-outline-warning btn-lg">編輯食物</a>
                    </div>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" v-model="keyword" placeholder="搜尋店名" aria-label="Search" @keyup="search()">
                    </form>
                </div>
            </nav>
            <div class="card mx-auto mt-4 w-75">
                <div class="card-header">
                    <h3 class="d-inline-block">店家資料</h3>
                    <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#Modal" @click="openModal('add')">新增</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">店名</th>
                            <th class="hide">地址</th>
                            <th class="hide">營業時間</th>
                            <th class="hide">電話</th>
                            <th scope="col">動作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in stores">
                            <th>{{i.store_name}}</th>
                            <td class="hide">{{i.address}}</td>
                            <td class="hide">{{i.business_hour}}</td>
                            <td class="hide">{{i.phone}}</td>
                            <td>
                                <button type="button" class="btn btn-outline-warning"  data-toggle="modal" data-target="#Modal" @click="openModal('edit',[i.store_name,i.address,i.business_hour,i.phone,i.store_ID])">編輯</button>
                                <button type="button" class="btn btn-outline-danger" @click="deleteStore(i.store_name)">刪除</button>
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
                                <label>店名</label>
                                <input type="text" class="form-control" v-model="name">
                            </div>
                            <div class="form-group">
                                <label>地址</label>
                                <input type="text" class="form-control" v-model="address">
                            </div>
                            <div class="form-group">
                                <label>營業時間</label>
                                <input type="text" class="form-control" v-model="business_hour">
                            </div>
                            <div class="form-group">
                                <label>電話</label>
                                <input type="text" class="form-control" v-model="phone">
                            </div>
                            <div class="form-group" v-if = "isNew">
                                <label>圖片</label>
                                <br/>
                                <input id="upload" type="file" accept="image/*" @change="getFile">
                            </div>
                            
                            
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                            <button type="button" class="btn btn-primary" @click="submitModal()">
                                <span class="spinner-border spinner-border-sm" v-if="loading" role="status" aria-hidden="true"></span>
                                {{actionName}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
