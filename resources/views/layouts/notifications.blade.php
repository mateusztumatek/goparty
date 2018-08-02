
<div id="notifications-trigger" class="notifications-link row">

    <i  id="notifications-trigger-i" class="fa fa-globe"></i>
    <p>2</p>
</div>
<div  id="notifications" class="notifications-toogle" style="width: 450px">

    <div class="notifications-header">
        <p class="mb-2" >Powiadomienia użytkownika {{\Illuminate\Support\Facades\Auth::user()->first_name}}</p>
    </div>

    <div class="notifications-content ">

        @if(!($notifications = \Illuminate\Support\Facades\Auth::user()->getNotifications())->isEmpty())
        <form id="mark-Notifications" action="{{route('mark.notifications')}}" method="POST">
            @CSRF



        @foreach($notifications as $notification)
                <input name="notifications[]" value="{{$notification->id}}" type="hidden">
        <div class="notifiactions-item @if($notification->open == true) muted @endif"  >
            <div class=" row justify-content-between">
                <div class="col-sm-9">
                    @if($notification->message == 'rate')

                        <p style="font-weight: normal">
                            Użytkownik: <strong style="color: white">{{$notification->getOwner()->first_name}} {{$notification->getOwner()->last_name}}
                            </strong > ocenił/a twój klub  <strong style="color: white">{{$notification->getClub()->official_name}}</strong> na
                            <strong>{{$notification->rate}} </strong>
                        </p>

                    @elseif($notification->message == 'event-attendance')

                        <p style="font-weight: normal">
                            Użytkownik: <strong style="color: white">{{$notification->getOwner()->first_name}} {{$notification->getOwner()->last_name}}
                            </strong > Weźmie udział w wydarzeniu:  <strong style="color: white">{{$notification->getEvent()->title}}</strong>
                        </p>

                    @endif
                        @if($notification->open != true)
                            <a class="link" href="#"><i class="fa fa-eye"></i></a>

                        @endif
                </div>
                <div class="col-sm-3 pl-0 text-right">

                    <p class="muted">{{str_replace( ['hours', 'ago', 'days', 'day', 'hour', 'minutes'], ['godzin', 'temu', 'dni', 'dzień', 'godzine', 'minut'], \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans()) }}</p>
                    @if($notification->message == 'rate')
                    <a href="{{url('clubs/'. $notification->getClub()->id)}}" class="link"> Zobacz Klub</a>
                        @endif

                </div>
            </div>
        </div>

            @endforeach

        </form>
        @else
            <div class="notifiactions-item ">
                <div class=" row justify-content-between">
                    <div class="col-sm-12 text-center">
                    Nie masz jeszcze żadnych powiadomień
                    </div>
                </div>
            </div>
        @endif



    </div>

</div>