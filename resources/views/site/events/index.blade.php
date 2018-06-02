@extends('layouts.app')

@section('content')

    <div class="container">



        @include('site.events.includes.search')



        <div id="event-list" class="mt-4 pt-4">

            <div class="card-columns">

                @foreach($events as $event)
                    <div class="">
                    <div class="card mb-4">
                        {{--<div class="card-header">--}}
                        {{--Card Header--}}
                        {{--</div>--}}
                        <img class="card-img-top" src="@if($event->event_img) {{ url('/uploads/events/' . $event->event_img )  }} @else {{url('/img/default-event-img.jpg')}} @endif " alt="Card image top">
                        <div class="card-body">
                            <a href="{{ url('/events/' . $event->id)  }}"><h4>{{$event->title}}</h4></a>
                            <h6><i class="fa fa-calendar-o" aria-hidden="true"></i>
                                {{--{{ Carbon\Carbon::now() }}--}}
                                {{$event->start_date}}</h6>
                            <h6><i class="fa fa-building"
                                   aria-hidden="true"></i><a href="{{url('clubs/' . $event->club->id )}}">
                                    {{$event->club->official_name }}</a> <br> <i class="fa fa-map-marker pt-1"
                                                                                aria-hidden="true"></i>
                                {{$event->club->route }}, {{$event->club->locality }}</h6>
                            <p class="mb-1">
                                @if($event->ticket_price) Wstęp od: {{$event->admission}} + @else Wstęp dla każdego @endif |
                                @if($event->ticket_price) Cena biletu: {{$event->ticket_price}}zł @else <span class="text-success">Darmowy wstęp</span> @endif
                                    <br>
                                Selekcja: @if($event->selection) Tak @else Nie @endif</p>
                            <p>{{ str_limit($event->description, $limit = 120, $end = '...') }}</p>

                            @if(Auth::check())
                                @if(!$event->checkIfAttendance())

                                    <form method="POST" action="{{url('/take-part')}}">
                                        @csrf
                                        <input name="event_id" type="hidden" value="{{$event->id}}">
                                        <input style="background: #EF3AB1 !important; border-radius: 3px !important;" class="btn btn-success pull-right mb-3" type="submit" value="Weź udział">
                                    </form>

                                @else

                                    <form method="POST" action="{{url('/take-part')}}">
                                        @csrf
                                        <input name="event_id" type="hidden" value="{{$event->id}}">
                                        <input style="background: #EF3AB1 !important; border-radius: 3px !important;" class="btn btn-success pull-right mb-3" type="submit" value="Zrezygnuj z imprezy">
                                    </form>

                                @endif

                            @endif


                        </div>

                        {{--<div class="card-footer">--}}
                        {{--Card Footer--}}
                        {{--</div>--}}
                    </div>
                    </div>
                @endforeach


            </div>
        </div>

        {{ $events->links() }}

    </div>


@endsection

