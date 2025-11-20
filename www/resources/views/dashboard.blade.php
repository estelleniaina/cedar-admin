@extends('layout/template')

@section('title')
    Dashboard
@endsection

@section('subsection')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        @foreach($cards as $card)
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box {{$card['color']}}">
                    <div class="inner">
                        <h3>{{$card['total']}}</h3>

                        <p>{{$card['title']}}</p>
                    </div>
                    <div class="icon">
                        <i class="{{$card['icon']}}"></i>
                    </div>
                    <a href={{route($card['link'])}} class="small-box-footer">Plus d'infos <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
