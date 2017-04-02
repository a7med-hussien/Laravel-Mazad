@extends("layouts.app")


@section("styles")
	<link rel="stylesheet" href="{{ asset("css/item.css") }}">
	<link rel="stylesheet" href="{{ asset("css/font-awesome.min.css") }}">
@endsection

@section("content")
	<div class="container">
		<div class="row">
   			<div class="col-xs-4 item-photo">
                <img class="img-responsive" src="{{ asset($item->image) }}" />
                </div>
                <div class="col-xs-5" style="border:0px solid gray">
                    <h3>{{ $item->name }}</h3>    
                    <h5 style="color:#337ab7">Posted By: <a href="javascript:;">{{ $item->user->name }}</a>
                    	<small style="color:#337ab7">{{ $item->user->location }}</small>
                    </h5>

                    <h6 class="title-price"><small>Price</small></h6>
                    <h3 style="margin-top:0px;">{{ $item->price }} EGP</h3>

                    <h6 class="title-price"><small>Bids No</small></h6>
                    <h3 style="margin-top:0px;">{{ $item->bids }}</h3>

                    <h6 class="title-price"><small>Highest Price</small></h6>
                    <h3 style="margin-top:0px;">{{ $item->highest_price }} EGP</h3>

                    <div class="section" style="padding-bottom:20px;">
                        <h6 class="title-attr"><small>CANTIDAD</small></h6>                    
                        <div>
                            <input id="bid_val" name="bid_val" class="form-control" placeholder="Pid Value" />
                        </div>
                    </div>

                    <div class="section" style="padding-bottom:20px;">
                        <button id="bid" class="btn btn-success">
                        	<i class="fa fa-handshake-o" aria-hidden="true"></i>
                        	Bid</button>
                    </div>                                        
                </div>                              

                <div class="col-xs-9">
                    <ul class="menu-items">
                        <li class="active">Details</li>
                    </ul>
                    <div style="width:100%;border-top:1px solid silver">
                        <p style="padding:15px;">
                            {{ $item->details }}
                        </p>
                    </div>
                </div>
		</div>
	</div>
@endsection

@section("scripts")
<script>
	$('#bid').on('click', function(){
		var bid_val = $("#bid_val").val();
		// var id = $("#bid_val").attr('name');
		$.ajax({
			url: {{ $item->id }}+'/bid',
			type: 'GET',
			data: {bid_val: bid_val},
			success: function(response) {
				console.log(response);
				window.location.reload();
			}
		})
		
	})
</script>
@endsection