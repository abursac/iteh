
@foreach ($players as $player)
    <tr>
        <td>{{$loop->index + 1}}</td> 
        <td>{{$player->name}}</td>  
        <td>{{$player->surname}}</td>  
        <td>{{$player->rating}}</td>  
        <td><a class="btn btn-primary" href="/igrac/{{ $player->id }}">+</a></td> 
    </tr>
@endforeach

<tr>
    <td colspan="5">
    <ul class="pagination justify-content-center">
    @for($i = 1; $i< $number_of_pages + 1;$i++)
        <li class="page-item"><button class="page-link"  onclick="prikazi_igrace({{$i}})">{{$i}}</button></li>
    @endfor
    </ul>
    </td>
</tr>