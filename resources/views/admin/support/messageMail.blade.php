@if($data['type'] == 'ticketGenerated')

    Hi 
    @if($data['createdFor'] == $data['createdBy'])
        Admin,
    @else
        {{$data['createdFor']}},
    @endif
    <br>
    {{$data['createdBy']}} has generated a new ticket <strong>#{{$data['ticketNo']}}</strong> against the loan <strong>"{{$data['loan']}}"</strong>.
    <br>
    <strong>Issue:</strong> {{$data['issue']}}

@elseif($data['type'] == 'ticketClosed')

    Hi {{$data['createdFor']}},
    <br>
    The ticket <strong>#{{$data['ticketNo']}}</strong> has been closed now by {{$data['createdBy']}}.

@elseif($data['type'] == 'chat')

    Hi {{$data['userTo']}},
    <br>
    {{$data['userFrom']}} has sent a new message to the ticket <strong>#{{$data['ticketNo']}}</strong>.
    <br>
    <strong>Message:</strong> {{$data['message']}}

@endif

<br><br>

Thanks!