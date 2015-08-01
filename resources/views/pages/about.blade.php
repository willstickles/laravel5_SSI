    @extends('app')

    @section('content')

        <div class="row">

            <div class="col-xs-6">
                <h1>About</h1>

                @if (count($people))
                    <h3>People I Like:</h3>

                    <ul>
                        @foreach ($people as $person)

                            <li>{{ $person }}</li>

                        @endforeach
                    </ul>
                @endif

                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid architecto consectetur dolor excepturi inventore ipsa optio sapiente ullam. Accusamus commodi deserunt ipsa laborum maxime numquam, obcaecati officiis pariatur voluptatem voluptatibus.
                </p>

            </div>

        </div>


    @stop
