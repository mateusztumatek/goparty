@extends('layouts.app')

@section('content')

    <div class="container" style="max-width: 85%; padding: 0px; margin-top: 120px;" id="single_club" data-scroll = 'scroll'>

        <div class="row justify-content-center">

            <div class="club-border"> </div>
            <div class="col-lg-5">
                @if(empty($club->getMain($club->id)))
                    <p class="text-white">Ten klub nie ma jeszcze dodanych zdjęć</p>
                    @if(\Illuminate\Support\Facades\Auth::id() == $club->user_id)
                    <a href="{{url('dashboard/clubs/' . $club->id . '/edit/photo')}}" style="color: white; " class="myBtn-link myBtn hvr-sweep-to-right"> dodaj zdjęcie </a>
                        @endif
                @else
                <img onclick="loadGallery(this)" data-toogle = 'modal' data-target="#photos" id="img-gallery" src="{{url('public/users/'.$club->user_id.'/'.$club->getMain($club->id)->image_path)}}">
                @endif
                @if (empty($club->getPhotos($club, 3)))

                @else

                <div class="row" id="other-image">
                    @foreach($club->getPhotos($club, 3) as $photo)
                    <div class="col-lg-4" >
                        <img onclick="loadGallery(this)" id="img-gallery" src="{{url('public/users/'.$photo->user_id.'/'.$photo->image_path)}}">
                    </div>

                        @endforeach

                </div>
                    @endif
            </div>

            <div class="col-lg-7" style="padding-top: 0px;">

                <h2 style="margin-top: 0px;" class="text-center">{{$club->official_name}} sasawa</h2>
                <hr>
                <p id="description">
                    Lorem Ipsum jest tekstem stosowanym jako przykładowy wypełniacz w przemyśle poligraficznym. Został po raz pierwszy użyty w XV w. przez nieznanego drukarza do wypełnienia tekstem próbnej książki. Pięć wieków później zaczął być używany przemyśle elektronicznym, pozostając praktycznie niezmienionym. Spopularyzował się w latach 60. XX w. wraz z publikacją arkuszy Letrasetu, zawierających fragmenty Lorem Ipsum, a ostatnio z zawierającym różne wersje Lorem Ipsum oprogramowaniem przeznaczonym do realizacji druków na komputerach osobistych, jak Aldus PageMaker
                </p>
                <div class="description-footer" >
                @auth
                    <fieldset style="width: 100%;" @if(!empty($club->getRate(\Illuminate\Support\Facades\Auth::user()))) data-rate = "{{$club->getRate(\Illuminate\Support\Facades\Auth::user())->rate}}" @endif class="rating">


                        <input id="star5" data-club = "{{$club->id}}" data-user = "{{\Illuminate\Support\Facades\Auth::id()}}"  type="radio" name="rating" value="5" ><label for="star5"  class = "full" title="Awesome - 5 stars"></label>

                        <input id="star4" data-club = "{{$club->id}}" data-user = "{{\Illuminate\Support\Facades\Auth::id()}}"  type="radio" name="rating" value="4" ><label  for="star4" class = "full" title="Pretty good - 4 stars"></label>

                        <input id="star3" data-club = "{{$club->id}}" data-user = "{{\Illuminate\Support\Facades\Auth::id()}}"  type="radio" name="rating" value="3" ><label  for="star3" class = "full"  title="Meh - 3 stars"></label>

                        <input id="star2" data-club = "{{$club->id}}" data-user = "{{\Illuminate\Support\Facades\Auth::id()}}"  type="radio" name="rating" value="2" ><label  for="star2" class = "full"  title="Kinda bad - 2 stars"></label>

                        <input id="star1" data-club = "{{$club->id}}" data-user = "{{\Illuminate\Support\Facades\Auth::id()}}"  type="radio" name="rating" value="1" ><label  for="star1" class = "full"  title="Sucks big time - 1 star"></label>

                    </fieldset>

                    @if(!empty($club->getRate(\Illuminate\Support\Facades\Auth::user())))

                        <button style="float: right" data-user = "{{\Illuminate\Support\Facades\Auth::id()}}" data-club = "{{$club->id}}" id="remove_rate" class="btn btn-sm btn-primary p-1">usun ocene</button>

                    @endif
                    @endauth
                    @if(\Illuminate\Support\Facades\Auth::id() == $club->user_id)
                        <div class="d-inline-flex">
                            <a style="display:inline-block; margin: 0px" href="{{route('clubs.edit', ['club' => $club])}}" class="btn btn-sm btn-primary" ><i class="fa fa-edit"></i> Edytuj Klub</a>
                            <form onsubmit="return confirm('czy na pewno chcesz usunac ten klub?')" style="margin-left: 10px; margin-right: 10px" action="{{route('clubs.destroy', ['club'=> $club])}}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                @CSRF
                                <button type="submit" class="btn btn-sm btn-primary" ><i class="fa fa-trash"></i> Usuń Klub</button>
                            </form>
                            <a style="display:inline-block; margin: 0px" href="{{url('dashboard/clubs/'. $club->id.'/events/create')}}" class="btn btn-sm btn-primary" ><i class="fa fa-edit"></i> Utwórz wydarzenie</a>
                        </div>
                    @endif

                    <a href="#" ><i class="fa fa-globe mt-2" style="margin-right: 5px"> </i> <span style="color: white; ">wojewodztwo: </span>{{$club->voivodeship}} </a>
                    <a href="#" ><i class="fa fa-globe b-2" style="margin-right: 5px"> </i> <span style="color: white; ">Ulica: </span>{{$club->route}}{{$club->street_number}} </a>
                    <div style="padding-left: 0px" class="col-md-8">

                        <ul style="display: inline-flex; flex-direction: row" class=" mt-1 list-group music_types_tags">
                            @foreach($club->music_types as $music_type)
                            <li class="list-group-item music-type-tag"><a style="color: white" href="{{url('search/clubs?music_type='.$music_type->id)}}">#{{$music_type->name}} </a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>

            </div>
        </div>


        @if(empty($club->rule()) AND \Illuminate\Support\Facades\Auth::id() == $club->user_id)

            <p class="text-center mt-3 mb-3" style="color: white"> Nie masz jeszcze żadnych zasad ani możliwości w tym klubie.</p>

        @else

        <h3 class="text-center mb-2 mt-2">Zasady: </h3>
        <div class="row justify-content-center" style="margin-top: 30px; padding: 0px;">
            @foreach($rules as $rule)
            <div class="col-md-2 ml-5 mr-5" id="club-rules">
                <div class="rules-addnotations align-middle">
                    <p>{{$rule->rule->name}}</p>
                </div>
                <img src="{{asset('img/icons/'.$rule->rule->image_path)}}">

            </div>

        @endforeach

        </div>
        @endif

        <h3 class="text-center mt-5 mb-5">Kluby w pobliżu</h3>
    </div>
        <div class="row justify-content-center" style="padding:0px; max-width: 90%; margin: auto;  position: relative; margin-top: 80px; position: relative; height: 550px">
            <a class="btn-prev text-left align-left"> Poprzedni </a>
            @php $count = 0; @endphp
            @foreach($club->getClosestClubs($club) as $key => $my_club)

            <div class="club-slide"  @if($count == 2) id="club-slide-left" @elseif($count == 1) id="club-slide-right" @elseif($count == 0) id = 'club-slide-center' @endif style="margin: auto; margin-bottom: 50px;">
                <img id="box-shadow" src="{{url('img/box-shadow.png')}}">
                @if(empty(\App\Models\Club::getMain($my_club[0]['id'])))
                    <img src="{{url('img/brak-zdjecia.jpg')}}">
                    @else
                    <img src="{{url('public/users/'. $my_club[0]['user_id'].'/'.\App\Models\Club::getMain($my_club[0]['id'])->image_path)}}">
                    @endif

                <div class="club-slide-content">
                    <a href="{{url('/clubs/'. $my_club[0]['id'])}}" style="text-decoration: none"><h2>{{$my_club[0]['official_name']}}</h2></a>

                    <div class="distance-box mt-5">
                        <p><span style="color: rgb(239, 58, 177);">@php
                                    if($my_club['distance'] < 1){
                                    $my_club['distance'] = $my_club['distance'] *1000;
                                    echo round($my_club['distance']).'m';
                                    } else {
                                    echo $my_club['distance'].'km';
                                    }
                                @endphp  </span>od {{$club->official_name}}</p>

                        <p style="font-family: Muli;font-size: 14px; margin: 0px; font-weight: 100"> <i style="font-size: 12px;" class="fa fa-globe"></i> {{$my_club[0]['route'] . ' ' . $my_club[0]['street_number']}}</p>

                        <p style="font-size: 14px; margin: 0px; font-weight: 100"><i style="font-size: 12px;"class="fa fa-phone"></i> {{$my_club[0]['phone']}}</p>
                    </div>
                    <div class="club-slide-footer" >


                            <a href="{{url('/clubs/'. $my_club[0]['id'])}}" style="position: sticky; font-size: 14px; font-weight: 100; " class="navigator">Zobacz więcej</a>


                    </div>

                </div>
            </div>
                @php $count++; @endphp
                @if($count == 3)
                    @break
                @endif
                @endforeach
            <a  style="position: absolute; top: 33%" id="left" class="navigator" onclick="prev_slide()" ><i class="fa fa-angle-left"></i> </a>
            <a   style="position: absolute; top: 33%" id="right" class="navigator" onclick="next_slide()" >  <i class="fa fa-angle-right"></i></a>



        </div>
        @if($events->isEmpty() == false)
        <div class="container" id="events">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h3>Wydarzenia w tym klubie: </h3>
                </div>
                <div id="event-carousel" class="carousel carousel-events slide carousel-fade" data-ride="carousel" >
                    <div class="carousel-inner">
                        @php
                            $counter = 0;
                            $site = 1;
                        @endphp
                        @foreach($events as $event)

                            @php $counter++; @endphp
                            <div id="shadow-outside" class="carousel-item @if($counter == 1) active @endif " style="height: 420px; overflow: hidden">
                                <div class="event-image">

                                    <img class="event-image" src="{{asset('img/klub1.jpg')}}">
                                    <div id="shadow-inside"> </div>

                                </div>

                                        <div class="col-lg-12 event" style="padding-top:1rem; padding-bottom: 1rem"   >

                                            <div class="row" >
                                                <div class="col-lg-1" >
                                                    <h1 style=" margin: 0px; @if($counter>9) font-size: 50px !important; margin-top: 35% !important; @endif"> {{$counter}}. </h1>
                                                </div>
                                                <div class="col-lg-11" >
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <p style="margin-top: 5px;" id="event-name" >{{$event->title}}</p>
                                                            <p id="event-date" >{{substr($event->start_date,0,10)}} </p>
                                                        </div>
                                                        <div class="col-lg-4 text-right">
                                                            <div style="position: absolute; right: 15px; bottom: 0px;">
                                                            <p style="color: white; font-weight: 900;" class="text-right"> Ilość osób które wezmą udział: <span class="attendendNumber" style="color: rgb(239, 58, 177)">{{$event->getAttendendList()}}</span></p>

                                                                @auth
                                                                    <form class="attendEvent" action="    @if(!$event->checkAttendandUser(\Illuminate\Support\Facades\Auth::user())) {{route('attendEvent')}} @else {{route('notAttendEvent')}} @endif">
                                                                        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                                                                        <input type="hidden" name="event_id" value="{{$event->id}}">
                                                                        @if(!$event->checkAttendandUser(\Illuminate\Support\Facades\Auth::user()))
                                                                         <button data-attend = 'attende' type="submit" style="border: none; margin-bottom: 3px;" class=" myBtn-link myBtn hvr-sweep-to-right">weź udział </button>
                                                                            @else
                                                                            <button data-attend = 'notattende' type="submit" style="border: none; margin-bottom: 3px;" class=" myBtn-link myBtn hvr-sweep-to-right">nie bierz udziału </button>
                                                                        @endif

                                                                    </form>
                                                                @endauth
                                                            </div>
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <hr style="background-color: white; text-align: center; margin-top: 5px">
                                            <div  id="event-article" class="col-lg-19 text-center " style="; padding: 0px;">
                                                <article >
                                                    {{$event->description}}
                                                </article>

                                            </div>
                                            <a style=" font-size: 20px;" class="mt-3 myBtn-link myBtn hvr-sweep-to-right animated fadeIn">Zobacz wiecej</a>
                                        </div>




                            </div>
                        @endforeach


                    </div>

                    <a  class="carousel-control-prev " href="#event-carousel" data-slide="prev" style="font-size:4em; color:black; z-index: 1; left: -11%; top:0px !important;">
                        <span  class="carousel-control fa fa-caret-left fa-sm" ></span>
                    </a>
                    <a class="carousel-control-next " href="#event-carousel" data-slide="next" style="font-size:4em; color:black; z-index: 1; right: -11%; top:0px !important;">
                        <span  class="carousel-control fa fa-caret-right fa-sm" ></span>
                    </a>

                </div>

                     </div>
                </div>


            </div>
            @endif
        </div>





    <!-- Modal -->
    <div class="modal fade" id="photos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">


                <img id = "modal-photo" src="{{url('img/klub1.jpg')}}">

               

            </div>
        <button id="modal-button" id="modal-button" type="button" class="btn btn-secondary" data-dismiss="modal">X</button>
     
    </div>
@endsection
