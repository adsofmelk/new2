    <div class='form-group'>
        {!!Form::label("nombres","Nombres:")!!}
        {!!Form::text("nombres",null,['class'=>'form-control','placeholder'=>'Ingrese los nombres del usuario'])!!}
    </div>
    <div class='form-group'>
        {!!Form::label("apellidos","Apellidos:")!!}
        {!!Form::text("apellidos",null,['class'=>'form-control','placeholder'=>'Ingrese los apellidos del usuario'])!!}
    </div>
    <div class='form-group'>
        {!!Form::label("email","Email:")!!}
        {!!Form::email("email",null,['class'=>'form-control','placeholder'=>'Correo electrónico'])!!}
    </div>
    <div class='form-group'>
        {!!Form::label("password","Password:")!!}
        {!!Form::password("password",['class'=>'form-control','placeholder'=>'Password'])!!}
    </div>
    <div class='form-group'>
        {!!Form::label("idtipousuario","Tipo de usuario:")!!}
        {!!Form::select("idtipousuario",$tipousuario,null,['class'=>'form-control','placeholder'=>' -- Tipo de Usuario --'])!!}
    </div>

