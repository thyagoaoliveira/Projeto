@extends('teste/template')

@section('titulo')
	notas
@endsection

@section('conteudo')
	<h1>Anotações</h1>
		<ul>
			<!-- Exemplo 1
			*** Inserir sem loop. ***
			<li>Nota 1</li>
			<li>Nota 2</li>
			<li>Nota 3</li> -->

			@foreach($notas as $nota)
				<li>{{ $nota }}</li>
			@endforeach
		</ul>
@endsection