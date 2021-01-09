<!DOCTYPE html>
<html>
<head>
	<title></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
  <meta charset="utf-8">
  {{-- <link rel="stylesheet" href='https://mmwebfonts.comquas.com/fonts/?font=myanmar3' /> --}}

</head>
{{-- {!! Zawuni::includeFiles() !!} --}}
<style type="text/css">
  @import url('https://mmwebfonts.comquas.com/fonts/?font=myanmar3');

  .mmfont{
      font-family: Myanmar3,Yunghkio,'Masterpiece Uni Sans';
      color:red;
    }
</style>
<body>
	<h1>Wyas of {{$data['deliveryman']->user->name}}</h1>
	<table border="1" cellpadding="5px">
                    <thead>
                      <tr>
                      	<th>No</th>
                        <th>Item Cod</th>
                        <th>Delivered Township</th>
                        <th>Receiver Name</th>
                        <th>Full Address</th>
                        <th>Receiver Phone No</th>
                        <th>Client</th>
                        <th>Amount</th>
                      </tr>
                    </thead>

                    <tbody>
                    @php $i=1; @endphp
                     @foreach($data["ways"] as $way)
                     @php
                      $address = Zawuni::text($way->item->receiver_address);
                      dd(Rabbit::uni2zg("သီဟိုဠ်မှ ဉာဏ်ကြီးရှင်သည် အာယုဝဍ်ဎနဆေးညွှန်းစာကို ဇလွန်ဈေးဘေးဗာဒံပင်ထက် အဓိဋ္ဌာန်လျက် ဂဃနဏဖတ်ခဲ့သည်။"););
                      @endphp
                     <tr>
                     	<td>{{$i++}}</td>
                     	<td>{{$way->item->codeno}}</td>
                     	@if($way->item->sender_gate_id != null)
                			<td>{{$way->item->SenderGate->name}}</td>
              			@elseif($way->item->sender_postoffice_id != null)
               				<td> {{$way->item->SenderPostoffice->name}}</td>
              			@else
               			 <td>{{$way->item->township->name}}</td>
              			@endif
                     	<td>{{$way->item->receiver_name}}</td>
                     	<td><p>@php
                                Rabbit::uni2zg("သီဟိုဠ်မှ ဉာဏ်ကြီးရှင်သည် အာယုဝဍ်ဎနဆေးညွှန်းစာကို ဇလွန်ဈေးဘေးဗာဒံပင်ထက် အဓိဋ္ဌာန်လျက် ဂဃနဏဖတ်ခဲ့သည်။");
                             @endphp</p></td>
                     	<td>{{$way->item->receiver_phone_no}}</td>
                     	<td>{{$way->item->pickup->schedule->client->user->name}}<br>
                     	({{$way->item->pickup->schedule->client->phone_no}})
                     	</td>
                     	 @if($way->item->paystatus==1)
              			 <td>{{$way->item->amount}} Ks</td>
            			@else
             				<td>All Paid!</td>
            			@endif
                     </tr>
                     @endforeach
                    </tbody>
              </table>

</body>
</html>