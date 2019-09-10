<section> 
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar"> 
        <!-- User Info -->
        <div class="user-info">
            <div class="admin-image"> <img src="{{asset('assets/images/random-avatar7.jpg')}}" alt=""> </div>
            <div class="admin-action-info"> <span>Welcome</span>
                <h3>{{Auth::user()->name}}</h3>
                <ul>
                    <li>
                        <a data-placement="bottom" title="Go to Profile" 
                            href="{{  Auth::user()->role =='medecin' ? route('medecins.show',['medecin'=> Auth::user()->medecins[0]->id]) : '#' }}"
                        >
                            <i class="zmdi zmdi-account"></i>
                        </a>
                    </li>
                    <li><a data-placement="bottom" title="Logout" href="{{ route('logout') }}"  onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="zmdi zmdi-sign-in"></i></a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form></li>
                </ul>
            </div>
            <div class="quick-stats">
                <h5>Today Report</h5>
                @if(Auth::user()->role == 'medecin')
                <ul>
                    <li><span>{{ Auth::user()->medecins[0]->nombreRendezVousAujourdhui() }}<i>Rendez-vous</i></span></li>
                    <li><span>{{ Auth::user()->medecins[0]->nombreRendezVousNonTraite() }}<i>Non Traité</i></span></li>
                    <li><span>{{ Auth::user()->medecins[0]->nombreRendezVousTraite() }}<i>Visite</i></span></li>
                </ul>
                @else
                <ul>
                    <li><span>20<i>Medecins</i></span></li>
                    <li><span>20<i>Panding</i></span></li>
                    <li><span>04<i>Actif</i></span></li>
                </ul>
                @endif
            </div>
        </div>
        <!-- #User Info --> 
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <li class="header">MAIN NAVIGATION</li>
                <li class="active open"><a href="{{ route('home') }}"><i class="zmdi zmdi-home"></i><span>Tableau de bord</span></a></li>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-add"></i><span>Docteurs</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{ route('medecins.index') }}">Tous les docteurs</a></li>
                            <li><a href="{{ route('medecins.create') }}">Ajouter un docteur</a></li>
                        </ul>
                    </li>
                    @if(Auth::user()->role == 'admin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Utilisateurs</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('users.index')}}">Utilisateurs</a></li>
                        </ul>
                    </li>
                    @endif
                @endif
                @if (Auth::user()->role == 'medecin')
                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-calendar-check"></i><span>Appointment</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('calendrier')}}">Calendrier Rendez-vous</a></li>
                            <li><a href="{{route('table_rendez_vous')}}">Liste Rendez-vous</a></li>
                            <li><a href="{{route('patients.create')}}">Ajouter un Rendez-vous</a></li>
                        </ul>
                    </li>

                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Patients</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('patients.index')}}">Tous les Patients</a></li>
                            <li><a href="{{route('patients.create')}}">Ajouter un Patient</a></li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-account-o"></i><span>Planning</span> </a>
                        <ul class="ml-menu">
                            <li><a href="{{route('planning')}}">Planning</a></li>
                            <li><a href="{{route('empechement')}}">Empêchement</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </aside>
</section>