@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
       <h2>{{ $title??'' }}</h2>
       <table class="table">
        <thead>
            @foreach ( $tHead as $th )
                <th>{{ $th }}</th>
            @endforeach
        </thead>
        <tbody>
                  @forelse ($documents as $doc)
                    <tr>
                        @foreach ($tHead as $column)
                            <td>{{ $doc->$column }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($tHead) }}" class="text-center">No documents found.</td>
                    </tr>
                @endforelse
        </tbody>
       </table>
    </div>
</div>
<script>


</script>
@endsection