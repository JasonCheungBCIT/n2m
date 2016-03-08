@extends('layouts/basic')

@section('pagetitle')
    <title>Note-to-myself : notes</title>
@stop

@section('headers')
    {{ HTML::style('css/homepage.css') }}
    <script type="text/javascript">
        function openInNew(textbox){
            window.open(textbox.value);
            this.blur();
        }
    </script>
@stop

@section('maincontent')

    <div id="wrapper">
        {{Form::open(['action'=>'NotesController@store', 'files'=>true])}}
            <h2 id="header">{{ $email }} - <span>{{ HTML::link('logout', 'Log out') }}</span></h2>

            <div id="main_content">

                <div id="column1" class="column">
                    <h2>Notes</h2>
                    {{ Form::textarea('note', $note, ['id'=>'note', 'cols'=>'16', 'rows'=>'40']) }}
                </div>

                <div id="column2" class="column">
                    <h2>Websites</h2><h3>click to open</h3>
                    @foreach ($sites as $s)
                        {{ Form::text('websites[]', $s, array("onclick"=>"openInNew(this)")) }}
                    @endforeach
                    @for ($i = 0; $i < 4; $i++)
                        {{ Form::text('websites[]') }}
                    @endfor
                    {{$errors->first('websites', '<span class="error">:message<span>')}}
                </div>


            <!-- <div id="section2"> -->

                <div id="column3" class="column">
                    <h2>Images</h2><h3>click for full size</h3>
                    <!-- <textarea cols="16" rows="40" id="image" name="image" /></textarea> -->

                    {{ Form::file('user_image') }}

                    <div>
                        @foreach($images as $i)
                            <div class="image-holder">
                                {{ HTML::image(URL::asset($i), "User's image") }}
                                Delete{{ Form::checkbox('delete_image[]', $i) }}
                            </div>
                        @endforeach
                    </div>

                </div>

                <div id="column4" class="column">
                    <h2>Todo</h2>
                    {{ Form::textarea('todo', $todo, ['id'=>'notes', 'cols'=>'16', 'rows'=>'40']) }}
                </div>

            </div>

            <div id="footer">
                <input type="submit" value="Save" style="width:200px;height:80px" name="submitting" />
            </div>

        {{ Form::close() }}
    </div>
@stop