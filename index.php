<?php
	include("function/condb.php");
?>
<!doctype html>
<html lang="en">
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
                var carousel = new Vue({
                    el: '#carousel-inner',
                    data: {
                        message: 'Hello Vue!'
                    }
                })
            }

            //js
            $('.carousel').carousel({
                    interval: 1000
            })

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
        <div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner" id="carousel-inner">
            <div class="carousel-item active">
                <img class="img-responsive center-block d-block mx-auto" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(121).jpg" alt="First slide">
                <h3 class="text-center my-3">{{message}}</h3>           
            </div>
            <div class="carousel-item">
                <img class="img-responsive center-block d-block mx-auto" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(121).jpg" alt="Second slide">
                <h3 class="text-center my-3">Photo title2</h3> 
            </div>
            <div class="carousel-item">
                <img class="img-responsive center-block d-block mx-auto" src="https://mdbootstrap.com/img/Photos/Horizontal/Nature/4-col/img%20(121).jpg" alt="Third slide">
                <h3 class="text-center my-3">Photo title3</h3> 
            </div>
        </div>
        <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        </div>
    </body>
</html>