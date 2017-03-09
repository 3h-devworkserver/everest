

@if(!empty($summitteers))
                    @foreach($summitteers as $sum)
                    <tr>
                        <td class="name">{{$sum->name}}</td>
                        <td class="country">{{$sum->country}}</td>
                        <td class="date">{{$sum->date}}</td>
                        <td class="route">{{$sum->route}}</td>
                        <td class="team">{{$sum->team_name}}</td>
                        <td class="leader">{{$sum->leader}}</td>
                    </tr>
                    @endforeach
                    @endif

