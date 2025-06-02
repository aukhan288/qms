@extends('layouts.base')
@section('page')
<div class="row py-5 ms-5 me-5">
    <x-user-side_menu />
    <div class="col-md-9">
       <h2 class="text-success">{{ $title??'' }}</h2>
 <table class="table">
    <thead class="tbl-tr">
        <tr class="tbl-tr">
            @foreach ($tFields as $head)
                <th>{{ ucwords(str_replace('_', ' ', $head)) }}</th>
            @endforeach
            <th class="text-center">Options</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($documents as $doc)
            <tr class="tbl-tr">
        
                @foreach ($tFields as $field)
                    @if ($field == 'type')
                     @if($doc->document_type->value=='word')
                        <td><i class="mdi mdi-file-word" style="color:blue; font-size:18px"></i></td>
                     @elseif($doc->document_type->value=='pdf')
                        <td><i class="mdi mdi-file-pdf text-danger" style="font-size:18px"></i></td>
                     @endif   
                    @else
                        <td>{{ $doc->$field }}</td>
                    @endif
                @endforeach
                <td class="text-center">
                    <a href="#" onclick="downloadFile({{ $doc->id }}); return false;">
                        <i class="mdi mdi-download"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr class="tbl-tr">
                <td colspan="{{ count($tFields) + 1 }}" class="text-center">No documents found.</td>
            </tr>
        @endforelse
    </tbody>
</table>


    </div>
</div>
<script>


</script>
@endsection