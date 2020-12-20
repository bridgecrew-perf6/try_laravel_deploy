@extends('layouts.owner.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">貸し出し日程を登録</div>
                    <div class="card-body">
                        <div id="input">
                            @if ($errors->any())
                            <div class ="alert alert-danger">
                                <ul>
                                @foreach($errors->all() as $message)
                                    <li>{{$message}}</li>
                                @endforeach
                                </ul>
                            </div>
                            @endif 
                            <form action="" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="" class="col-md-4 col-form-label text-md-right">貸出時間</label>
                                    <div class="col-md-6">
                                        <input id="departure" type="datetime-local"  step="1800" class="form-control" name="departure" value="{{ old('departure') }}" required autocomplete="" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-4 col-form-label text-md-right">返却時間</label>
                                    <div class="col-md-6">
                                        <input id="revert" type="datetime-local"  step="1800" class="form-control" name="revert" value="{{ old('revert') }}" required autocomplete="" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-4 col-form-label text-md-right">貸出場所</label>
                                    <div class="col-md-6">
                                        <select name="place" class="form-control">
                                            <option value="下津熊">行橋市　下津熊</option>
                                            <option value="高瀬">行橋市　高瀬</option>
                                            <option value="大野井">行橋市　大野井</option>
                                            <option value="行事">行橋市　行事</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="" class="col-md-4 col-form-label text-md-right"></label>
                                    <div class="col-md-6">
                                        <input type="submit" value="追加">
                                    </div>
                                <div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
        <button><a href="talkerSelect">ドライバーとのトークはこちらから</a></button>
        </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">登録済の日程一覧</div>
                    <div class="card-body">
                        <div id="output">   <!-- 入力フォームを入れたら出力-->
                            <table class="table text-center">
                                <tr>
                                    <th>出発日</th>
                                    <th>返却日</th>
                                    <th>貸出場所</th>
                                    <th>削除</th>                    
                                </tr>
                                @foreach($ownerSchedules as $ownerSchedule)
                                <tr>
                                    <td>{{$ownerSchedule->departure->format('Y/m/d H:i')}}</td>
                                    <td>{{$ownerSchedule->revert->format('Y/m/d H:i')}}</td>
                                    <td>{{$ownerSchedule->place}}</td>
                                    <td>
                                        <form action="{{route('owner.destroy',['id'=> $ownerSchedule->id])}}" method="post">
                                        @csrf
                                            <button type="submit" class="btn-danger">削除 </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
