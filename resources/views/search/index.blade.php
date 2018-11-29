@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <h1>Draugų paieška</h1>
                <form method="post" action="paieskos-rezultatai">
                    {{ csrf_field() }}
                    <input type="text" name="keyword" class="form-control"><br>
                    <input type="submit" class="btn btn-success" value="Ieškoti">
                </form>
            </div>
        </div>
    </div>
@stop