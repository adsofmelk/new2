<ul class="nav" id="side-menu">
    @foreach($datos as $row)
            <li>
                <a href="#"><i class="{{$row->iconogrupo}} fa-fw"></i> {{$row->nombregrupomodulo}}<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @foreach($row['modulos'] as $modulo)
                    <li>
                        <a href="/{{$modulo->path}}"><i class='{{$modulo->iconomodulo}} fa-fw'></i> {{$modulo->nombremodulo}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
    @endforeach
</ul>