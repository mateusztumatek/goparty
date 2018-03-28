<div class="col-md-3" id="sidebar">

    <div class="card text-white bg-dark mb-3 user-left-menu">
        <div class="card-header">
            <b>Panel użytkownika</b>
            <img class="img-fluid mt-2" src="https://www.w3schools.com/howto/img_avatar.png" alt="">
            <h4 class="mt-3 mb-0">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
        </div>

        <div class="list-group panel">

            @role('owner')
            <a href="#menu1" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar"
               aria-expanded="false"><i class="fa fa-music"></i> <span class="hidden-sm-down"> Kluby</span> </a>
            <div class="collapse" id="menu1">
                <a href="{{url('/dashboard/clubs')}}" class="list-group-item" data-parent="#menu1">Moje kluby</a>
                <a href="{{url('/dashboard/clubs/create')}}" class="list-group-item" data-parent="#menu1">Dodaj nowy klub</a>
            </div>
            @endrole

            <a href="#menu2" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar"
               aria-expanded="false"><i class="fa fa-music"></i> <span class="hidden-sm-down"> Wydarzenia</span> </a>
            @role('owner')
            <div class="collapse" id="menu2">
                <a href="{{url('dashboard/owner-all-events')}}" class="list-group-item" data-parent="#menu1">Moje wydarzenia</a>
            </div>
            @endrole

            <a href="#" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-gear"></i> <span
                        class="hidden-sm-down">Ustawienia konta</span></a>

        </div>


    </div>


</div>


