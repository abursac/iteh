@extends('master')

@section('title', $tournament->name)

@section('content')

<script>

var round = 1;

function loadResults(){
$.ajax({
	type: "GET",
	url: "/turnir/{{$tournament->id}}/rezultati",
	data: {
		round: round
	},
	success: function (data) {
		document.getElementById("rezultati").innerHTML = data;
		loadNames();
		participants = participants2.slice(0);
		return;
	},
	error: function (data) {
		return;
	},
});
}

@if($tournament->type == 'player')
var str = "{{json_encode($tournament->participants()->select('id', 'name', 'surname')->get())}}";
var participants = JSON.parse(str.replace(/&quot;/g,'"'));
var participants2 = participants.slice(0);
@else
var str = "{{json_encode($tournament->participants()->select('id', 'name')->get())}}";
var participants = JSON.parse(str.replace(/&quot;/g,'"'));
var participants2 = participants.slice(0);
@endif


function playerSelected(selected){
		
	for(let i = 1; i < selected.childNodes.length; i++){
		const index = participants.findIndex(item => item.id == selected.childNodes[i].value);
		if (index == -1) {
			var name = selected.childNodes[i].innerHTML;
			@if($tournament->type == 'player')
				var surname = name.split(" ")[1];
				name = name.split(" ")[0];
			@endif
			var part = {id:selected.childNodes[i].value, name:name, @if($tournament->type == 'player') surname:surname @endif}
			participants.push(part);
		}
	}
	

	if(selected.value > 0){
		const index = participants.findIndex(item => item.id == selected.value);
		if (index > -1) {
			participants.splice(index, 1);
		}
	}
	
	loadNames();
}

function loadNames(){
	let emptyOption = document.createElement('option');
	emptyOption.value = 0;
	@if($tournament->type == 'player')
	emptyOption.innerHTML = "Izaberite igraca";
	@else
	emptyOption.innerHTML = "Izaberite klub";
	@endif
	
	const whites = document.getElementsByClassName("white");
	const blacks = document.getElementsByClassName("black");

	for(let j = 0; j < whites.length; j++){
		if(whites[j].value == 0){
			whites[j].innerHTML = "";
			whites[j].appendChild(emptyOption.cloneNode(true));
		}
		else{
			const val = whites[j].value;
			const name = whites[j].options[whites[j].selectedIndex].text;

			let lastOption = document.createElement('option');
			lastOption.value = val;
			lastOption.innerHTML = name;
			lastOption.selected = true;

			whites[j].innerHTML = "";
			whites[j].appendChild(emptyOption.cloneNode(true));
			whites[j].appendChild(lastOption);


			const index = participants.findIndex(item => item.id == val);
			if (index > -1) {
				participants.splice(index, 1);
			}
		}
	}

	for(let j = 0; j < blacks.length; j++){
		if(blacks[j].value == 0){
			blacks[j].innerHTML = "";
			blacks[j].appendChild(emptyOption.cloneNode(true));
		}
		else{
			const val = blacks[j].value;
			const name = blacks[j].options[blacks[j].selectedIndex].text;

			let lastOption = document.createElement('option');
			lastOption.value = val;
			lastOption.innerHTML = name;
			lastOption.selected = true;

			blacks[j].innerHTML = "";
			blacks[j].appendChild(emptyOption.cloneNode(true));
			blacks[j].appendChild(lastOption);

			const index = participants.findIndex(item => item.id == val);
			if (index > -1) {
				participants.splice(index, 1);
			}
		}
	}

	for(let i = 0; i < participants.length; i++)
	{
		let option = document.createElement('option');

		@if($tournament->type == 'player')
		option.innerHTML = participants[i].name + " " + participants[i].surname;
		@else
		option.innerHTML = participants[i].name;
		@endif

		option.value = participants[i].id;

		for(let j = 0; j < whites.length; j++){
			if(whites[j].childNodes != 0)
				whites[j].appendChild(option.cloneNode(true));
		}
		for(let j = 0; j < blacks.length; j++)	
			blacks[j].appendChild(option.cloneNode(true));
	}
}

function selectRound()
{
	round = document.getElementById("round").value;
	loadResults();
}

function addRow()
{
	if(document.getElementById('rezultati').childElementCount >= participants2.length / 2){
		alert("Nije moguce dodati jos redova");
		return;
	}

	let row = document.createElement('tr');
	let td1 = document.createElement('td');
	let td2 = document.createElement('td');
	let td3 = document.createElement('td');
	let td4 = document.createElement('td');
	let option = document.createElement('option');
	option.value = 0;
	option.innerHTML = "Izaberite igraca";
	
	let whiteSelect = document.createElement('select');
	whiteSelect.appendChild(option);
	whiteSelect.classList.add("white");
	whiteSelect.name = "white[]";
	whiteSelect.onchange = function() {playerSelected(this)};
	td2.appendChild(whiteSelect);
	
	let blackSelect = document.createElement('select');
	blackSelect.appendChild(option.cloneNode(true));
	blackSelect.classList.add("black");
	blackSelect.name = "black[]";
	blackSelect.onchange = function() {playerSelected(this)};
	td4.appendChild(blackSelect);

	let resultSelect = document.createElement('select');
	let whiteWin = document.createElement('option');
	whiteWin.value = 2;
	whiteWin.innerHTML = "1:0";
	let draw = document.createElement('option');
	draw.value = 2;
	draw.innerHTML = "0.5:0.5";
	let blackWin = document.createElement('option');
	blackWin.value = 2;
	blackWin.innerHTML = "0:1";

	resultSelect.name = "result[]";
	resultSelect.appendChild(whiteWin);
	resultSelect.appendChild(draw);
	resultSelect.appendChild(blackWin);

	td3.appendChild(resultSelect);

	let table = document.createElement('input');
	table.type = "number";
	table.min = "1";
	table.max = participants2.length / 2;
	table.value = document.getElementById('rezultati').childElementCount + 1;
	table.name = "table[]";
	td1.appendChild(table); 

	row.appendChild(td1);
	row.appendChild(td2);
	row.appendChild(td3);
	row.appendChild(td4);
	document.getElementById('rezultati').appendChild(row);

	loadNames();
}

loadResults();

</script>



<h1>Unos rezultata - {{ $tournament->name }}</h1>


<button onclick="addRow()" class="btn btn-primary mb-2">Dodaj rezultat</button>

<form action="/turnir/{{$tournament->id}}/unosRezultata" method="POST" >
	@csrf

	<label class="h5">Kolo:
	<select name="round" id="round" onchange="selectRound()">
		@for($i = 1; $i <= $tournament->rounds; $i++)
		<option value="{{$i}}">{{$i}}</option>
		@endfor
	</select>
	</label>

	<table class="table table-hover w-75 text-center">
		<thead class="thead-dark">
			<tr>
				<th scope="col">#</th>
				<th class="w-30" scope="col">Beli</th>
				<th scope="col">Rezultat</th>
				<th class="w-30" scope="col">Crni</th>
			</tr>
		</thead>

		<tbody id="rezultati">
			
			
		</tbody>
	</table>
	<input type="submit" value="Potvrdi" class="btn btn-success">

</form>	


	

@endsection