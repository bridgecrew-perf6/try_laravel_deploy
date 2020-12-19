@extends('layouts.driver.app')

@section('content')


<style>
	#fixed {
		position:fixed;
		z-index:10;
		background-color:#f5f5f5;
		border:1px solid #CCC;
		opacity:0.9;
		display: table;
		bottom:0;
		text-align:left;
		margin-bottom:20px;
		width:60%;
		

	}
	#fixed textarea {
		margin:10px 30px;
		border-radius:20px;
		padding:8px;
		display: table-cell;
		vertical-align: middle;
		width: 70%;
	}

	@media screen and (max-width: 767px) {
	#fixed button {
    	float:right;
	  }
	}
	.card {
		z-index:1;
	}
</style>




<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">オーナー：<img src="{{$ownerInfo->iconOwner}}" class="iconImgContract" alt="アイコン画像">{{$ownerInfo->nameOwner}}さんとのトークルーム</div>
                    <div class="card-body">
                        <div class ="row text-center">
                            <div class="col-md-6">
                                <ul class="marker">
                                    <li><img src="{{$ownerInfo->imgCar}}" class="carImg" alt="車両画像">
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="marker">
                                    <li>車名：{{$ownerInfo->nameCar}}
                                    <li>最大乗車可能人数：{{$ownerInfo->numPeople}}人
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body"> 

                    <div id="room">
                        @foreach($posts as $key => $post)
                            @if($post->sort === 1)
                                <div class="driver" style="text-align:left">
                                    <p>{{$post->comment}}</p>
                                </div>
                            @elseif($post->sort === 0)
                                <div class="owner" style="text-align:right">
                                    <p>{{$post->comment}}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-md-12">

    <div id="fixed">
        <form>
            @csrf
            <textarea id="textarea" name="comment" cols="70" rows="3" placeholder="メッセージを入力"></textarea>     
            <button type="button" class="btn btn-primary" id="scrollBtn">送信</button>
        </form>
            <input type="hidden" name="idDriver" value="{{$driverInfo->id}}">
            <input name='idOwner' type="hidden" value="{{$ownerInfo->id}}">
            <input type="hidden" name="login" value="{{Auth::id()}}">
		</div>
	</div>
</div>
@endsection
        <script src="/js/app.js"></script>
        <script>
        //ログを有効にする
        Pusher.logToConsole = true;

        var pusher = new Pusher('6dfeb35a6b59eee36ab9',{
            cluster :'ap3',
            enctypted : true
        })
        //チャンネルの指定
        var pusherChannel = pusher.subscribe('chat');

        //イベントを受信したら下記処理
        pusherChannel.bind('chat-event',function(data) {

            let appendText;
            let login = $('input[name="login"]').val();


            appendText = '<div class="idDriver" style="text-align:center"><p>'+'-NEW MESSAGE-<br>' + data.comment + '</p></div> ';
            // if(data.idDriver === login){
            //     appendText = '<div class="idDriver" style="text-align:right"><p>' + data.comment + '</p></div> ';
            // }else if(data.idOwner === login){
            //     appendText = '<div class="idOwner" style="text-align:left"><p>' + data.comment + '</p></div> ';
            // }else{
            //     return false;
            // }

            //メッセージを表示
            $("#room").append(appendText);

            if(data.idOwner === login){
                //ブラウザへプッシュ通知
                //一旦置いておく
            }
        });

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")
            }
        });
        //メッセージ送信
        $('#send').on('click' , function(){
            $.ajax({
            type : 'POST',
            url : '/driver/post',
            data : {
                comment : $('textarea[name="comment"]').val(),
                idDriver : $('input[name="idDriver"]').val(),
                idOwner : $('input[name="idOwner"]').val(),
            }
            }).done(function(result){
                $('textarea[name="comment"]').val('');
            }).fail(function(result){
            });
        });
    </script>

