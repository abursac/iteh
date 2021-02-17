@foreach ($clubs as $club)
<tr>
    <td> {{$loop->index + 1}} </td> 
    <td> {{$club->name}} </td>  
    <td> {{0}} </td>  
    <td> {{$club->address}} </td>
    <td><a class="btn btn-primary" href="/klub/{{ $club->id }}">+</a></td> 
</tr>
@endforeach

<tr>
    <td colspan="5">
    <ul class="pagination justify-content-center">
    @for($i = 1; $i< $broj_stranica + 1;$i++)
        <li class="page-item"><button class="page-link"  onclick="prikazi_klubove({{$i}})">{{$i}}</button></li>
    @endfor
    </ul>
    </td>
</tr>