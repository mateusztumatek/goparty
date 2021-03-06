<div class="single-event mb-3 p-4">
    <div class="row">
        <div class="col-md-3">
            <img class="img-fluid"
                 src="@if($event->event_img) {{ url('/uploads/events/' . $event->event_img )  }} @else {{url('/img/default-event-img.jpg')}} @endif " alt="">
        </div>
        <div class="col-md-9">
            <span class="badge">{{ rand(3.00, 5.00) }}/5</span>
            <a href="{{ url('/events/' . $event->id)  }}"><h3>{{$event->title}}</h3></a>
            <h5><i class="fa fa-calendar-o" aria-hidden="true"></i>
                {{--{{ Carbon\Carbon::now() }}--}}
                {{$event->start_date}}</h5>
            <h5><i class="fa fa-building"
                   aria-hidden="true"></i><a href="{{url('clubs/' . $event->club->id )}}">
                    {{$event->club->official_name }}</a> <i class="fa fa-map-marker pl-3"
                                                            aria-hidden="true"></i>
                {{$event->club->route }}, {{$event->club->locality }}</h5>
            <p class="mb-1">
                @if($event->ticket_price) Wstęp od: {{$event->admission}} + @else Wstęp dla każdego @endif |
                @if($event->ticket_price) Cena biletu: {{$event->ticket_price}}zł @else <span class="text-success">Darmowy wstęp</span> @endif  |
                Selekcja: @if($event->selection) Tak @else Nie @endif</p>
            <i class="fa fa-users" aria-hidden="true"></i>

            @if(!$event->attendance->count() > 0)
                Nikt jescze nie bierze udziału
            @else
                Liczba osób które biorą udział: {{$event->attendance->count()}}
            @endif


            <p class="mt-1">{{ str_limit($event->description, $limit = 250, $end = '...') }}</p>

            @if(Auth::check())
                @if(!$event->checkIfAttendance())

                    <form method="POST" action="{{url('/take-part')}}">
                        @csrf
                        <input name="event_id" type="hidden" value="{{$event->id}}">
                        <input style="background: #EF3AB1 !important" class="btn btn-success pull-right" type="submit" value="Weź udział">
                    </form>

                @else

                    <form method="POST" action="{{url('/take-part')}}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input name="event_id" type="hidden" value="{{$event->id}}">
                        <input style="background: #EF3AB1 !important" class="btn btn-success pull-right" type="submit" value="Zrezygnuj z imprezy">
                    </form>

                @endif

            @endif





            {{--<take-part :user="{{ json_encode(Auth::id()) }}" :event="{{ json_encode($event->id) }}"></take-part>--}}

        </div>
    </div>
</div>