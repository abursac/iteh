@foreach ($tournaments as $tournament)
    <tr>
        <th scope="row">{{$loop->index + 1}}</td> 
        <td>{{$tournament->name}}</td>  
        <td>{{$tournament->place}}</td>
        <td>{{$tournament->rounds}}</td>    
        <td>{{date("d.m.Y.", strtotime($tournament->start_date))}}</td>  
        <td>{{date("d.m.Y.", strtotime($tournament->end_date))}}</td>  
        <td><a class="btn btn-primary" href="/turnir/{{ $tournament->id }}">+</a></td> 
    </tr>
@endforeach

<tr>
    <td colspan="7">
    <ul class="pagination justify-content-center">
    @for($i = 1; $i< $number_of_pages + 1;$i++)
        <li class="page-item"><button class="page-link"  onclick="prikazi_turnire({{$i}})">{{$i}}</button></li>
    @endfor
    </ul>
    </td>
</tr>